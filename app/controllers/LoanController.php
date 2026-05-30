<?php
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Account.php';

class LoanController {

    // Removed the problematic __construct()

    public function create() {
    $company_id = $_SESSION['user']['company_id'];
    $loanModel = new Loan();
    $db = $loanModel->getDb();
    
    // 1. Fetch Borrowers
    $stmt = $db->prepare("SELECT id, first_name, last_name FROM borrowers WHERE company_id = ?");
    $stmt->execute([$company_id]);
    $borrowers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// In LoanController.php -> create() method
$stmtAcc = $db->prepare("SELECT id, name, current_balance FROM accounts WHERE company_id = ?");
$stmtAcc->execute([$company_id]);
$accounts = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);


    // 2. NEW: Fetch Accounts
    $stmtAcc = $db->prepare("SELECT id, name, current_balance FROM accounts WHERE company_id = ?");
    $stmtAcc->execute([$company_id]);
    $accounts = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);
    
    require_once __DIR__ . '/../views/admin/loans/create.php';
}

   public function store() {
    // 1. Capture and sanitize inputs
    $borrower_id   = $_POST['borrower_id'];
    $account_id    = $_POST['account_id'];
    $amount        = (float)$_POST['amount'];
    $interest      = (float)$_POST['interest_rate'];
    $total_pay     = (float)$_POST['total_payable'];
    $term_months   = (int)$_POST['term_months'];
    $term_type     = $_POST['term_type'];
    $released_date = $_POST['released_date'];
    $notes         = $_POST['notes'] ?? '';
    $company_id    = $_SESSION['user']['company_id'];

    // Collateral inputs
    $collateral_name  = $_POST['collateral_name'] ?? '';
    $collateral_value = (float)($_POST['collateral_value'] ?? 0);

    // 2. Calculate Due Date
    $date = new DateTime($released_date);
    if ($term_type === 'month') {
        $date->modify("+{$term_months} months");
    } else {
        $date->modify("+{$term_months} days");
    }
    $due_date = $date->format('Y-m-d');

    // 3. Database operations
    $loanModel = new Loan();
    $db = $loanModel->getDb();

    try {
        $db->beginTransaction();

        // A. Insert the loan record
        $stmt = $db->prepare("INSERT INTO loans 
            (borrower_id, company_id, account_id, amount, interest_rate, released_date, due_date, total_payable, notes, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
        
        $stmt->execute([
            $borrower_id, $company_id, $account_id, $amount, $interest, $released_date, $due_date, $total_pay, $notes
        ]);
        
        $loan_id = $db->lastInsertId();

        // B. Handle Collateral and File Upload
        if (!empty($collateral_name)) {
            $filePath = null;

            if (isset($_FILES['collateral_file']) && $_FILES['collateral_file']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/collaterals/';
                
                // Create directory if it doesn't exist
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileExtension = pathinfo($_FILES['collateral_file']['name'], PATHINFO_EXTENSION);
                $newFileName = 'collateral_' . $loan_id . '_' . time() . '.' . $fileExtension;
                
                if (move_uploaded_file($_FILES['collateral_file']['tmp_name'], $uploadDir . $newFileName)) {
                    $filePath = 'uploads/collaterals/' . $newFileName;
                }
            }

            $stmtCollateral = $db->prepare("INSERT INTO loan_collaterals
                (company_id, loan_id, item_name, estimated_value, file_path) 
                VALUES (?, ?, ?, ?, ?)");
            
            $stmtCollateral->execute([
                $company_id, $loan_id, $collateral_name, $collateral_value, $filePath
            ]);
        }

        $db->commit();

        header("Location: /loansaas/public/index.php?url=loan/index");
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        die("Error saving loan: " . $e->getMessage());
    }
}

    public function details() {
    if (!isset($_GET['id'])) die("No ID provided");
    $id = $_GET['id'];
    
    // 1. Get the DB connection manually (since there is no constructor)
    $loanModel = new Loan();
    $db = $loanModel->getDb(); // Use $db instead of $this->db
    
    $paymentModel = new Payment();
    
    $loan = $loanModel->getById($id);
    $payments = $paymentModel->getByLoanId($id);
    $totalPaid = $paymentModel->getTotalPaidByLoanId($id);

    // 2. Use $db here instead of $this->db
    $stmt = $db->prepare("SELECT * FROM loan_collaterals WHERE loan_id = ?");
    $stmt->execute([$id]);
    $collateral = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $remainingBalance = $loan['total_payable'] - $totalPaid;
    
    require_once __DIR__ . '/../views/admin/loans/details.php';
}

    public function index() {
        $loanModel = new Loan(); 
        $company_id = $_SESSION['user']['company_id'];
        $loans = $loanModel->getAllByCompany($company_id);
        
        require_once __DIR__ . '/../views/admin/loans/index.php';
    }

    // FIXED: Approve method now uses the Loan model to get DB connection
    public function approve() {
    if (!isset($_GET['id'])) die("No ID provided");
    $id = $_GET['id'];
    
    $loanModel = new Loan();
    $db = $loanModel->getDb();
    
    try {
        $db->beginTransaction();

        // 1. Get loan details first so we know how much to deduct and which account
        $stmt = $db->prepare("SELECT amount, account_id, company_id FROM loans WHERE id = ?");
        $stmt->execute([$id]);
        $loan = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$loan) throw new Exception("Loan not found.");

        // 2. Update loan status to 'Approved'
        $stmtApprove = $db->prepare("UPDATE loans SET status = 'Approved' WHERE id = ?");
        $stmtApprove->execute([$id]);

        // 3. Deduct from the account (only now!)
        $stmtDeduct = $db->prepare("UPDATE accounts 
                                    SET current_balance = current_balance - ? 
                                    WHERE id = ? AND company_id = ?");
        
        $stmtDeduct->execute([$loan['amount'], $loan['account_id'], $loan['company_id']]);

        $db->commit();
        header("Location: /loansaas/public/index.php?url=loan/index");
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        die("Error approving loan: " . $e->getMessage());
    }
}
}