<?php
// app/controllers/ActivitylogsController.php

require_once __DIR__ . '/../models/ActivityLog.php';

class ActivitylogsController {
    private $activityModel;

    public function __construct() {
        // Added session check for safety
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']['company_id'])) {
            header("Location: /loansaas/public/index.php?url=auth/login");
            exit;
        }
        $this->activityModel = new ActivityLog();
    }

    public function index() {
        $company_id = $_SESSION['user']['company_id'];
        
        $limit = 10;
        $page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalLogs = $this->activityModel->countByCompany($company_id);
        $totalPages = ceil($totalLogs / $limit);
        $logs = $this->activityModel->getPaginatedByCompany($company_id, $limit, $offset);
        
        require_once __DIR__ . '/../views/admin/activitylogs/index.php';
    }
}