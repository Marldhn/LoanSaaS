<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    :root { --primary: #4f46e5; --success: #16a34a; --danger: #dc2626; --bg: #f8fafc; --text-main: #1e293b; --text-muted: #64748b; }
    .loan-container { max-width: 1000px; margin: 0 auto; padding: 20px; }
    
    .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 15px; }
    .page-title { font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0; }
    
    .card { background: #fff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem; }
    .card-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
    
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem; }
    .info-item { display: flex; flex-direction: column; gap: 0.25rem; }
    .info-label { font-size: 0.70rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
    .info-value { font-size: 0.95rem; font-weight: 600; color: var(--text-main); }
    
    .btn { padding: 0.6rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; border: none; display: inline-flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none; }
    
    /* Tables */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; padding: 10px; }
    .data-table td { padding: 12px 10px; border-bottom: 1px solid #f1f5f9; }

    /* Mobile Responsive Fixes */
    @media (max-width: 768px) {
        .header-actions { flex-direction: column; align-items: stretch; }
        .header-actions > div { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .btn { width: 100%; }
        
        /* Penalty Form Stack */
        form > div { grid-template-columns: 1fr !important; }
        
        /* Table to List Card View */
        .data-table thead { display: none; }
        .data-table, .data-table tbody, .data-table tr, .data-table td { display: block; width: 100%; }
        .data-table tr { margin-bottom: 10px; border: 1px solid #f1f5f9; padding: 10px; border-radius: 8px; }
        .data-table td { display: flex; justify-content: space-between; border-bottom: none; padding: 4px 0; }
        .data-table td::before { content: attr(data-label); font-weight: bold; color: var(--text-muted); font-size: 12px; }
    }
</style>

<div class="loan-container">
    <div class="header-actions">
        <h1 class="page-title">Loan #<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></h1>
        <div style="display: flex; gap: 0.75rem;">
            <?php if ($loan['status'] === 'Pending'): ?>
                <a href="/loansaas/public/index.php?url=loan/approve&id=<?= $loan['id'] ?>" class="btn" style="background:var(--primary); color:white;">Approve</a>
                <a href="/loansaas/public/index.php?url=loan/reject&id=<?= $loan['id'] ?>" class="btn" style="background:var(--danger); color:white;">Reject</a>
            <?php endif; ?>
            <?php if ($loan['status'] !== 'Pending'): ?>
                <a href="/loansaas/public/index.php?url=payment/create&loan_id=<?= $loan['id'] ?>" class="btn" style="background:var(--success); color:white;">+ Payment</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="/loansaas/public/index.php?url=loan/edit&id=<?= $loan['id'] ?>" class="btn" style="background:#64748b; color:white;">Modify</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Apply Penalty</div>
        <form action="/loansaas/public/index.php?url=loan/apply_penalty" method="POST">
            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
            <div style="display: grid; grid-template-columns: 1fr 2fr auto; gap: 10px; align-items: end;">
                <div class="info-item">
                    <label class="info-label">Amount (₱)</label>
                    <input type="number" name="amount" step="0.01" required style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>
                <div class="info-item">
                    <label class="info-label">Reason</label>
                    <input type="text" name="reason" placeholder="e.g., Late fee" required style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>
                <button type="submit" class="btn" style="background:var(--danger); color:white;">Apply</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-title">Financial Summary</div>
        <div class="info-grid">
            <div class="info-item"><span class="info-label">Principal</span><span class="info-value">₱<?= number_format($loan['amount'], 2) ?></span></div>
            <div class="info-item"><span class="info-label">Interest</span><span class="info-value"><?= number_format($loan['interest_rate']) ?>%</span></div>
            <div class="info-item"><span class="info-label">Total Payable</span><span class="info-value">₱<?= number_format($loan['total_payable'], 2) ?></span></div>
            <div class="info-item"><span class="info-label">Penalties</span><span class="info-value" style="color:var(--danger)">₱<?= number_format($totalPenalties, 2) ?></span></div>
            <div class="info-item"><span class="info-label">Remaining</span><span class="info-value" style="color:var(--danger)">₱<?= number_format($remainingBalance, 2) ?></span></div>
            <div class="info-item"><span class="info-label">Status</span><span class="info-value"><?= htmlspecialchars($loan['status']) ?></span></div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Payment History</div>
        <table class="data-table">
            <thead><tr><th>Date</th><th>Amount</th></tr></thead>
            <tbody>
                <?php foreach ($payments as $p): ?>
                    <tr>
                        <td data-label="Date"><?= $p['payment_date'] ?></td>
                        <td data-label="Amount" style="color:var(--success); font-weight:600;">₱<?= number_format($p['amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-title">Penalty History</div>
        <table class="data-table">
            <thead><tr><th>Date</th><th>Reason</th><th>Amount</th></tr></thead>
            <tbody>
                <?php foreach ($penalties as $p): ?>
                    <tr>
                        <td data-label="Date"><?= $p['date_applied'] ?></td>
                        <td data-label="Reason"><?= htmlspecialchars($p['reason']) ?></td>
                        <td data-label="Amount" style="color:var(--danger); font-weight:600;">₱<?= number_format($p['amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>