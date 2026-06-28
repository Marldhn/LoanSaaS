<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Modern Card Layout */
    .settings-container { display: flex; flex-direction: column; gap: 24px; }
    .settings-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .card-header { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .card-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; }
    
    /* Staff Grid Styling */
    .staff-row { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; padding: 16px 24px; border-bottom: 1px solid #f1f5f9; align-items: center; }
    .staff-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .btn-icon { color: #64748b; margin-left: 15px; transition: 0.2s; }
    .btn-icon:hover { color: #6366f1; }
</style>

<div class="settings-container">
    <div class="settings-card">
        <div class="card-header"><h3 class="card-title">Business Settings</h3></div>
        <div style="padding: 24px;">
            <p style="color: #64748b; margin-bottom: 15px; font-size: 0.9rem;">Update your company branding</p>
            <form method="POST" action="/loansaas/public/index.php?url=admin/updateBusinessName" style="display:flex; gap:10px;">
                <input type="text" name="business_name" value="<?= htmlspecialchars($company['name']) ?>" 
                       style="padding: 10px 14px; width: 350px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;">
                <button type="submit" style="padding: 10px 24px; background: #6366f1; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Save Changes</button>
            </form>
        </div>
    </div>

    <div class="settings-card">
    <div class="card-header"><h3 class="card-title">System Maintenance</h3></div>
    <div style="padding: 24px;">
        <p style="color: #64748b; margin-bottom: 15px; font-size: 0.9rem;">
            Export activity logs to CSV and clear database storage. <strong>Keep a backup!</strong>
        </p>
        <a href="/loansaas/public/index.php?url=admintools/exportLogs" 
   class="btn" 
   style="...">
   Download Logs & Clear
</a>
    </div>
</div>

    <div class="settings-card">
        <div class="card-header">
            <h3 class="card-title">Staff Management</h3>
            <a href="/loansaas/public/index.php?url=user/create" style="padding: 8px 16px; background: #6366f1; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">+ Add Staff</a>
        </div>

        <div class="staff-row header">
            <div>Username</div>
            <div>Role</div>
            <div>Status</div>
            <div style="text-align: right;">Actions</div>
        </div>

        <?php foreach ($staff as $u): ?>
        <div class="staff-row">
            <div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($u['username']) ?></div>
            <div style="color: #475569;"><?= ucfirst($u['role']) ?></div>
            <div>
                <span class="status-badge" style="<?= $u['status'] == 1 ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;' ?>">
                    <?= ($u['status'] == 1) ? 'Active' : 'Inactive' ?>
                </span>
            </div>
            <div style="text-align: right;">
                <a href="/loansaas/public/index.php?url=admin/toggleStatus&id=<?= $u['id'] ?>" class="btn-icon" title="Toggle Status"><i class="fas fa-power-off"></i></a>
                <a href="#" onclick="openModal(<?= $u['id'] ?>); return false;" class="btn-icon" title="Change Password"><i class="fas fa-key"></i></a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="modalContainer" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 16px; width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <h3 style="margin-top:0;">Reset Password</h3>
        <form id="changeForm" method="POST" action="">
            <p style="color: #64748b; font-size: 0.9rem;">Set a new temporary password for this user.</p>
            <input type="text" name="new_password" placeholder="Enter new password" required style="width:100%; margin-bottom:20px; padding:12px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing:border-box;">
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="padding: 10px 16px; border:1px solid #e2e8f0; background:white; cursor:pointer; border-radius:8px;">Cancel</button>
                <button type="submit" style="padding: 10px 16px; background: #6366f1; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(userId) {
    document.getElementById('modalContainer').style.display = 'flex';
    document.getElementById('changeForm').action = '/loansaas/public/index.php?url=admin/resetPassword&id=' + userId;
}
function closeModal() { document.getElementById('modalContainer').style.display = 'none'; }
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>