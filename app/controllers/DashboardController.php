<?php
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Borrower.php';

class DashboardController {
    public function index() {
        if (!isset($_SESSION['user']['company_id'])) {
            header("Location: /loansaas/public/index.php?url=auth/login");
            exit;
        }

        $company_id = $_SESSION['user']['company_id'];
        $loanModel = new Loan();
        $db = $loanModel->getDb();

        $stats = [];

        // 1-8. Basic Stats (Total Loans, Collected, Borrowers, Pending, etc.)
        $stats['total_loans'] = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ?");
        $stats['total_loans']->execute([$company_id]); $stats['total_loans'] = $stats['total_loans']->fetchColumn();

        $stmt = $db->prepare("SELECT SUM(amount) FROM payments WHERE company_id = ?");
        $stmt->execute([$company_id]); $stats['total_collected'] = $stmt->fetchColumn() ?? 0;

        $stmt = $db->prepare("SELECT COUNT(DISTINCT borrower_id) FROM loans WHERE company_id = ?");
        $stmt->execute([$company_id]); $stats['total_borrowers'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ? AND status = 'pending'");
        $stmt->execute([$company_id]); $stats['pending_loans'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT SUM(current_balance) FROM accounts WHERE company_id = ?");
        $stmt->execute([$company_id]); $stats['cash_on_hand'] = $stmt->fetchColumn() ?? 0;

        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ? AND status = 'approved' AND due_date < CURDATE()");
        $stmt->execute([$company_id]); $stats['overdue_loans'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ? AND status = 'approved'");
        $stmt->execute([$company_id]); $stats['active_loans'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT SUM(amount) FROM loans WHERE company_id = ? AND status IN ('approved', 'paid')");
        $stmt->execute([$company_id]); $stats['total_disbursed'] = $stmt->fetchColumn() ?? 0;

        // 9. Total Remaining: Calculate dynamically (Total Payable - Total Paid)
        $stmt = $db->prepare("
            SELECT SUM(l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) 
            FROM loans l 
            WHERE l.company_id = ? AND l.status = 'approved'
        ");
        $stmt->execute([$company_id]);
        $stats['total_remaining'] = $stmt->fetchColumn() ?? 0;
        
        $stats['total_profit'] = $stats['total_collected'] - $stats['total_disbursed'];

        // 10. Chart Data
        $chartStmt = $db->prepare("SELECT DATE(created_at) as date, SUM(amount) as total FROM loans WHERE company_id = ? AND created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) GROUP BY DATE(created_at) ORDER BY date ASC");
        $chartStmt->execute([$company_id]);
        $chartData = $chartStmt->fetchAll(PDO::FETCH_ASSOC);
        $chartLabels = []; $chartTotals = [];
        foreach ($chartData as $row) { $chartLabels[] = date('M d', strtotime($row['date'])); $chartTotals[] = $row['total']; }

        // 11. Active Borrowers with Balance
        $borrowerStmt = $db->prepare("
    SELECT 
        CONCAT(b.first_name, ' ', b.last_name) as name,
        SUM(l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) as total_due
    FROM borrowers b
    JOIN loans l ON b.id = l.borrower_id
    WHERE l.company_id = ? AND l.status = 'approved'
    GROUP BY b.id
    LIMIT 5
");
        $borrowerStmt->execute([$company_id]);
        $activeBorrowers = $borrowerStmt->fetchAll(PDO::FETCH_ASSOC);

        require_once dirname(__DIR__) . '/views/admin/dashboard/index.php';
    }
}