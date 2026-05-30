<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Register Workspace - Lowndesk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f8fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .auth-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); width: 100%; max-width: 420px; padding: 32px; box-sizing: border-box; }
        .brand { display: flex; align-items: center; gap: 8px; font-size: 22px; font-weight: 700; color: #2563eb; justify-content: center; margin-bottom: 24px; }
        .title h2 { text-align: center; margin: 0; font-size: 20px; color: #0f172a; }
        .title p { text-align: center; color: #64748b; font-size: 14px; margin: 6px 0 24px 0; }
        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .form-label { font-size: 13px; font-weight: 600; color: #475569; }
        .form-input { padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; }
        .btn-submit { background: #2563eb; color: #fff; padding: 11px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 8px; width: 100%; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand"><i class="fas fa-wallet"></i> Lowndesk</div>
        <div class="title"><h2>Create an account</h2><p>Provision your micro-lending SaaS platform database matrix instantly.</p></div>
        <form method="POST" action="/loansaas/public/index.php?url=auth/storeregister">
            <div class="form-group"><label class="form-label">Lending Company Name</label><input type="text" name="company_name" class="form-input" required autocomplete="off"></div>
            <div class="form-group"><label class="form-label">Admin Username</label><input type="text" name="username" class="form-input" required autocomplete="off"></div>
            <div class="form-group"><label class="form-label">Security Password</label><input type="password" name="password" class="form-input" required></div>
            <button type="submit" class="btn-submit">Provision My System</button>
        </form>
        <p style="text-align: center; font-size: 13px; color: #64748b; margin-top: 24px;">Already managing a branch? <a href="/loansaas/public/index.php?url=auth/login" style="color: #2563eb; text-decoration: none; font-weight: 600;">Sign in here</a></p>
    </div>
</body>
</html>