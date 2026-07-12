<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_url = $_GET['url'] ?? '';
$userRole = $_SESSION['user']['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard - Lowndesk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
    :root { 
        --sidebar-bg: #ffffff; 
        --primary-color: #6366f1; 
        --hover-bg: #f5f3ff; 
        --text-main: #1e293b; 
        --text-muted: #64748b;
        --border-color: #f1f5f9;
    }
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f8fafc; }
    
    /* Sidebar Structure */
    .sidebar { width: 260px; height: 100vh; background: var(--sidebar-bg); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 1000; }
    
    .sidebar-brand { padding: 25px 20px; font-weight: 800; color: var(--primary-color); font-size: 1.2rem; display: flex; align-items: center; gap: 10px; }
    
    .sidebar-menu { list-style: none; padding: 15px; flex-grow: 1; margin: 0; }
    .menu-item { margin-bottom: 4px; }
    .menu-item a { 
        display: flex; align-items: center; gap: 12px; padding: 12px 16px; 
        color: var(--text-muted); text-decoration: none; border-radius: 10px; 
        transition: all 0.2s ease; font-weight: 500; font-size: 0.95rem;
    }
    .menu-item a:hover { background: var(--hover-bg); color: var(--primary-color); }
    .menu-item.active a { background: var(--primary-color); color: #fff; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3); }
    
    .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }
    .sidebar-footer a { 
        display: flex; align-items: center; gap: 10px; color: #ef4444 !important; 
        text-decoration: none; font-weight: 600; padding: 10px; border-radius: 8px; 
        transition: background 0.2s;
    }
    .sidebar-footer a:hover { background: #fef2f2; }

    .mobile-header { 
    display: none; 
    background: #ffffff; 
    padding: 15px 20px; 
    border-bottom: 1px solid var(--border-color); 
    align-items: center; 
    justify-content: space-between;
}
    
    .main-content { margin-left: 260px; padding: 25px; }

    @media (max-width: 900px) {
        .sidebar { left: -260px; transition: 0.3s; }
        .sidebar.active { left: 0; box-shadow: 10px 0 20px rgba(0,0,0,0.1); }
        .main-content { margin-left: 0; }
        .close-btn { display: block !important; }
        .mobile-header { display: flex; }
    .main-content { margin-left: 0; padding: 15px; }
    }
</style>
</head>
<body>
<header class="mobile-header">
    <div style="font-weight:700;"><?= htmlspecialchars($_SESSION['user']['company_name'] ?? 'Loan Management') ?></div>
    <button onclick="document.querySelector('.sidebar').classList.toggle('active')" 
            style="border:none; background:none; font-size:20px; cursor:pointer;">
        <i class="fas fa-bars"></i>
    </button>
</header>
<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-wallet" style="background: #e0e7ff; padding: 8px; border-radius: 8px;"></i> 
        Lowndesk
        <button onclick="document.querySelector('.sidebar').classList.remove('active')" 
                style="margin-left:auto; border:none; background:none; cursor:pointer;" class="close-btn"><i class="fas fa-times"></i></button>
    </div>

    <ul class="sidebar-menu">
       <?php
$userRole = $_SESSION['user']['role'] ?? '';
$menuItems = [];

if ($userRole === 'superadmin') {
    $menuItems = [
        ['url' => 'feedback/index', 'icon' => 'fa-inbox', 'label' => 'User Messages'],
        ['url' => 'admin/index', 'icon' => 'fa-building', 'label' => 'Companies'],
        ['url' => 'superadmin/listAdmins', 'icon' => 'fa-user-shield', 'label' => 'Admin List'],
        ['url' => 'superadmin/dashboard', 'icon' => 'fa-chart-line', 'label' => 'Admin Dashboard'],
        ['url' => 'superadmin/manage', 'icon' => 'fa-chart-line', 'label' => 'Registration Requests']
    ];
} elseif ($userRole === 'admin') {
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
} elseif ($userRole === 'staff') {
    $menuItems = [
        ['url' => 'dashboard/index', 'icon' => 'fa-chart-line', 'label' => 'Dashboard'],
        ['url' => 'loan/index', 'icon' => 'fa-hand-holding-dollar', 'label' => 'Loans'],
        ['url' => 'account/index', 'icon' => 'fa-building-columns', 'label' => 'Accounts'],
        ['url' => 'borrower/index', 'icon' => 'fa-users', 'label' => 'Borrowers'],
        ['url' => 'payment/index', 'icon' => 'fa-money-bill-wave', 'label' => 'Payments'],
        ['url' => 'collateral/index', 'icon' => 'fa-shield-halved', 'label' => 'Collateral'],
        ['url' => 'expense/index', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Expenses'],
        ['url' => 'activitylogs/index', 'icon' => 'fa-clock-rotate-left', 'label' => 'Logs'],
        ['url' => 'feedback/create', 'icon' => 'fa-comment-dots', 'label' => 'Send Feedback']
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
        <a href="/loansaas/public/index.php?url=auth/logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>

<main class="main-content">
    <script>
        // Optional: Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            const sidebar = document.querySelector('.sidebar');
            if (!sidebar.contains(e.target) && !e.target.closest('.mobile-header')) {
                sidebar.classList.remove('active');
            }
        });
    </script>