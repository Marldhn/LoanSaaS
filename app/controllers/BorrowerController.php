<?php
// Location: C:/xampp/htdocs/loansaas/app/controllers/BorrowerController.php

require_once __DIR__ . '/../models/Borrower.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class BorrowerController {
    private $borrowerModel;

    public function __construct() {
        $this->borrowerModel = new Borrower();
    }

    public function index() {
        $borrowers = $this->borrowerModel->getAll();
        require_once __DIR__ . '/../views/admin/borrowers/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../views/admin/borrowers/create.php';
    }

    public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_SESSION['user'];
        
        // 1. Create the borrower 
        // Ensure your Borrower Model's create() method returns $db->lastInsertId();
        $borrower_id = $this->borrowerModel->create([
            'company_id'  => $user['company_id'],
            'first_name'  => $_POST['first_name'],
            'middle_name' => $_POST['middle_name'] ?? '',
            'last_name'   => $_POST['last_name'],
            'gender'      => $_POST['gender'] ?? '',
            'birthdate'   => $_POST['birthdate'] ?? null,
            'phone'       => $_POST['phone'],
            'email'       => $_POST['email'] ?? '',
            'address'     => $_POST['address'],
            'valid_id'    => $_POST['valid_id'] ?? ''
        ]);

        if ($borrower_id) {
            // 2. Log the activity
            (new ActivityLog($this->borrowerModel->getDb()))->logAction(
                $user['company_id'], 
                $user['id'], 
                'CREATE_BORROWER', 
                'borrowers', 
                $borrower_id, 
                "Added new borrower: " . $_POST['first_name'] . " " . $_POST['last_name']
            );
        }

        // Redirect back to index (the modal will close automatically on page reload)
        header("Location: /loansaas/public/index.php?url=borrower/index&status=success");
        exit;
    }
}
    public function toggle($id) {
        $this->borrowerModel->toggleStatus($id);

        (new ActivityLog($this->borrowerModel->getDb()))->logAction(
            $_SESSION['user']['company_id'], 
            $_SESSION['user']['id'], 
            'TOGGLE_BORROWER_STATUS', 
            'borrowers', 
            $id, 
            "Toggled status for borrower ID #$id"
        );

        header("Location: /loansaas/public/index.php?url=borrower/index");
        exit;
    }

    public function edit($id) {
        $borrower = $this->borrowerModel->getById($id);
        require_once __DIR__ . '/../views/admin/borrowers/edit.php';
    }

    public function update($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Fetch current data using the correct method name (getById)
        $borrower = $this->borrowerModel->getById($id); 
        $fullName = ($borrower) ? $borrower['first_name'] . ' ' . $borrower['last_name'] : "ID #$id";

        $data = [
            'first_name'  => $_POST['first_name'],
            'last_name'   => $_POST['last_name'],
            'phone'       => $_POST['phone'],
            'email'       => $_POST['email'],
            'address'     => $_POST['address'],
            'valid_id'    => $_POST['valid_id']
        ];

        // 2. Perform the update
        $this->borrowerModel->update($id, $data);

        // 3. Log using the name
        (new ActivityLog($this->borrowerModel->getDb()))->logAction(
            $_SESSION['user']['company_id'], 
            $_SESSION['user']['id'], 
            'UPDATE_BORROWER', 
            'borrowers', 
            $id, 
            "Updated profile for: " . $fullName
        );
        
        header("Location: /loansaas/public/index.php?url=borrower/index");
        exit;
    }
}

    public function details($id = null) {
        $id = $id ?? $_GET['id'] ?? null;
        if (!$id) die("Error: No Borrower ID provided.");

        $borrower = $this->borrowerModel->getById($id);
        if (!$borrower) die("Borrower not found.");

        $db = $this->borrowerModel->getDb(); 
        $stmt = $db->prepare("SELECT * FROM loans WHERE borrower_id = ? ORDER BY created_at DESC");
        $stmt->execute([$id]);
        $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalLoansCount = count($loans);
        $totalPayable = 0;
        foreach ($loans as $loan) {
            $totalPayable += $loan['total_payable'];
        }

        require_once __DIR__ . '/../views/admin/borrowers/details.php';
    }
}