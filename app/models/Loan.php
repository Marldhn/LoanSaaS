<?php
require_once __DIR__ . '/../core/Model.php';

class Loan extends Model {
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM loans WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByCompany($company_id) {
        $stmt = $this->conn->prepare("SELECT * FROM loans WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$company_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}