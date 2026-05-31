<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .loan-card { max-width: 600px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #444; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
    .row { display: flex; gap: 15px; }
    .btn-save { width: 100%; padding: 14px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; transition: 0.3s; }
    .btn-save:hover { background: #1d4ed8; }
    .due-date-box { background: #f8fafc; border: 1px dashed #cbd5e1; padding: 12px; border-radius: 6px; font-weight: bold; color: #0f172a; text-align: center; }
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
             <div class="form-group">
            <label>Select Account</label>
            <select name="account_id" class="form-control" required>
                <option value="">-- Choose an Account --</option>
                <?php foreach ($accounts as $acc): ?>
                    <option value="<?= $acc['id'] ?>">
                        <?= htmlspecialchars($acc['name']) ?> (Balance: ₱<?= number_format($acc['current_balance'], 2) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="form-group">
            <label>Loan Amount (Principal)</label>
            <input type="number" step="0.01" id="amount" name="amount" class="form-control" placeholder="0.00" required>
        </div>

   
        <div class="form-group">
            <label>Interest Rate (%)</label>
            <input type="number" step="0.01" id="interest_rate" name="interest_rate" class="form-control" placeholder="0.00">
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

        <div class="form-group" style="margin-top: 20px;">
            <label>Loan Duration</label>
            <div class="row">
                <input type="number" id="term_months" name="term_months" class="form-control" placeholder="Qty (e.g. 3)" required>
                <select name="term_type" id="term_type" class="form-control" required>
                    <option value="month">Month(s)</option>
                    <option value="day">Day(s)</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Release Date</label>
            <input type="date" id="loan_date" name="released_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <label>Calculated Due Date</label>
            <div id="due_date_display" class="due-date-box">Select date and term to calculate...</div>
            <input type="hidden" name="due_date" id="due_date_hidden" required>
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
    const totalPayableInput = document.getElementById('total_payable');
    const loanDateInput = document.getElementById('loan_date');
    const termValueInput = document.getElementById('term_months');
    const termTypeInput = document.getElementById('term_type');
    const dueDateDisplay = document.getElementById('due_date_display');
    const dueDateHidden = document.getElementById('due_date_hidden');

    function calculateTotal() {
        const principal = parseFloat(amountInput.value) || 0;
        const rate = parseFloat(interestInput.value) || 0;
        const total = principal + (principal * (rate / 100));
        totalPayableInput.value = total.toFixed(2);
    }

    function calculateDueDate() {
        if (!loanDateInput.value || !termValueInput.value) {
            dueDateDisplay.innerText = "Select date and term to calculate...";
            dueDateHidden.value = "";
            return;
        }

        let date = new Date(loanDateInput.value);
        let value = parseInt(termValueInput.value);
        let type = termTypeInput.value;

        if (type === 'month') {
            date.setMonth(date.getMonth() + value);
        } else {
            date.setDate(date.getDate() + value);
        }

        // Display for user
        dueDateDisplay.innerText = date.toLocaleDateString(undefined, { 
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
        });

        // Set hidden input for database (YYYY-MM-DD)
        dueDateHidden.value = date.toISOString().split('T')[0];
    }

    // Event Listeners
    amountInput.addEventListener('input', calculateTotal);
    interestInput.addEventListener('input', calculateTotal);
    [loanDateInput, termValueInput, termTypeInput].forEach(el => {
        el.addEventListener('change', calculateDueDate);
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>