<?php
// Location: C:/xampp/htdocs/loansaas/app/core/SubscriptionGuard.php

require_once __DIR__ . '/../models/Subscription.php';

class SubscriptionGuard {
    public static function check($user) {
        if (!$user) {
            header("Location: /loansaas/public/index.php?url=auth/login");
            exit;
        }
        // Core subscription bypass or constraints can be verified directly here
        return true;
    }
}