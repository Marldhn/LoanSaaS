<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_url = $_GET['url'] ?? '';
$userRole = $_SESSION['user']['role'] ?? '';
$userName = $_SESSION['user']['username'] ?? $_SESSION['user_name'] ?? 'Administrator';
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
        --border-color: #e2e8f0;
    }
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f8fafc; display: flex; }
    
    /* Sidebar Structure with Collapse Transition */
    .sidebar { 
        width: 260px; 
        height: 100vh; 
        background: var(--sidebar-bg); 
        border-right: 1px solid var(--border-color); 
        display: flex; 
        flex-direction: column; 
        position: fixed; 
        top: 0; 
        left: 0; 
        z-index: 1000; 
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .sidebar-brand { 
        padding: 25px 20px; 
        font-weight: 800; 
        color: var(--primary-color); 
        font-size: 1.2rem; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        white-space: nowrap; 
        overflow: hidden; 
    }
    
    .sidebar-brand span {
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }
    
    .sidebar-menu { 
        list-style: none; 
        padding: 15px; 
        flex-grow: 1; 
        margin: 0; 
        overflow-y: auto; 
        overflow-x: hidden;
    }

    .menu-item { margin-bottom: 4px; }
    
    .menu-item a { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 12px 16px; 
        color: var(--text-muted); 
        text-decoration: none; 
        border-radius: 10px; 
        transition: all 0.2s ease; 
        font-weight: 500; 
        font-size: 0.95rem; 
        white-space: nowrap;
    }

    .menu-item a i {
        min-width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .menu-item a span {
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .menu-item a:hover { background: var(--hover-bg); color: var(--primary-color); }
    .menu-item.active a { background: var(--primary-color); color: #fff; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3); }
    
    .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); display: none; }

    /* Collapsed Sidebar State Classes */
    body.sidebar-collapsed .sidebar {
        width: 78px;
    }

    body.sidebar-collapsed .sidebar-brand span,
    body.sidebar-collapsed .menu-item a span {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    body.sidebar-collapsed .main-wrapper {
        margin-left: 78px;
        width: calc(100% - 78px);
    }

    /* Main Wrapper to handle layout beside sidebar */
    .main-wrapper {
        margin-left: 260px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        width: calc(100% - 260px);
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .main-content { padding: 25px; flex: 1; }

    /* Top Header Custom Styles */
    .top-header {
        position: sticky;
        top: 0;
        z-index: 999;
        height: 70px;
        background: #ffffff;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
        margin: 0;
    }

    .top-header-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .sidebar-toggle-btn {
        background: #f1f5f9;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sidebar-toggle-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .top-header-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    /* Profile Dropdown Navbar Design with Vertical Separator */
    .profile-dropdown-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .profile-trigger {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        user-select: none;
        background: transparent;
        border: none;
        padding: 4px 8px;
        border-radius: 8px;
        transition: background 0.15s ease;
    }

    .profile-trigger:hover {
        background: #f8fafc;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        text-align: right;
    }

    .profile-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }

    .profile-role {
        font-size: 0.7rem;
        color: #64748b;
        text-transform: capitalize;
    }

    /* Dropdown Menu Box */
    .user-dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        width: 190px;
        z-index: 1000;
        padding: 6px 0;
    }

    .user-dropdown-menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        color: var(--text-main);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: background 0.15s ease;
    }

    .user-dropdown-menu a:hover {
        background: #f8fafc;
        color: var(--primary-color);
    }

    .user-dropdown-menu a.logout-link {
        color: #ef4444;
    }

    .user-dropdown-menu a.logout-link:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 4px 0;
    }

    @media (max-width: 900px) {
        .sidebar { left: -260px; transition: 0.3s; }
        .sidebar.active { left: 0; box-shadow: 10px 0 20px rgba(0,0,0,0.1); width: 260px !important; }
        body.sidebar-collapsed .sidebar { left: -260px; }
        body.sidebar-collapsed .sidebar.active { left: 0; width: 260px !important; }
        body.sidebar-collapsed .sidebar.active .sidebar-brand span,
        body.sidebar-collapsed .sidebar.active .menu-item a span {
            opacity: 1;
            visibility: visible;
        }
        .main-wrapper { margin-left: 0 !important; width: 100% !important; }
        .close-btn { display: block !important; }
        .top-header { padding: 0 15px; height: 60px; }
        .main-content { padding: 15px; }
    }
</style>
<script>
    // Apply saved sidebar state instantly before page renders to prevent layout flashing
    if (localStorage.getItem('sidebar_collapsed') === 'true' && window.innerWidth > 900) {
        document.documentElement.classList.add('preload-collapsed');
        document.write('<style>body.sidebar-collapsed .sidebar { width: 78px; } body.sidebar-collapsed .sidebar-brand span, body.sidebar-collapsed .menu-item a span { opacity: 0; visibility: hidden; pointer-events: none; } body.sidebar-collapsed .main-wrapper { margin-left: 78px; width: calc(100% - 78px); }</style>');
        document.body ? document.body.classList.add('sidebar-collapsed') : document.addEventListener('DOMContentLoaded', () => document.body.classList.add('sidebar-collapsed'));
    }
</script>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-wallet" style="background: #e0e7ff; padding: 8px; border-radius: 8px;"></i> 
        <span>Lowndesk</span>
        <button onclick="document.querySelector('.sidebar').classList.remove('active')" 
                style="margin-left:auto; border:none; background:none; cursor:pointer; display:none;" class="close-btn"><i class="fas fa-times"></i></button>
    </div>

    <ul class="sidebar-menu">
       <?php
        $menuItems = [];

        if ($userRole === 'superadmin') {
            $menuItems = [
                                ['url' => 'superadmin/dashboard', 'icon' => 'fa-chart-line', 'label' => 'Admin Dashboard'],

                ['url' => 'feedback/index', 'icon' => 'fa-inbox', 'label' => 'User Messages'],
                ['url' => 'admin/index', 'icon' => 'fa-building', 'label' => 'Companies'],
                ['url' => 'superadmin/listAdmins', 'icon' => 'fa-user-shield', 'label' => 'Admin List'],
                ['url' => 'superadmin/approvals', 'icon' => 'fa-chart-line', 'label' => 'Registration Requests']
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
            $active = ($current_url === $item['url']) ? 'active' : '';
            echo "<li class='menu-item $active'>
                    <a href='/loansaas/public/index.php?url={$item['url']}' title='{$item['label']}'>
                        <i class='fas {$item['icon']}'></i> 
                        <span>{$item['label']}</span>
                    </a>
                  </li>";
        }
        ?>
    </ul>
</aside>

<!-- Main Wrapper Container -->
<div class="main-wrapper">
    
    <!-- Top Header Bar -->
    <header class="top-header">
        <div class="top-header-left">
            <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" title="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="top-header-right">
            <div class="profile-dropdown-container">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <!-- Vertical Line Separator -->
                    <span style="color: #cbd5e1; font-size: 1.4rem; font-weight: 300;">|</span>
                    
                    <button type="button" class="profile-trigger" id="userDropdownTrigger">
                        <div class="profile-info">
                            <span class="profile-name"><?= htmlspecialchars($userName, ENT_QUOTES) ?></span>
                            <span class="profile-role"><?= htmlspecialchars($userRole ?: 'Active User', ENT_QUOTES) ?></span>
                        </div>
                        <i class="fas fa-chevron-down" style="font-size: 0.75rem; color: #64748b; margin-left: 4px;"></i>
                    </button>
                </div>

                <!-- Dropdown Menu -->
                <div class="user-dropdown-menu" id="userDropdownMenu">
                    <a href="/loansaas/public/index.php?url=admin/settings">
                        <i class="fas fa-gear" style="width: 16px;"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/loansaas/public/index.php?url=auth/logout" class="logout-link">
                        <i class="fas fa-sign-out-alt" style="width: 16px;"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <script>
            // Sidebar Collapse and Dropdown Toggle Handlers with LocalStorage Persistence
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebar = document.querySelector('.sidebar');
                
                // Sync initial state from local storage on load
                if (localStorage.getItem('sidebar_collapsed') === 'true' && window.innerWidth > 900) {
                    document.body.classList.add('sidebar-collapsed');
                }

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (window.innerWidth <= 900) {
                            sidebar.classList.toggle('active');
                        } else {
                            document.body.classList.toggle('sidebar-collapsed');
                            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                            localStorage.setItem('sidebar_collapsed', isCollapsed);
                        }
                    });
                }

                const dropdownTrigger = document.getElementById('userDropdownTrigger');
                const dropdownMenu = document.getElementById('userDropdownMenu');

                if (dropdownTrigger && dropdownMenu) {
                    dropdownTrigger.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
                    });

                    window.addEventListener('click', function() {
                        dropdownMenu.style.display = 'none';
                    });
                }

                // Close mobile sidebar when clicking outside
                document.addEventListener('click', (e) => {
                    if (window.innerWidth <= 900 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                });
            });
        </script>