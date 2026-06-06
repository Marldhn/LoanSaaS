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

    public function listAdmins() {
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Unauthorized");
        }

        $admins = $this->userModel->getAllAdmins();
        require_once dirname(__DIR__) . '/views/superadmin/admins/adminlist.php';
    }

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

        // 3. Now $this->db is initialized and safe to use
        $stats = [
            'total_companies' => $this->db->query("SELECT COUNT(*) FROM companies")->fetchColumn(),
            'total_users'     => $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            'total_loans'     => $this->db->query("SELECT COUNT(*) FROM loans")->fetchColumn(),
            'active_loans'    => $this->db->query("SELECT COUNT(*) FROM loans WHERE status = 'active'")->fetchColumn()
        ];

        // Fetch recent companies
        $recentCompanies = $this->db->query("SELECT * FROM companies ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

        require_once dirname(__DIR__) . '/views/superadmin/dashboard/dashboard.php';
    }
}