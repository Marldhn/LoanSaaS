<?php 
// 1. Correct path to your layout header
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>

<style>
    /* Prevent double-margin issues */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-header { margin-bottom: 20px; }
    .page-header h1 { font-size: 1.5rem; color: #1e293b; margin: 0; }

    /* Dashboard Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .stat-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; }
    .stat-value { font-size: 1.25rem; font-weight: 800; color: #0f172a; }

    /* Bottom Section */
    .dashboard-bottom {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    .card-box {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .chart-container { position: relative; height: 300px; width: 100%; }

    @media (max-width: 768px) {
        .dashboard-bottom { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <h1>Super Admin Overview</h1>
        <p style="color: #64748b;">System-wide performance summary</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff; color:#6366f1;"><i class="fas fa-building"></i></div>
            <div class="stat-info"><span class="stat-label">Companies</span><div class="stat-value"><?= $stats['total_companies'] ?></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-users"></i></div>
            <div class="stat-info"><span class="stat-label">Total Users</span><div class="stat-value"><?= $stats['total_users'] ?></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed; color:#ea580c;"><i class="fas fa-hand-holding-usd"></i></div>
            <div class="stat-info"><span class="stat-label">Total Loans</span><div class="stat-value"><?= $stats['total_loans'] ?></div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2; color:#dc2626;"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info"><span class="stat-label">Active Loans</span><div class="stat-value"><?= $stats['active_loans'] ?></div></div>
        </div>
    </div>

    <div class="dashboard-bottom">
        <div class="card-box">
            <h3>Loan Trends</h3>
            <div class="chart-container"><canvas id="loanChart"></canvas></div>
        </div>
        <div class="card-box">
            <h3>Recent Companies</h3>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($recentCompanies as $comp): ?>
                    <li style="padding: 10px 0; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($comp['name']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [{ label: 'Loans', data: [12, 19, 3, 5], borderColor: '#6366f1', fill: false }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>

<?php 
// 4. Correct path to layout footer
require_once dirname(__DIR__, 2) . '/layouts/footer.php'; 
?>