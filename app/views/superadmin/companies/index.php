<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>
    .companies-page-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        box-sizing: border-box;
    }

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
        margin: 0;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.875rem;
        margin: 4px 0 0 0;
    }

    /* Card Wrapper */
    .card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    /* Modern Data Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.875rem;
        color: #334155;
    }

    .data-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    .data-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Status Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }

    .badge-active {
        background-color: #dcfce7;
        color: #15803d;
    }

    .badge-inactive {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* Action Buttons */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.775rem;
        font-weight: 600;
        transition: all 0.15s ease;
        border: none;
        cursor: pointer;
    }

    .btn-close {
        background-color: #fef2f2;
        color: #dc2626;
    }

    .btn-close:hover {
        background-color: #dc2626;
        color: #ffffff;
    }

    .btn-reactivate {
        background-color: #f0fdf4;
        color: #16a34a;
    }

    .btn-reactivate:hover {
        background-color: #16a34a;
        color: #ffffff;
    }
</style>

<div class="companies-page-wrapper">
    <div class="page-header">
        <div>
            <h2 class="page-title">Manage Companies</h2>
            <p class="page-subtitle">Monitor and oversee registered client organizations and subscriptions.</p>
        </div>
    </div>

    <div class="card-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($companies)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <i class="fas fa-building" style="font-size: 2rem; margin-bottom: 12px; display: block; color: #cbd5e1;"></i>
                            No companies found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($companies as $c): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                            <td style="text-transform: capitalize;"><?= htmlspecialchars($c['plan_tier']) ?></td>
                            <td>
                                <span class="badge <?= $c['subscription_status'] === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                    <?= ucfirst($c['subscription_status']) ?>
                                </span>
                            </td>
                           <td style="text-align: right;">
    <!-- Details Button -->
    <a href="/loansaas/public/index.php?url=superadmin/companyDetails&id=<?= $c['id'] ?>" 
       class="btn-action" style="background: #eef2ff; color: #4f46e5; margin-right: 6px;">
        <i class="fas fa-eye"></i> Details
    </a>

    <?php if ($c['subscription_status'] === 'active'): ?>
        <a href="/loansaas/public/index.php?url=admin/toggleCompanyStatus&id=<?= $c['id'] ?>&status=closed" 
           onclick="return confirm('Are you sure you want to close this account?');"
           class="btn-action btn-close">
            <i class="fas fa-lock"></i> Close
        </a>
    <?php else: ?>
        <a href="/loansaas/public/index.php?url=admin/toggleCompanyStatus&id=<?= $c['id'] ?>&status=active" 
           class="btn-action btn-reactivate">
            <i class="fas fa-unlock"></i> Reactivate
        </a>
    <?php endif; ?>
</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>