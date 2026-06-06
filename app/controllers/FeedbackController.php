<?php
// Location: app/controllers/FeedbackController.php

require_once __DIR__ . '/../models/Loan.php'; 

class FeedbackController {

    public function create() {
        require_once dirname(__DIR__) . '/views/admin/feedback/create.php';
    }

    public function store() {
        $loanModel = new Loan();
        $db = $loanModel->getDb(); 
        
        $imagePath = null;

        // Handle Image Upload if present
        if (isset($_FILES['feedback_image']) && $_FILES['feedback_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(__DIR__, 2) . '/public/uploads/feedback/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['feedback_image']['name']);
            $targetPath = $uploadDir . $fileName;

            // Move file to server
            if (move_uploaded_file($_FILES['feedback_image']['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/feedback/' . $fileName;
            }
        }
        
        // Insert data including image_path
        $stmt = $db->prepare("INSERT INTO feedback (sender_id, company_id, message, image_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user']['id'], 
            $_SESSION['user']['company_id'], 
            $_POST['message'],
            $imagePath
        ]);
        
        header("Location: /loansaas/public/index.php?url=feedback/create");
        exit;
    }

    public function index() {
        // Security check
        if ($_SESSION['user']['role'] !== 'superadmin') {
            die("Access Denied");
        }
        
        $loanModel = new Loan();
        $db = $loanModel->getDb();
        
        // Fetching messages including image_path
        $messages = $db->query("SELECT f.*, u.username 
                                FROM feedback f 
                                JOIN users u ON f.sender_id = u.id 
                                ORDER BY created_at DESC")
                       ->fetchAll(PDO::FETCH_ASSOC);
        
        require_once dirname(__DIR__) . '/views/admin/feedback/index.php';
    }
}