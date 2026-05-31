<?php
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Account.php';
require_once __DIR__ . '/../models/ActivityLog.php';

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
    $borrower_id    = $_POST['borrower_id'];
    $account_id     = $_POST['account_id'];
    $amount         = (float)$_POST['amount'];
    $interest       = (float)$_POST['interest_rate'];
    $total_pay      = (float)$_POST['total_payable'];
    $term_months    = (int)$_POST['term_months'];
    $fee            = (float)($_POST['fee'] ?? 0); 
    $term_type      = $_POST['term_type'];
    $released_date  = $_POST['released_date'];
    $notes          = $_POST['notes'] ?? '';
    
    $company_id     = $_SESSION['user']['company_id'];

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

    // ... capture your variables ...
    $account_id = $_POST['account_id'];
    $amount     = (float)$_POST['amount'];

    // 1. Fetch current balance from database to be 100% sure
    $loanModel = new Loan();
    $db = $loanModel->getDb();
    
    $stmt = $db->prepare("SELECT current_balance FROM accounts WHERE id = ?");
    $stmt->execute([$account_id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($amount > $account['current_balance']) {
        // Redirect back with an error message
        die("Error: Insufficient funds. The loan amount exceeds the available account balance.");
    }

    // 3. Database operations
    $loanModel = new Loan();
    $db = $loanModel->getDb();

    try {
        $db->beginTransaction();

        // A. Insert the loan record
        $sql = "INSERT INTO loans 
            (borrower_id, company_id, account_id, amount, interest_rate, released_date, due_date, total_payable, notes, fee, status, term_months, term_type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        
        $stmt->execute([
            $borrower_id,    // 1
            $company_id,     // 2
            $account_id,     // 3
            $amount,         // 4
            $interest,       // 5
            $released_date,  // 6
            $due_date,       // 7
            $total_pay,      // 8
            $notes,          // 9
            $fee,            // 10
            'Pending',       // 11
            $term_months,    // 12
            $term_type       // 13
        ]);
        
        $loan_id = $db->lastInsertId();

        // B. Add Activity Log
        (new ActivityLog($db))->logAction($company_id, $_SESSION['user']['id'], 'CREATE_LOAN', 'loans', $loan_id, "Created new loan #$loan_id");

        // C. Handle Collateral and File Upload
        if (!empty($collateral_name)) {
            $filePath = null;

            if (isset($_FILES['collateral_file']) && $_FILES['collateral_file']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/collaterals/';
                
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
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        die("Error saving loan: " . $e->getMessage());
    }
}

    public function details() {
    if (!isset($_GET['id'])) die("No ID provided");
    $id = $_GET['id'];
    
    $loanModel = new Loan();
    $db = $loanModel->getDb();
    
    // ADDED: term_months and term_type to the SELECT statement
    $stmt = $db->prepare("
        SELECT l.*, b.first_name, b.last_name, b.phone, b.address, a.name as account_name, 
               l.term_months, l.term_type 
        FROM loans l
        JOIN borrowers b ON l.borrower_id = b.id
        JOIN accounts a ON l.account_id = a.id
        WHERE l.id = ?
    ");
    $stmt->execute([$id]);
    $loan = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch collateral separately
    $stmtColl = $db->prepare("SELECT * FROM loan_collaterals WHERE loan_id = ?");
    $stmtColl->execute([$id]);
    $collateral = $stmtColl->fetch(PDO::FETCH_ASSOC);

    // Fetch payments
    $paymentModel = new Payment();
    $payments = $paymentModel->getByLoanId($id);
    $totalPaid = $paymentModel->getTotalPaidByLoanId($id);
    $remainingBalance = $loan['total_payable'] - $totalPaid;

    require_once __DIR__ . '/../views/admin/loans/details.php';
}

   public function index() {
    $loanModel = new Loan();
    $db = $loanModel->getDb();
    
    $status = $_GET['status'] ?? '';
    $search = $_GET['search'] ?? '';
    $company_id = $_SESSION['user']['company_id'];
    
    // Start building query
    $sql = "SELECT l.*, b.first_name, b.last_name 
            FROM loans l
            JOIN borrowers b ON l.borrower_id = b.id
            WHERE l.company_id = ?";
    $params = [$company_id];
    
    // Add Search logic
    if (!empty($search)) {
        $sql .= " AND (b.first_name LIKE ? OR b.last_name LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    $sql .= " ORDER BY l.created_at DESC";
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $allLoans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate status and apply filter in PHP (because status is calculated dynamically)
    $loans = [];
    foreach ($allLoans as $loan) {
        $loan['display_status'] = $this->calculateLoanStatus($loan);
        
        // If user filtered by status, skip if it doesn't match
        if (!empty($status) && $loan['display_status'] !== $status) {
            continue;
        }
        $loans[] = $loan;
    }
    
    require_once __DIR__ . '/../views/admin/loans/index.php';
}


private function calculateLoanStatus($loan) {
    // 1. Always check for Rejected first
    if ($loan['status'] === 'Rejected') return 'Rejected';

    // 2. Then check for Pending
    if ($loan['status'] === 'Pending') return 'Pending';

    // 3. Only calculate 'Paid', 'Overdue', or 'Active' if the loan is Approved
    if ($loan['status'] === 'Approved') {
        // Check if fully paid
        if (isset($loan['total_payable'], $loan['total_paid']) && $loan['total_paid'] >= $loan['total_payable']) {
            return 'Paid';
        }
        
        // Check if overdue
        if (strtotime($loan['due_date']) < time()) {
            return 'Overdue';
        }
        
        // Otherwise, it's active
        return 'Active';
    }

    // 4. Default fallback if status is something else
    return 'Pending';
}

    // FIXED: Approve method now uses the Loan model to get DB connection
  public function approve($id = null) {
    // If $id was not passed as an argument, try to get it from the URL GET parameter
    if ($id === null) {
        $id = $_GET['id'] ?? null;
    }

    if (!$id) {
        die("Error: Loan ID is missing.");
    }

    $loanModel = new Loan();
    $accountModel = new Account();
    $loan = $loanModel->getById($id);
    $db = $loanModel->getDb();

    if (!$loan) {
        die("Error: Loan not found.");
    }

    if ($loan['status'] !== 'Pending') {
        header("Location: /loansaas/public/index.php?url=loan/details&id=" . $id);
        return;
    }

    $db->beginTransaction();
    try {
        // Fetch balance with FOR UPDATE to prevent race conditions
        $stmt = $db->prepare("SELECT current_balance FROM accounts WHERE id = ? FOR UPDATE");
        $stmt->execute([$loan['account_id']]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$account) {
            throw new Exception("Account not found.");
        }

        // FIXED: Use $loan['amount'] instead of $amount
        if ($loan['amount'] > $account['current_balance']) {
            throw new Exception("Insufficient funds. The loan amount exceeds the available account balance.");
        }

        // Deduct
        $accountModel->addTransaction(
            $loan['account_id'], 
            -$loan['amount'], 
            'loan_issuance', 
            "Loan #$id Approved", 
            $id
        );
        
        // Update status
        $stmt = $db->prepare("UPDATE loans SET status = 'Approved' WHERE id = ?");
        $stmt->execute([$id]);

        (new ActivityLog($db))->logAction($_SESSION['user']['company_id'], $_SESSION['user']['id'], 'APPROVE_LOAN', 'loans', $id, "Approved loan #$id");
        
        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        // Store error and redirect to details page
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: /loansaas/public/index.php?url=loan/details&id=" . $id);
        exit;
    }
    
    header("Location: /loansaas/public/index.php?url=loan/details&id=" . $id);
    exit;
}


public function edit($id = null) {
    // 1. Security Check
    if ($_SESSION['user']['role'] !== 'admin') {
        die("Access Denied.");
    }

    $id = $id ?? $_GET['id'] ??     null;
    if (!$id) die("Error: No Loan ID provided.");

    // 2. Instantiate Model
    $loanModel = new Loan(); 
    
    // 3. Use the model's connection to get the DB
    // Assuming your Model has a public method or property to access the connection
    $db = $loanModel->getDb(); 

    // 4. Fetch the Loan
    $loan = $loanModel->getById($id);
    if (!$loan) die("Loan record not found.");

    // 5. Fetch Collateral using the correct connection
    $stmtColl = $db->prepare("SELECT * FROM loan_collaterals WHERE loan_id = ?");
    $stmtColl->execute([$id]);
    $collateral = $stmtColl->fetch(PDO::FETCH_ASSOC);

    // 6. Fetch Accounts (to populate dropdown)
    $stmtAcc = $db->prepare("SELECT id, name FROM accounts WHERE company_id = ?");
    $stmtAcc->execute([$_SESSION['user']['company_id']]);
    $accounts = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);

    require_once __DIR__ . '/../views/admin/loans/edit.php';
}

public function update() {
    $id = $_GET['id'];
    $loanModel = new Loan();
    $accountModel = new Account();
    $db = $loanModel->getDb();

    // 1. Get current (OLD) data for comparison
    $oldLoan = $loanModel->getById($id);
    $oldAmount = (float)$oldLoan['amount'];
    $oldAccountId = $oldLoan['account_id'];

    // 2. Prepare new data from POST
    $newAmount = (float)$_POST['amount'];
    $newInterest = (float)$_POST['interest_rate'];
    $newTotal = $newAmount + ($newAmount * ($newInterest / 100));
    $newAccountId = $_POST['account_id'];

    $db->beginTransaction();
    try {
        // ONLY perform account transaction logic if amount or account changed
        if ($newAmount != $oldAmount || $newAccountId != $oldAccountId) {
            
            // A. REVERSE: Add the OLD amount back to the old account balance
            $accountModel->addTransaction(
                $oldAccountId, 
                $oldAmount, 
                'loan_reversal', 
                "Reversing loan #$id for edit", 
                $id
            );

            // B. APPLY: Subtract the NEW amount from the chosen account
            $accountModel->addTransaction(
                $newAccountId, 
                -$newAmount, 
                'loan_issuance', 
                "Loan #$id re-issued with updated amount", 
                $id
            );
        }

        // C. Update the Loan table
        $stmt = $db->prepare("UPDATE loans SET 
            amount = ?, 
            interest_rate = ?, 
            total_payable = ?, 
            account_id = ?, 
            term_months = ?, 
            term_type = ?, 
            released_date = ?, 
            due_date = ?, 
            notes = ? 
            WHERE id = ?");
        
        $stmt->execute([
            $newAmount, 
            $newInterest, 
            $newTotal, 
            $newAccountId, 
            $_POST['term_months'],
            $_POST['term_type'], 
            $_POST['released_date'], 
            $_POST['due_date'], 
            $_POST['notes'], 
            $id
        ]);

        // D. Update Collateral
        $stmtColl = $db->prepare("UPDATE loan_collaterals SET item_name = ?, estimated_value = ? WHERE loan_id = ?");
        $stmtColl->execute([$_POST['collateral_name'], $_POST['collateral_value'], $id]);

        (new ActivityLog($db))->logAction($_SESSION['user']['company_id'], $_SESSION['user']['id'], 'UPDATE_LOAN', 'loans', $id, "Updated loan #$id");

        $db->commit();
        header("Location: /loansaas/public/index.php?url=loan/details&id=" . $id);
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        die("Error updating loan: " . $e->getMessage());
    }
}
// Change the definition to accept $id = null
public function reject($id = null) {
    // If $id wasn't passed as an argument, get it from $_GET
    $id = $id ?? $_GET['id'] ?? null;

    if (!$id) {
        die("Error: No Loan ID provided.");
    }

    $loanModel = new Loan();
    $accountModel = new Account();
    $db = $loanModel->getDb();
    $loan = $loanModel->getById($id);

    // Only allow rejection if it was previously Approved
    if ($loan['status'] === 'Approved') {
        $db->beginTransaction();
        try {
            // Add the money back to the account
            $accountModel->addTransaction(
                $loan['account_id'], 
                $loan['amount'], 
                'loan_reversal', 
                "Loan #$id rejected, reversing deduction", 
                $id
            );

            // Update status
            $stmt = $db->prepare("UPDATE loans SET status = 'Rejected' WHERE id = ?");
            $stmt->execute([$id]);

            (new ActivityLog($db))->logAction($_SESSION['user']['company_id'], $_SESSION['user']['id'], 'REJECT_LOAN', 'loans', $id, "Rejected loan #$id");
            
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            die("Error: " . $e->getMessage());
        }
    } else {
        // If it was just 'Pending', just update the status without financial impact
        $stmt = $db->prepare("UPDATE loans SET status = 'Rejected' WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    header("Location: /loansaas/public/index.php?url=loan/index");
    exit;
}

}