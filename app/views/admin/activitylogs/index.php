<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .customer-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .customer-list { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    
    .log-row { display: grid; grid-template-columns: 1fr 1.5fr 1fr 3fr 1fr; padding: 15px 20px; border-bottom: 1px solid #f1f5f9; align-items: center; }
    .log-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
    
    .badge-info { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .avatar-mini { width: 32px; height: 32px; background: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem; margin-right: 10px; }
</style>

<div class="customer-card">
    <h2 style="margin:0;">System Activity Logs</h2>
    <p style="margin:5px 0 0; color: #94a3b8; font-size: 0.9rem;">Track all administrative actions and system events</p>
</div>

<div class="customer-list">
    <div class="log-row header">
        <div>User</div>
        <div>Action</div>
        <div>Category</div>
        <div>Description</div>
        <div style="text-align: right;">Date</div>
    </div>

    <?php if (empty($logs)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8;">No recent activities found.</div>
    <?php else: ?>
        <?php foreach ($logs as $log): ?>
            <div class="log-row">
                <div style="display: flex; align-items: center;">
                    <div class="avatar-mini"><?= strtoupper(substr($log['username'], 0, 1)) ?></div>
                    <strong><?= htmlspecialchars($log['username']) ?></strong>
                </div>
                <div><span class="badge-info"><?= htmlspecialchars($log['action']) ?></span></div>
                <div><code><?= htmlspecialchars($log['table_name']) ?></code></div>
                <div style="font-size: 0.9rem; color: #475569;"><?= htmlspecialchars($log['description']) ?></div>
                <div style="text-align: right; font-size: 0.85rem; color: #64748b;">
                    <?= date('M d, H:i', strtotime($log['created_at'])) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
    <div style="padding: 20px; display: flex; justify-content: center; gap: 10px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?url=activitylogs/index&page=<?= $i ?>" 
               style="padding: 6px 12px; border-radius: 6px; text-decoration: none; 
                      background: <?= ($i == $page) ? '#6366f1' : '#fff' ?>; 
                      color: <?= ($i == $page) ? '#fff' : '#64748b' ?>; 
                      border: 1px solid #e2e8f0; font-size: 0.85rem;">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>