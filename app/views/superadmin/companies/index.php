<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<div class="page-header">
    <h2 style="margin: 0;">Manage Companies</h2>
</div>

<div class="card-wrapper">
    <table class="data-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 16px; text-align: left;">Company Name</th>
                <th style="padding: 16px; text-align: left;">Plan</th>
                <th style="padding: 16px; text-align: left;">Status</th>
                <th style="padding: 16px; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($companies)): ?>
                <tr><td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">No companies found.</td></tr>
            <?php else: ?>
                <?php foreach ($companies as $c): ?>
                    <tr>
                        <td style="padding: 16px;"><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                        <td style="padding: 16px; text-transform: capitalize;"><?= htmlspecialchars($c['plan_tier']) ?></td>
                        <td style="padding: 16px;">
                            <span class="badge <?= $c['subscription_status'] === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($c['subscription_status']) ?>
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <?php if ($c['subscription_status'] === 'active'): ?>
                                <a href="/loansaas/public/index.php?url=admin/toggleCompanyStatus&id=<?= $c['id'] ?>&status=closed" 
                                   onclick="return confirm('Are you sure you want to close this account?');"
                                   style="background: #dc2626; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;">
                                   <i class="fas fa-lock"></i> Close
                                </a>
                            <?php else: ?>
                                <a href="/loansaas/public/index.php?url=admin/toggleCompanyStatus&id=<?= $c['id'] ?>&status=active" 
                                   style="background: #16a34a; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;">
                                   <i class="fas fa-unlock"></i> Reactivate
                                </a>
                            <?php endif; ?>

                            <a href="#" onclick="openModal(<?= $c['id'] ?>); return false;" 
                               style="color: #6366f1; margin-left: 10px; text-decoration: none; font-weight: 600; font-size: 13px;">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>