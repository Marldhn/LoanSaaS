<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Consistent Dashboard Design */
    .col-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .col-list { background: transparent; }
    
    /* Desktop Grid Layout */
    .col-row { 
        display: grid; 
        grid-template-columns: 1.5fr 1fr 1.5fr 1fr 0.5fr; 
        padding: 16px 20px; 
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        align-items: center;
    }
    .col-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 0.85rem; text-transform: uppercase; border: 1px solid #e2e8f0; }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .col-row { 
            display: flex !important; 
            flex-direction: column !important; 
            align-items: flex-start !important; 
            gap: 8px !important; 
            padding: 16px !important; 
        }
        .col-row.header { display: none !important; }
        
        .col-row > div { width: 100%; display: flex; justify-content: space-between; }
        .col-row > div::before { content: attr(data-label); font-weight: 700; color: #64748b; font-size: 11px; text-transform: uppercase; }
        
        .col-row a { padding: 8px 16px; background: #f1f5f9; border-radius: 6px; }
    }
</style>

<div class="col-card">
    <div>
        <h2 style="margin:0;">Secured Loan Collaterals</h2>
        <p style="margin:5px 0 0; color: #94a3b8; font-size: 0.9rem;">View and manage items secured against loans</p>
    </div>
</div>
<div class="col-list">
    <div class="col-row header">
        <div>Borrower</div>
        <div>Loan Reference</div>
        <div>Item Name</div>
        <div>Value</div>
        <div style="text-align: right;">Action</div>
    </div>

    <?php if (empty($collaterals)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8;">No collateral records found.</div>
    <?php else: ?>
        <?php foreach ($collaterals as $c): ?>
            <div class="col-row">
                <div data-label="Borrower" style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></div>
                <div data-label="Loan Ref" style="color: #64748b;"><b>#LN-<?= str_pad($c['loan_id'], 6, '0', STR_PAD_LEFT) ?></b></div>
                <div data-label="Item Name" style="color: #334155;"><?= htmlspecialchars($c['item_name']) ?></div>
                <div data-label="Value" style="font-weight: 700; color: #059669;">₱<?= number_format($c['estimated_value'], 2) ?></div>
                <div data-label="Action" style="text-align: right;">
                    <a href="/loansaas/public/index.php?url=loan/details&id=<?= $c['loan_id'] ?>" 
                       style="color:#64748b; text-decoration:none; padding: 6px 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
                       View
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>