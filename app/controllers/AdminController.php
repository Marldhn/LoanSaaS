<?php

require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class AdminController {
    protected $userModel;

    public function __construct() {
        $this->userModel = new User(); 
    }

    public function index() {


        $loanModel = new Loan();
        $db = $loanModel->getDb();
        
        $stmt = $db->query("SELECT * FROM companies ORDER BY created_at DESC");
        $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/superadmin/companies/index.php';
    }

    public function toggleCompanyStatus() {
        if (strtolower(trim($_SESSION['user']['role'] ?? '')) !== 'superadmin') {
            die("Unauthorized access.");
        }

        $id = $_GET['id'] ?? null;
        $newStatus = $_GET['status'] ?? null;

        if ($id && in_array($newStatus, ['active', 'closed'])) {
            $loanModel = new Loan();
            $db = $loanModel->getDb();
            
            $stmt = $db->prepare("UPDATE companies SET subscription_status = ? WHERE id = ?");
            $stmt->execute([$newStatus, $id]);
        }

        header("Location: /loansaas/public/index.php?url=admin/index");
        exit;
    }

   

// Action to update business name
// In AdminController.php

public function settings() {
    // 1. Ensure only an Admin can access this
    if ($_SESSION['user']['role'] !== 'admin') {
        die("Unauthorized access.");
    }

    $companyId = $_SESSION['user']['company_id'];

    // 2. Fetch Company Name
    $loanModel = new Loan();
    $db = $loanModel->getDb();
    $stmt = $db->prepare("SELECT * FROM companies WHERE id = ?");
    $stmt->execute([$companyId]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Fetch Staff List using your existing Model method
    $staff = $this->userModel->getByCompany($companyId);

    // 4. Load the view
        require_once dirname(__DIR__) . '/views/admin/business/settings.php';
}

public function updateBusinessName() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user']['role'] === 'admin') {
        $newName = trim($_POST['business_name']);
        $companyId = $_SESSION['user']['company_id'];;
        
        // Ensure this line is present and correct:
        $userId = $_SESSION['user']['id'] ?? null; 
        
        if (!$userId) {
            die("Error: User session not found. Please log in again.");
        }
        
        $loanModel = new Loan();
        $db = $loanModel->getDb();
        
        // 1. Update the record
        $stmt = $db->prepare("UPDATE companies SET name = ? WHERE id = ?");
        $stmt->execute([$newName, $companyId]);

        // 2. Log the activity with the now-defined $userId
        require_once __DIR__ . '/../models/ActivityLog.php';
        (new ActivityLog($db))->logAction(
            $companyId, 
            $userId, // This is now correctly populated
            'UPDATE_BUSINESS_NAME', 
            'companies', 
            $companyId, 
            "Updated business name to: $newName"
        );
        
        // 3. Update the session
        $_SESSION['user']['company_name'] = $newName;     
        header("Location: /loansaas/public/index.php?url=admin/settings");
        exit;

        session_write_close();

        header("Location: /loansaas/public/index.php?url=admin/settings");
        exit;
    }
}


// In your Controller
public function toggleStatus() {
    $id = $_GET['id'] ?? null;
    if (!$id) return;

    $loanModel = new Loan();
    $db = $loanModel->getDb();

    // Fetch user directly here
    $stmt = $db->prepare("SELECT status FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $newStatus = ($user['status'] == 1) ? 0 : 1;
        
        $updateStmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
        $updateStmt->execute([$newStatus, $id]);
    }

    header("Location: /loansaas/public/index.php?url=admin/settings");
    exit;
}

// DELETE OR COMMENT OUT the old changePassword() method entirely.

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
        
        header("Location: /loansaas/public/index.php?url=admin/settings");
        exit;
    }
}
}