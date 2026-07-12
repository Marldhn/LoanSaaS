<?php 
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>

<style>
    /* Global Page Wrapper */
    .page-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    
    .account-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
    .account-header h1 { font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; }
    .account-header p { color: #64748b; margin: 4px 0 0 0; }

    /* Modern Card Layout */
    .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px; }
    
    .card { 
        background: #ffffff; padding: 24px; border-radius: 16px; 
        border: 1px solid #e2e8f0; 
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        display: flex; flex-direction: column;
    }
    .card h4 { margin: 0 0 12px 0; font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.08em; }
    .card h2 { margin: 0; font-size: 32px; font-weight: 700; color: #1e293b; }

    /* Form Container */
    .create-account-card { 
        background: #ffffff; padding: 28px; border-radius: 16px; 
        border: 1px solid #e2e8f0; margin-bottom: 40px;
    }
.inline-form { 
        display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; 
    }    

    .form-field { 
        flex: 1; min-width: 200px; /* Prevents boxes from getting too skinny */
    }
    .form-field label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px; }
   .form-input { 
        height: 44px; padding: 0 16px; border: 1px solid #cbd5e1; 
        border-radius: 8px; font-size: 14px; width: 100%; 
        box-sizing: border-box; /* Crucial: ensures padding doesn't push width out */
        transition: all 0.2s; 
    }
    .form-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); outline: none; }
    
    .btn-primary { 
        height: 44px; padding: 0 24px; background: #4f46e5; color: white; 
        border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); display: none;
        justify-content: center; align-items: center; z-index: 9999;
    }

    @media (max-width: 768px) {
        .account-header { flex-direction: column; align-items: flex-start; gap: 15px; }
        .inline-form { flex-direction: column; align-items: stretch; }
        .grid-container { grid-template-columns: 1fr; }
        .create-account-card { padding: 20px; }
        .btn-primary { width: 100%; }
        .form-field { min-width: 100%; }
    }
</style>

<div class="page-container">
    <div class="account-header">
        <div>
            <h1>Financial Accounts</h1>
            <p>Manage your liquidity and internal transfers.</p>
        </div>
        <button type="button" class="btn-primary" onclick="toggleModal('transferModal')">
            <i class="fas fa-exchange-alt"></i> New Transfer
        </button>
    </div>

    <div class="create-account-card">
        <h3 style="margin-top: 0; font-size: 16px;">Create New Account</h3>
        <form method="POST" action="/loansaas/public/index.php?url=account/storeAccount" class="inline-form">
            <div class="form-field">
                <label>Account Name</label>
                <input type="text" name="name" placeholder="e.g. GCash" class="form-input" required>
            </div>
            <div class="form-field">
                <label>Initial Balance</label>
                <input type="number" name="initial_balance" placeholder="0.00" class="form-input" step="0.01">
            </div>
            <button type="submit" class="btn-primary">Create</button>
        </form>
    </div>

    <div class="grid-container">
        <?php foreach ($accounts as $a): ?>
        <a href="/loansaas/public/index.php?url=account/details&id=<?= $a['id'] ?>" style="text-decoration: none;">
            <div class="card">
                <h4><?= htmlspecialchars($a['name']) ?></h4>
                <h2>₱<?= number_format($a['current_balance'], 2) ?></h2>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<div id="transferModal" class="modal-overlay">
    <div class="modal-content" style="background: white; padding: 32px; border-radius: 20px; width: 90%; max-width: 400px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3 style="margin: 0; font-size: 18px; color: #1e293b;">Transfer Funds</h3>
            <span onclick="toggleModal('transferModal')" style="cursor: pointer; font-size: 24px; color: #94a3b8;">&times;</span>
        </div>
        
        <form method="POST" action="/loansaas/public/index.php?url=account/transfer" id="transferForm">
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">From Account</label>
                <select name="from_id" id="from_id" class="form-input" required style="background: #f8fafc;">
                    <?php foreach($accounts as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?> (₱<?= number_format($a['current_balance'], 2) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style="text-align: center; margin: 10px 0; color: #94a3b8;"><i class="fas fa-arrow-down"></i></div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">To Account</label>
                <select name="to_id" id="to_id" class="form-input" required>
                    <?php foreach($accounts as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">Amount (₱)</label>
                <input type="number" name="amount" class="form-input" placeholder="0.00" step="0.01" required style="font-size: 18px; font-weight: 700;">
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%; height: 50px; font-size: 16px;">Confirm Transfer</button>
        </form>
    </div>
</div>

<div id="errorModal" class="modal-overlay" style="<?= isset($_SESSION['error_message']) ? 'display: flex;' : 'display: none;' ?>">
    <div class="modal-content" style="background: white; padding: 30px; border-radius: 16px; width: 90%; max-width: 400px; text-align: center;">
        <h3 style="color: #e11d48; margin-top: 0;">Transfer Failed</h3>
        <p><?= htmlspecialchars($_SESSION['error_message'] ?? '') ?></p>
        <button class="btn-primary" onclick="toggleModal('errorModal')" style="width: 100%;">Close</button>
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