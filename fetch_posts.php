<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
$query = "SELECT id, title, description, active_status, image, created_at FROM posts where active_status=1 ORDER BY created_at DESC";
$result = $conn->query($query);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($posts);
?>
