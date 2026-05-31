<?php
// Look up two levels: admin/ -> views/ -> layouts/
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Borrowers Directory - Lowndesk</title>
    <link rel="stylesheet" href="/loansaas/public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
<td>
    <a href="/loansaas/public/index.php?url=borrower/edit/<?= $b['id'] ?>" class="btn-edit" style="margin-right: 10px;">
        <i class="fas fa-edit"></i> Edit
    </a>
    
    <a href="/loansaas/public/index.php?url=borrower/toggle/<?= $b['id'] ?>" class="btn-toggle">
        <i class="fas fa-sync"></i> Toggle
    </a>
    
    <a href="/loansaas/public/index.php?url=borrower/details&id=<?= $b['id'] ?>" style="margin-left: 10px;" class="btn-details">View Profile</a>
</td>                       </tr>
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