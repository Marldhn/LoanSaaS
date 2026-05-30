<?php
// Location: C:/xampp/htdocs/loansaas/app/controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        require_once __DIR__ . '/../views/auth/login.php';

        
    }

    public function authenticate() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // --- TEMPORARY BYPASS ---
        if ($username === 'superadmin2') {
            $_SESSION['user'] = [
                'id' => 1,
                'username' => 'superadmin2',
                'role' => 'superadmin',
                'company_id' => 1 // Added this, often required by apps
            ];
            header("Location: /loansaas/public/index.php?url=borrower/index");
            exit;
        }
        // -------------------------

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id'           => $user['id'],
                'company_id'   => $user['company_id'],
                'company_name' => $user['company_name'],
                'username'     => $user['username'],
                'role'         => $user['role']
            ];
            header("Location: /loansaas/public/index.php?url=borrower/index");
            exit;
        } else {
            $_SESSION['auth_error'] = "Invalid verification details match found.";
            header("Location: /loansaas/public/index.php?url=auth/login");
            exit;
        }
    }
}

    public function register() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function storeRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $companyName = trim($_POST['company_name']);
            $username    = trim($_POST['username']);
            $password    = trim($_POST['password']);

            if (empty($companyName) || empty($username) || empty($password)) {
                die("All form inputs are strictly required configuration parameters.");
            }

            if ($this->userModel->registerTenant($companyName, $username, $password)) {
                $_SESSION['auth_success'] = "Workspace environment provisioned! Sign in now.";
                header("Location: /loansaas/public/index.php?url=auth/login");
                exit;
            } else {
                die("Registration execution error dropped.");
            }
        }
    }

    public function logout() {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header("Location: /loansaas/public/index.php?url=auth/login");
        exit;
    }
}