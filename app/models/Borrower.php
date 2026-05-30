<?php
// Location: C:/xampp/htdocs/loansaas/app/models/Borrower.php

require_once __DIR__ . '/../core/Model.php';

class Borrower extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM borrowers WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$this->getTenantId()]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO borrowers (company_id, first_name, middle_name, last_name, gender, birthdate, phone, email, address, valid_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['company_id'],
            $data['first_name'],
            $data['middle_name'] ?? null,
            $data['last_name'],
            $data['gender'] ?? null,
            $data['birthdate'] ?? null,
            $data['phone'],
            $data['email'] ?? null,
            $data['address'],
            $data['valid_id'] ?? null
        ]);
    }

    public function toggleStatus($id) {
        $stmt = $this->conn->prepare("UPDATE borrowers SET status = NOT status WHERE id = ? AND company_id = ?");
        return $stmt->execute([$id, $this->getTenantId()]);
    }
}