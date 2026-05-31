<?php
// Location: C:/xampp/htdocs/loansaas/app/models/ActivityLog.php

require_once __DIR__ . '/../core/Model.php';

class ActivityLog extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function logAction($company_id, $user_id, $action, $table_name, $record_id, $description) {
    $sql = "INSERT INTO activity_logs (company_id, user_id, action, table_name, record_id, description, ip_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);
    $ip = $_SERVER['REMOTE_ADDR'];
    
    return $stmt->execute([$company_id, $user_id, $action, $table_name, $record_id, $description, $ip]);
}

    // Add to ActivityLog.php
public function getRecentLogs($limit = 50) {
    // Ensure you are filtering by the logged-in company
    $sql = "SELECT l.*, u.username 
            FROM activity_logs l
            JOIN users u ON l.user_id = u.id 
            WHERE l.company_id = ? 
            ORDER BY l.created_at DESC LIMIT ?";
            
    $stmt = $this->conn->prepare($sql);
    // Ensure getTenantId() returns $_SESSION['user']['company_id']
    $stmt->execute([$this->getTenantId(), $limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// In ActivityLog.php
public function getAllByCompany($company_id) {
    $sql = "SELECT l.*, u.username 
            FROM activity_logs l
            JOIN users u ON l.user_id = u.id 
            WHERE l.company_id = ? 
            ORDER BY l.created_at DESC";
            
    // Change $this->db to $this->conn 
    // (Most base Models in these types of apps use 'conn' or 'db')
    $stmt = $this->conn->prepare($sql); 
    $stmt->execute([$company_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}