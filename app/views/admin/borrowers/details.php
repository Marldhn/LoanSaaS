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
                            <td>#LN-<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></td>
                            <td>₱<?= number_format($loan['amount'], 2) ?></td>
                            <td>₱<?= number_format($loan['total_payable'], 2) ?></td>
                            <td><?= htmlspecialchars($loan['status']) ?></td>
                            <td><a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>">View</a></td>
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