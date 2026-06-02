<?php
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/User.php';

class SuperAdminController {
    protected $userModel;

    public function __construct() {
        $this->userModel = new User();
    }


public function listAdmins() {
    // Ensure only SuperAdmin can access
    if ($_SESSION['user']['role'] !== 'superadmin') {
        die("Unauthorized");
    }

    $admins = $this->userModel->getAllAdmins();
    require_once dirname(__DIR__) . '/views/superadmin/admins/adminlist.php';
}


public function businessSettings() {
    // 1. Verify Access
    if ($_SESSION['user']['role'] !== 'admin') {
        die("Unauthorized");
    }

    $companyId = $_SESSION['user']['company_id']; // Assuming this is stored in session

    // 2. Fetch Company Info
    $loanModel = new Loan();
    $db = $loanModel->getDb();
    $stmt = $db->prepare("SELECT * FROM companies WHERE id = ?");
    $stmt->execute([$companyId]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Fetch Staff List
    $staff = $this->userModel->getByCompany($companyId);

    // 4. Load the consolidated view
    require_once dirname(__DIR__, 1) . '/views/admin/settings.php';
}




public function resetPassword($id = null) {
    // If the router didn't pass the ID as an argument, get it from $_GET
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
        
        header("Location: /loansaas/public/index.php?url=admins/index");
        exit;
    }
}


}