<div class="card">
    <h3>Record New Payment</h3>
    <form action="/loansaas/public/index.php?url=payment/store" method="POST">
        <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
        
        <div class="form-group">
            <label>Amount (₱)</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Payment Date</label>
            <input type="date" name="payment_date" value="<?= date('Y-m-d') ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Method</label>
            <select name="payment_method" class="form-control">
                <option value="Cash">Cash</option>
                <option value="GCash">GCash</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>

        <div class="form-group">
            <label>Reference #</label>
            <input type="text" name="reference_number" class="form-control" placeholder="Optional">
        </div>

        <button type="submit" class="btn-primary" style="margin-top: 15px;">Process Payment</button>
    </form>
</div>