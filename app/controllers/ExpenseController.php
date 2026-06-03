<?php

require_once __DIR__ . '/../models/Collateral.php';


require_once 'C:/xampp/htdocs/LoanSaaS/app/models/Loan.php';
require_once 'C:/xampp/htdocs/LoanSaaS/app/models/Category.php';
class ExpenseController {
 public function index() {
    $company_id = $_SESSION['user']['company_id'];
    $db = (new Loan())->getDb();

    $stmt = $db->prepare("
        SELECT e.*, c.name as category_name 
        FROM expenses e 
        LEFT JOIN categories c ON e.category_id = c.id 
        WHERE e.company_id = ? 
        ORDER BY e.expense_date DESC
    ");
    $stmt->execute([$company_id]);
    $expenses = $stmt->fetchAll();

    require_once dirname(__DIR__) . '/views/admin/expenses/index.php';
}

  public function store() {
    $db = (new Loan())->getDb();
    $companyId = $_SESSION['user']['company_id'];
    $userId = $_SESSION['user']['id'];
    
    // Start transaction
    $db->beginTransaction();

    try {
        // 1. Save the expense
        $stmt = $db->prepare("INSERT INTO expenses (company_id, account_id, title, amount, category_id, expense_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $companyId,
            $_POST['account_id'],
            $_POST['title'],
            $_POST['amount'],
            $_POST['category_id'],
            $_POST['expense_date'],
            $_POST['notes']
        ]);
        
        $expenseId = $db->lastInsertId();

        // 2. Deduct from the selected account
        $stmt = $db->prepare("UPDATE accounts SET current_balance = current_balance - ? WHERE id = ? AND company_id = ?");
        $stmt->execute([$_POST['amount'], $_POST['account_id'], $companyId]);

        // 3. Log the activity using your ActivityLog model
        require_once 'C:/xampp/htdocs/LoanSaaS/app/models/ActivityLog.php';
        $log = new ActivityLog($db);
        $log->logAction(
            $companyId, 
            $userId, 
            'CREATE_EXPENSE', 
            'expenses', 
            $expenseId, 
            "Created new expense: " . $_POST['title'] . " - Amount: ₱" . number_format($_POST['amount'], 2)
        );

        $db->commit();
        header("Location: /loansaas/public/index.php?url=expense/index&status=success");
    } catch (Exception $e) {
        $db->rollBack();
        die("Error: " . $e->getMessage());
    }
}


public function create() {
    $db = (new Loan())->getDb();
    $company_id = $_SESSION['user']['company_id'];

    // 1. Fetch Accounts
    $stmtAcc = $db->prepare("SELECT id, name, current_balance FROM accounts WHERE company_id = ?");
    $stmtAcc->execute([$company_id]);
    $accounts = $stmtAcc->fetchAll();



 // 1. Fetch categories for this company
    require_once __DIR__ . '/../models/Category.php';
    $categoryModel = new Category();
    $categories = $categoryModel->getAllByCompany($_SESSION['user']['company_id']);
    
    // 3. Fetch expense categories
    $expenseCategories = array_filter($categories, function($cat) {
        return $cat['type'] === 'expense';
    });

    require_once dirname(__DIR__) . '/views/admin/expenses/create.php';
}
}