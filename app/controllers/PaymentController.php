<?php
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/ActivityLog.php';
require_once __DIR__ . '/../models/Account.php';

class PaymentController {
    public function index() {
        $paymentModel = new Payment();
        $company_id = $_SESSION['user']['company_id'] ?? 0;
        $payments = $paymentModel->getAllByCompany($company_id);
        require_once __DIR__ . '/../views/admin/payments/index.php';
    }

   public function store() {
    $loan_id = $_POST['loan_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $account_id = $_POST['account_id']; // Ensure you capture this
    $company_id = $_SESSION['user']['company_id'] ?? 0;
    $user_id = $_SESSION['user']['id'];

    $loanModel = new Loan();
    $db = $loanModel->getDb();

    try {
        $db->beginTransaction();
        
        // 1. Insert Payment
        $stmt = $db->prepare("INSERT INTO payments (loan_id, company_id, account_id, amount, payment_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$loan_id, $company_id, $account_id, $amount, $payment_date]);
        
        // 2. Remove the UPDATE loans query that caused the SQL error
        
        // 3. Optional: Update Account Balance if needed
        $accUpdate = $db->prepare("UPDATE accounts SET current_balance = current_balance + ? WHERE id = ?");
        $accUpdate->execute([$amount, $account_id]);

        // 4. Add Activity Log
        (new ActivityLog($db))->logAction(
            $company_id, $user_id, 'CREATE_PAYMENT', 'payments', $loan_id, 
            "Received payment of ₱" . number_format($amount, 2) . " for loan #$loan_id"
        );

        $db->commit();
        header("Location: /loansaas/public/index.php?url=loan/details&id=" . $loan_id);
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        die("Error: " . $e->getMessage());
    }
}

  public function create() {
    $company_id = $_SESSION['user']['company_id'];
    $selected_loan_id = $_GET['loan_id'] ?? null;
    
    $loanModel = new Loan();
    $paymentModel = new Payment();
    
    // Fetch approved loans
    $allLoans = $loanModel->getApprovedLoansByCompany($company_id);
    $loans = []; // Initialize a new array for filtered loans
    
    // Calculate balance and filter out fully paid loans
    foreach ($allLoans as $loan) {
        $totalPaid = $paymentModel->getTotalPaidByLoanId($loan['id']);
        $remainingBalance = $loan['total_payable'] - $totalPaid;
        
        // Only add to the list if the balance is greater than 0
        if ($remainingBalance > 0) {
            $loan['remaining_balance'] = $remainingBalance;
            $loans[] = $loan;
        }
    }
    
    // Fetch accounts
    $accStmt = (new Account())->getDb()->prepare("SELECT id, name, current_balance FROM accounts WHERE company_id = ?");
    $accStmt->execute([$company_id]);
    $accounts = $accStmt->fetchAll(PDO::FETCH_ASSOC);
    
    require_once __DIR__ . '/../views/admin/payments/create.php';
}
}