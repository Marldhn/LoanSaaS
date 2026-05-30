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
    
    .btn-primary { background: #2563eb; color: white; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: 0.2s; }
    .btn-secondary { background: #f1f5f9; color: #475569; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; }
    
    /* Green Approve Button */
    .btn-approve { background: #16a34a; color: white; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; margin-left: 5px; }
    .empty-state { text-align: center; padding: 40px; color: #94a3b8; font-style: italic; }
</style>

<div class="page-header">
    <h1>Loans List</h1>
    <a href="/loansaas/public/index.php?url=loan/create" class="btn-primary">+ Create New Loan</a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Borrower</th>
                <th>Amount</th>
                <th>Status</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($loans)): ?>
                <tr><td colspan="5" class="empty-state">No loans found.</td></tr>
            <?php else: ?>
                <?php foreach ($loans as $loan): ?>
                <tr>
                    <td>#LN-<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></td>
                    <td>
                        <div style="font-weight: 600; color: #0f172a;">ID: <?= $loan['borrower_id'] ?></div>
                    </td>
                    <td style="font-weight: 600; color: #059669;">₱<?= number_format($loan['amount'], 2) ?></td>
                    <td>
                        <span style="padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; 
                            <?= strtolower($loan['status']) === 'approved' ? 'background:#d1fae5; color:#065f46;' : 'background:#fef3c7; color:#92400e;' ?>">
                            <?= htmlspecialchars($loan['status']) ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>" class="btn-secondary">View Details</a>
                        
                        <a href="/loansaas/public/index.php?url=loan/approve&id=<?= $loan['id'] ?>" 
                           class="btn-approve" 
                           onclick="return confirm('Approve this loan?');">
                           Approve
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>