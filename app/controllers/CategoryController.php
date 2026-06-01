<?php
// app/controllers/CategoryController.php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {

    public function index() {
        // Same security/role check as your working FeedbackController
        if ($_SESSION['user']['role'] !== 'admin') {
            die("Access Denied");
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getAllByCompany($_SESSION['user']['company_id']);
        
        // Using the same path style that works in your FeedbackController
        require_once dirname(__DIR__) . '/views/admin/category/index.php';
    }

    public function create() {
        require_once dirname(__DIR__) . '/views/admin/category/create.php';
    }

    public function store() {
        $categoryModel = new Category();
        $categoryModel->create([
            'company_id'  => $_SESSION['user']['company_id'],
            'type'        => $_POST['type'],
            'name'        => $_POST['name'],
            'description' => $_POST['description'] ?? ''
        ]);

        header("Location: /loansaas/public/index.php?url=category/index");
        exit;
    }
}