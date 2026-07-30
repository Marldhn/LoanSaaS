<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>



<style>
    /* Top Header Section */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .page-subtitle {
        color: #64748b;
        font-size: 0.875rem;
        margin: 4px 0 0 0;
    }
    
    /* Search & Filter Controls */
    .filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }
    .search-input-wrapper {
        position: relative;
        flex: 1;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    .search-input {
        width: 100%;
        padding: 10px 14px 10px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        outline: none;
        box-sizing: border-box;
        background: #fff;
    }
    .search-input:focus {
        border-color: #6366f1;
    }
    .filter-select {
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #334155;
        background: #fff;
        outline: none;
        cursor: pointer;
    }

    /* Table Grid Layout */
    .customer-list { 
        background: #ffffff; 
        border: 1px solid #f1f5f9;
        border-radius: 8px; 
    }
    .customer-row { 
        display: grid; 
        grid-template-columns: 3.5fr 3fr 1.5fr 1fr; 
        padding: 14px 20px; 
        background: #fff; 
        border-bottom: 1px solid #f1f5f9; 
        align-items: center; 
    }
    .customer-row:last-child {
        border-bottom: none;
    }
    .customer-row.header { 
        background: #fff; 
        font-weight: 600; 
        color: #64748b; 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }
    .customer-row:not(.header):hover {
        background-color: #f8fafc;
    }
    
    /* Badges & Action Buttons */
    .badge { 
        padding: 4px 10px; 
        border-radius: 12px; 
        font-size: 0.75rem; 
        font-weight: 600; 
        display: inline-block; 
    }
    .badge-active { background: #dcfce7; color: #15803d; }
    .badge-inactive { background: #fee2e2; color: #b91c1c; }
    
    /* Action Icon Styles */
    .action-group {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }
    .icon-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: none;
        background: #f1f5f9;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }
    .icon-btn-edit:hover {
        background: #e0e7ff;
        color: #4f46e5;
    }
    .icon-btn-view:hover {
        background: #dcfce7;
        color: #166534;
    }

    /* Primary Button matching Loans view */
    .btn-primary-action {
        background: #6366f1;
        color: #ffffff;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-primary-action:hover {
        background: #4f46e5;
    }

    /* Forms & Modal */
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .form-label { font-size: 13px; font-weight: 600; color: #475569; }
    .form-input, .form-textarea { padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; width: 100%; box-sizing: border-box; }
    .btn-secondary { background: #f1f5f9; color: #475569; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; }

    /* Modal Overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(2px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        overflow-y: auto;
    }
    .modal-box {
        background: #fff;
        width: 90%;
        max-width: 700px;
        border-radius: 12px;
        padding: 28px;
        position: relative;
        margin: 20px auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Mobile view */
    @media (max-width: 768px) {
        .customer-row { display: flex !important; flex-direction: column !important; align-items: flex-start !important; gap: 12px; }
        .customer-row.header { display: none !important; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .filter-bar { flex-direction: column; }
        .action-group { justify-content: flex-start; }
    }
</style>

<!-- Header Section -->
<div class="page-header">
    <div>
        <h1 class="page-title">Customer Management</h1>
        <p class="page-subtitle">Manage customer information, track statuses, and review borrower KYC details.</p>
    </div>
    <button type="button" class="btn-primary-action" onclick="openAddModal()">
        <i class="fas fa-plus"></i> New Borrower
    </button>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div style="background: #dcfce7; color: #166534; padding: 10px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.875rem;">
        Borrower successfully added!
    </div>
<?php endif; ?>

<!-- Search and Filter Bar -->
<div class="filter-bar">
    <div class="search-input-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" id="borrowerSearch" class="search-input" placeholder="Search borrower name or ID..." onkeyup="filterBorrowers()">
    </div>
    <select id="statusFilter" class="filter-select" onchange="filterBorrowers()">
        <option value="">All Statuses</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>
</div>

<!-- Table Data Section -->
<div class="customer-list">
    <div class="customer-row header">
        <div>Borrower / ID</div>
        <div>Contact</div>
        <div>Status</div>
        <div style="text-align: right;">Action</div>
    </div>

    <?php if (empty($borrowers)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8; font-size: 0.875rem;">No customer records found.</div>
    <?php else: ?>
        <?php foreach ($borrowers as $b): ?>
            <div class="customer-row borrower-data-row">
                <div>
                    <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;" class="borrower-name">
                        <?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?>
                    </div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;" class="borrower-id">
                        BORROWER ID: #<?= str_pad($b['id'], 6, '0', STR_PAD_LEFT) ?>
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: #334155; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-envelope" style="color: #94a3b8; width: 14px;"></i> <?= htmlspecialchars($b['email'] ?? '-') ?>
                    </div>
                    <div style="font-size: 0.85rem; color: #334155; display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                        <i class="fas fa-phone" style="color: #94a3b8; width: 14px;"></i> <?= htmlspecialchars($b['phone'] ?? '-') ?>
                    </div>
                </div>
                <div>
                    <span class="badge <?= ($b['status'] ?? 1) == 1 ? 'badge-active' : 'badge-inactive' ?> borrower-status">
                        <?= ($b['status'] ?? 1) == 1 ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="action-group">
                    <button type="button" class="icon-btn icon-btn-edit" 
                            title="Edit Borrower"
                            data-id="<?= $b['id'] ?>"
                            data-first_name="<?= htmlspecialchars($b['first_name'] ?? '', ENT_QUOTES) ?>"
                            data-middle_name="<?= htmlspecialchars($b['middle_name'] ?? '', ENT_QUOTES) ?>"
                            data-last_name="<?= htmlspecialchars($b['last_name'] ?? '', ENT_QUOTES) ?>"
                            data-phone="<?= htmlspecialchars($b['phone'] ?? '', ENT_QUOTES) ?>"
                            data-email="<?= htmlspecialchars($b['email'] ?? '', ENT_QUOTES) ?>"
                            data-gender="<?= htmlspecialchars($b['gender'] ?? '', ENT_QUOTES) ?>"
                            data-birthdate="<?= htmlspecialchars($b['birthdate'] ?? '', ENT_QUOTES) ?>"
                            data-valid_id="<?= htmlspecialchars($b['valid_id'] ?? '', ENT_QUOTES) ?>"
                            data-address="<?= htmlspecialchars($b['address'] ?? '', ENT_QUOTES) ?>"
                            onclick="openEditModal(this)">
                        <i class="fas fa-pen"></i>
                    </button>

                    <a href="/loansaas/public/index.php?url=borrower/details&id=<?= $b['id'] ?>" class="icon-btn icon-btn-view" title="View Details">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Add Borrower Modal -->
<div id="addModal" class="modal-overlay">
    <div class="modal-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0; color: #0f172a;">Enroll New Borrower</h3>
            <button type="button" onclick="closeAddModal()" style="background:none; border:none; font-size: 24px; cursor:pointer; color: #64748b;">&times;</button>
        </div>

        <form method="POST" action="/loansaas/public/index.php?url=borrower/store">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label class="form-label">First Name *</label><input type="text" name="first_name" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Last Name *</label><input type="text" name="last_name" class="form-input" required></div>
            </div>
            <div class="form-group"><label class="form-label">Middle Name</label><input type="text" name="middle_name" class="form-input"></div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label class="form-label">Phone *</label><input type="text" name="phone" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-input"></div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label class="form-label">Gender</label><input type="text" name="gender" class="form-input" placeholder="Male/Female"></div>
                <div class="form-group"><label class="form-label">Birthdate</label><input type="date" name="birthdate" class="form-input"></div>
            </div>
            <div class="form-group"><label class="form-label">Valid ID Serial</label><input type="text" name="valid_id" class="form-input"></div>
            <div class="form-group"><label class="form-label">Residential Address *</label><textarea name="address" class="form-textarea" rows="3" required></textarea></div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn-secondary" onclick="closeAddModal()">Cancel</button>
                <button type="submit" class="btn-primary-action">Save Profile Record</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Borrower Modal -->
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0; color: #0f172a;">Edit Borrower Profile</h3>
            <button type="button" onclick="closeEditModal()" style="background:none; border:none; font-size: 24px; cursor:pointer; color: #64748b;">&times;</button>
        </div>

        <form id="editBorrowerForm" method="POST" action="">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label class="form-label">First Name *</label><input type="text" id="edit_first_name" name="first_name" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Last Name *</label><input type="text" id="edit_last_name" name="last_name" class="form-input" required></div>
            </div>
            <div class="form-group"><label class="form-label">Middle Name</label><input type="text" id="edit_middle_name" name="middle_name" class="form-input"></div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label class="form-label">Phone *</label><input type="text" id="edit_phone" name="phone" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Email</label><input type="email" id="edit_email" name="email" class="form-input"></div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label class="form-label">Gender</label><input type="text" id="edit_gender" name="gender" class="form-input" placeholder="Male/Female"></div>
                <div class="form-group"><label class="form-label">Birthdate</label><input type="date" id="edit_birthdate" name="birthdate" class="form-input"></div>
            </div>
            <div class="form-group"><label class="form-label">Valid ID Serial</label><input type="text" id="edit_valid_id" name="valid_id" class="form-input"></div>
            <div class="form-group"><label class="form-label">Residential Address *</label><textarea id="edit_address" name="address" class="form-textarea" rows="3" required></textarea></div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-primary-action">Update Profile Record</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Search and Filter logic
    function filterBorrowers() {
        const query = document.getElementById('borrowerSearch').value.toLowerCase();
        const status = document.getElementById('statusFilter').value.toLowerCase();
        const rows = document.querySelectorAll('.borrower-data-row');

        rows.forEach(row => {
            const name = row.querySelector('.borrower-name').textContent.toLowerCase();
            const id = row.querySelector('.borrower-id').textContent.toLowerCase();
            const rowStatus = row.querySelector('.borrower-status').textContent.trim().toLowerCase();

            const matchesSearch = name.includes(query) || id.includes(query);
            const matchesStatus = status === '' || rowStatus === status;

            if (matchesSearch && matchesStatus) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal Helpers
    function openAddModal() {
        document.getElementById('addModal').style.display = 'flex';
    }
    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
    }

    function openEditModal(button) {
        const id = button.getAttribute('data-id');
        document.getElementById('editBorrowerForm').action = '/loansaas/public/index.php?url=borrower/update/' + id;
        
        document.getElementById('edit_first_name').value = button.getAttribute('data-first_name');
        document.getElementById('edit_middle_name').value = button.getAttribute('data-middle_name');
        document.getElementById('edit_last_name').value = button.getAttribute('data-last_name');
        document.getElementById('edit_phone').value = button.getAttribute('data-phone');
        document.getElementById('edit_email').value = button.getAttribute('data-email');
        document.getElementById('edit_gender').value = button.getAttribute('data-gender');
        document.getElementById('edit_birthdate').value = button.getAttribute('data-birthdate');
        document.getElementById('edit_valid_id').value = button.getAttribute('data-valid_id');
        document.getElementById('edit_address').value = button.getAttribute('data-address');
        
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.onclick = function(event) { 
        if (event.target.classList.contains('modal-overlay')) {
            event.target.style.display = "none"; 
        }
    }

    document.addEventListener('keydown', function(event) { 
        if (event.key === "Escape") {
            closeAddModal();
            closeEditModal();
        } 
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>