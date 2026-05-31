<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-title { font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; }
    
    .card { background: #fff; padding: 24px; border-radius: 16px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
    .card-title { font-size: 16px; font-weight: 700; color: #334155; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
    
    .grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
    .info-group { margin-bottom: 15px; }
    .info-label { display: block; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; }
    .info-value { font-size: 14px; font-weight: 600; color: #0f172a; margin-top: 4px; }
    
    .btn-modify { background: #6366f1; color: #fff; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; }
    .btn-success { background: #16a34a; color: #fff; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; }
    .btn-back { color: #64748b; text-decoration: none; font-weight: 600; }
</style>

<div class="header-actions">
    <h1 class="page-title">Loan #<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></h1>
    <div>
        <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="/loansaas/public/index.php?url=loan/edit&id=<?= $loan['id'] ?>" class="btn-modify">Modify Loan</a>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-title">Financial Summary</div>
    <div class="grid-4">
        <div class="info-group"><span class="info-label">Principal</span><span class="info-value">₱<?= number_format($loan['amount'], 2) ?></span></div>
               <div class="info-group"><span class="info-label">Interest (%)</span><span class="info-value"><?= number_format($loan['interest_rate']) ?></span></div>

        <div class="info-group"><span class="info-label">Total Payable</span><span class="info-value">₱<?= number_format($loan['total_payable'], 2) ?></span></div>
        <div class="info-group"><span class="info-label">Remaining Balance</span><span class="info-value" style="color: #dc2626;">₱<?= number_format($remainingBalance, 2) ?></span></div>
        <div class="info-group"><span class="info-label">Status</span><div><?= $loan['status'] === 'Pending' ? '<span style="color:#dc2626; font-weight:bold;">Pending</span>' : '<span style="color:#059669; font-weight:bold;">Active</span>' ?></div></div>
    </div>
</div>

<div class="card">
    <div class="card-title">Loan & Collateral Details</div>
    <div class="grid-4">
        <div class="info-group"><span class="info-label">Account</span><span class="info-value"><?= htmlspecialchars($loan['account_name'] ?? 'N/A') ?></span></div>
<span class="info-value">
    <?= htmlspecialchars($loan['term_months'] ?? '0') ?> 
    <?= !empty($loan['term_type']) ? htmlspecialchars($loan['term_type']) . '(s)' : 'day(s)' ?>
</span>        <div class="info-group"><span class="info-label">Released</span><span class="info-value"><?= $loan['released_date'] ?></span></div>
        <div class="info-group"><span class="info-label">Due Date</span><span class="info-value"><?= $loan['due_date'] ?></span></div>
    </div>
    
    <?php if (!empty($collateral)): ?>
    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-top: 15px; border: 1px solid #e2e8f0;">
        <span class="info-label">Collateral: <?= htmlspecialchars($collateral['item_name']) ?> (₱<?= number_format($collateral['estimated_value'], 2) ?>)</span>
        <?php if (!empty($collateral['file_path'])): ?>
            <a href="/loansaas/public/<?= $collateral['file_path'] ?>" target="_blank" style="font-size: 12px; color: #2563eb;">View Attached File</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-title">Payment History</div>
    <table class="data-table">
        <thead><tr><th>Date</th><th>Amount</th></tr></thead>
        <tbody>
            <?php foreach ($payments as $p): ?>
                <tr><td><?= $p['payment_date'] ?></td><td style="color:#059669; font-weight:600;">₱<?= number_format($p['amount'], 2) ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="card" style="border: none; background: transparent; padding: 20px 0;">
    <div class="actions">
        <?php if ($loan['status'] === 'Pending'): ?>
            <a href="/loansaas/public/index.php?url=loan/approve&id=<?= $loan['id'] ?>" 
               class="btn" style="background: #16a34a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;" 
               onclick="return confirm('Are you sure you want to Approve this loan? This will deduct the amount from the account.');">
               ✓ Approve Loan
            </a>
            <a href="/loansaas/public/index.php?url=loan/reject&id=<?= $loan['id'] ?>" 
               class="btn" style="background: #dc2626; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;" 
               onclick="return confirm('Are you sure you want to Reject this loan?');">
               Reject Loan
            </a>
        <?php else: ?>
            <div style="padding: 15px; background: #f1f5f9; border-radius: 8px; color: #475569; text-align: center;">
                Loan is <strong><?= htmlspecialchars($loan['status']) ?></strong>. No further actions allowed.
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 15px;">
            <a href="/loansaas/public/index.php?url=loan/index" class="btn-back">← Back to List</a>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>