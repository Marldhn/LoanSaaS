<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .header-title h1 { font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; }
    .header-title p { font-size: 14px; color: #64748b; margin: 4px 0 0 0; }
    .btn-primary { background: var(--primary-color); color: #ffffff; padding: 10px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    
    .card-wrapper { background: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .data-table { width: 100%; border-collapse: collapse; text-align: left; }
    .data-table th { background: #f8fafc; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; border-bottom: 1px solid var(--border-color); text-transform: uppercase; letter-spacing: 0.05em; }
    .data-table td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    
    .role-badge { padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; background: #e0e7ff; color: #4338ca; }
    .btn-action { color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.2s; }
    .btn-action:hover { color: var(--primary-color); }
    .text-muted { color: #94a3b8; cursor: not-allowed; font-size: 13px; font-weight: 600; }
</style>

<div class="page-header">
    <div class="header-title">
        <h1>Staff Management</h1>
        <p>Control access and manage team members for this workspace.</p>
    </div>
    <a href="/loansaas/public/index.php?url=user/create" class="btn-primary">
        <i class="fas fa-plus"></i> Add Staff Member
    </a>
</div>

<div class="card-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Access Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">No staff members added yet.</td></tr>
            <?php else: ?>
                <?php foreach ($users as $u): 
                    // Determine if the current user is an admin and if the row is NOT the current logged-in user
                    $isAdmin = ($_SESSION['user']['role'] === 'admin');
                    $isSelf = ($_SESSION['user']['id'] == $u['id']);
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($u['username']) ?></strong></td>
                    <td><span class="role-badge"><?= ucfirst(htmlspecialchars($u['role'])) ?></span></td>
                    <td>
                        <?php if (isset($u['status']) && $u['status'] == 1): ?>
                            <span style="color: #10b981; font-weight: 600; font-size: 12px;">Active</span>
                        <?php else: ?>
                            <span style="color: #ef4444; font-weight: 600; font-size: 12px;">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($isAdmin && !$isSelf): ?>
                            <a href="/loansaas/public/index.php?url=user/toggle/<?= $u['id'] ?>" class="btn-action">
                                <i class="fas fa-sync-alt"></i> Toggle Status
                            </a>
                        <?php else: ?>
                            <span class="text-muted" title="<?= $isSelf ? 'Cannot toggle your own status' : 'Admin access required' ?>">
                                <i class="fas fa-ban"></i> Toggle Status
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>