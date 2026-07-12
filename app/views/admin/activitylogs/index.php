<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Page Header */
    .customer-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    
    /* Layout Setup */
    .customer-list { background: transparent; }
    
    /* Desktop Row: Card-based grid (5 columns) */
    .log-row { 
        display: grid; 
        grid-template-columns: 1.5fr 1fr 1fr 3fr 1fr; 
        padding: 16px 20px; 
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        gap: 15px;
    }

    /* Header Row (Hidden on mobile) */
    .log-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 0.8rem; text-transform: uppercase; }
    
    /* Badge & Avatar Styles */
    .badge-info { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; white-space: nowrap; }
    .avatar-mini { width: 32px; height: 32px; background: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem; margin-right: 10px; flex-shrink: 0; }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .log-row.header { display: none; } /* Hide header on mobile */
        
        .log-row {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .log-row > div { width: 100%; text-align: left !important; }
        
        .mobile-meta { 
            display: flex; 
            justify-content: space-between; 
            width: 100%; 
            align-items: center; 
            margin-top: 5px;
        }
    }
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

                <div>
                    <span class="badge-info"><?= htmlspecialchars($log['action']) ?></span>
                </div>

                <div><code><?= htmlspecialchars($log['table_name']) ?></code></div>

                <div style="color: #475569;"><?= htmlspecialchars($log['description']) ?></div>

                <div style="text-align: right;" class="mobile-meta">
                    <span style="font-size: 0.85rem; color: #64748b;">
                        <?= date('M d, H:i', strtotime($log['created_at'])) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
        <div style="padding: 20px; display: flex; justify-content: center; gap: 10px; background: #f8fafc; border-top: 1px solid #e2e8f0; border-radius: 12px;">
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