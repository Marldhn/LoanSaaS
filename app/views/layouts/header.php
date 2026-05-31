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
    <aside class="sidebar">
        <div class="sidebar-brand"><i class="fas fa-wallet"></i> Lowndesk</div>
        <ul class="sidebar-menu">
            <li class="menu-item <?= (strpos($current_url, 'loan') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=loan/index"><i class="fas fa-hand-holding-dollar"></i> <span>Loan</span></a>
            </li>
            <li class="menu-item <?= (strpos($current_url, 'borrower') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=borrower/index"><i class="fas fa-users"></i> <span>Borrowers</span></a>
            </li>
            <li class="menu-item <?= (strpos($current_url, 'payment') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=payment/index"><i class="fas fa-receipt"></i> <span>Payments</span></a>
            </li>
            <li class="menu-item">
                <a href="/loansaas/public/index.php?url=auth/logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['username'], 0, 1)) ?></div>
                <div class="user-info">
                    <span class="username"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                       <span class="company"><?= htmlspecialchars($_SESSION['user']['company_name'] ?? 'Admin') ?></span>
                </div>
            </div>
                 <a href="/loansaas/public/index.php?url=auth/logout" class="btn-logout-sidebar"></a>
        </div>
    </aside>
    <main class="main-content">