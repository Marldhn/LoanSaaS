<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Consistent Dashboard Design */
    .loan-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .filter-bar { background: #ffffff; padding: 15px 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; display: flex; gap: 10px; align-items: center; }
    .loan-list { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    
    /* Desktop: 5 columns (Borrower/ID combined as 1.5fr) */
    .loan-row { 
        display: grid; 
        grid-template-columns: 1.5fr 1fr 1fr 1fr 0.5fr; 
        padding: 15px 20px; 
        border-bottom: 1px solid #f1f5f9; 
        align-items: center; 
    }
    
    .loan-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 12px; text-transform: uppercase; }
    
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 600; }
    .btn-view { color: #4f46e5; font-weight: 600; text-decoration: none; font-size: 10px; }
    .sort-link { text-decoration: none; color: inherit; display: flex; align-items: center; gap: 4px; }

    /* Pagination Styles */
    .pagination { margin-top: 30px; display: flex; justify-content: center; gap: 8px; }
    .page-link { padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; border: 1px solid #e2e8f0; transition: 0.2s; }
    .page-link.active { background: #4f46e5; color: #fff; border-color: #4f46e5; }
    .page-link.inactive { background: #fff; color: #64748b; }
    .page-link:hover { border-color: #4f46e5; color: #4f46e5; }

    /* Mobile Responsive Fixes */
    @media (max-width: 768px) {
        .loan-row { 
            display: flex !important; 
            flex-direction: column !important; 
            align-items: flex-start !important; 
            gap: 8px; 
            padding: 16px !important; 
            margin-bottom: 15px !important; 
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
        }

        .loan-list { background: transparent !important; border: none !important; }
        .loan-row.header { display: none !important; }
        
        .loan-row > div { width: 100%; display: flex; justify-content: space-between; }
        
        /* Adds the label to the left of the value on mobile */
        .loan-row > div:not(:first-child)::before { 
            content: attr(data-label); 
            font-weight: 700; 
            color: #64748b; 
            font-size: 11px; 
            text-transform: uppercase; 
        }
        
        .loan-row .btn-view { padding: 8px 16px; background: #f1f5f9; border-radius: 6px; }
    }
</style>

<div class="loan-card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0;">Loan Portfolio</h2>
        <a href="/loansaas/public/index.php?url=loan/create" class="btn-primary" style="background:#fff; color:#1e293b; padding:8px 16px; border-radius:8px; text-decoration:none; font-weight:600;">+ New Loan</a>
    </div>
</div>

<form method="GET" action="/loansaas/public/index.php" class="filter-bar">
    <input type="hidden" name="url" value="loan/index">
    <input type="text" name="search" placeholder="Search borrower..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="flex-grow:1; padding:8px 12px; border:1px solid #e2e8f0; border-radius:8px;">
    <select name="status" onchange="this.form.submit()" style="padding:8px; border:1px solid #e2e8f0; border-radius:8px;">
        <option value="">All Statuses</option>
        <?php foreach(['Active', 'Overdue', 'Paid', 'Pending', 'Rejected'] as $s): ?>
            <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
        <?php endforeach; ?>
    </select>
</form>

<div class="loan-list">
    <div class="loan-row header">
        <?php 
        $nextOrder = (($_GET['order'] ?? 'DESC') === 'DESC') ? 'ASC' : 'DESC';
        $qs = "&order=$nextOrder&status=" . urlencode($_GET['status'] ?? '');
        ?>
        <div><a href="?url=loan/index&sort=borrower_name<?= $qs ?>" class="sort-link">Borrower / ID</a></div>
        <div><a href="?url=loan/index&sort=remaining_balance<?= $qs ?>" class="sort-link">Balance</a></div>
        <div><a href="?url=loan/index&sort=due_date<?= $qs ?>" class="sort-link">Due Date</a></div>
        <div>Status</div>
        <div style="text-align:right;">Action</div>
    </div>

   <?php if (empty($loans)): ?>
        <div style="padding:40px; text-align:center; color:#94a3b8;">No loans found.</div>
    <?php else: 
        $statusColors = ['Pending'=>'#f59e0b', 'Active'=>'#10b981', 'Overdue'=>'#ef4444', 'Paid'=>'#3b82f6', 'Rejected'=>'#64748b'];
        foreach ($loans as $loan): 
            $color = $statusColors[$loan['display_status']] ?? '#94a3b8';
    ?>
       <div class="loan-row">
            <div style="display: flex; flex-direction: column;">
                <span style="font-weight: 700; color: #1e293b;"><?= htmlspecialchars($loan['first_name'] . ' ' . $loan['last_name']) ?></span>
                <span style="font-size: 0.85rem; color: #64748b;">LOAN ID: #LN<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            
            <div data-label="Balance" style="font-weight: 700;">₱<?= number_format($loan['remaining_balance'], 2) ?></div>
            <div data-label="Due Date"><?= htmlspecialchars($loan['due_date']) ?></div>
            <div data-label="Status"><span class="badge" style="background: <?= $color ?>15; color: <?= $color ?>;"><?= htmlspecialchars($loan['display_status']) ?></span></div>
            <div data-label="Action" style="text-align:right;"><a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>" class="btn-view">View</a></div>
       </div>
    <?php endforeach; endif; ?>
</div>

<?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="pagination">
        <?php 
        $search = urlencode($_GET['search'] ?? '');
        $status = urlencode($_GET['status'] ?? '');
        $sort = $_GET['sort'] ?? 'id';
        $order = $_GET['order'] ?? 'DESC';
        $currentPage = (int)($_GET['page'] ?? 1);

        for ($i = 1; $i <= $totalPages; $i++): 
            $isActive = ($currentPage === $i);
        ?>
            <a href="?url=loan/index&page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= $search ?>&status=<?= $status ?>" 
               class="page-link <?= $isActive ? 'active' : 'inactive' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>