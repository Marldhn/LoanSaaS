<?php
// app/controllers/CategoryController.php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/ActivityLog.php';


class CategoryController {

    public function index() {
 

        $categoryModel = new Category();
        $categories = $categoryModel->getAllByCompany($_SESSION['user']['company_id']);
        
        // Using the same path style that works in your FeedbackController
        require_once dirname(__DIR__) . '/views/admin/category/index.php';
    }

    public function create() {
        require_once dirname(__DIR__) . '/views/admin/category/create.php';
    }

   public function store() {
    // 1. Force retrieval of session data to ensure variables exist
    $companyId = $_SESSION['user']['company_id'] ?? null;
    $userId = $_SESSION['user']['id'] ?? null;

    if (!$companyId || !$userId) {
        die("Error: Session data missing. Please log in again.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryModel = new Category();
        $name = $_POST['name'] ?? 'Unknown';

        // 2. Save the Category
        $categoryModel->create([
            'company_id'  => $companyId,
            'type'        => $_POST['type'],
            'name'        => $name,
            'description' => $_POST['description'] ?? ''
        ]);

        // 3. Log the activity using the variables we defined above
        $loanModel = new Loan(); // Using Loan model to get the DB connection
        $db = $loanModel->getDb();
        
        $log = new ActivityLog($db);
        $log->logAction(
            $companyId, 
            $userId, 
            'CREATE_CATEGORY', 
            'categories', 
            0, 
            "Created new category: " . $name
        );

        header("Location: /loansaas/public/index.php?url=category/index");
        exit;
    }
}
}