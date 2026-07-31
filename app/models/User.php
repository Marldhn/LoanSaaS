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


    public function getRegistrationRequests()
{
    $stmt = $this->conn->prepare("
        SELECT
            c.id,
            c.name AS company_name,
            c.plan_tier,
            c.subscription_status AS status,
            c.created_at,
            u.username
        FROM companies c
        INNER JOIN users u
            ON c.id = u.company_id
        WHERE u.role = 'admin'
        ORDER BY c.created_at DESC
    ");

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function approveRegistration($companyId)
{
    $stmt = $this->conn->prepare("
        UPDATE companies
        SET subscription_status = 'active'
        WHERE id = ?
    ");

    return $stmt->execute([$companyId]);
}

public function rejectRegistration($companyId)
{
    $stmt = $this->conn->prepare("
        UPDATE companies
        SET subscription_status = 'rejected'
        WHERE id = ?
    ");

    return $stmt->execute([$companyId]);
}

    public function registerTenant($companyName, $username, $password) {
        try {
            $this->conn->beginTransaction();

            // Create the company with 'free' tier and 'active' status
            $stmt1 = $this->conn->prepare("INSERT INTO companies (name, plan_tier, subscription_status) VALUES (?, 'free', 'active')");
            $stmt1->execute([$companyName]);
            $companyId = $this->conn->lastInsertId();

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Updated: Added 'status' column. Defaulting to 0 (pending)
            // Ensure your 'users' table has a 'status' column that defaults to 0 or is nullable
            $stmt2 = $this->conn->prepare("INSERT INTO users (company_id, username, password, role, status) VALUES (?, ?, ?, 'admin', 0)");
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


    public function updatePassword($id, $hashedPassword) {
    // Change $this->db to $this->conn to match your Model base class
    $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    return $stmt->execute([$hashedPassword, $id]);
}


public function getAdminsOnly() {
        // This selects all users where the role is 'admin'
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE role = 'admin' ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }


    
    
    // Add to app/models/User.php
public function getAllAdmins() {
    $db = $this->conn; // Assuming $this->conn is your PDO instance
    $stmt = $db->query("
        SELECT u.*, c.name as company_name 
        FROM users u 
        JOIN companies c ON u.company_id = c.id 
        WHERE u.role = 'admin'
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}