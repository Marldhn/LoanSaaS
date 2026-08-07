<?php
// Location: loansaas/app/controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';


class AuthController {

    private $userModel;


    public function __construct() {
        $this->userModel = new User();
    }



    public function index() {

        header("Location: /loansaas/public/index.php?url=auth/login");
        exit;

    }




    public function authenticate() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);


            $user = $this->userModel->findByUsername($username);



            if ($user && password_verify($password, $user['password'])) {


                // --- APPROVAL CHECK ---
                // Assuming status 1 = Approved, 0 = Pending

                if ((int)$user['status'] !== 1) {

                    $_SESSION['auth_error'] = "Your account is pending approval by the administrator.";

                    header("Location: /loansaas/public/index.php?url=auth/login");

                    exit;

                }

                // -----------------------



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


                $_SESSION['auth_error'] = "Invalid credentials.";

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

            
            // Default status for new registration
            // 0 = Pending approval

            $status = 0;



            if (empty($companyName) || empty($username) || empty($password)) {

                die("All form inputs are strictly required configuration parameters.");

            }




            if ($this->userModel->registerTenant($companyName, $username, $password, $status)) {


                $_SESSION['auth_success'] = "Registration submitted! Please wait for admin approval.";


                header("Location: /loansaas/public/index.php?url=auth/login");

                exit;


            } else {


                die("Registration execution error dropped.");


            }

        }

    }





    public function login() {


        // Capture error from URL

        $error = $_GET['error'] ?? '';

        $message = '';




        if ($error === 'account_closed') {


            $message = "Your account has been closed. Please contact support.";



        } elseif (isset($_SESSION['auth_error'])) {


            $message = $_SESSION['auth_error'];


            unset($_SESSION['auth_error']);

        }




        require_once __DIR__ . '/../views/auth/login.php';


    }





    // Logout user and destroy session

    public function logout()
    {

        if (session_status() === PHP_SESSION_NONE) {

            session_start();

        }


        // Remove all session variables

        $_SESSION = [];



        // Destroy session

        session_destroy();



        // Prevent cached pages after logout

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

        header("Cache-Control: post-check=0, pre-check=0", false);

        header("Pragma: no-cache");



        // Redirect back to login

        header("Location: /loansaas/public/index.php?url=auth/login");

        exit;

    }



}