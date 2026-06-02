<?php
// Look up two levels: admin/ -> views/ -> layouts/
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>

<STYLE>
    /* Cards */
.card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 20px;
    padding: 20px;
}
.card-header { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }

/* Table Styling */
.table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
.table th { background-color: #f8f9fa; font-weight: 600; }
.table-striped tr:nth-child(even) { background-color: #f9f9f9; }

/* Badges */
.badge-info { 
    background-color: #17a2b8; 
    color: white; 
    padding: 4px 8px; 
    border-radius: 4px; 
    font-size: 0.85em; 
}
</STYLE>

<div class="container-fluid" style="padding: 20px;">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-history"></i> System Activity Log</h3>
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr><td colspan="5" class="text-center">No recent activities found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($log['username']) ?></strong></td>
                                <td><span class="badge badge-info"><?= $log['action'] ?></span></td>
                                <td><code><?= $log['table_name'] ?></code></td>
                                <td><?= htmlspecialchars($log['description']) ?></td>
                                <td><small class="text-muted"><?= date('M d, Y H:i', strtotime($log['created_at'])) ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
require_once dirname(__DIR__, 2) . '/layouts/footer.php'; 
?>