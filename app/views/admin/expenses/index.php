<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Clean Container & Header Section */

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

    /* Desktop Row: Grid layout with Action column */
    .exp-list { background: transparent; }
    
    .exp-row { 
        display: grid; 
        grid-template-columns: 120px minmax(150px, 1fr) 140px 130px 100px; 
        padding: 16px 20px; 
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        align-items: center;
        gap: 20px;
        transition: background-color 0.15s;
    }
    
    .exp-row.header { 
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

    .exp-row:not(.header):hover {
        background-color: #f8fafc;
    }

    /* Action Icons Style */
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

    /* Modal Styles */
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

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .exp-row.header { display: none !important; }
        .exp-row { 
            display: flex !important; 
            flex-direction: column !important; 
            align-items: flex-start !important; 
            gap: 12px !important; 
            padding: 16px !important; 
        }
        .exp-row > div { 
            width: 100% !important; 
            display: flex !important; 
            justify-content: space-between !important; 
            align-items: center !important;
        }
        .exp-row > div::before { 
            content: attr(data-label); 
            font-weight: 700; 
            color: #64748b; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
        }
        .filter-card { flex-direction: column; }
        .filter-select { width: 100%; }
        .action-group { justify-content: flex-end; width: 100%; }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Expenses</h1>
            <p class="page-subtitle">Track your company expenditures</p>
        </div>
        <button type="button" class="btn-add" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add Expense
        </button>
    </div>

    <!-- Search & Filter Bar -->
    <div class="filter-card">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Search expense title..." onkeyup="filterExpenses()">
        </div>
    </div>

    <div class="exp-list">
        <div class="exp-row header">
            <div>Date</div>
            <div>Title</div>
            <div>Category</div>
            <div style="text-align: right;">Amount</div>
            <div style="text-align: right;">Action</div>
        </div>

        <?php if (empty($expenses)): ?>
            <div style="padding: 40px; text-align: center; color: #94a3b8; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">No expenses recorded yet.</div>
        <?php else: ?>
            <?php foreach ($expenses as $exp): ?>
            <div class="exp-row expense-item" data-title="<?= strtolower(htmlspecialchars($exp['title'])) ?>">
                <div data-label="Date" style="font-size: 0.85rem; color: #64748b;"><?= date('M d, Y', strtotime($exp['expense_date'])) ?></div>
                <div data-label="Title" style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($exp['title']) ?></div>
                <div data-label="Category">
                    <span style="background:#f1f5f9; padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight: 600; color: #475569;">
                        <?= htmlspecialchars($exp['category_name'] ?? 'General') ?>
                    </span>
                </div>
                <div data-label="Amount" style="color: #dc2626; font-weight: 700; text-align: right;">-₱<?= number_format($exp['amount'], 2) ?></div>
                <div data-label="Action" class="action-group">
                    <button type="button" class="icon-btn icon-btn-edit" 
                            title="Edit Expense"
                            data-id="<?= $exp['id'] ?>"
                            data-title="<?= htmlspecialchars($exp['title'] ?? '', ENT_QUOTES) ?>"
                            data-amount="<?= $exp['amount'] ?>"
                            data-date="<?= $exp['expense_date'] ?>"
                            onclick="openEditModal(this)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" class="icon-btn icon-btn-delete" 
                            title="Delete Expense"
                            data-id="<?= $exp['id'] ?>"
                            data-title="<?= htmlspecialchars($exp['title'] ?? '', ENT_QUOTES) ?>"
                            onclick="openDeleteModal(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Add Expense Modal -->
<div id="expModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0; color: #0f172a;">Record New Expense</h3>
            <span onclick="closeAddModal()" style="cursor:pointer; font-size:24px; color: #64748b;">&times;</span>
        </div>
        <form method="POST" action="/loansaas/public/index.php?url=expense/store">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Amount *</label>
                <input type="number" name="amount" step="0.01" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Date *</label>
                <input type="date" name="expense_date" class="form-input" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div style="text-align: right; margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-secondary" onclick="closeAddModal()">Cancel</button>
                <button type="submit" class="btn-add">Save Expense</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Expense Modal -->
<div id="editExpModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0; color: #0f172a;">Edit Expense</h3>
            <span onclick="closeEditModal()" style="cursor:pointer; font-size:24px; color: #64748b;">&times;</span>
        </div>
        <form id="editExpenseForm" method="POST" action="">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" id="edit_title" name="title" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Amount *</label>
                <input type="number" id="edit_amount" name="amount" step="0.01" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Date *</label>
                <input type="date" id="edit_date" name="expense_date" class="form-input" required>
            </div>
            <div style="text-align: right; margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-add">Update Expense</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteExpModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="margin:0; color: #0f172a;">Delete Expense</h3>
            <span onclick="closeDeleteModal()" style="cursor:pointer; font-size:24px; color: #64748b;">&times;</span>
        </div>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 24px;">
            Are you sure you want to delete <strong id="delete_expense_title" style="color: #0f172a;"></strong>? This action cannot be undone.
        </p>
        <form id="deleteExpenseForm" method="POST" action="">
            <div style="text-align: right; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="btn-danger-action">Delete Expense</button>
            </div>
        </form>
    </div>
</div>

<script>
    function filterExpenses() {
        const searchVal = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.expense-item');

        rows.forEach(row => {
            const title = row.getAttribute('data-title');
            if (title.includes(searchVal)) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function openAddModal() { document.getElementById('expModal').style.display = 'flex'; }
    function closeAddModal() { document.getElementById('expModal').style.display = 'none'; }

    function openEditModal(button) {
        const id = button.getAttribute('data-id');
        document.getElementById('editExpenseForm').action = '/loansaas/public/index.php?url=expense/update/' + id;
        document.getElementById('edit_title').value = button.getAttribute('data-title');
        document.getElementById('edit_amount').value = button.getAttribute('data-amount');
        document.getElementById('edit_date').value = button.getAttribute('data-date');
        document.getElementById('editExpModal').style.display = 'flex';
    }
    function closeEditModal() { document.getElementById('editExpModal').style.display = 'none'; }

    function openDeleteModal(button) {
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        document.getElementById('deleteExpenseForm').action = '/loansaas/public/index.php?url=expense/delete/' + id;
        document.getElementById('delete_expense_title').textContent = title;
        document.getElementById('deleteExpModal').style.display = 'flex';
    }
    function closeDeleteModal() { document.getElementById('deleteExpModal').style.display = 'none'; }

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