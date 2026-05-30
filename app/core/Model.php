<?php
// Location: C:/xampp/htdocs/loansaas/app/core/Model.php

require_once __DIR__ . "/Database.php";

class Model {
    protected $conn;

    public function __construct() {
        // ✅ Call the connection statically since Database handles it as static now!
        $this->conn = Database::getConnection();
    }

    /**
     * Instantly grabs the active workspace tenant isolation ID safely
     */
    protected function getTenantId() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user']['company_id'] ?? 1;
    }

    // Inside app/core/Model.php
public function getDb() {
    return $this->conn;
}
}