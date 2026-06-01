<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<div class="main-content" style="padding: 20px;">
    <h2>User Feedback & Suggestions</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 12px; border: 1px solid #e2e8f0;">User</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Message</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= htmlspecialchars($msg['username']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= htmlspecialchars($msg['message']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= $msg['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>