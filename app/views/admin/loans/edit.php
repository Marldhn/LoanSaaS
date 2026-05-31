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
                <input type="number" name="amount" value="<?= htmlspecialchars($loan['amount']) ?>" required>
            </div>
            <div class="form-group">
                <label>Interest Rate (%)</label>
                <input type="number" step="0.01" name="interest_rate" value="<?= htmlspecialchars($loan['interest_rate']) ?>" required>
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
                <label>Term & Type</label>
                <div style="display: flex; gap: 5px;">
                    <input type="number" name="term_months" value="<?= htmlspecialchars($loan['term_months'] ?? '') ?>" style="width: 60%;" required>
                    <select name="term_type" style="width: 40%;">
                        <option value="month" <?= ($loan['term_type'] ?? '') === 'month' ? 'selected' : '' ?>>Month(s)</option>
                        <option value="day" <?= ($loan['term_type'] ?? '') === 'day' ? 'selected' : '' ?>>Day(s)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Released Date</label>
                <input type="date" name="released_date" value="<?= htmlspecialchars($loan['released_date']) ?>" required>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date" value="<?= htmlspecialchars($loan['due_date']) ?>" required>
            </div>

            <div class="form-group full-width">
                <label>Notes</label>
                <input type="text" name="notes" value="<?= htmlspecialchars($loan['notes'] ?? '') ?>">
            </div>
        </div>

        <div class="card" style="margin-top: 20px; background: #f8fafc;">
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

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>