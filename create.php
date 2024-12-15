<?php
include "db_connect.php";
include "header.php";

// session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $active_status = $_POST['active_status'] ?? 0;
    $user_id = $_SESSION['user_id'];

    // Validate required fields
    if (empty($title) || empty($description)) {
        echo "<script>alert('Title and description are required.');</script>";
        exit();
    }

    // File upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            $newFileName = uniqid() . '.' . $fileExtension;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                $stmt = $conn->prepare("INSERT INTO posts (user_id, title, description, active_status, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issis", $user_id, $title, $description, $active_status, $newFileName);
                if($stmt->execute()) {
                    header('Location: posts.php');
                    exit();
                } else {
                    echo "<script>alert('Failed to save post in the database.');</script>";
                }
            } else {
                echo "<script>alert('Error moving the uploaded file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
        }
    } else {
        echo "<script>alert('No image uploaded or upload error.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="mt-24">
<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Add Post</h2>

    <form method="POST" action="create.php" enctype="multipart/form-data">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <!-- Title -->
            <div>
                <label class="text-gray-700 dark:text-gray-200" for="title">Title</label>
                <input id="title" name="title" type="text" 
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                    required>
            </div>

            <div>
                <label class="text-gray-700 dark:text-gray-200" for="description">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                    required></textarea>
            </div>

            <div>
                <label class="text-gray-700 dark:text-gray-200">Active Status</label>
                <div class="flex items-center mt-2 space-x-4">
                    <label class="flex items-center text-gray-700 dark:text-gray-200">
                        <input type="radio" name="active_status" value="1" class="form-radio text-blue-600" required>
                        <span class="ml-2">Active</span>
                    </label>
                    <label class="flex items-center text-gray-700 dark:text-gray-200">
                        <input type="radio" name="active_status" value="0" class="form-radio text-red-600" required>
                        <span class="ml-2">Not Active</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="text-gray-700 dark:text-gray-200" for="image">Upload Image</label>
                <input id="image" name="image" type="file" accept="image/*" 
                    class="block w-full text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                    required>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                Save
            </button>
        </div>
    </form>
</section>
 
</div> 
</body>
</html>
