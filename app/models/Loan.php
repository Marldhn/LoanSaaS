<?php
require_once __DIR__ . '/../core/Model.php';

class Loan extends Model {
    // In Loan.php

public function getById($id) {
    // We join the borrowers table (aliased as 'b') to get their details
    $stmt = $this->conn->prepare("
        SELECT loans.*, 
               b.first_name, 
               b.last_name, 
               b.phone, 
               b.address 
        FROM loans 
        LEFT JOIN borrowers b ON loans.borrower_id = b.id 
        WHERE loans.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function getAllByCompany($company_id) {
        $stmt = $this->conn->prepare("SELECT * FROM loans WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$company_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // In app/models/Loan.php

public function getApprovedLoansByCompany($company_id) {
    // We CONCAT the first and last name here
    $sql = "SELECT l.*, CONCAT(b.first_name, ' ', b.last_name) AS borrower_name 
            FROM loans l
            LEFT JOIN borrowers b ON l.borrower_id = b.id
            WHERE l.company_id = ? AND l.status = 'approved'";
            
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$company_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}