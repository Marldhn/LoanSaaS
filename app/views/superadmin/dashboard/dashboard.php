<?php
require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>

<style>
.dashboard-container{
    display:flex;
    flex-direction:column;
    gap:24px;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

.page-title{
    font-size:28px;
    font-weight:700;
    color:#0f172a;
    margin:0;
}

.page-subtitle{
    color:#64748b;
    margin-top:5px;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
    gap:18px;
}

.stat-card{
    background:#fff;
    border-radius:14px;
    border:1px solid #e2e8f0;
    padding:22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:.2s;
}

.stat-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 30px rgba(0,0,0,.08);
}

.stat-left{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.stat-title{
    font-size:13px;
    color:#64748b;
    text-transform:uppercase;
    font-weight:700;
}

.stat-value{
    font-size:30px;
    font-weight:700;
    color:#0f172a;
}

.stat-icon{
    width:60px;
    height:60px;
    border-radius:14px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:24px;
}

.dashboard-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

.card{
    background:#fff;
    border-radius:14px;
    border:1px solid #e2e8f0;
    padding:20px;
}

.card-title{
    font-size:18px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:20px;
}

.chart-box{
    height:350px;
}

.company-list{
    display:flex;
    flex-direction:column;
    gap:15px;
}

.company-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-bottom:14px;
    border-bottom:1px solid #f1f5f9;
}

.company-item:last-child{
    border-bottom:none;
}

.company-name{
    font-weight:600;
    color:#0f172a;
}

.company-plan{
    display:inline-block;
    padding:5px 12px;
    border-radius:50px;
    background:#eef2ff;
    color:#4f46e5;
    font-size:12px;
    font-weight:700;
}

.bottom-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.activity-list{
    display:flex;
    flex-direction:column;
    gap:16px;
}

.activity-item{
    display:flex;
    gap:15px;
    align-items:flex-start;
}

.activity-icon{
    width:42px;
    height:42px;
    border-radius:50%;
    background:#eef2ff;
    color:#4f46e5;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-shrink:0;
}

.activity-title{
    font-weight:600;
    color:#0f172a;
}

.activity-date{
    color:#64748b;
    font-size:13px;
}

.health-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid #f1f5f9;
}

.health-item:last-child{
    border-bottom:none;
}

.status-online{
    color:#16a34a;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    gap:6px;
}

.status-warning{
    color:#f59e0b;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    gap:6px;
}

@media(max-width:992px){
    .dashboard-grid{
        grid-template-columns:1fr;
    }
    .bottom-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="dashboard-container">

    <div class="page-header">
        <div>
            <h1 class="page-title">
                Super Admin Dashboard
            </h1>
            <p class="page-subtitle">
                Monitor all companies, subscriptions and system activities.
            </p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <!-- Card 1 -->
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-title">Companies</div>
                <div class="stat-value"><?= $stats['total_companies'] ?></div>
            </div>
            <div class="stat-icon" style="background:#eef2ff;color:#4f46e5;">
                <i class="fas fa-building"></i>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-title">Users</div>
                <div class="stat-value"><?= $stats['total_users'] ?></div>
            </div>
            <div class="stat-icon" style="background:#ecfdf5;color:#16a34a;">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-title">Loans</div>
                <div class="stat-value"><?= $stats['total_loans'] ?></div>
            </div>
            <div class="stat-icon" style="background:#fff7ed;color:#ea580c;">
                <i class="fas fa-hand-holding-dollar"></i>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-title">Active Loans</div>
                <div class="stat-value"><?= $stats['active_loans'] ?></div>
            </div>
            <div class="stat-icon" style="background:#fef2f2;color:#dc2626;">
                <i class="fas fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- Main Section -->
    <div class="dashboard-grid">
        <div class="card">
            <h3 class="card-title">
                Loan Activity Overview (<?= date('Y') ?>)
            </h3>
            <div class="chart-box">
                <canvas id="loanChart"></canvas>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">
                Newest Companies
            </h3>
            <div class="company-list">
                <?php if (!empty($recentCompanies)): ?>
                    <?php foreach ($recentCompanies as $company): ?>
                        <div class="company-item">
                            <div>
                                <div class="company-name">
                                    <?= htmlspecialchars($company['name']) ?>
                                </div>
                                <small style="color:#64748b;">
                                    <?= date('M d, Y', strtotime($company['created_at'])) ?>
                                </small>
                            </div>
                            <span class="company-plan">
                                <?= ucfirst($company['plan_tier']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align:center;padding:30px;color:#94a3b8;">
                        No companies found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="bottom-grid">
        <div class="card">
            <h3 class="card-title">
                System Health
            </h3>
            <div class="health-item">
                <span>Database Connection</span>
                <span class="status-online">
                    <i class="fas fa-circle" style="font-size: 8px;"></i> Connected
                </span>
            </div>
            <div class="health-item">
                <span>PHP Engine</span>
                <span class="status-online">
                    <i class="fas fa-circle" style="font-size: 8px;"></i> v<?= phpversion() ?>
                </span>
            </div>
            <div class="health-item">
                <span>Server Software</span>
                <span class="status-online">
                    <i class="fas fa-circle" style="font-size: 8px;"></i> <?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Active') ?>
                </span>
            </div>
            <div class="health-item">
                <span>Environment</span>
                <span class="status-online">
                    <i class="fas fa-circle" style="font-size: 8px;"></i> Production
                </span>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">
                Recent Activities
            </h3>
            <div class="activity-list">
                <?php if (!empty($recentActivities)): ?>
                    <?php foreach ($recentActivities as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <div class="activity-title">
                                    New company registered: <?= htmlspecialchars($activity['name']) ?>
                                </div>
                                <div class="activity-date">
                                    <?= date('M d, Y h:i A', strtotime($activity['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="color:#64748b; font-size:13px; text-align:center; padding:20px;">No recent activities logged.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('loanChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Loans Created',
            data: <?= json_encode($loanChartData) ?>,
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99,102,241,.10)',
            fill: true,
            tension: .4,
            borderWidth: 3,
            pointRadius: 4,
            pointBackgroundColor: '#6366f1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' },
                ticks: { stepSize: 1 }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>