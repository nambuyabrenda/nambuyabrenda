<?php
// hash_generator.php - Run this to generate a hash
$hash = password_hash('YujoAdmin2024!', PASSWORD_DEFAULT);
echo "Copy this hash:<br>";
echo "<textarea rows='3' cols='60'>" . $hash . "</textarea>";
echo "<br><br>Then run this SQL in phpMyAdmin:<br>";
echo "<textarea rows='5' cols='60'>";
echo "UPDATE admin_users SET password_hash = '" . $hash . "' WHERE username = 'admin';";
echo "</textarea>";
?>