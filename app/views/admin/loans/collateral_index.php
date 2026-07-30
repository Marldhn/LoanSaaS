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

    /* Desktop Row: Grid layout */
    .col-list { background: transparent; }
    
    .col-row { 
        display: grid; 
        grid-template-columns: 1.5fr 1fr 1.5fr 1fr 100px; 
        padding: 16px 20px; 
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        align-items: center;
        gap: 20px;
        transition: background-color 0.15s;
    }
    
    .col-row.header { 
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

    .col-row:not(.header):hover {
        background-color: #f8fafc;
    }

    /* Action Button Style */
    .action-group {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .action-btn {
        padding: 6px 12px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .action-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
        border-color: #94a3b8;
    }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .col-row.header { display: none !important; }
        
        .col-row { 
            display: flex !important; 
            flex-direction: column !important; 
            align-items: flex-start !important; 
            gap: 12px !important; 
            padding: 16px !important; 
        }

        .col-row > div { 
            width: 100% !important; 
            display: flex !important; 
            justify-content: space-between !important; 
            align-items: center !important;
            text-align: left !important;
        }

        .col-row > div::before { 
            content: attr(data-label); 
            font-weight: 700; 
            color: #64748b; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
        }

        .filter-card { flex-direction: column; }
        .action-group { justify-content: flex-end; width: 100%; }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Secured Loan Collaterals</h1>
            <p class="page-subtitle">View and manage items secured against loans</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="filter-card">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Search borrower or item name..." onkeyup="filterCollaterals()">
        </div>
    </div>

    <div class="col-list">
        <div class="col-row header">
            <div>Borrower</div>
            <div>Loan Reference</div>
            <div>Item Name</div>
            <div>Value</div>
            <div style="text-align: right;">Action</div>
        </div>

        <?php if (empty($collaterals)): ?>
            <div style="padding: 40px; text-align: center; color: #94a3b8; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">No collateral records found.</div>
        <?php else: ?>
            <?php foreach ($collaterals as $c): ?>
                <?php 
                    $borrowerName = $c['first_name'] . ' ' . $c['last_name'];
                    $loanRef = '#LN-' . str_pad($c['loan_id'], 6, '0', STR_PAD_LEFT);
                ?>
                <div class="col-row collateral-item" 
                     data-borrower="<?= strtolower(htmlspecialchars($borrowerName)) ?>"
                     data-item="<?= strtolower(htmlspecialchars($c['item_name'])) ?>"
                     data-ref="<?= strtolower(htmlspecialchars($loanRef)) ?>">
                    
                    <div data-label="Borrower" style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($borrowerName) ?></div>
                    <div data-label="Loan Reference" style="color: #64748b; font-weight: 600;"><?= htmlspecialchars($loanRef) ?></div>
                    <div data-label="Item Name" style="color: #334155;"><?= htmlspecialchars($c['item_name']) ?></div>
                    <div data-label="Value" style="font-weight: 700; color: #059669;">₱<?= number_format($c['estimated_value'], 2) ?></div>
                    <div data-label="Action" class="action-group">
                        <a href="/loansaas/public/index.php?url=loan/details&id=<?= $c['loan_id'] ?>" class="action-btn">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function filterCollaterals() {
        const searchVal = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.collateral-item');

        rows.forEach(row => {
            const borrower = row.getAttribute('data-borrower');
            const item = row.getAttribute('data-item');
            const ref = row.getAttribute('data-ref');

            if (borrower.includes(searchVal) || item.includes(searchVal) || ref.includes(searchVal)) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>