<?php
// Location: C:/xampp/htdocs/loansaas/app/core/App.php

class App {
    protected $controller = "AuthController"; 
    protected $method = "login";
    protected $params = [];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $url = $this->parseUrl();
        
        // 1. Identify Controller and Method
        $controllerPart = !empty($url[0]) ? ucfirst($url[0]) . "Controller" : "AuthController";
        
        // Route logic
        $currentRoute = strtolower(($url[0] ?? 'auth') . "/" . ($url[1] ?? 'login'));
        $publicRoutes = ["auth/login", "auth/authenticate", "auth/register", "auth/storeregister"];

        // 2. Authentication Guard
        if (!isset($_SESSION['user']) && !in_array($currentRoute, $publicRoutes)) {
            header("Location: /loansaas/public/index.php?url=auth/login");
            exit;
        }

        // 3. NEW: Check if the company status is 'closed'
        if (isset($_SESSION['user']['company_id'])) {
            require_once __DIR__ . '/../models/Subscription.php';
            $subModel = new Subscription();
            $companyData = $subModel->getCompanySubscription($_SESSION['user']['company_id']);

            // In App.php, inside the subscription status check
if ($companyData && $companyData['subscription_status'] === 'closed') {
    session_destroy();
    // Redirect to login with a specific error code
    header("Location: /loansaas/public/index.php?url=auth/login&error=account_closed");
    exit;
}
        }

        // 4. Resolve Controller File
        $controllerFile = __DIR__ . "/../controllers/" . $controllerPart . ".php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = $controllerPart;
            array_shift($url); // Remove controller name from URL array
        } else {
            // Default to AuthController if file missing
            require_once __DIR__ . "/../controllers/AuthController.php";
            $this->controller = "AuthController";
        }

        $this->controller = new $this->controller;

        // 5. Resolve Method
        if (isset($url[0]) && method_exists($this->controller, $url[0])) {
            $this->method = $url[0];
            array_shift($url);
        } else {
            // If method doesn't exist, we must use the default
            $this->method = 'index'; 
        }

        // 6. Execution
        $this->params = $url ? array_values($url) : [];
        
        if (is_callable([$this->controller, $this->method])) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            die("Error: Method {$this->method} not found in " . get_class($this->controller));
        }
    }

    public function parseUrl() {
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            return explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL));
        }
        return [];
    }
}