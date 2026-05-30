<?php
require_once __DIR__ . '/../models/Account.php';

class AccountController {

    public function index() {
        $accountModel = new Account();
        // This now correctly calls the method from the Model
        $accounts = $accountModel->getAll(); 
        require_once __DIR__ . '/../views/admin/accounts/index.php';
    }

    public function storeAccount() {
        $acc = new Account();
        $acc->create($_POST['name'], $_POST['initial_balance']);
        header("Location: /loansaas/public/index.php?url=account/index");
    }

    public function transfer() {
        $acc = new Account();
        $success = $acc->transferFunds(
            $_POST['from_id'], 
            $_POST['to_id'], 
            $_POST['amount'], 
            $_POST['notes']
        );
        
        if ($success) {
            header("Location: /loansaas/public/index.php?url=account/index&msg=success");
        } else {
            header("Location: /loansaas/public/index.php?url=account/index&msg=error");
        }
    }
}