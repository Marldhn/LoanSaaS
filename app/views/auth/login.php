<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Login - Lowndesk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f8fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .auth-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); width: 100%; max-width: 400px; padding: 32px; box-sizing: border-box; }
        .brand { display: flex; align-items: center; gap: 8px; font-size: 22px; font-weight: 700; color: #2563eb; justify-content: center; margin-bottom: 24px; }
        .title h2 { text-align: center; margin: 0; font-size: 20px; color: #0f172a; }
        .title p { text-align: center; color: #64748b; font-size: 14px; margin: 6px 0 24px 0; }
        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .form-label { font-size: 13px; font-weight: 600; color: #475569; }
        .form-input { padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; }
        .form-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,235,115,0.1); }
        .btn-submit { background: #2563eb; color: #fff; padding: 11px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 8px; width: 100%; }
        .alert { padding: 10px 12px; border-radius: 6px; font-size: 13px; margin-bottom: 16px; }
        .alert-error { background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; }
        .alert-success { background: #dcfce7; border: 1px solid #22c55e; color: #15803d; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand"><i class="fas fa-wallet"></i> Lowndesk</div>
        <div class="title"><h2>Welcome back</h2><p>Access your isolated lending operational environment.</p></div>
        <?php if(isset($_SESSION['auth_error'])): ?><div class="alert alert-error"><?= $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?></div><?php endif; ?>
        <?php if(isset($_SESSION['auth_success'])): ?><div class="alert alert-success"><?= $_SESSION['auth_success']; unset($_SESSION['auth_success']); ?></div><?php endif; ?>
        <form method="POST" action="/loansaas/public/index.php?url=auth/authenticate">
            <div class="form-group"><label class="form-label">Username</label><input type="text" name="username" class="form-input" required autocomplete="off"></div>
            <div class="form-group"><label class="form-label">Password</label><input type="password" name="password" class="form-input" required></div>
            <button type="submit" class="btn-submit">Sign In</button>
        </form>
        <p style="text-align: center; font-size: 13px; color: #64748b; margin-top: 24px;">Need a tenant workspace? <a href="/loansaas/public/index.php?url=auth/register" style="color: #2563eb; text-decoration: none; font-weight: 600;">Register here</a></p>
    </div>
</body>
</html>