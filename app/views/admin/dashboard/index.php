<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>


<style>

    /* Dashboard Grid Layout */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

/* Individual Stat Cards */
.stat-card {
    background: #ffffff;
    padding: 24px;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-info { display: flex; flex-direction: column; }

.stat-label {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin-top: 4px;
}
</style>

<div class="page-header">
    <div class="header-title">
        <h1>Overview</h1>
        <p>Company Performance Summary</p>
    </div>
</div>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #eef2ff; color: #6366f1;"><i class="fas fa-hand-holding-dollar"></i></div>
        <div class="stat-info">
            <span class="stat-label">Total Loans</span>
            <span class="stat-value"><?= $stats['total_loans'] ?></span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-wallet"></i></div>
        <div class="stat-info">
            <span class="stat-label">Total Collected</span>
            <span class="stat-value">₱<?= number_format($stats['total_collected'], 2) ?></span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff7ed; color: #ea580c;"><i class="fas fa-bank"></i></div>
        <div class="stat-info">
            <span class="stat-label">Cash on Hand</span>
            <span class="stat-value">₱<?= number_format($stats['cash_on_hand'], 2) ?></span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #fef2f2; color: #dc2626;"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-info">
            <span class="stat-label">Overdue</span>
            <span class="stat-value"><?= $stats['overdue_loans'] ?></span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fefce8; color: #ca8a04;"><i class="fas fa-clock"></i></div>
        <div class="stat-info">
            <span class="stat-label">Pending</span>
            <span class="stat-value"><?= $stats['pending_loans'] ?></span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #f1f5f9; color: #475569;"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <span class="stat-label">Borrowers</span>
            <span class="stat-value"><?= $stats['total_borrowers'] ?></span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #f0fdfa; color: #0d9488;"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <span class="stat-label">Active Loans</span>
            <span class="stat-value"><?= $stats['active_loans'] ?></span>
        </div>
    </div>
<div class="stat-card">
    <div class="stat-icon" style="background: #f0fdf4; color: #15803d;"><i class="fas fa-chart-line"></i></div>
    <div class="stat-info">
        <span class="stat-label">Total Profit</span>
        <span class="stat-value" style="color: <?= $stats['total_profit'] >= 0 ? '#15803d' : '#dc2626' ?>;">
            ₱<?= number_format($stats['total_profit'], 2) ?>
        </span>
    </div>
</div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #f8fafc; color: #475569;"><i class="fas fa-coins"></i></div>
        <div class="stat-info">
            <span class="stat-label">Total Disbursed</span>
            <span class="stat-value">₱<?= number_format($stats['total_disbursed'], 2) ?></span>
        </div>
    </div>
</div>
<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
