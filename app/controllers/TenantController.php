<?php
// Location: C:/xampp/htdocs/loansaas/app/controllers/TenantController.php

require_once __DIR__ . '/../models/Tenant.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class TenantController {
    private $tenantModel;

    public function __construct() {
        $this->tenantModel = new Tenant();
    }

    public function index() {
        $tenants = $this->tenantModel->getAll();
        require_once __DIR__ . '/../views/admin/tenants/index.php';
    }

}