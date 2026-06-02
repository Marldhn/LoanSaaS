<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .page-header { margin-bottom: 24px; }
    .card-wrapper { background: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; border-bottom: 1px solid var(--border-color); text-transform: uppercase; }
    .data-table td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    .btn-reset { color: #e11d48; text-decoration: none; font-weight: 600; font-size: 13px; cursor: pointer; }
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
    .modal-content { background: white; padding: 24px; border-radius: 12px; width: 400px; }
</style>

<div class="page-header">
    <h1>Administrator Management</h1>
    <p style="color: #64748b;">Manage system administrators and reset their credentials.</p>
</div>

<div class="card-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><strong><?= htmlspecialchars($u['username']) ?></strong></td>
                <td><?= ucfirst(htmlspecialchars($u['role'])) ?></td>
                <td>
                    <a href="#" onclick="openResetModal(<?= $u['id'] ?>); return false;" class="btn-reset">
                        <i class="fas fa-key"></i> Reset Password
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="resetModal" class="modal">
    <div class="modal-content">
        <h3 style="margin-top:0;">Confirm Reset</h3>
        <p>This will set the password for this administrator to <strong>password123</strong>. Proceed?</p>
        <form id="resetForm" method="POST" action="">
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" onclick="closeModal()" style="padding: 8px 16px; border-radius: 6px; border: 1px solid #ddd; background: #fff; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 8px 16px; border-radius: 6px; border: none; background: #e11d48; color: white; cursor: pointer;">Reset Password</button>
            </div>
        </form>
    </div>
</div>



<script>
function openResetModal(userId) {
    document.getElementById('resetModal').style.display = 'flex';
    document.getElementById('resetForm').action = '/loansaas/public/index.php?url=user/resetPassword/' + userId;
}
function closeModal() {
    document.getElementById('resetModal').style.display = 'none';
}
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>