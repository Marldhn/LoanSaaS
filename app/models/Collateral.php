<?php
class Collateral extends Model {
    public function __construct() { parent::__construct(); }

    public function add($loan_id, $data, $file_path = null) {
        $stmt = $this->conn->prepare("
            INSERT INTO loan_collaterals (company_id, loan_id, item_name, description, estimated_value, file_path) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $this->getTenantId(), $loan_id, $data['item_name'], 
            $data['description'], $data['value'], $file_path
        ]);
    }

    public function getByLoanId($loan_id) {
        $stmt = $this->conn->prepare("SELECT * FROM loan_collaterals WHERE loan_id = ? AND company_id = ?");
        $stmt->execute([$loan_id, $this->getTenantId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllWithLoanDetails() {
    $stmt = $this->conn->prepare("
        SELECT c.*, l.id as loan_id, b.first_name, b.last_name 
        FROM loan_collaterals c
        JOIN loans l ON c.loan_id = l.id
        JOIN borrowers b ON l.borrower_id = b.id
        WHERE c.company_id = ?
        ORDER BY c.created_at DESC
    ");
    $stmt->execute([$this->getTenantId()]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}