<?php
include "db_connect.php"; 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

echo $_SESSION['name'];
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
    <a href="logout.php" class="text-sm text-gray-500">Logout</a>
<?php else: ?>
    <a href="login.php" class="text-sm text-gray-500">Login</a>
<?php endif; ?>
