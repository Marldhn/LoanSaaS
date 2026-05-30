<?php 
// Location: C:/xampp/htdocs/loansaas/app/views/admin/layouts/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_url = $_GET['url'] ?? '';

// Robustly get the role directly from the session. 
// Ensure 'role' matches the key you used when creating the session during login.
$userRole = $_SESSION['user']['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lowndesk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #2563eb;
            --bg-light: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background: var(--bg-light); color: var(--text-dark); display: flex; min-height: 100vh; overflow-x: hidden; }

        /* --- SIDEBAR STYLES --- */
        .sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-menu {
            list-style: none;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .menu-item a:hover {
            background: #f1f5f9;
            color: var(--text-dark);
        }

        .menu-item.active a {
            background: #eff6ff;
            color: var(--primary-color);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border-color);
            background: #f8fafc;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: #cbd5e1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #475569;
        }

        .user-info .username { font-size: 13px; font-weight: 600; color: var(--text-dark); display: block; }
        .user-info .company { font-size: 11px; color: var(--text-muted); display: block; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .btn-logout-sidebar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px;
            background: #fee2e2;
            color: #ef4444;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-logout-sidebar:hover { background: #fca5a5; }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            padding: 40px;
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-wallet"></i> Lowndesk
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item <?= (strpos($current_url, 'loan') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=loan/index"><i class="fas fa-hand-holding-dollar"></i> Loan Ledger</a>
            </li>
            
            <li class="menu-item <?= (strpos($current_url, 'borrower') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=borrower/index"><i class="fas fa-users"></i> Borrowers</a>
            </li>

            <li class="menu-item <?= (strpos($current_url, 'account') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=account/index"><i class="fas fa-university"></i> Accounts</a>
            </li>

            <li class="menu-item <?= (strpos($current_url, 'payment') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=payment/index"><i class="fas fa-receipt"></i> Payments</a>
            </li>

            <li class="menu-item <?= (strpos($current_url, 'collateral') === 0) ? 'active' : '' ?>">
                <a href="/loansaas/public/index.php?url=collateral/index"><i class="fas fa-shield-halved"></i> Collateral List</a>
            </li>

            <?php if ($userRole === 'superadmin'): ?>
                <li class="menu-item <?= (strpos($current_url, 'company') === 0) ? 'active' : '' ?>">
                    <a href="/loansaas/public/index.php?url=company/index"><i class="fas fa-building"></i> Manage Companies</a>
                </li>
            <?php else: ?>
                <li class="menu-item <?= (strpos($current_url, 'user') === 0) ? 'active' : '' ?>">
                    <a href="/loansaas/public/index.php?url=user/index"><i class="fas fa-user-gear"></i> Staff Management</a>
                </li>
            <?php endif; ?>
        </ul>

      <div class="sidebar-footer">
        <?php if (isset($_SESSION['user'])): ?>
            <div class="user-profile">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['user']['username'], 0, 1)) ?>
                </div>
                <div class="user-info">
                    <span class="username"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                    <span class="company"><?= htmlspecialchars($_SESSION['user']['company_name'] ?? 'Admin') ?></span>
                </div>
            </div>
            <a href="/loansaas/public/index.php?url=auth/logout" class="btn-logout-sidebar">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        <?php endif; ?>
      </div>
    </aside>

    <main class="main-content">


    