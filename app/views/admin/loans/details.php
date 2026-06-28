<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    :root { --primary: #4f46e5; --success: #16a34a; --danger: #dc2626; --bg: #f8fafc; --text-main: #1e293b; --text-muted: #64748b; }
    .loan-container { max-width: 1000px; margin: 0 auto; padding: 20px; }
    .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.875rem; font-weight: 800; color: var(--text-main); margin: 0; }
    .card { background: #fff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .card-title { font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.25rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; }
    .info-item { display: flex; flex-direction: column; gap: 0.25rem; }
    .info-label { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }
    .info-value { font-size: 1rem; font-weight: 600; color: var(--text-main); }
    .btn { padding: 0.625rem 1.25rem; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.2s; font-size: 0.875rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-approve { background: var(--success); color: white; }
    .btn-reject { background: var(--danger); color: white; }
    .btn-modify { background: var(--primary); color: white; }
    .btn:hover { opacity: 0.9; }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .data-table th, .data-table td { padding: 12px; text-align: left; border-bottom: 1px solid #f1f5f9; }
</style>

<div class="loan-container">
    <div class="header-actions">
    <h1 class="page-title">Loan #<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></h1>
    <div style="display: flex; gap: 0.75rem;">
        
        <?php if ($loan['status'] === 'Pending'): ?>
            <a href="/loansaas/public/index.php?url=loan/approve&id=<?= $loan['id'] ?>" class="btn btn-approve">Approve</a>
            <a href="/loansaas/public/index.php?url=loan/reject&id=<?= $loan['id'] ?>" class="btn btn-reject">Reject</a>
        <?php endif; ?>
        <?php if ($loan['status'] !== 'Pending'): ?>
            <a href="/loansaas/public/index.php?url=payment/create&loan_id=<?= $loan['id'] ?>" class="btn" style="background:#059669; color:white;">+ Record Payment</a>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="/loansaas/public/index.php?url=loan/edit&id=<?= $loan['id'] ?>" class="btn btn-modify">Modify Loan</a>
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
                    <input type="text" name="reason" placeholder="e.g., Late payment fee" required style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px;">
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
                    <tr><td><?= $p['payment_date'] ?></td><td style="color:var(--success); font-weight:600;">₱<?= number_format($p['amount'], 2) ?></td></tr>
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
                    <tr><td><?= $p['date_applied'] ?></td><td><?= htmlspecialchars($p['reason']) ?></td><td style="color:var(--danger); font-weight:600;">₱<?= number_format($p['amount'], 2) ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    

    </div>