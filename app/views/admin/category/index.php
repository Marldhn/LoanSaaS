<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<div class="main-content" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Categories</h2>
        <a href="/loansaas/public/index.php?url=category/create" style="padding: 10px 15px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px;">+ Add Category</a>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Name</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Type</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= htmlspecialchars($cat['name']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0; text-transform: capitalize;"><?= htmlspecialchars($cat['type']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= htmlspecialchars($cat['description']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>