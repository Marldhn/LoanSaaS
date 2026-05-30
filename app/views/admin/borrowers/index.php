<?php
// Look up two levels: admin/ -> views/ -> layouts/
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Borrowers Directory - Lowndesk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f8fafc; padding: 24px; margin: 0; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .header-title h1 { font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; }
        .header-title p { font-size: 14px; color: #64748b; margin: 4px 0 0 0; }
        .btn-primary { background: #2563eb; color: #ffffff; padding: 10px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-logout { background: #ea580c; color: #ffffff; padding: 10px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-left: 8px;}
        .card-wrapper { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; text-align: left; }
        .data-table th { background: #f8fafc; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #475569; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; }
        .data-table td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid #f1f5f9; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-active { background: #dcfce7; color: #15803d; }
        .badge-inactive { background: #fee2e2; color: #b91c1c; }
        .btn-toggle { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="header-title">
            <h1>Borrowers Directory (<?= htmlspecialchars($_SESSION['user']['company_name']) ?>)</h1>
            <p>Monitor profiles assigned strictly to your isolated database branch cluster node partition.</p>
        </div>
        <div>
            <a href="/loansaas/public/index.php?url=borrower/create" class="btn-primary"><i class="fas fa-plus"></i> Add Borrower</a>
        </div>
    </div>
    <div class="card-wrapper">
        <table class="data-table">
            <thead>
                <tr><th>Full Name</th><th>Contact Info</th><th>Location Address</th><th>Valid ID Reference</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php if (empty($borrowers)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">No tenant consumer records managed yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($borrowers as $b): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?></strong></td>
                            <td><?= htmlspecialchars($b['phone']) ?><br><small><?= htmlspecialchars($b['email']) ?></small></td>
                            <td><?= htmlspecialchars($b['address']) ?></td>
                            <td><code><?= htmlspecialchars($b['valid_id'] ?: 'None') ?></code></td>
                            <td><span class="badge <?= $b['status'] == 1 ? 'badge-active' : 'badge-inactive' ?>"><?= $b['status'] == 1 ? 'Active' : 'Inactive' ?></span></td>
                            <td><a href="/loansaas/public/index.php?url=borrower/toggle/<?= $b['id'] ?>" class="btn-toggle"><i class="fas fa-sync"></i> Toggle Status</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php 
require_once dirname(__DIR__, 2) . '/layouts/footer.php'; 
?>