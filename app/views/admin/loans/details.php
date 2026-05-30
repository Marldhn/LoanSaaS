<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .page-header { margin-bottom: 24px; }
    .page-header h1 { font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; }

    .card {
        background: #fff;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-box {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .stat-box p {
        margin: 8px 0;
        color: #475569;
        font-size: 14px;
    }

    .stat-box strong {
        color: #0f172a;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .data-table thead {
        background: #f8fafc;
    }

    .data-table th {
        padding: 16px 20px;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }

    .data-table td {
        padding: 16px 20px;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .btn-success {
        display: inline-block;
        padding: 10px 16px;
        background: #16a34a;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        margin-right: 10px;
    }

    .btn-success:hover {
        background: #15803d;
    }

    .btn-back {
        display: inline-block;
        margin-top: 20px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-back:hover {
        color: #0f172a;
    }
    
    .collateral-box {
        border-left: 4px solid #2563eb;
        background: #eff6ff;
        padding: 15px;
        margin-top: 10px;
        border-radius: 0 8px 8px 0;
    }
</style>

<div class="page-header">
    <h1>Loan Details #<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></h1>
</div>

<div class="card">
    <div class="stats-grid">
        <div class="stat-box">
            <p><strong>Principal:</strong> ₱<?= number_format($loan['amount'], 2) ?></p>
            <p><strong>Total Payable:</strong> ₱<?= number_format($loan['total_payable'], 2) ?></p>
            <p>
                <strong>Status:</strong>
                <?php
                if ($remainingBalance <= 0) {
                    echo '<span style="color:#059669;font-weight:bold;">Paid</span>';
                } elseif ($loan['status'] === 'Pending') {
                    echo '<span style="color:#dc2626;font-weight:bold;">Pending</span>';
                } else {
                    echo '<span style="color:#d97706;font-weight:bold;">Active</span>';
                }
                ?>
            </p>
        </div>

        <div class="stat-box">
            <p><strong>Released:</strong> <?= $loan['released_date'] ?></p>
            <p><strong>Due Date:</strong> <?= $loan['due_date'] ?></p>
            <p>
                <strong>Remaining:</strong>
                <span style="font-weight:bold;color:#dc2626;">
                    ₱<?= number_format($remainingBalance, 2) ?>
                </span>
            </p>
        </div>
    </div>

    <?php if (!empty($collateral)): ?>
    <div class="card" style="background:#f8fafc; border:1px solid #dbeafe;">
        <h3>Collateral Information</h3>
        <div class="collateral-box">
            <p><strong>Item Name:</strong> <?= htmlspecialchars($collateral['item_name']) ?></p>
            <p><strong>Estimated Value:</strong> ₱<?= number_format($collateral['estimated_value'], 2) ?></p>
            <?php if (!empty($collateral['file_path'])): ?>
                <p><strong>Attachment:</strong> 
                    <a href="/loansaas/public/<?= htmlspecialchars($collateral['file_path']) ?>" target="_blank" style="color:#2563eb;">View File</a>
                </p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="card">
        <h3>Loan Notes</h3>
        <div style="background:#f8fafc;padding:15px;border-radius:8px;color:#475569;">
            <?= !empty($loan['notes']) ? nl2br(htmlspecialchars($loan['notes'])) : 'No notes available.' ?>
        </div>
    </div>

    <h3>Payment History</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($payments)): ?>
                <tr>
                    <td colspan="2" style="text-align:center;color:#94a3b8;">No payments recorded yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($payments as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['payment_date']) ?></td>
                        <td style="font-weight:600;color:#059669;">₱<?= number_format($p['amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <br>

    <?php if ($loan['status'] === 'Pending'): ?>
        <a href="/loansaas/public/index.php?url=loan/approve&id=<?= $loan['id'] ?>"
           class="btn-success"
           onclick="return confirm('Are you sure you want to Approve this loan? This will deduct the amount from your account.');">
           ✔ Approve Loan
        </a>
    <?php endif; ?>

    <a href="/loansaas/public/index.php?url=loan/index" class="btn-back">
        &larr; Back to Loans
    </a>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>