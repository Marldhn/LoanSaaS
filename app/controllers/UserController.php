<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function create() {
        require_once dirname(__DIR__) . '/views/admin/users/create.php';
    }

    public function store() {
        $user = $_SESSION['user'];
        $this->userModel->create([
            'company_id' => $user['company_id'],
            'username'   => $_POST['username'],
            'password'   => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role'       => 'staff'
        ]);
        header("Location: /loansaas/public/index.php?url=business/settings");
        exit;
    }

    public function resetPassword($id) {
    if (session_status() === PHP_SESSION_NONE) session_start();

    // 1. Debug: Make sure we are getting the right ID
    if (!$id) { die("No User ID provided."); }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $defaultPassword = 'password123';
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
        
        // 2. Debug: Check if the model call returns true or false
        $result = $this->userModel->updatePassword($id, $hashedPassword);
        
        if ($result) {
            $_SESSION['success'] = "Password has been reset to 'password123'.";
        } else {
            // If this shows up, your SQL update failed
            die("Error: The password was not updated in the database.");
        }

        header("Location: /loansaas/public/index.php?url=business/settings");
        exit;
    }
}

public function manageAdmins() {
    // 1. Only allow Superadmin
    if ($_SESSION['user']['role'] !== 'superadmin') {
        die("Access Denied");
    }

    // 2. Fetch only Admins or specific users
    $admins = $this->userModel->getAllAdmins(); 
    require_once dirname(__DIR__) . '/views/admin/superadmin_users.php';
}


public function changePassword($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $old = $_POST['old_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];
        
        // 1. Verify the OLD password from the database here
        // 2. Validate $new === $confirm
        // 3. Update with $this->userModel->updatePassword($id, password_hash($new, PASSWORD_DEFAULT));
    }
}


}