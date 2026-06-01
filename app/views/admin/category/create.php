<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<div class="main-content" style="padding: 20px;">
    <div class="form-container" style="max-width: 600px; background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; margin: 0 auto;">
        <h2 style="margin-bottom: 20px;">Create New Category</h2>
        
        <form method="POST" action="/loansaas/public/index.php?url=category/store">
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Category Name</label>
                <input type="text" name="name" class="form-input" required 
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Category Type</label>
                <select name="type" class="form-input" required 
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    <option value="loan">Loan Category</option>
                    <option value="payment">Payment Category</option>
                    <option value="feedback">Feedback Category</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Description (Optional)</label>
                <textarea name="description" class="form-input" rows="3" 
                          style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;"></textarea>
            </div>

            <button type="submit" 
                    style="background: var(--primary-color, #2563eb); color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                Save Category
            </button>
            <a href="/loansaas/public/index.php?url=category/index" 
               style="margin-left: 10px; color: #64748b; text-decoration: none;">Cancel</a>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>