<?php 
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>


<style>
    /* Global Page Wrapper */
    .page-container { max-width: 1200px; margin: 0 auto; }
    
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
        border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }
    .inline-form { display: flex; gap: 16px; align-items: flex-end; }
    .form-field { flex: 1; }
    .form-field label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px; }
    .form-input { height: 44px; padding: 0 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; width: 100%; transition: all 0.2s; }
    .form-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); outline: none; }
    
    .btn-primary { 
        height: 44px; padding: 0 24px; background: #4f46e5; color: white; 
        border: none; border-radius: 8px; font-weight: 600; cursor: pointer;
    }

    .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    display: none; /* Hidden by default */
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Crucial: ensures it sits on top of everything */
}
</style>

<div class="account-header">
    <div>
        <h1>Financial Accounts</h1>
        <p style="color: #64748b;">Manage your liquidity and internal transfers.</p>
    </div>
<button type="button" class="btn-primary" onclick="toggleModal('transferModal')">
    <i class="fas fa-exchange-alt"></i> New Transfer
</button></div>

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
    <div class="card">
        <h4><?= htmlspecialchars($a['name']) ?></h4>
        <h2>₱<?= number_format($a['current_balance'], 2) ?></h2>
    </div>
    <?php endforeach; ?>
</div>


<div id="transferModal" class="modal-overlay">
    <div class="modal-content" style="background: white; padding: 30px; border-radius: 16px; width: 100%; max-width: 400px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <h3 style="margin: 0;">Transfer Funds</h3>
            <span onclick="toggleModal('transferModal')" style="cursor: pointer; font-size: 20px;">&times;</span>
        </div>
        <form method="POST" action="/loansaas/public/index.php?url=account/transfer">
            <div style="margin-bottom: 15px;">
                <label>From Account</label>
                <select name="from_id" class="form-input" required>
                    <?php foreach($accounts as $a): ?><option value="<?= $a['id'] ?>"><?= $a['name'] ?></option><?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>To Account</label>
                <select name="to_id" class="form-input" required>
                    <?php foreach($accounts as $a): ?><option value="<?= $a['id'] ?>"><?= $a['name'] ?></option><?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label>Amount</label>
                <input type="number" name="amount" class="form-input" step="0.01" required>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Execute Transfer</button>
        </form>
    </div>
</div>


<?php 
require_once dirname(__DIR__, 2) . '/layouts/footer.php'; 
?>


<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        // Toggle the 'display' directly
        if (modal.style.display === 'none' || modal.style.display === '') {
            modal.style.display = 'flex';
        } else {
            modal.style.display = 'none';
        }
    }
</script>