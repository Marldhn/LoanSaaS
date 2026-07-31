<?php
session_start();
require_once __DIR__ . '/app/models/Loan.php';

$loanModel = new Loan();
$db = $loanModel->getDb();

// 1. Fetch the superadmin account from the database
$stmt = $db->prepare("SELECT * FROM users WHERE role = 'superadmin' LIMIT 1");
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // 2. Manually set the session variables your app checks for authentication
    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'role' => $user['role'],
        'company_id' => $user['company_id'] ?? null
    ];

    echo "Superadmin session created successfully!<br>";
    echo "You are now logged in as: <strong>" . htmlspecialchars($user['username']) . "</strong><br><br>";
    echo '<a href="/LoanSaaS/public/index.php?url=admin/index" style="padding: 10px 20px; background: #6366f1; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Go to Superadmin Dashboard</a>';
} else {
    echo "No superadmin account found in the database. Please insert one first.";
}
?>