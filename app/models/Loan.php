<?php
require_once __DIR__ . '/../core/Model.php';

class Loan extends Model {
    // In Loan.php

public function getById($id) {
    // We use a clean string with no hidden characters
    $sql = "SELECT loans.*, b.first_name, b.last_name, b.phone, b.address 
            FROM loans 
            LEFT JOIN borrowers b ON loans.borrower_id = b.id 
            WHERE loans.id = :id";
            
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    
    
    return $result;
}

    public function getAllByCompany($company_id) {
        $stmt = $this->conn->prepare("SELECT * FROM loans WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$company_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // In app/models/Loan.php

public function getApprovedLoansByCompany($company_id) {
    // Look at the status = 'approved'
    $sql = "SELECT l.*, b.first_name, b.last_name 
            FROM loans l
            LEFT JOIN borrowers b ON l.borrower_id = b.id
            WHERE l.company_id = ? AND l.status = 'approved'"; // <--- Check this
            
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$company_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getPaginatedLoans($company_id, $limit, $offset, $filters = []) {
    $where = ["company_id = ?"];
    $params = [$company_id];

    if (!empty($filters['search'])) {
        $where[] = "(b.first_name LIKE ? OR b.last_name LIKE ?)";
        $params[] = "%{$filters['search']}%";
        $params[] = "%{$filters['search']}%";
    }
    if (!empty($filters['status'])) {
        $where[] = "loans.status = ?";
        $params[] = $filters['status'];
    }
    if (!empty($filters['date_from'])) {
        $where[] = "loans.created_at >= ?";
        $params[] = $filters['date_from'];
    }

    $sql = "SELECT loans.*, b.first_name, b.last_name, loans.status as display_status 
            FROM loans 
            LEFT JOIN borrowers b ON loans.borrower_id = b.id 
            WHERE " . implode(" AND ", $where) . " 
            ORDER BY loans.id DESC LIMIT $limit OFFSET $offset";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTotalLoans($company_id, $filters = []) {
    $where = ["company_id = ?"];
    $params = [$company_id];

    if (!empty($filters['search'])) {
        $where[] = "(b.first_name LIKE ? OR b.last_name LIKE ?)";
        $params[] = "%{$filters['search']}%";
        $params[] = "%{$filters['search']}%";
    }
    if (!empty($filters['status'])) {
        $where[] = "loans.status = ?";
        $params[] = $filters['status'];
    }

    $sql = "SELECT COUNT(*) FROM loans LEFT JOIN borrowers b ON loans.borrower_id = b.id WHERE " . implode(" AND ", $where);
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}
}