<?php
// Location: C:/xampp/htdocs/loansaas/app/models/Subscription.php

require_once __DIR__ . '/../core/Model.php';

class Subscription extends Model {
    public function getCompanySubscription($companyId) {
        $stmt = $this->conn->prepare("SELECT plan_tier, subscription_status, expires_at FROM companies WHERE id = ? LIMIT 1");
        $stmt->execute([$companyId]);
        return $stmt->fetch();
    }
}