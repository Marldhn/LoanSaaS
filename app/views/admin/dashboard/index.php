<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Clean Modern Font (Inter) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

    .page-header { margin-bottom: 20px; }
    .page-header h1 { font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; }
    .page-header p { color: #64748b; font-size: 14px; margin: 4px 0 0 0; }

    /* Dashboard Stats Grid - All 10 Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #ffffff;
        padding: 16px 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .stat-info { display: flex; flex-direction: column; }
    .stat-label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px; }
    .stat-value { font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 4px; letter-spacing: -0.5px; }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    /* Main Content Layout */
    .dashboard-bottom {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .card-box {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-sizing: border-box;
        width: 100%;
        overflow: hidden;
    }

    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 16px 0;
    }

    /* Upcoming & Overdue Section Styling */
    .section-card-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-top: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .section-card-box.overdue {
        border-color: #fecaca;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 20px;
        color: #0f172a;
    }

    .section-header.overdue {
        color: #dc2626;
    }

    .badge-count {
        background: #e0e7ff;
        color: #4338ca;
        font-size: 12px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .badge-count.overdue {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Upcoming Summary Mini Cards */
    .upcoming-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .summary-subcard {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        display: flex;
        flex-direction: column;
    }

    .summary-subcard-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .summary-subcard-value {
        font-size: 22px;
        font-weight: 800;
    }

    .val-orange { color: #f97316; }
    .val-blue { color: #2563eb; }

    /* Responsive Table Container */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .custom-table th {
        color: #475569;
        font-weight: 600;
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        background-color: #f8fafc;
        white-space: nowrap;
    }

    .custom-table.overdue th {
        color: #ef4444;
        border-bottom-color: #fecaca;
        background-color: #fff5f5;
    }

    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        white-space: nowrap;
    }

    .days-badge {
        background: #fee2e2;
        color: #dc2626;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 10px;
    }

    .days-badge.upcoming {
        background: #e0f2fe;
        color: #0284c7;
    }

    /* Action Buttons Flex Wrapper */
    .action-group {
        display: flex !important;
        flex-direction: row !important;
        align-items: center;
        gap: 6px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .action-btn.remind {
        border-color: #fca5a5;
        color: #dc2626;
        background: #fff5f5;
    }

    .action-btn.remind:hover {
        background: #fee2e2;
    }

    .btn-icon { font-size: 13px; }
    .btn-text { margin-left: 4px; font-weight: 600; }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 280px; 
        width: 100%;
        max-width: 100%;
    }

    #loanChart {
        width: 100% !important;
        height: 100% !important;
    }

    /* Active Borrowers List Styling */
    .borrower-list { list-style: none; padding: 0; margin: 0; }
    .borrower-item {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .borrower-item:last-child { border-bottom: none; }

    /* Gmail-Style Email Composer Modal */
    .email-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(2px);
        z-index: 9999;
        justify-content: center;
        align-items: flex-end;
    }

    @media (min-width: 640px) {
        .email-modal-overlay {
            align-items: center;
        }
    }

    .email-modal-box {
        background: #ffffff;
        width: 100%;
        max-width: 600px;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
    }

    @media (min-width: 640px) {
        .email-modal-box {
            border-radius: 12px;
        }
    }

    .email-modal-header {
        background: #f8fafc;
        padding: 12px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .email-modal-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .email-modal-close {
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }

    .email-modal-close:hover { color: #0f172a; }

    .email-field-row {
        display: flex;
        align-items: center;
        padding: 8px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }

    .email-field-label {
        width: 70px;
        color: #64748b;
        font-weight: 600;
    }

    .email-field-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 13px;
        color: #0f172a;
        font-family: inherit;
        background: transparent;
    }

    .email-body-textarea {
        width: 100%;
        height: 200px;
        padding: 16px 20px;
        border: none;
        outline: none;
        resize: none;
        font-size: 13px;
        font-family: inherit;
        color: #334155;
        box-sizing: border-box;
        line-height: 1.6;
    }

    .email-modal-footer {
        padding: 12px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-send-email {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }

    .btn-send-email:hover { background: #1d4ed8; }
    .btn-send-email:disabled { opacity: 0.6; cursor: not-allowed; }

    /* Desktop View Layout */
    @media (min-width: 1024px) {
        .dashboard-bottom { grid-template-columns: 1fr 340px; }
        .chart-container { height: 320px; }
    }

    /* Mobile Responsive Fixes */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .upcoming-summary-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .stat-card { padding: 12px 14px; }
        .stat-icon { width: 36px; height: 36px; font-size: 15px; }
        .stat-value { font-size: 16px; }
        .card-box, .section-card-box { padding: 14px; }
        .chart-container { height: 220px; }
        .btn-text { display: none; }
        .action-btn { padding: 6px 8px; min-width: 30px; height: 30px; }
    }
</style>

<div class="page-header">
    <h1>Overview</h1>
    <p>Company Performance Summary</p>
</div>

<!-- All 10 Stat Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Total Loans</span>
            <span class="stat-value"><?= $stats['total_loans'] ?></span>
        </div>
        <div class="stat-icon" style="background:#eef2ff; color:#6366f1;"><i class="fas fa-hand-holding-dollar"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Total Collected</span>
            <span class="stat-value">₱<?= number_format($stats['total_collected'], 2) ?></span>
        </div>
        <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-wallet"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Available Money</span>
            <span class="stat-value">₱<?= number_format($stats['cash_on_hand'], 2) ?></span>
        </div>
        <div class="stat-icon" style="background:#fff7ed; color:#ea580c;"><i class="fas fa-bank"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Overdue</span>
            <span class="stat-value"><?= $stats['overdue_loans'] ?></span>
        </div>
        <div class="stat-icon" style="background:#fef2f2; color:#dc2626;"><i class="fas fa-exclamation-triangle"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Pending</span>
            <span class="stat-value"><?= $stats['pending_loans'] ?></span>
        </div>
        <div class="stat-icon" style="background:#fefce8; color:#ca8a04;"><i class="fas fa-clock"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Borrowers</span>
            <span class="stat-value"><?= $stats['total_borrowers'] ?></span>
        </div>
        <div class="stat-icon" style="background:#f1f5f9; color:#475569;"><i class="fas fa-users"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Active Loans</span>
            <span class="stat-value"><?= $stats['active_loans'] ?></span>
        </div>
        <div class="stat-icon" style="background:#f0fdfa; color:#0d9488;"><i class="fas fa-check-circle"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Collected Profit</span>
            <span class="stat-value" style="color:<?= $stats['total_profit'] >= 0 ? '#15803d' : '#dc2626' ?>;">
                ₱<?= number_format($stats['total_profit'], 2) ?>
            </span>
        </div>
        <div class="stat-icon" style="background:#f0fdf4; color:#15803d;"><i class="fas fa-chart-line"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Total Disbursed</span>
            <span class="stat-value">₱<?= number_format($stats['total_disbursed'], 2) ?></span>
        </div>
        <div class="stat-icon" style="background:#f8fafc; color:#475569;"><i class="fas fa-coins"></i></div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">Total Expenses</span>
            <span class="stat-value" style="color:#dc2626;">₱<?= number_format($stats['total_expenses'], 2) ?></span>
        </div>
        <div class="stat-icon" style="background:#fef2f2; color:#dc2626;"><i class="fas fa-receipt"></i></div>
    </div>
</div>

<div class="dashboard-bottom">
    <!-- Financial Chart Box -->
    <div class="card-box">
        <h3 class="card-title">Financial Overview</h3>
        <div class="chart-container">
            <canvas id="loanChart"></canvas>
        </div>
    </div>

    <!-- Active Borrowers Box -->
    <div class="card-box">
        <h3 class="card-title">Active Borrowers</h3>
        <?php if (!empty($activeBorrowers)): ?>
            <ul class="borrower-list">
                <?php foreach ($activeBorrowers as $borrower): ?>
                    <li class="borrower-item">
                        <span style="color: #334155; font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($borrower['name']) ?></span>
                        <span style="font-size: 0.85rem; font-weight: 700; color: #dc2626;">
                            ₱<?= number_format($borrower['total_due'], 2) ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="color: #64748b; font-size: 0.85rem;">No active borrowers found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Upcoming Payments Section -->
<?php 
    $upcomingPayments = $upcomingPayments ?? []; 
    $dueToday = $dueToday ?? 0;
    $dueThisWeek = $dueThisWeek ?? 0;
    $dueNext14Days = $dueNext14Days ?? 0;
?>
<div class="section-card-box">
    <div class="section-header">
        <span>Upcoming Payments (Next 14 Days)</span>
        <span class="badge-count"><?= count($upcomingPayments) ?></span>
    </div>

    <!-- Mini Cards Row -->
    <div class="upcoming-summary-grid">
        <div class="summary-subcard">
            <span class="summary-subcard-label">Due Today</span>
            <span class="summary-subcard-value val-orange">₱<?= number_format($dueToday, 0) ?></span>
        </div>
        <div class="summary-subcard">
            <span class="summary-subcard-label">Due This Week</span>
            <span class="summary-subcard-value val-orange">₱<?= number_format($dueThisWeek, 0) ?></span>
        </div>
        <div class="summary-subcard">
            <span class="summary-subcard-label">Due Next 14 Days</span>
            <span class="summary-subcard-value val-blue">₱<?= number_format($dueNext14Days, 0) ?></span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Due Date</th>
                    <th>Borrower</th>
                    <th>Loan ID</th>
                    <th>Amount Due</th>
                    <th>Days Left</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($upcomingPayments)): ?>
                    <?php foreach ($upcomingPayments as $item): ?>
                        <tr>
                            <td><?= date('n/j/Y', strtotime($item['due_date'])) ?></td>
                            <td style="font-weight: 600;"><?= htmlspecialchars($item['borrower_name']) ?></td>
                            <td style="font-weight: 700;">LN-<?= str_pad($item['loan_id'], 7, '0', STR_PAD_LEFT) ?></td>
                            <td style="font-weight: 700;">₱<?= number_format($item['amount_due'], 2) ?></td>
                            <td><span class="days-badge upcoming"><?= $item['days_left'] ?> days</span></td>
                            <td>
                      <button type="button" class="action-btn remind" title="Remind" 
        onclick="openEmailModal(
            '<?= htmlspecialchars($item['borrower_name'], ENT_QUOTES) ?>', 
            '<?= htmlspecialchars($item['email'] ?? '', ENT_QUOTES) ?>', 
            'LN-<?= str_pad($item['loan_id'], 7, '0', STR_PAD_LEFT) ?>', 
            '₱<?= number_format($item['amount_due'], 2) ?>', 
            '<?= date('n/j/Y', strtotime($item['due_date'])) ?>', 
            'upcoming', 
            <?= $item['loan_id'] ?>
        )">
    <i class="fas fa-envelope btn-icon"></i>
    <span class="btn-text">Remind</span>
</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px 0;">No upcoming payments found for the next 14 days.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Overdue Payments Section -->
<?php $overduePayments = $overduePayments ?? []; ?>
<div class="section-card-box overdue">
    <div class="section-header overdue">
        <i class="fas fa-exclamation-triangle"></i>
        <span>Overdue Payments</span>
        <span class="badge-count overdue"><?= count($overduePayments) ?></span>
    </div>

    <?php if (!empty($overduePayments)): ?>
        <div class="table-responsive">
            <table class="custom-table overdue">
                <thead>
                    <tr>
                        <th>Due Date</th>
                        <th>Borrower</th>
                        <th>Loan ID</th>
                        <th>Amount Due</th>
                        <th>Days Overdue</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($overduePayments as $item): ?>
                        <tr>
                            <td><?= date('n/j/Y', strtotime($item['due_date'])) ?></td>
                            <td style="font-weight: 600;"><?= htmlspecialchars($item['borrower_name']) ?></td>
                            <td style="font-weight: 700;">LN-<?= str_pad($item['loan_id'], 7, '0', STR_PAD_LEFT) ?></td>
                            <td style="font-weight: 700;">₱<?= number_format($item['amount_due'], 2) ?></td>
                            <td><span class="days-badge"><?= $item['days_overdue'] ?> days</span></td>
                            <td>
                                <div class="action-group">
                                  <button type="button" class="action-btn remind" title="Remind" 
        onclick="openEmailModal(
            '<?= htmlspecialchars($item['borrower_name'], ENT_QUOTES) ?>', 
            '<?= htmlspecialchars($item['email'] ?? '', ENT_QUOTES) ?>', 
            'LN-<?= str_pad($item['loan_id'], 7, '0', STR_PAD_LEFT) ?>', 
            '₱<?= number_format($item['amount_due'], 2) ?>', 
            '<?= date('n/j/Y', strtotime($item['due_date'])) ?>', 
            'overdue',
<?= $item['loan_id'] ?>
        )">
    <i class="fas fa-envelope btn-icon"></i>
    <span class="btn-text">Remind</span>
</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p style="color: #64748b; font-size: 13px; margin: 0;">No overdue payments found.</p>
    <?php endif; ?>
</div>

<!-- Gmail-Style Reminder Email Modal -->
<div id="emailModal" class="email-modal-overlay">
    <div class="email-modal-box">
        <div class="email-modal-header">
            <div class="email-modal-title">
                <i class="fas fa-paper-plane" style="color: #2563eb;"></i>
                <span>Send Payment Reminder Email</span>
            </div>
            <button type="button" class="email-modal-close" onclick="closeEmailModal()">&times;</button>
        </div>
        
        <form id="reminderEmailForm" onsubmit="submitReminderEmail(event)">
            <input type="hidden" id="modalLoanId" name="loan_id">
            
            <div class="email-field-row">
                <span class="email-field-label">To:</span>
                <input type="email" id="modalToEmail" class="email-field-input" placeholder="borrower@email.com" required>
            </div>
            
            <div class="email-field-row">
                <span class="email-field-label">Subject:</span>
                <input type="text" id="modalSubject" class="email-field-input" required>
            </div>
            
            <textarea id="modalBody" class="email-body-textarea" required></textarea>
            
            <div class="email-modal-footer">
                <button type="submit" id="btnSendEmail" class="btn-send-email">
                    <i class="fas fa-paper-plane"></i> Send Email
                </button>
                <span style="font-size: 11px; color: #94a3b8;">Automated Notification System</span>
            </div>
        </form>
    </div>
</div>

<script>
// Financial Chart Initialization
const ctx = document.getElementById('loanChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [
            {
                label: 'Revenue',
                data: <?= json_encode($chartTotals) ?>,
                backgroundColor: '#3b82f6',
                borderRadius: 4,
                barThickness: 16
            },
            {
                label: 'Expenses',
                data: <?= json_encode($chartExpenses) ?>,
                backgroundColor: '#94a3b8',
                borderRadius: 4,
                barThickness: 16
            }
        ]
    },
    options: { 
        responsive: true, 
        maintainAspectRatio: false,
        plugins: { 
            legend: { 
                position: 'bottom',
                labels: { boxWidth: 12, font: { family: 'Inter', size: 11 } } 
            } 
        }, 
        scales: { 
            y: { 
                beginAtZero: true, 
                grid: { color: '#f1f5f9' },
                ticks: { font: { family: 'Inter', size: 10 } } 
            },
            x: { 
                grid: { display: false },
                ticks: { font: { family: 'Inter', size: 10 } } 
            }
        } 
    }
});

// Modal Logic
function openEmailModal(name, email, loanIdFormatted, amount, dueDate, type, rawLoanId) {
    document.getElementById('modalLoanId').value = rawLoanId;
    document.getElementById('modalToEmail').value = email || '';
    
    let subject = '';
    let body = '';

    if (type === 'overdue') {
        subject = `OVERDUE NOTICE: Payment Request for Loan ${loanIdFormatted}`;
        body = `Dear ${name},\n\nWe hope this email finds you well.\n\nThis is a friendly reminder that your payment of ${amount} for Loan Account ${loanIdFormatted} was due on ${dueDate} and is currently overdue.\n\nPlease arrange for payment at your earliest convenience to avoid additional charges or penalities.\n\nThank you,\nLoan Management Team`;
    } else {
        subject = `Payment Reminder: Upcoming Loan Due Date (${loanIdFormatted})`;
        body = `Dear ${name},\n\nThis is an automated reminder regarding your upcoming loan payment.\n\nLoan ID: ${loanIdFormatted}\nAmount Due: ${amount}\nDue Date: ${dueDate}\n\nPlease ensure your payment is processed on or before the due date.\n\nThank you for choosing our service!\n\nBest regards,\nLoan Management Team`;
    }

    document.getElementById('modalSubject').value = subject;
    document.getElementById('modalBody').value = body;

    document.getElementById('emailModal').style.display = 'flex';
}

function closeEmailModal() {
    document.getElementById('emailModal').style.display = 'none';
}

function submitReminderEmail(event) {
    event.preventDefault();

    const btn = document.getElementById('btnSendEmail');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

    const payload = {
        loan_id: document.getElementById('modalLoanId').value,
        to_email: document.getElementById('modalToEmail').value,
        subject: document.getElementById('modalSubject').value,
        body: document.getElementById('modalBody').value
    };

    fetch('/loansaas/public/index.php?url=notification/sendReminder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Reminder email sent successfully!');
            closeEmailModal();
        } else {
            alert('Failed to send email: ' + (data.message || 'Please verify the borrower email address.'));
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('An error occurred while dispatching the email reminder.');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

// Close modal if overlay is clicked
window.onclick = function(event) {
    const modal = document.getElementById('emailModal');
    if (event.target === modal) {
        closeEmailModal();
    }
};
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>