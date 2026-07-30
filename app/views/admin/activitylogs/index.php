<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0;
    }

    /* Filter & Search Bar Row */
    .filter-card {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .search-input:focus {
        border-color: #6366f1;
    }

    /* Desktop Row: Grid layout (5 columns) */
    .log-list { background: transparent; }
    
    .log-row { 
        display: grid; 
        grid-template-columns: 1.5fr 1fr 1fr 3fr 1fr; 
        padding: 16px 20px; 
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        align-items: center;
        gap: 15px;
        transition: background-color 0.15s;
    }
    
    .log-row.header { 
        background: #ffffff; 
        font-weight: 700; 
        color: #64748b; 
        font-size: 0.75rem; 
        letter-spacing: 0.05em;
        text-transform: uppercase; 
        border: none;
        padding: 12px 20px;
        margin-bottom: 4px;
    }

    .log-row:not(.header):hover {
        background-color: #f8fafc;
    }

    /* Badge & Avatar Styles */
    .badge-info { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; white-space: nowrap; }
    .avatar-mini { width: 32px; height: 32px; background: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem; margin-right: 10px; flex-shrink: 0; color: #475569; }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .log-row.header { display: none !important; } 
        
        .log-row {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
            padding: 16px !important;
        }

        .log-row > div { 
            width: 100% !important; 
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            text-align: left !important; 
        }

        .log-row > div::before { 
            content: attr(data-label); 
            font-weight: 700; 
            color: #64748b; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
        }

        .log-row > div:first-child::before {
            content: "User";
        }

        .filter-card { flex-direction: column; }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">System Activity Logs</h1>
            <p class="page-subtitle">Track all administrative actions and system events</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="filter-card">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Search user, action, or description..." onkeyup="filterLogs()">
        </div>
    </div>

    <div class="log-list">
        <div class="log-row header">
            <div>User</div>
            <div>Action</div>
            <div>Category</div>
            <div>Description</div>
            <div style="text-align: right;">Date</div>
        </div>

        <?php if (empty($logs)): ?>
            <div style="padding: 40px; text-align: center; color: #94a3b8; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">No recent activities found.</div>
        <?php else: ?>
            <?php foreach ($logs as $log): ?>
                <div class="log-row log-item" 
                     data-username="<?= strtolower(htmlspecialchars($log['username'])) ?>"
                     data-action="<?= strtolower(htmlspecialchars($log['action'])) ?>"
                     data-table="<?= strtolower(htmlspecialchars($log['table_name'])) ?>"
                     data-description="<?= strtolower(htmlspecialchars($log['description'])) ?>">
                    
                    <div data-label="User" style="display: flex; align-items: center;">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <div class="avatar-mini"><?= strtoupper(substr($log['username'], 0, 1)) ?></div>
                            <strong style="color: #0f172a;"><?= htmlspecialchars($log['username']) ?></strong>
                        </div>
                    </div>

                    <div data-label="Action">
                        <span class="badge-info"><?= htmlspecialchars($log['action']) ?></span>
                    </div>

                    <div data-label="Category"><code style="color: #475569; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;"><?= htmlspecialchars($log['table_name']) ?></code></div>

                    <div data-label="Description" style="color: #475569; font-size: 0.875rem;"><?= htmlspecialchars($log['description']) ?></div>

                    <div data-label="Date" style="text-align: right;">
                        <span style="font-size: 0.85rem; color: #64748b;">
                            <?= date('M d, H:i', strtotime($log['created_at'])) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($totalPages > 1): ?>
            <div style="padding: 20px; display: flex; justify-content: center; gap: 10px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; margin-top: 20px;">
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
</div>

<script>
    function filterLogs() {
        const searchVal = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.log-item');

        rows.forEach(row => {
            const username = row.getAttribute('data-username');
            const action = row.getAttribute('data-action');
            const table = row.getAttribute('data-table');
            const description = row.getAttribute('data-description');

            if (username.includes(searchVal) || action.includes(searchVal) || table.includes(searchVal) || description.includes(searchVal)) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>