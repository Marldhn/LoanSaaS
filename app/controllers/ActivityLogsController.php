<?php
// app/controllers/ActivitylogsController.php

require_once __DIR__ . '/../models/ActivityLog.php';

class ActivitylogsController { // <--- This MUST match the file name!
    private $activityModel;

    public function __construct() {
        $this->activityModel = new ActivityLog();
    }

    public function index() {
        $logModel = new ActivityLog();
        $logs = $logModel->getAllByCompany($_SESSION['user']['company_id']);
        
        require_once __DIR__ . '/../views/admin/activitylogs/index.php';
    }
}