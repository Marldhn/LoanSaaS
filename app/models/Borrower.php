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


// In Borrower.php

// In Borrower.php
public function getById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM borrowers WHERE id = ? AND company_id = ?");
    $stmt->execute([$id, $this->getTenantId()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Ensure FETCH_ASSOC is used
    return $result;
}

public function update($id, $data) {
    $sql = "UPDATE borrowers 
            SET first_name = ?, last_name = ?, phone = ?, email = ?, address = ?, valid_id = ?
            WHERE id = ? AND company_id = ?";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['phone'],
        $data['email'],
        $data['address'],
        $data['valid_id'],
        $id,
        $this->getTenantId()
    ]);
}
}