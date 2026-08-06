<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .card-wrapper { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 30px; margin: 20px auto; max-width: 600px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .page-header h1 { color: #1e293b; margin-bottom: 20px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-weight: 600; margin-bottom: 8px; color: #475569; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; background: #fff; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #6366f1; ring: 2px solid #e0e7ff; }
    .btn-submit { background: #6366f1; color: white; width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background: #4f46e5; }
    .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
</style>

<div class="page-header">
    <h1>Create New Expense</h1>
</div>

<div class="card-wrapper">
    <form action="?url=expense/store" method="POST">
        
        <div class="form-group">
            <label>Select Account</label>
            <select name="account_id" class="form-control" required>
                <?php foreach($accounts as $acc): ?>
                    <option value="<?= $acc['id'] ?>"><?= $acc['name'] ?> (Bal: ₱<?= number_format($acc['current_balance'], 2) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Expense Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g., Office Rent, Electricity" required>
        </div>


        <div class="form-group">
            <label>Expense Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($expenseCategories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid-form">
            <div class="form-group">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="expense_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn-submit">Save & Deduct Expense</button>
    </form>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>