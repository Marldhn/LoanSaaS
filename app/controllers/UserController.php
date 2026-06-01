<?php
// Location: C:/xampp/htdocs/loansaas/app/controllers/UserController.php

require_once __DIR__ . '/../models/User.php';

class UserController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            header("Location: /loansaas/public/index.php?url=auth/login");
            exit;
        }

        $userModel = new User();
        $users = $userModel->getByCompany($user['company_id']);

        require_once dirname(__DIR__) . '/views/admin/users/index.php';
    }


    public function create() {
    // 1. Start the session and verify user login
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    if (!isset($_SESSION['user'])) {
        header("Location: /loansaas/public/index.php?url=auth/login");
        exit;
    }

    // 2. Load the view only if logged in
    require_once dirname(__DIR__) . '/views/admin/users/create.php';
}

    public function store() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'];

        $userModel = new User();
        $userModel->create([
            'company_id' => $user['company_id'],
            'username'   => $_POST['username'], // Ensure this matches your DB column
            'password'   => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role'       => 'staff'
        ]);

        header("Location: /loansaas/public/index.php?url=user/index");
        exit;
    }

    public function toggle($id) {
    // 1. Start session if not started
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    // 2. Security Check: Are they logged in?
    if (!isset($_SESSION['user'])) {
        header("Location: /loansaas/public/index.php?url=auth/login");
        exit;
    }

    // 3. Security Check: Is the user an Admin?
    if ($_SESSION['user']['role'] !== 'admin') {
        // Stop unauthorized users from even running this logic
        die("Access Denied: Only administrators can modify user status.");
    }

    // 4. Security Check: Prevent self-toggle
    if ($_SESSION['user']['id'] == $id) {
        die("Security Alert: You cannot toggle your own status.");
    }

    // 5. If all checks pass, proceed
    $userModel = new User();
    $userModel->toggleStatus($id);

    header("Location: /loansaas/public/index.php?url=user/index");
    exit;
}

    
}