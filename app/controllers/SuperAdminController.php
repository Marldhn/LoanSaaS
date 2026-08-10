<?php
// Location: app/controllers/SuperAdminController.php
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/User.php';

class SuperAdminController {
    protected $userModel;
    protected $db; // 1. Add this property

    public function __construct() {
        $this->userModel = new User();
        
        // 2. Initialize the database connection
        $loanModel = new Loan();
        $this->db = $loanModel->getDb();
    }


       // ============================
    // Registration Requests
    // ============================
    public function approvals()
    {
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Access Denied");
        }

        $registrations = $this->userModel->getRegistrationRequests();

        require_once dirname(__DIR__) . '/views/superadmin/registrations/index.php';
    }

    // ============================
    // Approve Registration
    // ============================
    public function approve($id)
    {
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Access Denied");
        }

        $this->userModel->approveRegistration($id);

        header("Location: /loansaas/public/index.php?url=superadmin/approvals");
        exit;
    }

    // ============================
    // Reject Registration
    // ============================
    public function reject($id)
    {
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Access Denied");
        }

        $this->userModel->rejectRegistration($id);

        header("Location: /loansaas/public/index.php?url=superadmin/approvals");
        exit;
    }

    public function listAdmins() {
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Unauthorized");
        }
        $admins = $this->userModel->getAllAdmins();
require_once dirname(__DIR__) . '/views/superadmin/admins/adminlist.php';    }

    public function businessSettings() {
        if ($_SESSION['user']['role'] !== 'admin') {
            die("Unauthorized");
        }

        $companyId = $_SESSION['user']['company_id'];

        $stmt = $this->db->prepare("SELECT * FROM companies WHERE id = ?");
        $stmt->execute([$companyId]);
        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        $staff = $this->userModel->getByCompany($companyId);

        require_once dirname(__DIR__, 1) . '/views/admin/settings.php';
    }

    public function resetPassword($id = null) {
        if ($id === null) {
            $id = $_GET['id'] ?? null;
        }

        if (!$id) {
            die("Error: No user ID provided.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'] ?? '';

            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->userModel->updatePassword($id, $hashedPassword);
            }
            
            header("Location: /loansaas/public/index.php?url=superadmin/listAdmins");
            exit;
        }
    }

    public function dashboard() {
        // Security Check
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Access Denied");
        }

        // 1. Core Statistics Cards
        $stats = [
            'total_companies' => $this->db->query("SELECT COUNT(*) FROM companies")->fetchColumn(),
            'total_users'     => $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            'total_loans'     => $this->db->query("SELECT COUNT(*) FROM loans")->fetchColumn(),
            'active_loans'    => $this->db->query("SELECT COUNT(*) FROM loans WHERE status = 'active'")->fetchColumn()
        ];

        // 2. Fetch recent companies
        $recentCompanies = $this->db->query("SELECT * FROM companies ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

        // 3. Fetch Real Monthly Loan Trends for the Current Year (for Chart.js)
        $currentYear = date('Y');
        $chartStmt = $this->db->prepare("
            SELECT MONTH(created_at) as month, COUNT(*) as total 
            FROM loans 
            WHERE YEAR(created_at) = ? 
            GROUP BY MONTH(created_at)
        ");
        $chartStmt->execute([$currentYear]);
        $loanDataRaw = $chartStmt->fetchAll(PDO::FETCH_KEY_PAIR); // Returns [month => total]

        // Map data across all 12 months (Jan = 1 to Dec = 12)
        $monthlyLoans = array_fill(1, 12, 0);
        foreach ($loanDataRaw as $month => $total) {
            $monthlyLoans[(int)$month] = (int)$total;
        }
        $loanChartData = array_values($monthlyLoans);

        // 4. Fetch Real Recent Activities (e.g., latest companies joined)
        $recentActivities = $this->db->query("
            SELECT name, created_at, 'company' as type 
            FROM companies 
            ORDER BY created_at DESC 
            LIMIT 4
        ")->fetchAll(PDO::FETCH_ASSOC);

        require_once dirname(__DIR__) . '/views/superadmin/dashboard/dashboard.php';
    }
public function companyDetails($id = null) {
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Access Denied");
        }

        $id = $id ?? ($_GET['id'] ?? null);
        if (!$id) {
            die("Company ID not provided.");
        }

        // Fetch company info
        $stmt = $this->db->prepare("SELECT * FROM companies WHERE id = ?");
        $stmt->execute([$id]);
        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$company) {
            die("Company not found.");
        }

        // Fetch total users belonging to this company
        $userStmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE company_id = ?");
        $userStmt->execute([$id]);
        $totalUsers = $userStmt->fetchColumn();

        // Fetch total loans directly using company_id (matching your Loan model schema)
        $loanStmt = $this->db->prepare("SELECT COUNT(*) FROM loans WHERE company_id = ?");
        $loanStmt->execute([$id]);
        $totalLoans = $loanStmt->fetchColumn();

        require_once dirname(__DIR__) . '/views/superadmin/companies/details.php';
    }

    public function updateSubscription() {
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Access Denied");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $companyId = $_POST['company_id'] ?? null;
            $planTier = $_POST['plan_tier'] ?? 'basic';
            $status = $_POST['subscription_status'] ?? 'active';

            if ($companyId) {
                $stmt = $this->db->prepare("UPDATE companies SET plan_tier = ?, subscription_status = ? WHERE id = ?");
                $stmt->execute([$planTier, $status, $companyId]);
            }

            header("Location: /loansaas/public/index.php?url=superadmin/companyDetails&id=" . $companyId);
            exit;
        }
    }
}