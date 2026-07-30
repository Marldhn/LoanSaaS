<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Page Header Section */
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

    /* Primary Action Button */
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
        text-decoration: none;
    }
    .btn-primary-action:hover {
        background: #4f46e5;
    }

    /* Filter & Search Bar */
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

    /* Clean Table Grid Structure */
    .pay-list { 
        background: #ffffff; 
        border: 1px solid #f1f5f9;
        border-radius: 8px; 
    }
    .pay-row { 
        display: grid; 
        grid-template-columns: 2.5fr 3fr 2.5fr 1fr; 
        padding: 14px 20px; 
        background: #fff; 
        border-bottom: 1px solid #f1f5f9; 
        align-items: center; 
    }
    .pay-row:last-child {
        border-bottom: none;
    }
    .pay-row.header { 
        background: #fff; 
        font-weight: 600; 
        color: #64748b; 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }
    .pay-row:not(.header):hover {
        background-color: #f8fafc;
    }

    /* Icon Action Buttons */
    .btn-icon-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        text-decoration: none;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
    }
    .btn-icon-action:hover {
        background: #f1f5f9;
        color: #4f46e5;
        border-color: #cbd5e1;
    }

    /* Modal Overlay & Styling */
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
        background: #fff; 
        width: 90%; 
        max-width: 480px; 
        border-radius: 12px; 
        padding: 28px; 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }
    .form-input {
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Mobile Responsive Layout */
    @media (max-width: 768px) {
        .pay-row { display: flex !important; flex-direction: column !important; align-items: flex-start !important; gap: 8px; }
        .pay-row.header { display: none !important; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .btn-primary-action { width: 100%; justify-content: center; }
    }
</style>

<!-- Header Section -->
<div class="page-header">
    <div>
        <h1 class="page-title">Payment History</h1>
        <p class="page-subtitle">View and manage all processed loan payment transactions.</p>
    </div>
    <button type="button" class="btn-primary-action" onclick="openPayModal()">
        <i class="fas fa-plus"></i> New Payment
    </button>
</div>

<!-- Search Bar -->
<div class="filter-bar">
    <div class="search-input-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" id="paymentSearch" class="search-input" placeholder="Search by loan reference or date..." onkeyup="filterPayments()">
    </div>
</div>

<!-- Payments List Section -->
<div class="pay-list">
    <div class="pay-row header">
        <div>Date</div>
        <div>Loan Reference</div>
        <div>Amount</div>
        <div style="text-align: right;">Action</div>
    </div>

    <?php if (empty($payments)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8; font-size: 0.875rem;">No payment records found.</div>
    <?php else: ?>
        <?php foreach ($payments as $p): ?>
            <div class="pay-row payment-data-row">
                <div class="pay-date" style="font-size: 0.875rem; color: #475569;">
                    <?= htmlspecialchars($p['payment_date']) ?>
                </div>
                <div class="pay-ref" style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">
                    #LN-<?= str_pad($p['loan_id'], 6, '0', STR_PAD_LEFT) ?>
                </div>
                <div style="font-weight: 700; color: #16a34a; font-size: 0.9rem;">
                    ₱<?= number_format($p['amount'], 2) ?>
                </div>
                <div style="text-align: right;">
                    <a href="/loansaas/public/index.php?url=loan/details&id=<?= $p['loan_id'] ?>" 
                       class="btn-icon-action" 
                       title="View Loan Details">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Record Payment Modal -->
<div id="payModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0; color: #0f172a;">Record New Payment</h3>
            <button type="button" onclick="closePayModal()" style="background:none; border:none; font-size: 24px; cursor:pointer; color: #64748b;">&times;</button>
        </div>

        <form method="POST" action="/loansaas/public/index.php?url=payment/store">
            <div class="form-group">
                <label class="form-label">Loan ID *</label>
                <input type="number" name="loan_id" class="form-input" placeholder="e.g. 45" required>
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label">Payment Amount (₱) *</label>
                <input type="number" name="amount" step="0.01" class="form-input" placeholder="0.00" required>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" style="background: #f1f5f9; color: #475569; padding: 10px 18px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;" onclick="closePayModal()">Cancel</button>
                <button type="submit" class="btn-primary-action">Save Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Search Filtering
    function filterPayments() {
        const query = document.getElementById('paymentSearch').value.toLowerCase();
        const rows = document.querySelectorAll('.payment-data-row');

        rows.forEach(row => {
            const date = row.querySelector('.pay-date').textContent.toLowerCase();
            const ref = row.querySelector('.pay-ref').textContent.toLowerCase();

            if (date.includes(query) || ref.includes(query)) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal Control
    function openPayModal() {
        document.getElementById('payModal').style.display = 'flex';
    }
    function closePayModal() {
        document.getElementById('payModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            closePayModal();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closePayModal();
        }
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>