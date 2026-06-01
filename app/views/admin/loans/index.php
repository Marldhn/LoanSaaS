<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .page-header { margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }
    .page-header h1 { font-size: 28px; font-weight: 700; color: #1e293b; margin: 0; }
    
    .filter-card { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 24px; display: flex; gap: 15px; align-items: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .filter-card input, .filter-card select { padding: 10px 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; }
    
    .table-container { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead { background: #f8fafc; }
    .data-table th { padding: 16px 24px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; text-align: left; }
    .data-table th a { text-decoration: none; color: #64748b; display: flex; align-items: center; gap: 4px; }
    .data-table td { padding: 18px 24px; font-size: 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    .data-table tr:hover { background: #f8fafc; }
    
    .btn-primary { background: #4f46e5; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; }
    .btn-view { color: #4f46e5; font-weight: 600; text-decoration: none; }
    .badge { padding: 5px 12px; border-radius: 99px; font-size: 12px; font-weight: 600; }
</style>

<div class="page-header">
    <h1>Loan Portfolio</h1>
    <a href="/loansaas/public/index.php?url=loan/create" class="btn-primary">+ New Loan</a>
</div>

<form method="GET" action="/loansaas/public/index.php" class="filter-card">
    <input type="hidden" name="url" value="loan/index">
    <input type="text" name="search" placeholder="Search by name..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="flex-grow: 1;">
    <select name="status" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <?php foreach(['Active', 'Overdue', 'Paid', 'Pending', 'Rejected'] as $s): ?>
            <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
        <?php endforeach; ?>
    </select>
</form>

<div class="table-container">
    <table class="data-table">
        <thead>
    <tr>
        <?php 
        $currentStatus = urlencode($_GET['status'] ?? '');
        $sort = $_GET['sort'] ?? 'id';
        $order = ($_GET['order'] ?? 'DESC');
        $nextOrder = ($order === 'DESC') ? 'ASC' : 'DESC';
        ?>
        
        <th>
            <a href="?url=loan/index&sort=id&order=<?= $nextOrder ?>&status=<?= $currentStatus ?>">
                ID <?= $sort == 'id' ? ($order == 'ASC' ? '↑' : '↓') : '↕' ?>
            </a>
        </th>
        <th>
            <a href="?url=loan/index&sort=borrower_name&order=<?= $nextOrder ?>&status=<?= $currentStatus ?>">
                Borrower <?= $sort == 'borrower_name' ? ($order == 'ASC' ? '↑' : '↓') : '↕' ?>
            </a>
        </th>
        <th>
            <a href="?url=loan/index&sort=remaining_balance&order=<?= $nextOrder ?>&status=<?= $currentStatus ?>">
                Balance <?= $sort == 'remaining_balance' ? ($order == 'ASC' ? '↑' : '↓') : '↕' ?>
            </a>
        </th>
        <th>
            <a href="?url=loan/index&sort=due_date&order=<?= $nextOrder ?>&status=<?= $currentStatus ?>">
                Due Date <?= $sort == 'due_date' ? ($order == 'ASC' ? '↑' : '↓') : '↕' ?>
            </a>
        </th>
        <th>Status</th>
        <th style="text-align: right;">Action</th>
    </tr>
</thead>
        <tbody>
            <?php if (empty($loans)): ?>
                <tr><td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">No loans found.</td></tr>
            <?php else: 
                $statusColors = ['Pending'=>'#f59e0b', 'Active'=>'#10b981', 'Overdue'=>'#ef4444', 'Paid'=>'#3b82f6', 'Rejected'=>'#64748b'];
                foreach ($loans as $loan): 
                    $color = $statusColors[$loan['display_status']] ?? '#94a3b8';
            ?>
                <tr>
                    <td style="font-weight: 700; color: #4f46e5;">#LN-<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></td>
                    <td><div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($loan['first_name'] . ' ' . $loan['last_name']) ?></div></td>
                    <td style="font-weight: 600;">₱<?= number_format($loan['remaining_balance'], 2) ?></td>
                    <td><?= htmlspecialchars($loan['due_date']) ?></td>
                    <td><span class="badge" style="background: <?= $color ?>15; color: <?= $color ?>;"><?= htmlspecialchars($loan['display_status']) ?></span></td>
                    <td style="text-align: right;"><a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>" class="btn-view">View →</a></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="margin-top: 25px; display: flex; justify-content: center; gap: 5px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?url=loan/index&page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= urlencode($_GET['search'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>" 
           style="padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;
                  background: <?= ($page ?? 1) == $i ? '#4f46e5' : '#fff' ?>; 
                  color: <?= ($page ?? 1) == $i ? '#fff' : '#64748b' ?>; 
                  border: 1px solid <?= ($page ?? 1) == $i ? '#4f46e5' : '#e2e8f0' ?>;">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>