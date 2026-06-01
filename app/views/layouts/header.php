<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_url = $_GET['url'] ?? '';
$userRole = $_SESSION['user']['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lowndesk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/loansaas/public/css/style.css">
</head>
<body>
    <aside class="sidebar" style="display: flex; flex-direction: column; height: 100vh; width: 260px; background: #ffffff; border-right: 1px solid #f1f5f9;">
        <div class="sidebar-brand" style="padding: 24px 20px; display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 18px; color: #1e293b; border-bottom: 1px solid #f1f5f9;">
            <i class="fas fa-wallet" style="color: var(--primary-color); font-size: 20px;"></i>
            <span><?= htmlspecialchars($_SESSION['user']['company_name'] ?? 'SHELDONS') ?></span>
        </div>

        <ul class="sidebar-menu" style="list-style: none; padding: 15px 0; margin: 0; flex-grow: 1;">
            <?php
            $menuItems = [
                ['url' => 'loan/index', 'icon' => 'fa-hand-holding-dollar', 'label' => 'Loans'],
                ['url' => 'account/index', 'icon' => 'fa-bank', 'label' => 'Accounts'],
                ['url' => 'borrower/index', 'icon' => 'fa-user-group', 'label' => 'Borrowers'],
                ['url' => 'payment/index', 'icon' => 'fa-receipt', 'label' => 'Payments'],
                ['url' => 'collateral/index', 'icon' => 'fa-shield-halved', 'label' => 'Collateral'],
                ['url' => 'category/index', 'icon' => 'fa-tags', 'label' => 'Manage Categories'],
                ['url' => 'activitylogs/index', 'icon' => 'fa-clock-rotate-left', 'label' => 'Logs'],
                ['url' => 'feedback/create', 'icon' => 'fa-comment', 'label' => 'Send Feedback']
            ];

            // Only show Messages to Admin/Super Admin
            if ($userRole === 'admin') {
                $menuItems[] = ['url' => 'feedback/index', 'icon' => 'fa-inbox', 'label' => 'User Messages'];
            }

            if ($userRole === 'admin') {
                $menuItems[] = ['url' => 'user/index', 'icon' => 'fa-user-gear', 'label' => 'Staff Users'];
            }

            foreach ($menuItems as $item) {
                $active = (strpos($current_url, explode('/', $item['url'])[0]) === 0) ? 'active' : '';
                echo "<li class='menu-item $active'>
                        <a href='/loansaas/public/index.php?url={$item['url']}' style='display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #64748b; text-decoration: none; transition: 0.2s;'>
                            <i class='fas {$item['icon']}'></i> <span>{$item['label']}</span>
                        </a>
                      </li>";
            }
            ?>
        </ul>

        <div class="sidebar-footer" style="padding: 20px; border-top: 1px solid #f1f5f9;">
            <div class="user-profile" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                <div class="user-avatar" style="width: 38px; height: 38px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #475569;">
                    <?= strtoupper(substr($_SESSION['user']['username'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="user-info" style="display: flex; flex-direction: column;">
                    <span style="font-size: 13px; font-weight: 600; color: #0f172a;"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'User') ?></span>
                    <span style="font-size: 11px; color: #64748b; text-transform: capitalize;"><?= htmlspecialchars($_SESSION['user']['role'] ?? 'Staff') ?></span>
                </div>
            </div>
            <a href="/loansaas/public/index.php?url=auth/logout" style="display: block; width: 100%; text-align: center; padding: 10px; background: #fef2f2; color: #dc2626; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600;">
                Logout
            </a>
        </div>
    </aside>
    <main class="main-content">