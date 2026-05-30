<?php
// Location: C:/xampp/htdocs/loansaas/app/controllers/BorrowerController.php

require_once __DIR__ . '/../models/Borrower.php';

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
            $this->borrowerModel->create([
                'company_id'  => $user['company_id'],
                'first_name'  => $_POST['first_name'],
                'middle_name' => $_POST['middle_name'],
                'last_name'   => $_POST['last_name'],
                'gender'      => $_POST['gender'],
                'birthdate'   => $_POST['birthdate'],
                'phone'       => $_POST['phone'],
                'email'       => $_POST['email'],
                'address'     => $_POST['address'],
                'valid_id'    => $_POST['valid_id']
            ]);
            header("Location: /loansaas/public/index.php?url=borrower/index");
            exit;
        }
    }

    public function toggle($id) {
        $this->borrowerModel->toggleStatus($id);
        header("Location: /loansaas/public/index.php?url=borrower/index");
        exit;
    }
}