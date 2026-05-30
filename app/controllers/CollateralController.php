<?php
// Location: app/controllers/CollateralController.php
require_once __DIR__ . '/../models/Collateral.php';

class CollateralController {

    public function index() {
        // SECURITY: Check if user is logged in/admin
        if (!isset($_SESSION['user'])) {
            header("Location: /loansaas/public/index.php?url=auth/login"); // <-- The correct path
            exit;
        }

        $collateralModel = new Collateral();
        $collaterals = $collateralModel->getAllWithLoanDetails();
        
        require_once __DIR__ . '/../views/admin/loans/collateral_index.php';
    }
}