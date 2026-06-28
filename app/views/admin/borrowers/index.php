<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .customer-card { background: #1e293b; color: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .customer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .customer-list { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    .customer-row { display: grid; grid-template-columns: 2fr 2fr 2fr 1fr 1fr; padding: 15px 20px; border-bottom: 1px solid #f1f5f9; align-items: center; }
    .customer-row.header { background: #f8fafc; font-weight: 700; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
    .avatar-circle { width: 40px; height: 40px; background: #6366f1; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 15px; }
    .badge { padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-inactive { background: #fee2e2; color: #991b1b; }
    .btn-action { padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; border: 1px solid #e2e8f0; }


    /* Ensure the header and button are on top */
.page-header {
    position: relative;
    z-index: 10; /* Keeps the header above other elements */
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* Ensure the button itself is clickable */
.btn-primary {
    position: relative;
    z-index: 20; /* Ensure button is above everything else */
    cursor: pointer;
}.form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .form-label { font-size: 13px; font-weight: 600; color: #475569; }
    .form-input, .form-textarea { padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; width: 100%; box-sizing: border-box; }
    .btn-primary { background: #6366f1; color: #ffffff; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
    .btn-secondary { background: #f1f5f9; color: #475569; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; margin-right: 10px; }
</style>

<div class="customer-card">
    <div class="customer-header">
        <div>
            <h2 style="margin:0;">Customer Management</h2>
            <p style="margin:5px 0 0; color: #94a3b8; font-size: 0.9rem;">Manage customer information and KYC details</p>
        </div>
        <button type="button" class="btn-primary" onclick="document.getElementById('addModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add New Borrower
        </button>
    </div>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div style="background: #dcfce7; color: #166534; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
        Borrower successfully added!
    </div>
<?php endif; ?>

</div>
</div>

<div class="customer-list">
    <div class="customer-row header">
        <div>Customer</div>
        <div>Contact</div>
        <div>Location</div>
        <div>Status</div>
        <div style="text-align: right;">Actions</div>
    </div>

    <?php if (empty($borrowers)): ?>
        <div style="padding: 40px; text-align: center; color: #94a3b8;">No customer records found.</div>
    <?php else: ?>
        <?php foreach ($borrowers as $b): ?>
            <div class="customer-row">
                <div style="display: flex; align-items: center;">
                    <div class="avatar-circle"><?= strtoupper(substr($b['first_name'], 0, 1)) ?></div>
                    <div>
                        <div style="font-weight: 700; color: #1e293b;"><?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?></div>
                        <div style="font-size: 0.75rem; color: #64748b;">ID: <?= str_pad($b['id'], 3, '0', STR_PAD_LEFT) ?></div>
                    </div>
                </div>
                <div>
                    <i class="fas fa-envelope" style="color: #94a3b8; font-size: 0.8rem;"></i> <?= htmlspecialchars($b['email']) ?><br>
                    <i class="fas fa-phone" style="co   lor: #94a3b8; font-size: 0.8rem;"></i> <?= htmlspecialchars($b['phone']) ?>
                </div>
                <div style="font-size: 0.85rem;"><?= htmlspecialchars($b['address']) ?></div>
                <div>
                    <span class="badge <?= $b['status'] == 1 ? 'badge-active' : 'badge-inactive' ?>">
                        <?= $b['status'] == 1 ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div style="text-align: right;">
                    <a href="/loansaas/public/index.php?url=borrower/edit/<?= $b['id'] ?>" class="btn-action"><i class="fas fa-edit"></i></a>
                    <a href="/loansaas/public/index.php?url=borrower/details&id=<?= $b['id'] ?>" class="btn-action" style="background: #f8fafc;"><i class="fas fa-eye"></i> View</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center; overflow-y:auto;">
    <div style="background:#fff; width:90%; max-width:700px; border-radius:12px; padding:28px; position:relative; margin: 20px auto;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0;">Enroll New Borrower Profile</h3>
            <button type="button" onclick="document.getElementById('addModal').style.display='none'" style="background:none; border:none; font-size: 24px; cursor:pointer;">&times;</button>
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
                <button type="button" class="btn-secondary" onclick="document.getElementById('addModal').style.display='none'" style="margin-right: 10px; cursor:pointer;">Cancel</button>
                <button type="submit" class="btn-primary" style="cursor:pointer;">Save Profile Record</button>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>


<script>
    // Close modal when clicking outside the modal content
    const modal = document.getElementById('addModal');
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Optional: Close modal when pressing the "Escape" key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            modal.style.display = "none";
        }
    });
</script>