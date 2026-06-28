<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .loan-card { max-width: 600px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #444; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
    .row { display: flex; gap: 15px; }
    .btn-save { width: 100%; padding: 14px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; transition: 0.3s; }
    .btn-save:hover { background: #1d4ed8; }
    .due-date-box { background: #f8fafc; border: 1px dashed #cbd5e1; padding: 12px; border-radius: 6px; font-weight: bold; color: #0f172a; text-align: left; }
    .collateral-box { background: #f1f5f9; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #e2e8f0; }
</style>

<div class="loan-card">
    <h2 style="margin-top: 0; color: #2563eb;">Create New Loan</h2>
    
    <form action="/loansaas/public/index.php?url=loan/store" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label>Select Borrower</label>
            <select name="borrower_id" class="form-control" required>
                <option value="">-- Choose a Borrower --</option>
                <?php foreach ($borrowers as $b): ?>
                    <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="form-group" style="flex: 2;">
                <label>Select Account</label>
                <select name="account_id" id="account_select" class="form-control" required>
                    <option value="">-- Choose an Account --</option>
                    <?php foreach ($accounts as $acc): ?>
                        <option value="<?= $acc['id'] ?>" data-balance="<?= $acc['current_balance'] ?>">
                            <?= htmlspecialchars($acc['name']) ?> (Balance: ₱<?= number_format($acc['current_balance'], 2) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Principal Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" class="form-control" placeholder="0.00" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group" style="flex: 1;">
                <label>Interest Rate (%)</label>
                <input type="number" step="0.01" id="interest_rate" name="interest_rate" class="form-control" placeholder="0.00">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Fee</label>
                <input type="number" step="0.01" id="fee" name="fee" class="form-control" placeholder="0.00">
            </div>
        </div>

        <div class="form-group">
            <label>Loan Purpose</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($loanCategories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Loan Duration</label>
            <div class="row">
                <input type="number" id="term_months" name="term_months" class="form-control" placeholder="Qty (e.g. 3)" required style="flex: 2;">
                <select name="term_type" id="term_type" class="form-control" required style="flex: 1;">
                    <option value="one_time">One Time (Full Payment)</option>
                    <option value="monthly">Monthly</option>
                    <option value="semi_monthly">Every 15 Days</option>
                    <option value="weekly">Weekly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Release Date</label>
            <input type="date" id="loan_date" name="released_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <label>Due Date(s)</label>
            <div id="due_date_display" class="due-date-box">Select date and term to calculate...</div>
            <input type="hidden" name="due_date" id="due_date_hidden" required>
        </div>

        <div class="form-group">
            <label>Total Payable</label>
            <input type="number" step="0.01" id="total_payable" name="total_payable" class="form-control" readonly style="background: #e9ecef;">
        </div>

        <div class="collateral-box">
            <h4 style="margin-top:0;">Collateral Details (Optional)</h4>
            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="collateral_name" class="form-control" placeholder="e.g., Gold Ring">
            </div>
            <div class="form-group">
                <label>Estimated Value</label>
                <input type="number" step="0.01" name="collateral_value" class="form-control" placeholder="0.00">
            </div>
            <div class="form-group">
                <label>Upload Attachment</label>
                <input type="file" name="collateral_file" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn-save">Save Loan</button>
    </form>
</div>

<script>
    const amountInput = document.getElementById('amount');
    const interestInput = document.getElementById('interest_rate');
    const feeInput = document.getElementById('fee');
    const totalPayableInput = document.getElementById('total_payable');
    const loanDateInput = document.getElementById('loan_date');
    const termValueInput = document.getElementById('term_months');
    const termTypeInput = document.getElementById('term_type');
    const dueDateDisplay = document.getElementById('due_date_display');
    const dueDateHidden = document.getElementById('due_date_hidden');
    const accountSelect = document.getElementById('account_select');

    function calculateTotal() {
        const principal = parseFloat(amountInput.value) || 0;
        const rate = parseFloat(interestInput.value) || 0;
        const fee = parseFloat(feeInput.value) || 0;
        const qty = parseFloat(termValueInput.value) || 1;
        const freq = termTypeInput.value;

        let interest = 0;
        
        // Logic: Calculate interest based on duration if monthly/daily/etc
        if (freq !== "one_time") {
            interest = principal * (rate / 100) * qty;
        } else {
            interest = principal * (rate / 100);
        }

        totalPayableInput.value = (principal + interest + fee).toFixed(2);
        calculateDates();
    }

    function calculateDates() {
        if (!loanDateInput.value || !termValueInput.value) return;

        const startDate = new Date(loanDateInput.value);
        const qty = parseInt(termValueInput.value);
        const freq = termTypeInput.value;
        let finalDate = new Date(startDate);

        // Calculate Final Date
        if (freq === "monthly") finalDate.setMonth(finalDate.getMonth() + qty);
        else if (freq === "daily") finalDate.setDate(finalDate.getDate() + qty);
        else if (freq === "weekly") finalDate.setDate(finalDate.getDate() + (qty * 7));
        else if (freq === "semi_monthly") finalDate.setDate(finalDate.getDate() + (qty * 15));
        else finalDate.setDate(finalDate.getDate() + qty); // Default for one-time

        dueDateHidden.value = finalDate.toISOString().split('T')[0];

        if (freq === "one_time") {
            dueDateDisplay.innerHTML = "<strong>Final Due Date:</strong> " + finalDate.toLocaleDateString();
            return;
        }

        // Show Schedule
        let html = "<strong>Payment Schedule</strong><ul style='margin-top:10px'>";
        let current = new Date(startDate);
        for(let i = 1; i <= qty; i++) {
            if (freq === "monthly") current.setMonth(current.getMonth() + 1);
            else if (freq === "weekly") current.setDate(current.getDate() + 7);
            else if (freq === "semi_monthly") current.setDate(current.getDate() + 15);
            else if (freq === "daily") current.setDate(current.getDate() + 1);
            
            html += `<li>Payment ${i}: ${current.toLocaleDateString()}</li>`;
        }
        dueDateDisplay.innerHTML = html + "</ul>";
    }

    // Event Listeners
    [amountInput, interestInput, feeInput, termValueInput].forEach(el => el.addEventListener('input', calculateTotal));
    [termTypeInput, loanDateInput].forEach(el => el.addEventListener('change', calculateTotal));

    document.querySelector('form').addEventListener('submit', function(e) {
        const balance = parseFloat(accountSelect.options[accountSelect.selectedIndex].getAttribute('data-balance')) || 0;
        if (parseFloat(amountInput.value) > balance) {
            e.preventDefault();
            alert('Error: Loan amount exceeds account balance.');
        }
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>