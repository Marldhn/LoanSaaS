<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .form-container { max-width: 500px; margin: 20px auto; }
    .form-card { background: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; padding: 32px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .card-header { margin-bottom: 24px; }
    .card-header h2 { font-size: 20px; color: #0f172a; margin: 0; }
    .card-header p { font-size: 14px; color: #64748b; margin: 4px 0 0 0; }
    
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; outline: none; }
    .form-input:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
    
    .actions { display: flex; gap: 12px; margin-top: 32px; }
    .btn-submit { background: var(--primary-color); color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; flex: 1; }
    .btn-cancel { background: #f1f5f9; color: #475569; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center; }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="card-header">
            <h2>Add Staff Member</h2>
            <p>Provision a new user account for your workspace.</p>
        </div>

        <form method="POST" action="/loansaas/public/index.php?url=user/store">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input" placeholder="e.g. jdoe_staff" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label class="form-label">Access Role</label>
                <select name="role" class="form-input">
                    <option value="staff">Staff (Standard)</option>
                    <option value="admin">Administrator (Full Access)</option>
                </select>
            </div>

            <div class="actions">
                <a href="/loansaas/public/index.php?url=user/index" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Provision User</button>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>