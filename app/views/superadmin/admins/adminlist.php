<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<div class="page-header">
    <h2>All Company Administrators</h2>
</div>

<div class="card-wrapper">
    <table class="data-table" style="width:100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>Company</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
            <tr>
                <td><?= htmlspecialchars($admin['username']) ?></td>
                <td><?= htmlspecialchars($admin['company_name']) ?></td>
                <td>
                    <a href="#" onclick="openModal(<?= $admin['id'] ?>); return false;" style="color: #6366f1;">Reset Password</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="modalContainer" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 24px; border-radius: 12px; width: 400px;">
        <h3>Reset Admin Password</h3>
        <form id="changeForm" method="POST" action="">
            <input type="text" name="new_password" placeholder="Enter new password" required style="width:100%; margin-bottom:15px; padding:8px;">
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()">Cancel</button>
                <button type="submit">Reset</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(userId) {
    document.getElementById('modalContainer').style.display = 'flex';
    // Ensure 'superadmin/resetPassword' is the route you defined in App.php
    document.getElementById('changeForm').action = '/loansaas/public/index.php?url=superadmin/resetPassword&id=' + userId;
}

function closeModal() {
    document.getElementById('modalContainer').style.display = 'none';
}
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>