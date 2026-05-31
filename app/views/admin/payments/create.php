<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .payment-container { max-width: 500px; margin: 40px auto; }
    .card { background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    h2 { margin-top: 0; color: #1e293b; font-size: 20px; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #475569; font-size: 14px; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
    .btn-submit { width: 100%; padding: 14px; background: #059669; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; }
    .btn-submit:hover { background: #047857; }
</style>

<div class="payment-container">
    <div class="card">
        <h2>Record New Payment</h2>
        
        <form action="/loansaas/public/index.php?url=payment/store" method="POST">
            
            <div class="form-group">
                <label>Select Loan</label>
                <select name="loan_id" class="form-control" required>
                    <option value="">-- Choose an Approved Loan --</option>
                    <?php foreach ($loans as $l): ?>
                        <option value="<?= $l['id'] ?>">
                            Loan #<?= str_pad($l['id'], 6, '0', STR_PAD_LEFT) ?> - 
                            <?= htmlspecialchars(($l['first_name'] ?? '') . ' ' . ($l['last_name'] ?? '')) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Deposit to Account</label>
                <select name="account_id" class="form-control" required>
                    <?php foreach ($accounts as $acc): ?>
                        <option value="<?= $acc['id'] ?>"><?= htmlspecialchars($acc['name']) ?> (Bal: ₱<?= number_format($acc['current_balance'], 2) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Amount Paid (₱)</label>
                <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label>Payment Date</label>
                <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>

            <button type="submit" class="btn-submit">Record Payment</button>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>