<?php require_once dirname(__DIR__, 3) . '/layouts/header.php'; ?>

<div class="container-fluid">
    <h2>Pending Company Registrations</h2>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pendingUsers)): ?>
                        <?php foreach ($pendingUsers as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['company_name']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <form action="/loansaas/public/index.php?url=admin/approveUser" method="POST">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No pending registrations found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 3) . '/layouts/footer.php'; ?>