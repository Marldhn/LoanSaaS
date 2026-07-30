<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>


    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0;
    }

    .btn-add {
        background: #6366f1;
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background-color 0.2s;
        text-decoration: none;
    }

    .btn-add:hover {
        background: #4f46e5;
    }

    /* Filter & Search Bar Row */
    .filter-card {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .search-input:focus {
        border-color: #6366f1;
    }

    .filter-select {
        padding: 12px 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #475569;
        outline: none;
        min-width: 160px;
        cursor: pointer;
    }

    /* Consistent Row List Structure */
    .cat-list {
        background: transparent;
    }

    .cat-row { 
        display: grid; 
        grid-template-columns: minmax(180px, 240px) minmax(120px, 160px) 1fr 100px; 
        padding: 16px 20px; 
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        align-items: center;
        gap: 20px; 
        transition: background-color 0.15s;
    }
    
    .cat-row.header { 
        background: #ffffff; 
        font-weight: 700; 
        color: #64748b; 
        font-size: 0.75rem; 
        letter-spacing: 0.05em;
        text-transform: uppercase; 
        border: none;
        padding: 12px 20px;
        margin-bottom: 4px;
    }

    .cat-row:not(.header):hover {
        background-color: #f8fafc;
    }

    /* Action Icons (Matching 2nd Picture Style) */
    .action-group {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    .icon-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: #f1f5f9;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.8rem;
    }

    .icon-btn-edit:hover {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .icon-btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Modals & Forms */
    .modal-overlay { 
        position: fixed; 
        top: 0; left: 0; 
        width: 100%; height: 100%; 
        background: rgba(15, 23, 42, 0.5); 
        backdrop-filter: blur(2px);
        display: none; 
        justify-content: center; 
        align-items: center; 
        z-index: 9999; 
    }

    .modal-content { 
        background: #ffffff; 
        width: 90%; 
        max-width: 500px; 
        border-radius: 12px; 
        padding: 24px; 
        position: relative; 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .form-label { font-size: 13px; font-weight: 600; color: #475569; }
    .form-input, .form-select, .form-textarea { 
        padding: 10px 14px; 
        border: 1px solid #cbd5e1; 
        border-radius: 8px; 
        font-size: 14px; 
        width: 100%; 
        box-sizing: border-box; 
        outline: none;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: #6366f1; }

    .btn-secondary { background: #f1f5f9; color: #475569; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
    .btn-danger-action { background: #dc2626; color: #ffffff; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .cat-row.header { display: none !important; }
        .cat-row { 
            display: flex !important; 
            flex-direction: column !important; 
            align-items: flex-start !important; 
            gap: 12px !important; 
            padding: 16px !important; 
        }
        .cat-row > div { 
            width: 100% !important; 
            display: flex !important; 
            justify-content: space-between !important; 
            align-items: center !important;
        }
        .cat-row > div::before { 
            content: attr(data-label); 
            font-weight: 700; 
            color: #64748b; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
        }
        .filter-card { flex-direction: column; }
        .filter-select { width: 100%; }
    }
</style>

<div class="page-container">
    <!-- Top Action Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Categories</h1>
            <p class="page-subtitle">Manage system categories for loans and expenses</p>
        </div>
        <button type="button" class="btn-add" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add Category
        </button>
    </div>

    <!-- Search & Type Filter Bar -->
    <div class="filter-card">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Search category name or description..." onkeyup="filterCategories()">
        </div>
        <select id="typeFilter" class="filter-select" onchange="filterCategories()">
            <option value="">All Types</option>
            <option value="loan">Loan</option>
            <option value="payment">Payment</option>
            <option value="feedback">Feedback</option>
            <option value="expense">Expense</option>
        </select>
    </div>

    <!-- Category List Table -->
    <div class="cat-list">
        <div class="cat-row header">
            <div>Category Name</div>
            <div>Type</div>
            <div>Description</div>
            <div style="text-align: right;">Action</div>
        </div>

        <?php if (empty($categories)): ?>
            <div style="padding: 40px; text-align: center; color: #94a3b8; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">No categories found.</div>
        <?php else: ?>
            <?php foreach ($categories as $cat): ?>
            <div class="cat-row category-item" data-name="<?= strtolower(htmlspecialchars($cat['name'])) ?>" data-type="<?= strtolower(htmlspecialchars($cat['type'])) ?>" data-description="<?= strtolower(htmlspecialchars($cat['description'] ?? '')) ?>">
                <div data-label="Category Name" style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($cat['name']) ?></div>
                <div data-label="Type">
                    <span style="background:#f1f5f9; padding:4px 12px; border-radius:20px; font-size:0.8rem; text-transform:capitalize; font-weight: 600; color: #475569;">
                        <?= htmlspecialchars($cat['type']) ?>
                    </span>
                </div>
                <div data-label="Description" style="color:#64748b; font-size: 0.875rem;"><?= htmlspecialchars($cat['description'] ?: '-') ?></div>
                <div data-label="Action" class="action-group">
                    <button type="button" class="icon-btn icon-btn-edit" 
                            title="Edit Category"
                            data-id="<?= $cat['id'] ?>"
                            data-name="<?= htmlspecialchars($cat['name'] ?? '', ENT_QUOTES) ?>"
                            data-type="<?= htmlspecialchars($cat['type'] ?? '', ENT_QUOTES) ?>"
                            data-description="<?= htmlspecialchars($cat['description'] ?? '', ENT_QUOTES) ?>"
                            onclick="openEditModal(this)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" class="icon-btn icon-btn-delete" 
                            title="Delete Category"
                            data-id="<?= $cat['id'] ?>"
                            data-name="<?= htmlspecialchars($cat['name'] ?? '', ENT_QUOTES) ?>"
                            onclick="openDeleteModal(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Add Category Modal -->
<div id="catModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0; color: #0f172a;">Create New Category</h3>
            <span onclick="closeAddModal()" style="cursor:pointer; font-size:24px; color: #64748b;">&times;</span>
        </div>
        <form method="POST" action="/loansaas/public/index.php?url=category/store">
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Category Type *</label>
                <select name="type" class="form-select" required>
                    <option value="loan">Loan Category</option>
                    <option value="payment">Payment Category</option>
                    <option value="feedback">Feedback Category</option>
                    <option value="expense">Expense Category</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-textarea"></textarea>
            </div>
            <div style="text-align: right; margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-secondary" onclick="closeAddModal()">Cancel</button>
                <button type="submit" class="btn-add">Save Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCatModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0; color: #0f172a;">Edit Category</h3>
            <span onclick="closeEditModal()" style="cursor:pointer; font-size:24px; color: #64748b;">&times;</span>
        </div>
        <form id="editCategoryForm" method="POST" action="">
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" id="edit_name" name="name" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Category Type *</label>
                <select id="edit_type" name="type" class="form-select" required>
                    <option value="loan">Loan Category</option>
                    <option value="payment">Payment Category</option>
                    <option value="feedback">Feedback Category</option>
                    <option value="expense">Expense Category</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea id="edit_description" name="description" rows="3" class="form-textarea"></textarea>
            </div>
            <div style="text-align: right; margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-add">Update Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteCatModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="margin:0; color: #0f172a;">Delete Category</h3>
            <span onclick="closeDeleteModal()" style="cursor:pointer; font-size:24px; color: #64748b;">&times;</span>
        </div>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 24px;">
            Are you sure you want to delete <strong id="delete_category_name" style="color: #0f172a;"></strong>? This action cannot be undone.
        </p>
        <form id="deleteCategoryForm" method="POST" action="">
            <div style="text-align: right; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="btn-danger-action">Delete Category</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Live Search and Type Filter Logic
    function filterCategories() {
        const searchVal = document.getElementById('searchInput').value.toLowerCase();
        const typeVal = document.getElementById('typeFilter').value.toLowerCase();
        const rows = document.querySelectorAll('.category-item');

        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const type = row.getAttribute('data-type');
            const desc = row.getAttribute('data-description');

            const matchesSearch = name.includes(searchVal) || desc.includes(searchVal);
            const matchesType = typeVal === '' || type === typeVal;

            if (matchesSearch && matchesType) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal Control Functions
    function openAddModal() { document.getElementById('catModal').style.display = 'flex'; }
    function closeAddModal() { document.getElementById('catModal').style.display = 'none'; }

    function openEditModal(button) {
        const id = button.getAttribute('data-id');
        document.getElementById('editCategoryForm').action = '/loansaas/public/index.php?url=category/update/' + id;
        document.getElementById('edit_name').value = button.getAttribute('data-name');
        document.getElementById('edit_type').value = button.getAttribute('data-type');
        document.getElementById('edit_description').value = button.getAttribute('data-description');
        document.getElementById('editCatModal').style.display = 'flex';
    }
    function closeEditModal() { document.getElementById('editCatModal').style.display = 'none'; }

    function openDeleteModal(button) {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        document.getElementById('deleteCategoryForm').action = '/loansaas/public/index.php?url=category/delete/' + id;
        document.getElementById('delete_category_name').textContent = name;
        document.getElementById('deleteCatModal').style.display = 'flex';
    }
    function closeDeleteModal() { document.getElementById('deleteCatModal').style.display = 'none'; }

    window.onclick = function(event) { 
        if (event.target.classList.contains('modal-overlay')) {
            event.target.style.display = "none"; 
        }
    }

    document.addEventListener('keydown', function(event) { 
        if (event.key === "Escape") {
            closeAddModal();
            closeEditModal();
            closeDeleteModal();
        } 
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>