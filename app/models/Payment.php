<?php
require_once __DIR__ . '/../core/Model.php';


class Payment extends Model {
    public function __construct() {
        parent::__construct(); // This ensures $this->conn is initialized from Model
    }
    
    public function getAllByCompany($company_id) {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE company_id = ? ORDER BY payment_date DESC");
        $stmt->execute([$company_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPaidByLoanId($loan_id) {
        // Use $this->conn instead of $this->db
        $stmt = $this->conn->prepare("SELECT SUM(amount) as total FROM payments WHERE loan_id = ?");
        $stmt->execute([$loan_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    // FIXED: Changed $this->db to $this->conn
    public function getByLoanId($loan_id) {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE loan_id = ? ORDER BY payment_date DESC");
        $stmt->execute([$loan_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}