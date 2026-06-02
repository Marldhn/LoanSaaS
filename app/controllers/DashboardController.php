<?php
// app/controllers/DashboardController.php
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/Payment.php';

class DashboardController {
    public function index() {
        // Ensure user is logged in and has a company_id
        if (!isset($_SESSION['user']['company_id'])) {
            header("Location: /loansaas/public/index.php?url=auth/login");
            exit;
        }

        $company_id = $_SESSION['user']['company_id'];
        $loanModel = new Loan();
        $db = $loanModel->getDb();

        $stats = [];

        // 1. Total Loans (All statuses)
        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ?");
        $stmt->execute([$company_id]);
        $stats['total_loans'] = $stmt->fetchColumn();

        // 2. Total Collected (From payments)
        $stmt = $db->prepare("SELECT SUM(amount) FROM payments WHERE company_id = ?");
        $stmt->execute([$company_id]);
        $stats['total_collected'] = $stmt->fetchColumn() ?? 0;

        // 3. Total Borrowers (Unique)
        $stmt = $db->prepare("SELECT COUNT(DISTINCT borrower_id) FROM loans WHERE company_id = ?");
        $stmt->execute([$company_id]);
        $stats['total_borrowers'] = $stmt->fetchColumn();

        // 4. Pending Loans
        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ? AND status = 'pending'");
        $stmt->execute([$company_id]);
        $stats['pending_loans'] = $stmt->fetchColumn();

        // 5. Cash on Hand (Sum of all company accounts)
        $stmt = $db->prepare("SELECT SUM(current_balance) FROM accounts WHERE company_id = ?");
        $stmt->execute([$company_id]);
        $stats['cash_on_hand'] = $stmt->fetchColumn() ?? 0;

        // 6. Overdue Loans
        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ? AND status = 'approved' AND due_date < CURDATE()");
        $stmt->execute([$company_id]);
        $stats['overdue_loans'] = $stmt->fetchColumn();

        // 7. Active Loans
        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ? AND status = 'approved'");
        $stmt->execute([$company_id]);
        $stats['active_loans'] = $stmt->fetchColumn();

        // 8. Total Disbursed (Principal lent)
        $stmt = $db->prepare("SELECT SUM(amount) FROM loans WHERE company_id = ? AND status IN ('approved', 'paid')");
        $stmt->execute([$company_id]);
        $stats['total_disbursed'] = $stmt->fetchColumn() ?? 0;

        // 9. Total Profit / Net Cash Flow
        // Calculation: Total Collected - Total Disbursed
        $stats['total_profit'] = $stats['total_collected'] - $stats['total_disbursed'];

        // Load the view
        require_once dirname(__DIR__) . '/views/admin/dashboard/index.php';
    }
}