<style>
    .bp-wrapper { display: grid; grid-template-columns: 350px 1fr; gap: 20px; }
    .bp-card { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
    .bp-card-title { font-weight: 700; margin-bottom: 15px; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
    .bp-info-group { margin-bottom: 12px; }
    .bp-info-label { font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; }
    .bp-info-value { font-size: 0.95rem; color: #1e293b; }
    .bp-stat-card { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center; }
    .bp-stat-value { font-size: 1.5rem; font-weight: 700; color: #6366f1; }
    
    /* Table Responsive */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th, .data-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: left; }

    @media (max-width: 768px) {
        .bp-wrapper { grid-template-columns: 1fr; }
        
        /* Turn table into stackable cards */
        .data-table thead { display: none; }
        .data-table, .data-table tbody, .data-table tr, .data-table td { display: block; width: 100%; }
        .data-table tr { margin-bottom: 15px; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; }
        .data-table td { display: flex; justify-content: space-between; border-bottom: none; padding: 5px 0; }
        .data-table td::before { content: attr(data-label); font-weight: bold; color: #64748b; }
    }
</style>
<?php 
// Ensure your layouts handle the <html>, <head>, and <body> tags
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>

<div class="page-header">
    <h1>Borrower Profile: <?= htmlspecialchars($borrower['first_name'] . ' ' . $borrower['last_name']) ?></h1>
</div>

<div class="bp-wrapper">
    <div class="bp-card">
        <div class="bp-card-title">Personal Information</div>
        <div class="bp-info-group">
            <span class="bp-info-label">Full Name</span>
            <div class="bp-info-value"><?= htmlspecialchars($borrower['first_name'] . ' ' . ($borrower['middle_name'] ?? '') . ' ' . $borrower['last_name']) ?></div>
        </div>
        <div class="bp-info-group">
            <span class="bp-info-label">Gender</span>
            <div class="bp-info-value"><?= htmlspecialchars($borrower['gender'] ?? 'N/A') ?></div>
        </div>
        <div class="bp-info-group">
            <span class="bp-info-label">Birthdate</span>
            <div class="bp-info-value"><?= htmlspecialchars($borrower['birthdate'] ?? 'N/A') ?></div>
        </div>
        <div class="bp-info-group">
            <span class="bp-info-label">Contact</span>
            <div class="bp-info-value"><?= htmlspecialchars($borrower['phone']) ?></div>
            <div class="bp-info-value"><?= htmlspecialchars($borrower['email'] ?? 'No Email') ?></div>
        </div>
        <div class="bp-info-group">
            <span class="bp-info-label">Address</span>
            <div class="bp-info-value"><?= htmlspecialchars($borrower['address']) ?></div>
        </div>
        <div class="bp-info-group">
            <span class="bp-info-label">Valid ID Serial</span>
            <div class="bp-info-value"><code><?= htmlspecialchars($borrower['valid_id'] ?? 'None') ?></code></div>
        </div>
    </div>

    <div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="bp-stat-card">
                <div class="bp-info-label">Total Loans</div>
                <div class="bp-stat-value"><?= $totalLoansCount ?></div>
            </div>
            <div class="bp-stat-card">
                <div class="bp-info-label">Total Payable</div>
                <div class="bp-stat-value" style="color: #059669;">₱<?= number_format($totalPayable, 2) ?></div>
            </div>
        </div>

        <div class="bp-card">
            <div class="bp-card-title">Loan History</div>
            <table class="data-table">
                <thead>
                    <tr><th>Loan ID</th><th>Amount</th><th>Payable</th><th>Status</th><th>Action</th></tr>
                </thead>
               <tbody>
    <?php if (empty($loans)): ?>
        <tr><td colspan="5" style="text-align:center;">No loan history found.</td></tr>
    <?php else: ?>
        <?php foreach ($loans as $loan): ?>
        <tr>
            <td data-label="Loan ID">#LN-<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></td>
            <td data-label="Amount">₱<?= number_format($loan['amount'], 2) ?></td>
            <td data-label="Payable">₱<?= number_format($loan['total_payable'], 2) ?></td>
            <td data-label="Status"><?= htmlspecialchars($loan['status']) ?></td>
            <td data-label="Action"><a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>">View</a></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
            </table>
        </div>
    </div>
</div>

<div style="margin-top: 20px;">
    <a href="/loansaas/public/index.php?url=borrower/index" class="btn-back">← Back to Borrowers</a>
</div>

<?php 
// Ensure footer handles closing tags
require_once dirname(__DIR__, 2) . '/layouts/footer.php'; 
?>