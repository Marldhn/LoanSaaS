<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Consistent Dashboard Design */
    .pay-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .pay-list { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    
    .pay-row { display: grid; grid-template-columns: 1.5fr 1.5fr 1.5fr 1fr; padding: 15px 20px; border-bottom: 1px solid #f1f5f9; align-items: center; }
    .pay-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
    
    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; justify-content: center; align-items: center; z-index: 9999; }
    .modal-content { background: #fff; width: 90%; max-width: 500px; border-radius: 12px; padding: 24px; }
</style>

<div class="pay-card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2 style="margin:0;">Payment History</h2>
            <p style="margin:5px 0 0; color: #94a3b8; font-size: 0.9rem;">View and manage processed payment records</p>
        </div>
                <a href="/loansaas/public/index.php?url=payment/create" class="btn-primary" style="background:#fff; color:#1e293b; padding:8px 16px; border-radius:8px; text-decoration:none; font-weight:600;">+ New Payment</a>

    </div>
</div>

<div class="pay-list">
    <div class="pay-row header">
        <div>Date</div>
        <div>Loan Reference</div>
        <div>Amount</div>
        <div style="text-align: right;">Action</div>
    </div>

    <?php if (empty($payments)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8;">No payment records found.</div>
    <?php else: ?>
        <?php foreach ($payments as $p): ?>
            <div class="pay-row">
                <div style="color:#64748b;"><?= htmlspecialchars($p['payment_date']) ?></div>
                <div style="font-weight: 700; color: #1e293b;">#LN-<?= str_pad($p['loan_id'], 6, '0', STR_PAD_LEFT) ?></div>
                <div style="font-weight: 700; color: #059669;">₱<?= number_format($p['amount'], 2) ?></div>
                <div style="text-align: right;">
    <a href="/loansaas/public/index.php?url=loan/details&id=<?= $p['loan_id'] ?>" 
       style="color:#64748b; text-decoration:none; padding: 8px; border-radius: 6px; border: 1px solid #e2e8f0; transition: 0.2s;"
       onmouseover="this.style.color='#4f46e5'; this.style.borderColor='#4f46e5'"
       onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'">
        <i class="fas fa-eye"></i>
    </a>
</div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="payModal" class="modal-overlay">
    <div class="modal-content">
        <h3 style="margin-top:0;">Record New Payment</h3>
        <form method="POST" action="/loansaas/public/index.php?url=payment/store">
            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:600; margin-bottom:5px;">Loan ID</label>
                <input type="number" name="loan_id" class="form-input" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-weight:600; margin-bottom:5px;">Amount</label>
                <input type="number" name="amount" step="0.01" class="form-input" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;">
            </div>
            <button type="submit" style="width:100%; padding:12px; background:#1e293b; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600;">Save Payment</button>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>