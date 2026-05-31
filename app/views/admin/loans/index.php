<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .page-header { margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }
    .page-header h1 { font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; }
    .card { background: #fff; padding: 24px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    
    .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .data-table thead { background: #f8fafc; }
    .data-table th { padding: 16px 20px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; text-align: left; }
    .data-table td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    .data-table tr:hover { background: #fcfcfc; }
    
    .btn-primary { background: #2563eb; color: white; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; }
    .btn-secondary { background: #f1f5f9; color: #475569; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; }
    .empty-state { text-align: center; padding: 40px; color: #94a3b8; font-style: italic; }
    
    .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
</style>

<div class="page-header">
    <h1>Loans List</h1>
    <a href="/loansaas/public/index.php?url=loan/create" class="btn-primary">+ Create New Loan</a>
</div>

<div class="card" style="margin-bottom: 20px; padding: 15px;">
    <form method="GET" action="/loansaas/public/index.php" style="display: flex; gap: 10px; align-items: center;">
        <input type="hidden" name="url" value="loan/index">
        
        <input type="text" name="search" placeholder="Search borrower..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
               style="padding: 8px; border-radius: 8px; border: 1px solid #cbd5e1; flex-grow: 1;">
        
        <select name="status" onchange="this.form.submit()" style="padding: 8px; border-radius: 8px; border: 1px solid #cbd5e1;">
            <option value="">All Statuses</option>
            <option value="Active" <?= ($_GET['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Overdue" <?= ($_GET['status'] ?? '') === 'Overdue' ? 'selected' : '' ?>>Overdue</option>
            <option value="Paid" <?= ($_GET['status'] ?? '') === 'Paid' ? 'selected' : '' ?>>Paid</option>
            <option value="Pending" <?= ($_GET['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Rejected" <?= ($_GET['status'] ?? '') === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
    </form>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Borrower</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Status</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($loans)): ?>
                <tr><td colspan="6" class="empty-state">No loans found.</td></tr>
            <?php else: ?>
                <?php
$statusColors = [
    'Pending' => 'orange',
    'Active'  => 'green',
    'Overdue' => 'red',
    'Paid'    => 'blue',
    'Rejected'=> 'black',
    'Other'   => 'gray' // Add this
];
?>
                <?php foreach ($loans as $loan): ?>
                <tr>
                    <td>#LN-<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></td>
                    <td><div style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($loan['first_name'] . ' ' . $loan['last_name']) ?></div></td>
                    <td style="font-weight: 600; color: #059669;">₱<?= number_format($loan['amount'], 2) ?></td>
                    <td><?= htmlspecialchars($loan['due_date']) ?></td>
                    <td>
                        <span class="badge" style="background: <?= $statusColors[$loan['display_status']] ?>20; color: <?= $statusColors[$loan['display_status']] ?>;">
                            <?= htmlspecialchars($loan['display_status']) ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>" class="btn-secondary">View Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>