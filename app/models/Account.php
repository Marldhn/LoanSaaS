<?php
require_once __DIR__ . '/../core/Model.php';

class Account extends Model {

    public function __construct() {
        // This ensures the parent Model initializes the $this->conn variable
        parent::__construct(); 
    }

    public function getAll() {
        // Added 'icon' to the selected columns
        $stmt = $this->conn->prepare("SELECT id, name, current_balance, icon FROM accounts WHERE company_id = ?");
        $stmt->execute([$this->getTenantId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $initial_balance = 0.00, $icon = null) {
        // Added 'icon' column insertion
        $stmt = $this->conn->prepare("INSERT INTO accounts (company_id, name, current_balance, icon) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->getTenantId(), $name, $initial_balance, $icon]);
    }

    public function update($id, $name, $icon = null) {
        // If a new icon is uploaded, update both name and icon. Otherwise, keep the old icon.
        if ($icon !== null) {
            $stmt = $this->conn->prepare("UPDATE accounts SET name = ?, icon = ? WHERE id = ? AND company_id = ?");
            return $stmt->execute([$name, $icon, $id, $this->getTenantId()]);
        } else {
            $stmt = $this->conn->prepare("UPDATE accounts SET name = ? WHERE id = ? AND company_id = ?");
            return $stmt->execute([$name, $id, $this->getTenantId()]);
        }
    }

    public function transferFunds($from_id, $to_id, $amount, $notes = '') {
        if ($from_id == $to_id) return false;

        $this->conn->beginTransaction();
        try {
            // Subtract from source
            $this->addTransaction($from_id, -$amount, 'transfer_out', "Transfer to Account #$to_id: $notes");
            // Add to destination
            $this->addTransaction($to_id, $amount, 'transfer_in', "Transfer from Account #$from_id: $notes");

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function addTransaction($account_id, $amount, $type, $notes = '', $loan_id = null) {
        // Record the transaction including the loan_id
        $stmt = $this->conn->prepare("
            INSERT INTO account_transactions (company_id, account_id, loan_id, amount, type, notes) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$this->getTenantId(), $account_id, $loan_id, $amount, $type, $notes]);

        // Update the account balance
        $stmt = $this->conn->prepare("
            UPDATE accounts 
            SET current_balance = current_balance + ? 
            WHERE id = ? AND company_id = ?
        ");
        $stmt->execute([$amount, $account_id, $this->getTenantId()]);
    }

    public function getHistoryByLoanId($loan_id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM account_transactions 
            WHERE loan_id = ? AND company_id = ? 
            ORDER BY created_at DESC
        ");
        $stmt->execute([$loan_id, $this->getTenantId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBalance($accountId) {
        // Calculates balance based on the current_balance column in the accounts table
        $stmt = $this->conn->prepare("SELECT current_balance FROM accounts WHERE id = ? AND company_id = ?");
        $stmt->execute([$accountId, $this->getTenantId()]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['current_balance'] ?? 0;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM accounts WHERE id = ? AND company_id = ?");
        $stmt->execute([$id, $this->getTenantId()]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTransactionsByAccountId($account_id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM account_transactions 
            WHERE account_id = ? AND company_id = ? 
            ORDER BY created_at DESC
        ");
        $stmt->execute([$account_id, $this->getTenantId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}