<?php
// Location: app/controllers/FeedbackController.php

// 1. You MUST require the Loan model so the class is found
require_once __DIR__ . '/../models/Loan.php'; 

class FeedbackController {

    public function create() {
        // No session_start() here; it's handled in the header/layout
        require_once dirname(__DIR__) . '/views/admin/feedback/create.php';
    }

    public function store() {
        // Ensure $_SESSION is available without re-starting it
        $loanModel = new Loan();
        $db = $loanModel->getDb(); 
        
        $stmt = $db->prepare("INSERT INTO feedback (sender_id, company_id, message) VALUES (?, ?, ?)");
        $stmt->execute([
            $_SESSION['user']['id'], 
            $_SESSION['user']['company_id'], 
            $_POST['message']
        ]);
        
        header("Location: /loansaas/public/index.php?url=feedback/success");
        exit;
    }

    public function index() {
        // Remove redundant session_start() here as well
        // Security check
        if ($_SESSION['user']['role'] !== 'admin') {
            die("Access Denied");
        }
        
        $loanModel = new Loan();
        $db = $loanModel->getDb();
        
        $messages = $db->query("SELECT f.*, u.username FROM feedback f JOIN users u ON f.sender_id = u.id ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
        
        require_once dirname(__DIR__) . '/views/admin/feedback/index.php';
    }
}