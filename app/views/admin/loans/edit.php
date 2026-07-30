<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Styling for the Edit Form */
    #edit-loan-form {
        max-width: 900px;
        margin: 20px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    #edit-loan-form h2 { margin-bottom: 25px; color: #1e293b; }

    .grid-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group { margin-bottom: 15px; }
    
    .full-width { grid-column: span 2; }

    label { font-weight: 600; font-size: 0.9rem; color: #475569; display: block; margin-bottom: 5px; }

    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        box-sizing: border-box;
    }

    .btn-update {
        width: 100%;
        padding: 12px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 20px;
    }

    .btn-update:hover { background: #15803d; }
</style>

<div id="edit-loan-form">
    <h2>Edit Loan #<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></h2>

    <form method="POST" action="/loansaas/public/index.php?url=loan/update&id=<?= $loan['id'] ?>">
        <div class="grid-container">
            <div class="form-group">
                <label>Principal Amount</label>
                <input type="number" id="amount" name="amount" value="<?= htmlspecialchars($loan['amount']) ?>" required>
            </div>
            <div class="form-group">
                <label>Interest Rate (%)</label>
                <input type="number" id="interest_rate" step="0.01" name="interest_rate" value="<?= htmlspecialchars($loan['interest_rate']) ?>" required>
            </div>

            <div class="form-group">
                <label>Loan Duration & Frequency</label>
                <div style="display: flex; gap: 5px;">
                    <input type="number" id="term_months" name="term_months" 
                           value="<?= htmlspecialchars($loan['term_months'] ?? '1') ?>" 
                           style="width: 40%;" required>
                    
                    <select name="term_type" id="term_type" style="width: 60%;">
                        <option value="one_time" <?= ($loan['term_type'] ?? '') === 'one_time' ? 'selected' : '' ?>>One Time (Full Payment)</option>
                        <option value="monthly" <?= ($loan['term_type'] ?? '') === 'monthly' ? 'selected' : '' ?>>Monthly</option>
                        <option value="semi_monthly" <?= ($loan['term_type'] ?? '') === 'semi_monthly' ? 'selected' : '' ?>>Every 15 Days</option>
                        <option value="weekly" <?= ($loan['term_type'] ?? '') === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                        <option value="daily" <?= ($loan['term_type'] ?? '') === 'daily' ? 'selected' : '' ?>>Daily</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Released Date</label>
                <input type="date" id="released_date" name="released_date" value="<?= htmlspecialchars($loan['released_date']) ?>" required>
            </div>

            <div class="form-group">
                <label>Total Payable Amount</label>
                <input type="text" id="total_payable" name="total_payable" 
                       value="<?= htmlspecialchars($loan['total_payable']) ?>" 
                       readonly style="background: #f1f5f9;"> 
            </div>

            <div class="form-group">
                <label>Loan Account</label>
                <select name="account_id" required>
                    <?php foreach ($accounts as $acc): ?>
                        <option value="<?= $acc['id'] ?>" <?= $loan['account_id'] == $acc['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($acc['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" id="due_date" name="due_date" value="<?= htmlspecialchars($loan['due_date']) ?>" required>
            </div>

            <div class="form-group full-width">
                <label>Notes</label>
                <input type="text" name="notes" value="<?= htmlspecialchars($loan['notes'] ?? '') ?>">
            </div>
        </div>

        <div style="margin-top: 20px; background: #f8fafc; padding: 15px; border-radius: 8px;">
            <h3>Edit Collateral</h3>
            <div class="grid-container">
                <input type="hidden" name="collateral_id" value="<?= $collateral['id'] ?? '' ?>">
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="collateral_name" value="<?= htmlspecialchars($collateral['item_name'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Estimated Value</label>
                    <input type="number" name="collateral_value" value="<?= htmlspecialchars($collateral['estimated_value'] ?? '') ?>">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-update">Update Loan Details</button>
        <a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>" style="display:block; text-align:center; margin-top:15px; color:#64748b;">Cancel</a>
    </form>
</div>

<script>
function calculateTotal() {
    const P = parseFloat(document.getElementById('amount').value) || 0;
    const rate = parseFloat(document.getElementById('interest_rate').value) || 0;
    const qty = parseFloat(document.getElementById('term_months').value) || 1;
    const freq = document.getElementById('term_type').value;

    let total = 0;

    // For One-Time loans, interest is applied once regardless of duration multiplier
    if (freq === 'one_time') {
        total = P + (P * (rate / 100));
    } else {
        total = P + (P * (rate / 100) * qty);
    }
    
    document.getElementById('total_payable').value = total.toFixed(2);
}

function calculateDueDate() {
    const releasedValue = document.getElementById('released_date').value;
    if (!releasedValue) return;

    const qty = parseInt(document.getElementById('term_months').value) || 1;
    const freq = document.getElementById('term_type').value;

    // Split YYYY-MM-DD manually to prevent UTC timezone offset bugs
    const parts = releasedValue.split('-');
    let date = new Date(parts[0], parts[1] - 1, parts[2]);

    switch (freq) {
        case 'daily':
            date.setDate(date.getDate() + qty);
            break;
        case 'weekly':
            date.setDate(date.getDate() + (7 * qty));
            break;
        case 'semi_monthly':
            date.setDate(date.getDate() + (15 * qty));
            break;
        case 'monthly':
            date.setMonth(date.getMonth() + qty);
            break;
        case 'one_time':
            // IF 'One Time' duration input represents DAYS (e.g. 5 days from release):
            date.setDate(date.getDate() + qty);
            
            // NOTE: If 'One Time' duration input represents MONTHS instead, use this line:
            // date.setMonth(date.getMonth() + qty);
            break;
    }

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    document.getElementById('due_date').value = `${year}-${month}-${day}`;
}

document.addEventListener("DOMContentLoaded", function() {
    const triggerElements = ['released_date', 'term_months', 'term_type'];
    
    triggerElements.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', calculateDueDate);
            el.addEventListener('input', calculateDueDate);
            el.addEventListener('change', calculateTotal);
            el.addEventListener('input', calculateTotal);
        }
    });

    document.getElementById('amount').addEventListener('input', calculateTotal);
    document.getElementById('interest_rate').addEventListener('input', calculateTotal);

    // Calculate on load
    calculateTotal();
    calculateDueDate();
});
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>