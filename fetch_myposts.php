<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
$user_id = $_SESSION['user_id'];
$query = "SELECT id, title, description, active_status, image, created_at FROM posts where user_id= $user_id ORDER BY created_at DESC";
$result = $conn->query($query);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
else{
    $posts[] = "No Posts Found";
}

header('Content-Type: application/json');
echo json_encode($posts);
?>
