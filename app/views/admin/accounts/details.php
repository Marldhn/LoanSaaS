<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .page-container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
    
    .account-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .account-header h1 { font-size: 24px; font-weight: 700; color: #1e293b; margin: 0; }
    
    .balance-card { 
        background: #4f46e5; color: white; padding: 30px; border-radius: 16px; 
        margin-bottom: 30px; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2);
    }
    .balance-card h4 { margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase; opacity: 0.8; letter-spacing: 0.05em; }
    .balance-card h2 { margin: 0; font-size: 40px; font-weight: 800; }

    .history-card { background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; }
    .history-card h3 { padding: 20px 24px; margin: 0; border-bottom: 1px solid #f1f5f9; font-size: 18px; color: #334155; }
    
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 16px 24px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase; }
    .data-table td { padding: 16px 24px; border-top: 1px solid #f1f5f9; font-size: 14px; color: #334155; }
    .data-table tr:hover { background: #fdfdfd; }
    
    .badge { 
        padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;
        background: #e2e8f0; color: #475569; text-transform: capitalize;
    }
    .btn-back { 
        padding: 10px 20px; background: #64748b; color: white; border-radius: 8px; 
        text-decoration: none; font-size: 14px; font-weight: 500; transition: background 0.2s;
    }
    .btn-back:hover { background: #475569; }
</style>

<div class="page-container">
    <div class="account-header">
        <h1><?= htmlspecialchars($account['name']) ?> Details</h1>
        <a href="/loansaas/public/index.php?url=account/index" class="btn-back">← Back to Accounts</a>
    </div>

    <div class="balance-card">
        <h4>Current Balance</h4>
        <h2>₱<?= number_format($account['current_balance'], 2) ?></h2>
    </div>

    <div class="history-card">
        <h3>Transaction History</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Notes</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td style="color: #64748b;"><?= date('M d, Y, h:i A', strtotime($t['created_at'])) ?></td>
                    <td><?= htmlspecialchars($t['notes']) ?></td>
                    <td style="font-weight: 600; color: <?= $t['amount'] < 0 ? '#e11d48' : '#059669' ?>;">
                        <?= $t['amount'] > 0 ? '+' : '' ?><?= number_format($t['amount'], 2) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>