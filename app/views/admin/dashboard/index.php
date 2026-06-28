<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Dashboard Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: #ffffff;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stat-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .stat-info { display: flex; flex-direction: column; }
    .stat-label { font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; }
    .stat-value { font-size: 24px; font-weight: 800; color: #0f172a; margin-top: 4px; }

    /* Bottom Grid Layout */
    .dashboard-bottom {
        display: grid;
        grid-template-columns: 2fr 1fr; /* Chart takes 2/3, List takes 1/3 */
        gap: 20px;
        align-items: start;
    }

    .card-box {
        background: #fff;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        width: 100%;
    }

    /* Fixed height container for chart */
    .chart-container {
        position: relative;
        height: 350px; 
        width: 100%;
    }

    @media (max-width: 992px) {
        .dashboard-bottom { grid-template-columns: 1fr; }
    }
</style>

<div class="page-header">
    <h1>Overview</h1>
    <p>Company Performance Summary</p>
</div>

<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon" style="background:#eef2ff; color:#6366f1;"><i class="fas fa-hand-holding-dollar"></i></div><div class="stat-info"><span class="stat-label">Total Loans</span><span class="stat-value"><?= $stats['total_loans'] ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-wallet"></i></div><div class="stat-info"><span class="stat-label">Total Collected</span><span class="stat-value">₱<?= number_format($stats['total_collected'], 2) ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fff7ed; color:#ea580c;"><i class="fas fa-bank"></i></div><div class="stat-info"><span class="stat-label">Cash on Hand</span><span class="stat-value">₱<?= number_format($stats['cash_on_hand'], 2) ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fef2f2; color:#dc2626;"><i class="fas fa-exclamation-triangle"></i></div><div class="stat-info"><span class="stat-label">Overdue</span><span class="stat-value"><?= $stats['overdue_loans'] ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fefce8; color:#ca8a04;"><i class="fas fa-clock"></i></div><div class="stat-info"><span class="stat-label">Pending</span><span class="stat-value"><?= $stats['pending_loans'] ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f1f5f9; color:#475569;"><i class="fas fa-users"></i></div><div class="stat-info"><span class="stat-label">Borrowers</span><span class="stat-value"><?= $stats['total_borrowers'] ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f0fdfa; color:#0d9488;"><i class="fas fa-check-circle"></i></div><div class="stat-info"><span class="stat-label">Active Loans</span><span class="stat-value"><?= $stats['active_loans'] ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f0fdf4; color:#15803d;"><i class="fas fa-chart-line"></i></div><div class="stat-info"><span class="stat-label">Collected Profit</span><span class="stat-value" style="color:<?= $stats['total_profit'] >= 0 ? '#15803d' : '#dc2626' ?>;">₱<?= number_format($stats['total_profit'], 2) ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f8fafc; color:#475569;"><i class="fas fa-coins"></i></div><div class="stat-info"><span class="stat-label">Total Disbursed</span><span class="stat-value">₱<?= number_format($stats['total_disbursed'], 2) ?></span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f8fafc; color:red; "><i class="fas fa-coins"></i></div><div class="stat-info"><span class="stat-label">Total Expenses</span><span class="stat-value" style="color:red;">₱<?= number_format($stats['total_expenses'], 2) ?></span></div></div>

</div>

<div class="dashboard-bottom">
    <div class="card-box">
        <h3>Loan Trends (Last 30 Days)</h3>
        <div class="chart-container">
            <canvas id="loanChart"></canvas>
        </div>
    </div>
   <div class="card-box">
    <h3>Active Borrowers</h3>
    <?php if (!empty($activeBorrowers)): ?>
        <ul style="list-style: none; padding: 0; margin-top: 15px;">
            <?php foreach ($activeBorrowers as $borrower): ?>
                <li style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center;">
                        <i class="fas fa-user-circle" style="margin-right: 10px; color: #6366f1;"></i>
                        <span style="color: #334155; font-weight: 500;"><?= htmlspecialchars($borrower['name']) ?></span>
                    </div>
                    <span style="font-size: 0.85rem; font-weight: bold; color: #e11d48;">
                        ₱<?= number_format($borrower['total_due'], 2) ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p style="color: #64748b; margin-top: 15px;">No active borrowers found.</p>
    <?php endif; ?>
</div>
</div>

<script>
const ctx = document.getElementById('loanChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [
            {
                label: 'Loan Amount',
                data: <?= json_encode($chartTotals) ?>,
                borderColor: '#10b981', 
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Expenses',
                data: <?= json_encode($chartExpenses) ?>,
                borderColor: '#ef4444', 
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Daily Profit', // New Profit line
                data: <?= json_encode($chartProfits) ?>, 
                borderColor: '#6366f1', // Indigo
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true,
                borderDash: [5, 5] // Dotted line style
            }
        ]
    },
    options: { 
        responsive: true, 
        maintainAspectRatio: false,
        plugins: { 
            legend: { position: 'top' } 
        }, 
        scales: { 
            y: { beginAtZero: true } 
        } 
    }
});
</script>
<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>