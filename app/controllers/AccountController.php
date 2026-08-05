<?php
require_once __DIR__ . '/../models/Account.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class AccountController {

    public function index() {
        $accountModel = new Account();
        // This now correctly calls the method from the Model
        $accounts = $accountModel->getAll(); 
        require_once __DIR__ . '/../views/admin/accounts/index.php';
    }

    // ADD THIS METHOD TO YOUR ACCOUNT CONTROLLER
   public function storeAccount() {
        $acc = new Account();
        $db = $acc->getDb();
        
        $iconName = null;
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/accounts/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileExtension = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
            $iconName = 'account_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
            move_uploaded_file($_FILES['icon']['tmp_name'], $uploadDir . $iconName);
        }

        // Save account with icon (ensure your Model's create method supports the icon argument, or modify it)
        $acc->create($_POST['name'], $_POST['initial_balance'], $iconName);
        
        // Log the creation
        (new ActivityLog($db))->logAction(
            $_SESSION['user']['company_id'], 
            $_SESSION['user']['id'], 
            'CREATE_ACCOUNT', 
            'accounts', 
            0, 
            "Created new account: " . $_POST['name']
        );

        header("Location: /loansaas/public/index.php?url=account/index");
        exit;
    }

    public function updateAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accountModel = new Account();
            $db = $accountModel->getDb();

            $account_id = $_POST['account_id'];
            $newName = trim($_POST['name']);
            
            // Fetch current account to check old icon
            $currentAccount = $accountModel->getById($account_id);
            $iconName = $currentAccount['icon'] ?? null;

            if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/accounts/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $fileExtension = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
                $iconName = 'account_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
                move_uploaded_file($_FILES['icon']['tmp_name'], $uploadDir . $iconName);
            }

            $db->beginTransaction();
            try {
                $stmt = $db->prepare("UPDATE accounts SET name = ?, icon = ? WHERE id = ?");
                $stmt->execute([$newName, $iconName, $account_id]);

                // Log the activity
                (new ActivityLog($db))->logAction(
                    $_SESSION['user']['company_id'], 
                    $_SESSION['user']['id'], 
                    'UPDATE_ACCOUNT', 
                    'accounts', 
                    $account_id, 
                    "Updated account details for: " . $newName
                );

                $db->commit();
                header("Location: /loansaas/public/index.php?url=account/details&id=" . $account_id);
                exit;
            } catch (Exception $e) {
                $db->rollBack();
                die("Update failed: " . $e->getMessage());
            }
        }
    }

    public function transfer() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fromId = $_POST['from_id'];
        $toId = $_POST['to_id'];
        $amount = (float)$_POST['amount'];

        $accountModel = new Account();
        
        // 1. Get current balance and names of the accounts
        $sourceAccount = $accountModel->getById($fromId);
        $destAccount = $accountModel->getById($toId);
        
        // 2. VALIDATION: Check if source has enough money
        if ($sourceAccount['current_balance'] < $amount) {
            session_start();
            $_SESSION['error_message'] = "Insufficient funds in " . $sourceAccount['name'] . ". Current balance is only ₱" . number_format($sourceAccount['current_balance'], 2);
            header("Location: /loansaas/public/index.php?url=account/index");
            exit;
        }

        // 3. If validation passes, proceed with the transfer
        $db = $accountModel->getDb();
        $db->beginTransaction();
        try {
            // Deduct from source (using name)
            $accountModel->addTransaction($fromId, -$amount, 'transfer_out', "Transfer to " . $destAccount['name']);
            
            // Add to destination (using name)
            $accountModel->addTransaction($toId, $amount, 'transfer_in', "Transfer from " . $sourceAccount['name']);
            
            // Log the transfer
            (new ActivityLog($db))->logAction(
                $_SESSION['user']['company_id'], 
                $_SESSION['user']['id'], 
                'TRANSFER_FUNDS', 
                'accounts', 
                0, 
                "Transferred ₱" . number_format($amount, 2) . " from " . $sourceAccount['name'] . " to " . $destAccount['name']
            );
            
            $db->commit();
            header("Location: /loansaas/public/index.php?url=account/index");
            exit;
        } catch (Exception $e) {
            $db->rollBack();
            session_start();
            $_SESSION['error_message'] = "Transfer failed: " . $e->getMessage();
            header("Location: /loansaas/public/index.php?url=account/index");
            exit;
        }
    }
}

    public function details($id = null) {
    // If the router didn't pass $id, check $_GET
    $id = $id ?? $_GET['id'] ?? null;

    if (!$id) {
        header("Location: /loansaas/public/index.php?url=account/index");
        exit;
    }

    $accountModel = new Account();
    $account = $accountModel->getById($id);
    
    if (!$account) {
        die("Account not found.");
    }

    $transactions = $accountModel->getTransactionsByAccountId($id);
    
    // Explicitly require the details view
    require_once __DIR__ . '/../views/admin/accounts/details.php';
}


// NEW METHOD ADDED HERE
    public function processAdjustment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accountModel = new Account();
            $db = $accountModel->getDb();
            
            $amount = (float)$_POST['amount'];
            $type = $_POST['type'];
            $account_id = $_POST['account_id'];
            $notes = $_POST['notes'];
            
            $finalAmount = ($type === 'deduct') ? -$amount : $amount;

            $db->beginTransaction();
            try {
                // Add the transaction record
                $accountModel->addTransaction($account_id, $finalAmount, 'adjustment', $notes);

                // Log the activity
                (new ActivityLog($db))->logAction(
                    $_SESSION['user']['company_id'], 
                    $_SESSION['user']['id'], 
                    'ADJUST_BALANCE', 
                    'accounts', 
                    $account_id, 
                    "Adjusted account balance: $type ₱" . number_format($amount, 2) . " | Note: " . $notes
                );

                $db->commit();
                header("Location: /loansaas/public/index.php?url=account/details&id=" . $account_id);
            } catch (Exception $e) {
                $db->rollBack();
                die("Adjustment failed: " . $e->getMessage());
            }
        }
    }
}