<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<?php
// Calculate the total balance across all accounts
$total_balance = 0;
if (!empty($accounts)) {
    foreach ($accounts as $a) {
        $total_balance += $a['current_balance'];
    }
}
?>

<style>
    .accounts-page-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        box-sizing: border-box;
    }

    /* Top Action Bar */
    .page-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 20px !important;
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

    /* Top Stats & Create Form Layout Grid */
    .top-section-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    @media (max-width: 1024px) {
        .top-section-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Total Balance Card */
    .total-balance-card {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
        color: #ffffff !important;
        padding: 24px !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2) !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
        box-sizing: border-box;
    }

    .total-balance-card h4 {
        margin: 0 0 6px 0 !important;
        font-size: 0.8125rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        font-weight: 600 !important;
        color: #e0e7ff !important;
    }

    .total-balance-card h2 {
        margin: 0 !important;
        font-size: 2rem !important;
        font-weight: 700 !important;
        color: #ffffff !important;
    }

    .total-balance-icon {
        background: rgba(255, 255, 255, 0.15);
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #fff;
    }

    /* Create Account Card */
    .create-account-card {
        background: #ffffff !important;
        padding: 24px !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
        box-sizing: border-box;
    }

    .card-heading {
        margin: 0 0 14px 0 !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }

    .inline-form {
        display: flex !important;
        gap: 12px !important;
        align-items: flex-end !important;
    }

    .form-field {
        flex: 1 !important;
    }

    .form-field label {
        display: block !important;
        font-size: 0.775rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
        margin-bottom: 6px !important;
    }

    .form-input {
        height: 38px !important;
        padding: 6px 12px !important;
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

    /* Accounts Grid & Smooth Dragging Enhancements */
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 28px 0 16px 0;
    }

    .accounts-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)) !important;
        gap: 16px !important;
        margin-bottom: 32px !important;
    }

    .account-card-link {
        text-decoration: none !important;
        color: inherit !important;
        display: block !important;
        cursor: grab !important;
        transition: transform 0.25s cubic-bezier(0.2, 0, 0, 1), box-shadow 0.25s ease, opacity 0.2s ease !important;
    }

    .account-card-link:active {
        cursor: grabbing !important;
    }

    .account-card-link.dragging {
        opacity: 0.35;
        transform: scale(0.96);
    }

    .account-card {
        background: #ffffff !important;
        padding: 20px !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
        pointer-events: none; /* Prevents text/image selection weirdness while dragging */
    }

    /* Re-enable pointer events for inner card content elements so links stay clean */
    .account-card * {
        pointer-events: auto;
    }

    .account-card-link:hover .account-card {
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
        border-color: #cbd5e1 !important;
    }

    .account-card h4 {
        margin: 0 0 6px 0 !important;
        font-size: 0.75rem !important;
        color: #64748b !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        font-weight: 700 !important;
    }

    .account-card h2 {
        margin: 0 !important;
        font-size: 1.35rem !important;
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

    .custom-file-upload {
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        background: #f8fafc;
        color: #334155;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .custom-file-upload:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-header { flex-direction: column !important; align-items: flex-start !important; gap: 16px !important; }
        .inline-form { flex-direction: column !important; align-items: stretch !important; }
        .accounts-grid { grid-template-columns: 1fr !important; }
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

    <!-- Top Grid: Balance Summary & Compact Form Side-by-Side -->
    <div class="top-section-grid">
        <!-- Total Balance Card -->
        <div class="total-balance-card">
            <div>
                <h4>Total Liquid Balance</h4>
                <h2>₱<?= number_format($total_balance, 2) ?></h2>
            </div>
            <div class="total-balance-icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>

        <!-- Create New Account Card -->
        <div class="create-account-card">
            <h3 class="card-heading">Create New Account</h3>
            <form method="POST" action="/loansaas/public/index.php?url=account/storeAccount" class="inline-form" enctype="multipart/form-data">
                <div class="form-field">
                    <label>Account Name</label>
                    <input type="text" name="name" placeholder="e.g. GCash" class="form-input" required>
                </div>
                <div class="form-field">
                    <label>Initial Balance</label>
                    <input type="number" name="initial_balance" placeholder="0.00" class="form-input" step="0.01">
                </div>
                
                <!-- Custom File Upload Field -->
                <div class="form-field">
                    <label>Icon / Logo</label>
                    <div style="display: flex; align-items: center; gap: 10px; height: 38px;">
                        <label for="account-icon-file" class="custom-file-upload" style="margin: 0; display: inline-flex; align-items: center; justify-content: center; height: 38px; box-sizing: border-box;">
                            <i class="fas fa-upload"></i> Choose Image
                        </label>
                        <input id="account-icon-file" type="file" name="icon" accept="image/*" style="display: none;" onchange="updateFileName(this)">
                        <span id="file-chosen-name" style="font-size: 13px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 110px; line-height: 38px;">No file chosen</span>
                    </div>
                </div>

                <button type="submit" class="btn-primary-custom" style="height: 38px;">Create</button>
            </form>
        </div>
    </div>

    <h4 class="section-title">All Accounts</h4>

    <!-- Accounts Grid -->
    <div class="accounts-grid" id="accountsGrid">
        <?php foreach ($accounts as $a): ?>
        <a href="/loansaas/public/index.php?url=account/details&id=<?= $a['id'] ?>" class="account-card-link" draggable="true" data-id="<?= $a['id'] ?>">
            <div class="account-card" style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                    <?php if (!empty($a['icon'])): ?>
                        <img src="/loansaas/public/uploads/accounts/<?= htmlspecialchars($a['icon']) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <i class="fas fa-wallet text-secondary"></i>
                    <?php endif; ?>
                </div>
                <div>
                    <h4><?= htmlspecialchars($a['name']) ?></h4>
                    <h2>₱<?= number_format($a['current_balance'], 2) ?></h2>
                </div>
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
    function updateFileName(input) {
        const fileNameSpan = document.getElementById('file-chosen-name');
        if (input.files && input.files.length > 0) {
            fileNameSpan.textContent = input.files[0].name;
            fileNameSpan.style.color = '#0f172a';
        } else {
            fileNameSpan.textContent = 'No file chosen';
            fileNameSpan.style.color = '#64748b';
        }
    }

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

    // --- Smooth Drag & Drop Sorting with LocalStorage Persistence ---
    document.addEventListener("DOMContentLoaded", () => {
        const grid = document.getElementById('accountsGrid');
        const storageKey = 'account_cards_order_user';

        // 1. Restore saved order from localStorage smoothly
        const savedOrder = localStorage.getItem(storageKey);
        if (savedOrder) {
            try {
                const orderIds = JSON.parse(savedOrder);
                const cardMap = {};
                Array.from(grid.children).forEach(card => {
                    cardMap[card.getAttribute('data-id')] = card;
                });
                orderIds.forEach(id => {
                    if (cardMap[id]) {
                        grid.appendChild(cardMap[id]);
                    }
                });
            } catch (e) {
                console.error("Error loading card arrangement", e);
            }
        }

        let draggedItem = null;

        // 2. Add Drag Events with fluid handling
        grid.querySelectorAll('.account-card-link').forEach(card => {
            card.addEventListener('dragstart', function (e) {
                draggedItem = this;
                setTimeout(() => this.classList.add('dragging'), 0);
            });

            card.addEventListener('dragend', function () {
                this.classList.remove('dragging');
                draggedItem = null;
                saveCardOrder();
            });

            card.addEventListener('dragover', function (e) {
                e.preventDefault();
                const afterElement = getDragAfterElement(grid, e.clientX, e.clientY);
                if (afterElement == null) {
                    grid.appendChild(draggedItem);
                } else {
                    grid.insertBefore(draggedItem, afterElement);
                }
            });
        });

        function getDragAfterElement(container, x, y) {
            const draggableElements = Array.from(container.querySelectorAll('.account-card-link:not(.dragging)'));

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offsetX = x - box.left - box.width / 2;
                const offsetY = y - box.top - box.height / 2;
                
                const distance = Math.sqrt(offsetX * offsetX + offsetY * offsetY);
                
                if (closest == null || distance < closest.distance) {
                    return { distance: distance, element: child };
                } else {
                    return closest;
                }
            }, null).element;
        }

        function saveCardOrder() {
            const cards = grid.querySelectorAll('.account-card-link');
            const orderIds = Array.from(cards).map(card => card.getAttribute('data-id'));
            localStorage.setItem(storageKey, JSON.stringify(orderIds));
        }
    });
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>