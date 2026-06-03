<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>


<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .btn-primary { background: #6366f1; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.2s; }
    .btn-primary:hover { background: #4f46e5; }
    .card-wrapper { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .data-table th { text-align: left; padding: 15px; border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 14px; }
    .data-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
    .badge { background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 500; }
</style>

<div class="page-header">
    <div class="header-title">
        <h1>Expenses</h1>
        <p>Manage your company expenditures</p>
    </div>
    <a href="?url=expense/create" class="btn-primary">+ Add New Expense</a>
</div>

<div class="card-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Category</th>
                <th>Amount</th>
            </tr>
        </thead>
       <tbody>
    <?php foreach ($expenses as $exp): ?>
    <tr>
        <td><?= date('M d, Y', strtotime($exp['expense_date'])) ?></td>
        <td><strong><?= htmlspecialchars($exp['title']) ?></strong></td>
        
<td><span class="badge"><?= htmlspecialchars($exp['category_name'] ?? 'General') ?></span></td>
        <td style="color: #dc2626; font-weight: 600;">-₱<?= number_format($exp['amount'], 2) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
