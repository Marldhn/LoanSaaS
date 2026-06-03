<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Consistent Page Layout */
    .exp-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .exp-list { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    
    .exp-row { display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; padding: 15px 20px; border-bottom: 1px solid #f1f5f9; align-items: center; }
    .exp-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
    
    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; justify-content: center; align-items: center; z-index: 9999; }
    .modal-content { background: #fff; width: 90%; max-width: 500px; border-radius: 12px; padding: 24px; position: relative; }
</style>

<div class="exp-card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2 style="margin:0;">Expenses</h2>
            <p style="margin:5px 0 0; color: #94a3b8; font-size: 0.9rem;">Track your company expenditures</p>
        </div>
        <button type="button" onclick="document.getElementById('expModal').style.display='flex'" 
                style="padding: 10px 20px; background: #6366f1; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
            + Add Expense
        </button>
    </div>
</div>

<div class="exp-list">
    <div class="exp-row header">
        <div>Date</div>
        <div>Title</div>
        <div>Category</div>
        <div>Amount</div>
    </div>

    <?php if (empty($expenses)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8;">No expenses recorded yet.</div>
    <?php else: ?>
        <?php foreach ($expenses as $exp): ?>
        <div class="exp-row">
            <div style="color: #64748b;"><?= date('M d, Y', strtotime($exp['expense_date'])) ?></div>
            <div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($exp['title']) ?></div>
            <div><span style="background:#f1f5f9; padding:4px 10px; border-radius:20px; font-size:0.8rem;"><?= htmlspecialchars($exp['category_name'] ?? 'General') ?></span></div>
            <div style="color: #dc2626; font-weight: 700;">-₱<?= number_format($exp['amount'], 2) ?></div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="expModal" class="modal-overlay">
    <div class="modal-content">
        <button type="button" onclick="document.getElementById('expModal').style.display='none'" 
                style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8;">
            &times;
        </button>

        <h3 style="margin-top:0;">Record New Expense</h3>
        
        <form method="POST" action="/loansaas/public/index.php?url=expense/store">
            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:600; margin-bottom:5px;">Title</label>
                <input type="text" name="title" class="form-input" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:600; margin-bottom:5px;">Amount</label>
                <input type="number" name="amount" step="0.01" class="form-input" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-weight:600; margin-bottom:5px;">Date</label>
                <input type="date" name="expense_date" class="form-input" value="<?= date('Y-m-d') ?>" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;">
            </div>
            <button type="submit" style="width:100%; padding:12px; background:#6366f1; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600;">Save Expense</button>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>