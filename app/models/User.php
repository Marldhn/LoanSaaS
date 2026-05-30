<?php
// Location: C:/xampp/htdocs/loansaas/app/models/User.php

require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function findByUsername($username) {
        $stmt = $this->conn->prepare("
            SELECT users.*, companies.name as company_name, companies.plan_tier 
            FROM users 
            JOIN companies ON users.company_id = companies.id 
            WHERE users.username = ?
        ");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function registerTenant($companyName, $username, $password) {
        try {
            $this->conn->beginTransaction();

            $stmt1 = $this->conn->prepare("INSERT INTO companies (name, plan_tier, subscription_status) VALUES (?, 'free', 'active')");
            $stmt1->execute([$companyName]);
            $companyId = $this->conn->lastInsertId();

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt2 = $this->conn->prepare("INSERT INTO users (company_id, username, password, role) VALUES (?, ?, ?, 'admin')");
            $stmt2->execute([$companyId, $username, $hashedPassword]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }


    // Add to your existing User class
public function listAllStaff() {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE company_id = ? ORDER BY id DESC");
    $stmt->execute([$this->getTenantId()]);
    return $stmt->fetchAll();
}

public function createStaff($username, $password, $role) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $this->conn->prepare("INSERT INTO users (company_id, username, password, role) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$this->getTenantId(), $username, $hashedPassword, $role]);
}

public function getByCompany($companyId) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$companyId]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO users (company_id, username, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['company_id'], $data['username'], $data['password'], $data['role']]);
    }

    public function toggleStatus($id) {
        // Assuming you have a 'status' column (1=Active, 0=Inactive)
        $stmt = $this->conn->prepare("UPDATE users SET status = NOT status WHERE id = ?");
        return $stmt->execute([$id]);
    }
}