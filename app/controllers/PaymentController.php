<?php
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Loan.php';

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
        $company_id = $_SESSION['user']['company_id'] ?? 0;


        $loanModel = new Loan();
        $db = $loanModel->getDb();

        try {
            $db->beginTransaction();
            // Insert Payment
            $stmt = $db->prepare("INSERT INTO payments (loan_id, company_id, amount, payment_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$loan_id, $company_id, $amount, $payment_date]);
            // Update Loan balance
            $update = $db->prepare("UPDATE loans SET paid_amount = paid_amount + ? WHERE id = ?");
            $update->execute([$amount, $loan_id]);
            $db->commit();
            header("Location: /loansaas/public/index.php?url=loan/details&id=" . $loan_id);
        } catch (Exception $e) {
            $db->rollBack();
            die("Error: " . $e->getMessage());
        }
    }


    public function create() {
    $company_id = $_SESSION['user']['company_id'];
    
    // Get Loans
    $loanModel = new Loan();
    $loans = $loanModel->getApprovedLoansByCompany($company_id);
    
    // Get Accounts (You need this for the dropdown!)
    $accStmt = (new Account())->getDb()->prepare("SELECT id, name, current_balance FROM accounts WHERE company_id = ?");
    $accStmt->execute([$company_id]);
    $accounts = $accStmt->fetchAll(PDO::FETCH_ASSOC);
    
    require_once __DIR__ . '/../views/admin/payments/create.php';
}

}