<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include "db_connect.php"; 
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header('Location: posts.php');
    exit();
} else {
    header('Location: login.php');
    exit();
}
?>


