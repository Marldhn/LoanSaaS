<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Consistent Page Layout */
    .cat-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .cat-list { background: transparent; }

    /* Desktop Row: Balanced grid to keep columns tight */
    .cat-row { 
        display: grid; 
        grid-template-columns: minmax(150px, 200px) minmax(100px, 150px) 1fr; 
        padding: 16px 20px; 
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        align-items: center;
        gap: 20px; 
    }
    
    .cat-row.header { 
        background: #f8fafc; 
        font-weight: 700; 
        color: #64748b; 
        font-size: 0.85rem; 
        text-transform: uppercase; 
        border: 1px solid #e2e8f0;
    }

    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; justify-content: center; align-items: center; z-index: 9999; }
    .modal-content { background: #fff; width: 90%; max-width: 500px; border-radius: 12px; padding: 24px; position: relative; }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .cat-row.header { display: none !important; }
        .cat-row { 
            display: flex !important; 
            flex-direction: column !important; 
            align-items: flex-start !important; 
            gap: 8px !important; 
            padding: 20px !important; 
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            margin-bottom: 12px !important;
        }
        .cat-row > div { 
            width: 100% !important; 
            display: flex !important; 
            justify-content: space-between !important; 
        }
        .cat-row > div::before { 
            content: attr(data-label); 
            font-weight: 700; 
            color: #64748b; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
        }
    }
</style>

<div class="cat-card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2 style="margin:0;">Categories</h2>
            <p style="margin:5px 0 0; color: #94a3b8; font-size: 0.9rem;">Manage system categories for loans and expenses</p>
        </div>
        <button type="button" onclick="document.getElementById('catModal').style.display='flex'" 
                style="padding: 10px 20px; background: #6366f1; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
            + Add Category
        </button>
    </div>
</div>

<div class="cat-list">
    <div class="cat-row header">
        <div>Name</div>
        <div>Type</div>
        <div>Description</div>
    </div>

    <?php if (empty($categories)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8;">No categories found.</div>
    <?php else: ?>
        <?php foreach ($categories as $cat): ?>
        <div class="cat-row">
            <div data-label="Name" style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($cat['name']) ?></div>
            <div data-label="Type">
                <span style="background:#f1f5f9; padding:4px 10px; border-radius:20px; font-size:0.8rem; text-transform:capitalize;">
                    <?= htmlspecialchars($cat['type']) ?>
                </span>
            </div>
            <div data-label="Description" style="color:#64748b; font-size: 0.9rem;"><?= htmlspecialchars($cat['description'] ?: '-') ?></div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="catModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <h3 style="margin:0;">Create New Category</h3>
            <span onclick="document.getElementById('catModal').style.display='none'" style="cursor:pointer; font-size:20px;">&times;</span>
        </div>
        <form method="POST" action="/loansaas/public/index.php?url=category/store">
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Category Name</label>
                <input type="text" name="name" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Category Type</label>
                <select name="type" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;" required>
                    <option value="loan">Loan Category</option>
                    <option value="payment">Payment Category</option>
                    <option value="feedback">Feedback Category</option>
                    <option value="expense">Expense Category</option>
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Description</label>
                <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; box-sizing:border-box;"></textarea>
            </div>
            <button type="submit" style="width:100%; padding:12px; background:#6366f1; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600;">Save Category</button>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>