<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    /* Container Reset */
    .accounts-page-wrapper {
        width: 100%;
        box-sizing: border-box;
    }

    /* Top Action Bar */
    .page-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 24px !important;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.875rem;
        margin: 4px 0 0 0;
    }

    .btn-primary-custom {
        background-color: #6366f1 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        padding: 9px 18px !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        font-size: 0.875rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        transition: background-color 0.15s ease !important;
        border: none !important;
        cursor: pointer !important;
        white-space: nowrap !important;
    }

    .btn-primary-custom:hover {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
    }

    /* Create Account Card */
    .create-account-card {
        background: #ffffff !important;
        padding: 20px 24px !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        margin-bottom: 24px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
    }

    .card-heading {
        margin: 0 0 16px 0 !important;
        font-size: 1rem !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }

    .inline-form {
        display: flex !important;
        gap: 16px !important;
        align-items: flex-end !important;
        flex-wrap: wrap !important;
    }

    .form-field {
        flex: 1 !important;
        min-width: 220px !important;
    }

    .form-field label {
        display: block !important;
        font-size: 0.8125rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
        margin-bottom: 6px !important;
    }

    .form-input {
        height: 40px !important;
        padding: 8px 12px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 0.875rem !important;
        width: 100% !important;
        box-sizing: border-box !important;
        background-color: #f8fafc !important;
        outline: none !important;
        transition: all 0.15s ease-in-out !important;
    }

    .form-input:focus {
        background-color: #ffffff !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
    }

    /* Accounts Grid */
    .accounts-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)) !important;
        gap: 20px !important;
        margin-bottom: 32px !important;
    }

    .account-card-link {
        text-decoration: none !important;
        color: inherit !important;
        display: block !important;
    }

    .account-card {
        background: #ffffff !important;
        padding: 20px 24px !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease !important;
    }

    .account-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
        border-color: #cbd5e1 !important;
    }

    .account-card h4 {
        margin: 0 0 8px 0 !important;
        font-size: 0.75rem !important;
        color: #64748b !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        font-weight: 700 !important;
    }

    .account-card h2 {
        margin: 0 !important;
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }

    /* Modal Overlay & Styling */
    .modal-overlay {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: rgba(15, 23, 42, 0.4) !important;
        backdrop-filter: blur(2px) !important;
        display: none;
        justify-content: center !important;
        align-items: center !important;
        z-index: 9999 !important;
    }

    .modal-content-box {
        background: #ffffff !important;
        padding: 28px !important;
        border-radius: 16px !important;
        width: 90% !important;
        max-width: 420px !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        border: 1px solid #e2e8f0 !important;
    }

    .modal-header-flex {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 20px !important;
    }

    .modal-close-btn {
        cursor: pointer !important;
        font-size: 20px !important;
        color: #94a3b8 !important;
        line-height: 1 !important;
        transition: color 0.15s !important;
    }

    .modal-close-btn:hover {
        color: #0f172a !important;
    }

    /* Responsive Queries */
    @media (max-width: 768px) {
        .page-header { flex-direction: column !important; align-items: flex-start !important; gap: 16px !important; }
        .inline-form { flex-direction: column !important; align-items: stretch !important; }
        .accounts-grid { grid-template-columns: 1fr !important; }
        .form-field { min-width: 100% !important; }
        .btn-primary-custom { width: 100% !important; justify-content: center !important; }
    }
</style>

<div class="accounts-page-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h3 class="page-title">Financial Accounts</h3>
            <p class="page-subtitle">Manage your liquidity and internal transfers.</p>
        </div>
        <button type="button" class="btn-primary-custom" onclick="toggleModal('transferModal')">
            <i class="fas fa-exchange-alt"></i> New Transfer
        </button>
    </div>

    <!-- Create New Account Card -->
    <div class="create-account-card">
        <h3 class="card-heading">Create New Account</h3>
        <form method="POST" action="/loansaas/public/index.php?url=account/storeAccount" class="inline-form">
            <div class="form-field">
                <label>Account Name</label>
                <input type="text" name="name" placeholder="e.g. GCash" class="form-input" required>
            </div>
            <div class="form-field">
                <label>Initial Balance</label>
                <input type="number" name="initial_balance" placeholder="0.00" class="form-input" step="0.01">
            </div>
            <button type="submit" class="btn-primary-custom" style="height: 40px;">Create Account</button>
        </form>
    </div>

    <!-- Accounts Grid -->
    <div class="accounts-grid">
        <?php foreach ($accounts as $a): ?>
        <a href="/loansaas/public/index.php?url=account/details&id=<?= $a['id'] ?>" class="account-card-link">
            <div class="account-card">
                <h4><?= htmlspecialchars($a['name']) ?></h4>
                <h2>₱<?= number_format($a['current_balance'], 2) ?></h2>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Transfer Funds Modal -->
<div id="transferModal" class="modal-overlay">
    <div class="modal-content-box">
        <div class="modal-header-flex">
            <h3 style="margin: 0; font-size: 1.125rem; color: #0f172a; font-weight: 700;">Transfer Funds</h3>
            <span class="modal-close-btn" onclick="toggleModal('transferModal')">&times;</span>
        </div>
        
        <form method="POST" action="/loansaas/public/index.php?url=account/transfer" id="transferForm">
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #475569; margin-bottom: 6px;">From Account</label>
                <select name="from_id" id="from_id" class="form-input" required style="cursor: pointer;">
                    <?php foreach($accounts as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?> (₱<?= number_format($a['current_balance'], 2) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style="text-align: center; margin: 12px 0; color: #94a3b8;">
                <i class="fas fa-arrow-down"></i>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #475569; margin-bottom: 6px;">To Account</label>
                <select name="to_id" id="to_id" class="form-input" required style="cursor: pointer;">
                    <?php foreach($accounts as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #475569; margin-bottom: 6px;">Amount (₱)</label>
                <input type="number" name="amount" class="form-input" placeholder="0.00" step="0.01" required style="font-size: 1.125rem; font-weight: 700;">
            </div>
            
            <button type="submit" class="btn-primary-custom" style="width: 100%; height: 44px; justify-content: center;">Confirm Transfer</button>
        </form>
    </div>
</div>

<!-- Error Notification Modal -->
<div id="errorModal" class="modal-overlay" style="<?= isset($_SESSION['error_message']) ? 'display: flex;' : 'display: none;' ?>">
    <div class="modal-content-box" style="text-align: center;">
        <h3 style="color: #ef4444; margin-top: 0; font-size: 1.125rem;">Transfer Failed</h3>
        <p style="color: #475569; font-size: 0.875rem; margin: 12px 0 20px 0;"><?= htmlspecialchars($_SESSION['error_message'] ?? '') ?></p>
        <button class="btn-primary-custom" onclick="toggleModal('errorModal')" style="width: 100%; justify-content: center;">Close</button>
    </div>
</div>

<?php unset($_SESSION['error_message']); ?>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = (modal.style.display === 'flex') ? 'none' : 'flex';
        }
    }

    document.getElementById('transferForm').addEventListener('submit', function(e) {
        const from = document.getElementById('from_id').value;
        const to = document.getElementById('to_id').value;
        if (from === to) {
            alert("Please select a different destination account.");
            e.preventDefault();
        }
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>