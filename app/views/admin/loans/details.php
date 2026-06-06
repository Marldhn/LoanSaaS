<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #4f46e5;
        --success: #16a34a;
        --danger: #dc2626;
        --bg: #f8fafc;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

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
            <?php if ($loan['status'] !== 'Pending'): ?>
                <a href="/loansaas/public/index.php?url=payment/create&loan_id=<?= $loan['id'] ?>" class="btn" style="background:#059669; color:white;">+ Record Payment</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="/loansaas/public/index.php?url=loan/edit&id=<?= $loan['id'] ?>" class="btn btn-modify">Modify Loan</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Financial Summary</div>
        <div class="info-grid">
            <div class="info-item"><span class="info-label">Principal</span><span class="info-value">₱<?= number_format($loan['amount'], 2) ?></span></div>
            <div class="info-item"><span class="info-label">Interest</span><span class="info-value"><?= number_format($loan['interest_rate']) ?>%</span></div>
            <div class="info-item"><span class="info-label">Total Payable</span><span class="info-value">₱<?= number_format($loan['total_payable'], 2) ?></span></div>
            <div class="info-item"><span class="info-label">Remaining</span><span class="info-value" style="color:var(--danger)">₱<?= number_format($remainingBalance, 2) ?></span></div>
            <div class="info-item"><span class="info-label">Status</span><span class="info-value"><?= htmlspecialchars($loan['status']) ?></span></div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Details</div>
        <div class="info-grid">
            <div class="info-item"><span class="info-label">Account</span><span class="info-value"><?= htmlspecialchars($loan['account_name'] ?? 'N/A') ?></span></div>
            <div class="info-item"><span class="info-label">Term</span><span class="info-value"><?= $loan['term_months'] ?> <?= htmlspecialchars($loan['term_type']) ?>s</span></div>
            <div class="info-item"><span class="info-label">Released</span><span class="info-value"><?= $loan['released_date'] ?></span></div>
            <div class="info-item"><span class="info-label">Due Date</span><span class="info-value"><?= $loan['due_date'] ?></span></div>
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

    <div style="margin-top: 2rem;">
        <?php if ($loan['status'] === 'Pending' && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
            <div style="display: flex; gap: 1rem;">
                <a href="#" class="btn btn-approve" data-url="/loansaas/public/index.php?url=loan/approve&id=<?= $loan['id'] ?>">✓ Approve Loan</a>
                <a href="#" class="btn btn-reject" data-url="/loansaas/public/index.php?url=loan/reject&id=<?= $loan['id'] ?>">Reject Loan</a>
            </div>
        <?php elseif ($loan['status'] !== 'Pending'): ?>
            <p style="color:var(--text-muted)">Loan is <strong><?= htmlspecialchars($loan['status']) ?></strong>.</p>
        <?php endif; ?>
        <a href="/loansaas/public/index.php?url=loan/index" style="display: block; margin-top: 1.5rem; color: var(--text-muted); text-decoration: none;">&larr; Back to List</a>
    </div>
</div>

<div id="confirmModal" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:9999;">
    <div style="background:white; padding:30px; border-radius:12px; max-width:400px; text-align:center; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <h3 id="modalTitle" style="margin-top:0;">Are you sure?</h3>
        <p id="modalMsg" style="color:#333; margin-bottom: 20px;"></p>
        <div style="display:flex; justify-content:center; gap: 10px;">
            <button onclick="document.getElementById('confirmModal').style.display='none'" style="padding:10px 20px; background:#64748b; color:white; border:none; border-radius:6px; cursor:pointer;">Cancel</button>
            <a id="modalConfirmBtn" href="#" style="padding:10px 20px; background:var(--primary); color:white; border-radius:6px; text-decoration:none;">Confirm</a>
        </div>
    </div>
</div>

<script>
    const confirmModal = document.getElementById('confirmModal');
    const confirmBtn = document.getElementById('modalConfirmBtn');
    
    document.querySelectorAll('.btn-approve, .btn-reject').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const isApprove = this.classList.contains('btn-approve');
            document.getElementById('modalTitle').innerText = isApprove ? "Approve Loan" : "Reject Loan";
            document.getElementById('modalMsg').innerText = isApprove ? "Are you sure you want to approve this loan? This will deduct the amount from the account." : "Are you sure you want to reject this loan?";
            confirmBtn.href = this.getAttribute('data-url');
            confirmModal.style.display = 'flex';
        });
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>