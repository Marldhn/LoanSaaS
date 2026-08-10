<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>
<style>
    .details-page-wrapper {
        width: 100%;
        max-width: 1200px;
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
    .grid-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }
    .card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        margin-bottom: 20px;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 10px;
    }
    .info-group {
        margin-bottom: 14px;
    }
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 0.95rem;
        color: #0f172a;
        font-weight: 600;
    }
    .form-group {
        margin-bottom: 16px;
    }
    .form-group label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.875rem;
        background-color: #f8fafc;
        box-sizing: border-box;
        outline: none;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .btn-primary-custom {
        background-color: #6366f1;
        color: #ffffff;
        font-weight: 600;
        padding: 9px 18px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        width: 100%;
        transition: background-color 0.15s;
    }
    .btn-primary-custom:hover {
        background-color: #4f46e5;
    }
    .badge {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-active { background-color: #dcfce7; color: #15803d; }
    .badge-inactive { background-color: #fee2e2; color: #b91c1c; }
    @media(max-width: 900px) {
        .grid-layout { grid-template-columns: 1fr; }
    }
</style>

<div class="details-page-wrapper">
    <div class="page-header">
        <div>
            <h2 class="page-title"><?= htmlspecialchars($company['name']) ?></h2>
            <p style="color: #64748b; font-size: 0.875rem; margin: 4px 0 0 0;">Company Profile & Subscription Management</p>
        </div>
        <a href="/loansaas/public/index.php?url=admin/companies" style="background: #f1f5f9; color: #334155; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="grid-layout">
        <!-- Left Side: Company Information -->
        <div>
            <div class="card">
                <h3 class="card-title">Company Information</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="info-group">
                        <div class="info-label">Company ID</div>
                        <div class="info-value">#<?= $company['id'] ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Registration Date</div>
                        <div class="info-value"><?= date('M d, Y h:i A', strtotime($company['created_at'])) ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Current Plan</div>
                        <div class="info-value" style="text-transform: capitalize;"><?= htmlspecialchars($company['plan_tier']) ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Account Status</div>
                        <div class="info-value">
                            <span class="badge <?= $company['subscription_status'] === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($company['subscription_status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title">Platform Statistics</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="info-label">Total Users</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-top: 4px;"><?= $totalUsers ?></div>
                    </div>
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="info-label">Total Loans Recorded</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-top: 4px;"><?= $totalLoans ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Edit Subscription Form -->
        <div>
            <div class="card">
                <h3 class="card-title">Edit Subscription</h3>
                <form method="POST" action="/loansaas/public/index.php?url=superadmin/updateSubscription">
                    <input type="hidden" name="company_id" value="<?= $company['id'] ?>">

                    <div class="form-group">
                        <label>Plan Tier</label>
                        <select name="plan_tier" class="form-control" style="text-transform: capitalize;">
                            <option value="basic" <?= $company['plan_tier'] === 'basic' ? 'selected' : '' ?>>Basic</option>
                            <option value="standard" <?= $company['plan_tier'] === 'standard' ? 'selected' : '' ?>>Standard</option>
                            <option value="premium" <?= $company['plan_tier'] === 'premium' ? 'selected' : '' ?>>Premium</option>
                            <option value="enterprise" <?= $company['plan_tier'] === 'enterprise' ? 'selected' : '' ?>>Enterprise</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Subscription Status</label>
                        <select name="subscription_status" class="form-control">
                            <option value="active" <?= $company['subscription_status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="closed" <?= $company['subscription_status'] === 'closed' ? 'selected' : '' ?>>Closed / Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary-custom" style="margin-top: 8px;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>