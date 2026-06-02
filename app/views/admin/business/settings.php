<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .card-wrapper { background: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .data-table { width: 100%; border-collapse: collapse; text-align: left; }
    .data-table th { background: #f8fafc; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; border-bottom: 1px solid var(--border-color); }
    .data-table td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    .btn-action { color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; cursor: pointer; }
</style>

<div class="page-header">
    <h1>Business Settings</h1>
</div>

<div class="card-wrapper">
    <h3>Update Business Name</h3>
    <form method="POST" action="/loansaas/public/index.php?url=admin/updateBusinessName">
        <input type="text" name="business_name" value="<?= htmlspecialchars($company['name']) ?>" style="padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" style="padding: 8px 16px; background: var(--primary-color); color: white; border: none; border-radius: 4px;">Save</button>
    </form>
</div>

<div class="card-wrapper">
    <div class="page-header">
        <h3>Staff Management</h3>
        <a href="/loansaas/public/index.php?url=user/create" class="btn-primary" style="text-decoration:none; padding: 8px 12px; background: var(--primary-color); color: white; border-radius: 5px;">+ Add Staff</a>
    </div>
    <table class="data-table">
        <thead>
            <tr><th>Username</th><th>Role</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($staff as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= ucfirst($u['role']) ?></td>
                <td><?= ($u['status'] == 1) ? 'Active' : 'Inactive' ?></td>

    <td>
<a href="/loansaas/public/index.php?url=admin/toggleStatus&id=<?= $u['id'] ?>" class="btn-action" style="margin-right:15px;">
    Toggle Status
</a>
<a href="#" onclick="openModal(<?= $u['id'] ?>); return false;" class="btn-action" style="color: #6366f1;">Change Pass</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="modalContainer" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 24px; border-radius: 12px; width: 400px;">
        <h3>Reset User Password</h3>
        <form id="changeForm" method="POST" action="">
            <p style="font-size: 13px; color: #64748b;">Set a new temporary password for this user.</p>
            <input type="text" name="new_password" placeholder="Enter new password" required style="width:100%; margin-bottom:15px; padding:8px; border: 1px solid #ccc; border-radius: 4px;">
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()">Cancel</button>
                <button type="submit" style="background: #6366f1; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Reset Password</button>
            </div>
        </form>
    </div>
</div>
<script>
function openModal(userId) {
    document.getElementById('modalContainer').style.display = 'flex';
    // Ensure this matches the route to your resetPassword function
    document.getElementById('changeForm').action = '/loansaas/public/index.php?url=admin/resetPassword&id=' + userId;
}
function closeModal() {
    document.getElementById('modalContainer').style.display = 'none';
}


</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>