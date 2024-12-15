<?php
include 'db_connect.php';
include 'header.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['id'];

if ($postId) {
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $postId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}
?>
