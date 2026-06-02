<?php
// Location: C:/xampp/htdocs/loansaas/app/models/Borrower.php

require_once __DIR__ . '/../core/Model.php';

class Tenant extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM tenants WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$this->getTenantId()]);
        return $stmt->fetchAll();
    }

}