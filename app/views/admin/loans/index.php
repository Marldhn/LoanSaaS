<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .loan-portfolio-container {
        width: 100%;
        box-sizing: border-box;
    }

    /* Page Title & Action Bar */
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
        gap: 6px !important;
        transition: background-color 0.15s ease !important;
        border: none !important;
        white-space: nowrap !important;
    }

    .btn-primary-custom:hover {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
    }

    /* Main Table Card Structure */
    .table-card {
        background: #ffffff !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden !important;
    }

    /* Dedicated Card Header for Search & Filters */
    .card-filter-header {
        padding: 16px 20px !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 12px !important;
    }

    .search-input-container {
        position: relative !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
    }

    .search-input-container input {
        width: 100% !important;
        height: 40px !important;
        padding: 8px 12px 8px 38px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 0.875rem !important;
        background-color: #f8fafc !important;
        box-sizing: border-box !important;
        outline: none !important;
        transition: all 0.15s ease-in-out;
    }

    .search-input-container input:focus {
        background-color: #ffffff !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
    }

    .search-icon-svg {
        position: absolute !important;
        left: 12px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        color: #94a3b8 !important;
        pointer-events: none !important;
        z-index: 2 !important;
    }

    .status-select-container {
        flex: 0 0 180px !important;
    }

    .status-select-container select {
        width: 100% !important;
        height: 40px !important;
        padding: 8px 12px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 0.875rem !important;
        color: #334155 !important;
        background-color: #f8fafc !important;
        cursor: pointer !important;
        box-sizing: border-box !important;
        outline: none !important;
        transition: all 0.15s ease-in-out;
    }

    .status-select-container select:focus {
        background-color: #ffffff !important;
        border-color: #6366f1 !important;
    }

    /* Table Rows */
    .loan-row { 
        display: grid !important; 
        grid-template-columns: 2fr 1.2fr 1.2fr 1fr 0.5fr !important; 
        padding: 14px 20px !important; 
        border-bottom: 1px solid #f1f5f9 !important; 
        align-items: center !important; 
    }

    .loan-row:last-child {
        border-bottom: none !important;
    }
    
    .loan-row.header { 
        background: #f8fafc !important; 
        font-weight: 700 !important; 
        color: #64748b !important; 
        font-size: 11px !important; 
        text-transform: uppercase !important; 
        letter-spacing: 0.05em !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    
    /* Badges */
    .badge-status { 
        padding: 4px 10px !important; 
        border-radius: 20px !important; 
        font-size: 11px !important; 
        font-weight: 600 !important; 
        display: inline-block !important;
    }

    .badge-active { background: #dcfce7 !important; color: #15803d !important; }
    .badge-overdue { background: #fee2e2 !important; color: #b91c1c !important; }
    .badge-pending { background: #fef3c7 !important; color: #b45309 !important; }
    .badge-paid { background: #dbeafe !important; color: #1d4ed8 !important; }
    .badge-rejected { background: #f1f5f9 !important; color: #475569 !important; }

    .btn-view { 
        color: #4f46e5 !important; 
        font-weight: 600 !important; 
        text-decoration: none !important; 
        font-size: 12px !important;
    }
    
    .btn-view:hover { 
        text-decoration: underline !important; 
    }

    .sort-link { 
        text-decoration: none !important; 
        color: inherit !important; 
    }

    /* Pagination */
    .pagination { 
        margin-top: 20px !important; 
        display: flex !important; 
        justify-content: center !important; 
        gap: 6px !important; 
    }
    
    .page-link { 
        padding: 6px 12px !important; 
        border-radius: 6px !important; 
        text-decoration: none !important; 
        font-size: 13px !important; 
        font-weight: 600 !important; 
        border: 1px solid #e2e8f0 !important; 
    }
    
    .page-link.active { background: #6366f1 !important; color: #fff !important; border-color: #6366f1 !important; }
    .page-link.inactive { background: #fff !important; color: #64748b !important; }
</style>

<div class="loan-portfolio-container">
    <!-- Top Header -->
    <div class="page-header">
        <div>
            <h3 class="page-title">Loan Portfolio</h3>
            <p class="page-subtitle">Manage active loans, track balances, and review borrower statuses.</p>
        </div>
        <a href="/loansaas/public/index.php?url=loan/create" class="btn-primary-custom">
            <span>+</span> New Loan
        </a>
    </div>

    <!-- Unified Table Card -->
    <div class="table-card">
        
        <!-- Integrated Card Header for Search and Filters -->
        <form method="GET" action="/loansaas/public/index.php" class="card-filter-header">
            <input type="hidden" name="url" value="loan/index">
            
            <div class="search-input-container">
                <svg class="search-icon-svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Search borrower name or loan ID..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>

            <div class="status-select-container">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <?php foreach(['Active', 'Overdue', 'Paid', 'Pending', 'Rejected'] as $s): ?>
                        <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Column Headers -->
        <div class="loan-row header">
            <?php 
            $nextOrder = (($_GET['order'] ?? 'DESC') === 'DESC') ? 'ASC' : 'DESC';
            $qs = "&order=$nextOrder&status=" . urlencode($_GET['status'] ?? '');
            ?>
            <div><a href="?url=loan/index&sort=borrower_name<?= $qs ?>" class="sort-link">Borrower / ID</a></div>
            <div><a href="?url=loan/index&sort=remaining_balance<?= $qs ?>" class="sort-link">Balance</a></div>
            <div><a href="?url=loan/index&sort=due_date<?= $qs ?>" class="sort-link">Due Date</a></div>
            <div>Status</div>
            <div style="text-align:right;">Action</div>
        </div>

        <!-- Data Rows -->
        <?php if (empty($loans)): ?>
            <div style="padding:40px; text-align:center; color:#94a3b8; font-size:0.9rem;">No loans found matching your criteria.</div>
        <?php else: 
            $statusClasses = [
                'Active'   => 'badge-active',
                'Overdue'  => 'badge-overdue',
                'Pending'  => 'badge-pending',
                'Paid'     => 'badge-paid',
                'Rejected' => 'badge-rejected'
            ];
            
            foreach ($loans as $loan): 
                $badgeClass = $statusClasses[$loan['display_status']] ?? 'badge-rejected';
                
                $dueDate = (!empty($loan['due_date']) && $loan['due_date'] !== '0000-00-00' && strtotime($loan['due_date']) > 0) 
                    ? htmlspecialchars($loan['due_date']) 
                    : '—';
        ?>
            <div class="loan-row">
                <div style="display: flex; flex-direction: column;">
                    <span style="font-weight: 700; color: #0f172a; font-size: 0.95rem;"><?= htmlspecialchars($loan['first_name'] . ' ' . $loan['last_name']) ?></span>
                    <span style="font-size: 0.8rem; color: #64748b;">LOAN ID: #LN<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></span>
                </div>
                
                <div style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">₱<?= number_format($loan['remaining_balance'], 2) ?></div>
                <div style="color: #334155; font-size: 0.875rem;"><?= $dueDate ?></div>
                <div>
                    <span class="badge-status <?= $badgeClass ?>"><?= htmlspecialchars($loan['display_status']) ?></span>
                </div>
                <div style="text-align:right;">
                    <a href="/loansaas/public/index.php?url=loan/details&id=<?= $loan['id'] ?>" class="btn-view">View →</a>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="pagination">
            <?php 
            $search = urlencode($_GET['search'] ?? '');
            $status = urlencode($_GET['status'] ?? '');
            $sort = $_GET['sort'] ?? 'id';
            $order = $_GET['order'] ?? 'DESC';
            $currentPage = (int)($_GET['page'] ?? 1);

            for ($i = 1; $i <= $totalPages; $i++): 
                $isActive = ($currentPage === $i);
            ?>
                <a href="?url=loan/index&page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= $search ?>&status=<?= $status ?>" 
                   class="page-link <?= $isActive ? 'active' : 'inactive' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>