<?php
$plainPassword = '@Rubinos110402';
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

echo "Plain Password: " . htmlspecialchars($plainPassword) . "<br>";
echo "Hashed Password: " . htmlspecialchars($hashedPassword);
?>