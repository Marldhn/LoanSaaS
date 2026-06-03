<style>
    .sidebar { width: 260px; height: 100vh; background: #fff; border-right: 1px solid #f1f5f9; display: flex; flex-direction: column; position: fixed; }
.sidebar-brand { padding: 24px 20px; display: flex; align-items: center; gap: 12px; font-weight: 700; color: #1e293b; border-bottom: 1px solid #f1f5f9; }
.sidebar-menu { list-style: none; padding: 15px 0; margin: 0; flex-grow: 1; }
.menu-item a { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #64748b; text-decoration: none; }
.menu-item.active a { background: #f1f5f9; color: var(--primary-color); border-right: 3px solid var(--primary-color); }
.sidebar-footer { padding: 20px; border-top: 1px solid #f1f5f9; }
.user-profile { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
.user-avatar { width: 38px; height: 38px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
.logout-btn { display: block; width: 100%; text-align: center; padding: 10px; background: #fef2f2; color: #dc2626; border-radius: 8px; text-decoration: none; font-size: 12px; }
.main-content { margin-left: 260px; padding: 20px; }
</style>

<?php

if (session_status() === PHP_SESSION_NONE) session_start();
$current_url = $_GET['url'] ?? '';
$userRole = $_SESSION['user']['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lowndesk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/loansaas/public/css/style.css">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-wallet"></i>
            <span><?= htmlspecialchars($_SESSION['company_name'] ?? 'SHELDONS') ?></span>
        </div>

        <ul class="sidebar-menu">
            <?php
            $menuItems = [];
            if ($userRole === 'superadmin') {
                $menuItems = [
                    ['url' => 'feedback/index', 'icon' => 'fa-inbox', 'label' => 'User Messages'],
                    ['url' => 'admin/index', 'icon' => 'fa-building', 'label' => 'Companies'],
                    ['url' => 'superadmin/listAdmins', 'icon' => 'fa-user-shield', 'label' => 'Admin List']
                ];
            } elseif ($userRole === 'admin' || $userRole === 'staff') {
                $menuItems = [
                    ['url' => 'dashboard/index', 'icon' => 'fa-chart-line', 'label' => 'Dashboard'],
                    ['url' => 'loan/index', 'icon' => 'fa-hand-holding-dollar', 'label' => 'Loans'],
                    ['url' => 'account/index', 'icon' => 'fa-building-columns', 'label' => 'Accounts'],
                    ['url' => 'borrower/index', 'icon' => 'fa-users', 'label' => 'Borrowers'],
                    ['url' => 'payment/index', 'icon' => 'fa-money-bill-wave', 'label' => 'Payments'],
                    ['url' => 'collateral/index', 'icon' => 'fa-shield-halved', 'label' => 'Collateral'],
                    ['url' => 'expense/index', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Expenses'],
                    ['url' => 'category/index', 'icon' => 'fa-tags', 'label' => 'Categories'],
                    ['url' => 'activitylogs/index', 'icon' => 'fa-clock-rotate-left', 'label' => 'Logs'],
                    ['url' => 'feedback/create', 'icon' => 'fa-comment-dots', 'label' => 'Send Feedback'],
                    ['url' => 'admin/settings', 'icon' => 'fa-gear', 'label' => 'Settings']
                ];
            }

            foreach ($menuItems as $item) {
                $active = (strpos($current_url, explode('/', $item['url'])[0]) === 0) ? 'active' : '';
                echo "<li class='menu-item $active'>
                        <a href='/loansaas/public/index.php?url={$item['url']}'>
                            <i class='fas {$item['icon']}'></i> <span>{$item['label']}</span>
                        </a>
                      </li>";
            }
            ?>
        </ul>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['username'] ?? 'U', 0, 1)) ?></div>
                <div class="user-info">
                    <strong><?= htmlspecialchars($_SESSION['user']['username'] ?? 'User') ?></strong>
                    <span><?= htmlspecialchars($_SESSION['user']['role'] ?? 'Staff') ?></span>
                </div>
            </div>
            <a href="/loansaas/public/index.php?url=auth/logout" class="logout-btn">Logout</a>
        </div>
    </aside>
    <main class="main-content">