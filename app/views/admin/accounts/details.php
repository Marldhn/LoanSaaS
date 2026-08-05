<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    
    .btn-back { padding: 10px 20px; background: #64748b; color: white; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; }
    .btn-adjust { background: #059669; color: white; padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; }
    .btn-edit-account { background: #4f46e5; color: white; padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; }
</style>

<div class="page-container">
    <div class="account-header">
        <h1><?= htmlspecialchars($account['name']) ?> Details</h1>
        <div class="d-flex gap-2">
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <button type="button" class="btn-edit-account" data-bs-toggle="modal" data-bs-target="#editAccountModal">
                    Edit Name
                </button>
                <button type="button" class="btn-adjust" data-bs-toggle="modal" data-bs-target="#adjustModal">
                    Adjust Balance
                </button>
            <?php endif; ?>
            <a href="?url=account/index" class="btn-back">← Back to Accounts</a>
        </div>
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

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="?url=account/updateAccount" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="account_id" value="<?= $account['id'] ?>">
        
        <div class="modal-header">
          <h5 class="modal-title">Edit Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Account Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($account['name']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Account Icon / Logo</label>
            <input type="file" name="icon" class="form-control" accept="image/*">
            <?php if (!empty($account['icon'])): ?>
                <div class="mt-2">
                    <small class="text-muted">Current Icon:</small><br>
                    <img src="/loansaas/public/uploads/accounts/<?= htmlspecialchars($account['icon']) ?>" alt="Icon" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; margin-top: 4px;">
                </div>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Adjust Balance Modal -->
<div class="modal fade" id="adjustModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="?url=account/processAdjustment" method="POST">
        <input type="hidden" name="account_id" value="<?= $account['id'] ?>">
        
        <div class="modal-header">
          <h5 class="modal-title">Adjust Account Balance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Adjustment Type</label>
            <select name="type" class="form-control" required>
              <option value="add">Add Funds</option>
              <option value="deduct">Deduct Funds</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Amount (₱)</label>
            <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Reason / Note</label>
            <input type="text" name="notes" class="form-control" placeholder="e.g., Opening Balance Adjustment" required>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm Adjustment</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>