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

        // 1-8. Basic Stats
        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ?");
        $stmt->execute([$company_id]); 
        $stats['total_loans'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT SUM(amount) FROM payments WHERE company_id = ?");
        $stmt->execute([$company_id]); 
        $stats['total_collected'] = $stmt->fetchColumn() ?? 0;

        $stmt = $db->prepare("SELECT COUNT(DISTINCT borrower_id) FROM loans WHERE company_id = ?");
        $stmt->execute([$company_id]); 
        $stats['total_borrowers'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ? AND status = 'pending'");
        $stmt->execute([$company_id]); 
        $stats['pending_loans'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT SUM(current_balance) FROM accounts WHERE company_id = ?");
        $stmt->execute([$company_id]); 
        $stats['cash_on_hand'] = $stmt->fetchColumn() ?? 0;

        // Overdue Loans Count
        $stmt = $db->prepare("
            SELECT COUNT(*) 
            FROM loans l 
            WHERE l.company_id = ? 
            AND l.due_date < CURDATE()
            AND (l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) > 0
        ");
        $stmt->execute([$company_id]);
        $stats['overdue_loans'] = $stmt->fetchColumn();

        // Active Loans Count (FIXED: Supports both 'approved' AND 'Active')
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM loans l 
            WHERE l.company_id = ? AND l.status IN ('approved', 'Active')
            AND (l.total_payable + (SELECT IFNULL(SUM(amount), 0) FROM penalties WHERE loan_id = l.id) 
                 - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) > 0
        ");
        $stmt->execute([$company_id]); 
        $stats['active_loans'] = $stmt->fetchColumn();

        $stmt = $db->prepare("SELECT SUM(amount) FROM loans WHERE company_id = ? AND status IN ('approved', 'Active', 'paid')");
        $stmt->execute([$company_id]); 
        $stats['total_disbursed'] = $stmt->fetchColumn() ?? 0;

        $stmt = $db->prepare("SELECT SUM(amount) FROM expenses WHERE company_id = ?");
        $stmt->execute([$company_id]); 
        $stats['total_expenses'] = $stmt->fetchColumn() ?? 0;

        // 9. Total Remaining & Profit
        $stmt = $db->prepare("
            SELECT SUM(
                (l.total_payable + (SELECT IFNULL(SUM(amount), 0) FROM penalties WHERE loan_id = l.id)) 
                - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)
            ) 
            FROM loans l 
            WHERE l.company_id = ? AND l.status IN ('approved', 'Active')
        ");
        $stmt->execute([$company_id]);
        $stats['total_remaining'] = $stmt->fetchColumn() ?? 0;
        
        $stats['total_profit'] = $stats['total_collected'] - $stats['total_disbursed'];

        // 10. Chart Data
        $range = isset($_GET['range']) && in_array($_GET['range'], [7, 15, 30, 365]) ? (int)$_GET['range'] : 30;
        $dateRange = [];
        
        for ($i = $range - 1; $i >= 0; $i--) {
            $dateRange[date('Y-m-d', strtotime("-$i days"))] = ['loans' => 0, 'expenses' => 0];
        }

        $loanStmt = $db->prepare("SELECT DATE(created_at) as date, SUM(amount) as total FROM loans WHERE company_id = ? AND created_at >= DATE_SUB(CURDATE(), INTERVAL $range DAY) GROUP BY DATE(created_at)");
        $loanStmt->execute([$company_id]);
        while ($row = $loanStmt->fetch(PDO::FETCH_ASSOC)) {
            if (isset($dateRange[$row['date']])) $dateRange[$row['date']]['loans'] = $row['total'];
        }

        $expStmt = $db->prepare("SELECT DATE(expense_date) as date, SUM(amount) as total FROM expenses WHERE company_id = ? AND expense_date >= DATE_SUB(CURDATE(), INTERVAL $range DAY) GROUP BY DATE(expense_date)");
        $expStmt->execute([$company_id]);
        while ($row = $expStmt->fetch(PDO::FETCH_ASSOC)) {
            if (isset($dateRange[$row['date']])) $dateRange[$row['date']]['expenses'] = $row['total'];
        }

        $chartLabels = []; $chartTotals = []; $chartExpenses = []; $chartProfits = [];
        foreach ($dateRange as $date => $data) {
            $chartLabels[] = date('M d', strtotime($date));
            $chartTotals[] = $data['loans'];
            $chartExpenses[] = $data['expenses'];
            $chartProfits[] = $data['loans'] - $data['expenses'];
        }

        // 11. Active Borrowers
        $borrowerStmt = $db->prepare("
            SELECT CONCAT(b.first_name, ' ', b.last_name) as name,
            SUM(l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) as total_due
            FROM borrowers b
            JOIN loans l ON b.id = l.borrower_id
            WHERE l.company_id = ? AND l.status IN ('approved', 'Active')
            GROUP BY b.id
            LIMIT 20
        ");
        $borrowerStmt->execute([$company_id]);
        $activeBorrowers = $borrowerStmt->fetchAll(PDO::FETCH_ASSOC);

        // 12. Overdue Payments List (FIXED: Added b.email)
        $overdueStmt = $db->prepare("
            SELECT 
                l.id as loan_id,
                l.due_date,
                DATEDIFF(CURDATE(), l.due_date) as days_overdue,
                CONCAT(b.last_name, ', ', b.first_name) as borrower_name,
                b.email,
                (l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) as amount_due
            FROM loans l
            JOIN borrowers b ON l.borrower_id = b.id
            WHERE l.company_id = ? 
              AND l.due_date < CURDATE()
              AND (l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) > 0
            ORDER BY l.due_date ASC
        ");
        $overdueStmt->execute([$company_id]);
        $overduePayments = $overdueStmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        // 13. UPCOMING PAYMENTS LIST (FIXED: Added b.email)
        $upcomingStmt = $db->prepare("
            SELECT 
                l.id as loan_id,
                l.due_date,
                DATEDIFF(l.due_date, CURDATE()) as days_left,
                CONCAT(b.last_name, ', ', b.first_name) as borrower_name,
                b.email,
                (l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) as amount_due
            FROM loans l
            JOIN borrowers b ON l.borrower_id = b.id
            WHERE l.company_id = ? 
              AND l.due_date >= CURDATE()
              AND l.due_date <= DATE_ADD(CURDATE(), INTERVAL 14 DAY)
              AND (l.total_payable - (SELECT IFNULL(SUM(amount), 0) FROM payments WHERE loan_id = l.id)) > 0
            ORDER BY l.due_date ASC
        ");
        $upcomingStmt->execute([$company_id]);
        $upcomingPayments = $upcomingStmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        // 14. Calculate Upcoming Summary Totals for top Cards
        $dueToday = 0;
        $dueThisWeek = 0;
        $dueNext14Days = 0;

        foreach ($upcomingPayments as $payment) {
            $daysLeft = (int)$payment['days_left'];
            $amt = (float)$payment['amount_due'];

            if ($daysLeft === 0) {
                $dueToday += $amt;
            }
            if ($daysLeft >= 0 && $daysLeft <= 7) {
                $dueThisWeek += $amt;
            }
            if ($daysLeft >= 0 && $daysLeft <= 14) {
                $dueNext14Days += $amt;
            }
        }

        require_once dirname(__DIR__) . '/views/admin/dashboard/index.php';
    }
}