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

    public function countByCompany($company_id) {
        // FIXED: Changed $this->db to $this->conn
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM activity_logs WHERE company_id = ?");
        $stmt->execute([$company_id]);
        return $stmt->fetchColumn();
    }

    public function getPaginatedByCompany($company_id, $limit, $offset) {
        // FIXED: Added JOIN users to get the username for the UI
        $stmt = $this->conn->prepare("
            SELECT l.*, u.username 
            FROM activity_logs l
            JOIN users u ON l.user_id = u.id 
            WHERE l.company_id = ? 
            ORDER BY l.created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, (int)$company_id, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(3, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}