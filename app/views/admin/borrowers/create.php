<?php
// Look up two levels: admin/ -> views/ -> layouts/
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Enroll Borrower - Lowndesk</title>
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f8fafc; padding: 24px; margin: 0; }
        .form-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 28px; max-width: 600px; margin: 0 auto; }
        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .form-label { font-size: 13px; font-weight: 600; color: #475569; }
        .form-input, .form-textarea { padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; width: 100%; box-sizing: border-box; }
        .btn-primary { background: #2563eb; color: #ffffff; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
        .btn-secondary { color: #475569; text-decoration: none; margin-right: 12px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2>Enroll New Borrower Profile</h2>
        <form method="POST" action="/loansaas/public/index.php?url=borrower/store">
            <div class="form-group"><label class="form-label">First Name *</label><input type="text" name="first_name" class="form-input" required></div>
            <div class="form-group"><label class="form-label">Middle Name</label><input type="text" name="middle_name" class="form-input"></div>
            <div class="form-group"><label class="form-label">Last Name *</label><input type="text" name="last_name" class="form-input" required></div>
            <div class="form-group"><label class="form-label">Phone *</label><input type="text" name="phone" class="form-input" required></div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-input"></div>
            <div class="form-group"><label class="form-label">Gender</label><input type="text" name="gender" class="form-input" placeholder="Male/Female"></div>
            <div class="form-group"><label class="form-label">Birthdate</label><input type="date" name="birthdate" class="form-input"></div>
            <div class="form-group"><label class="form-label">Valid ID Serial</label><input type="text" name="valid_id" class="form-input"></div>
            <div class="form-group"><label class="form-label">Residential Address *</label><textarea name="address" class="form-textarea" rows="3" required></textarea></div>
            <div style="text-align: right;">
                <a href="/loansaas/public/index.php?url=borrower/index" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Save Profile Record</button>
            </div>
        </form>
    </div>
</body>
</html>


<?php 
require_once dirname(__DIR__, 2) . '/layouts/footer.php'; 
?>