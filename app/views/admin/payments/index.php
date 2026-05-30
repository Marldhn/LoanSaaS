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
    
    .btn-secondary { background: #f1f5f9; color: #475569; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; transition: 0.2s; }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
    
    .btn-primary { background: #0f172a; color: #fff; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; }
    .btn-primary:hover { background: #334155; }
    
    .empty-state { text-align: center; padding: 40px; color: #94a3b8; font-style: italic; }
</style>

<div class="page-header">
    <h1>Payment History</h1>
    <a href="/loansaas/public/index.php?url=payment/create" class="btn-primary">+ Record Payment</a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Loan Reference</th>
                <th>Amount</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($payments)): ?>
                <tr><td colspan="4" class="empty-state">No payment records found.</td></tr>
            <?php else: ?>
                <?php foreach ($payments as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['payment_date']) ?></td>
                    <td style="font-weight: 600; color: #0f172a;">#LN-<?= str_pad($p['loan_id'], 6, '0', STR_PAD_LEFT) ?></td>
                    <td style="font-weight: 600; color: #059669;">₱<?= number_format($p['amount'], 2) ?></td>
                    <td style="text-align: right;">
                        <a href="/loansaas/public/index.php?url=loan/details&id=<?= $p['loan_id'] ?>" class="btn-secondary">View Loan</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>