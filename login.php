<?php
include "db_connect.php"; 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['logged_in'] = true;
                header('Location: posts.php');
                exit();
            } else {
                echo "<script>alert('Invalid credentials!');</script>";
            }
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
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
<body>
    <section class="bg-white">
        <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
        <aside class="relative block h-16 lg:order-last lg:col-span-5 lg:h-full xl:col-span-6">
      <img
        alt=""
        src="https://images.unsplash.com/photo-1513118172236-00b7cc57e1fa?fm=jpg&amp;q=60&amp;w=3000&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        class="absolute inset-0 h-full w-full object-cover"
      />
    </aside>
            <main class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
                <div class="max-w-xl lg:max-w-3xl" style="width:80%">
                    <a class="block text-blue-600" href="">
                        <img src="assets\logo.png" alt="testx" class="h-12">
                    </a>

                    <h1 class="mt-6 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">
                        Welcome to The Blog
                    </h1>

                    <h2 class="mt-4 text-2xl text-gray-500">
                        User Login
                    </h2>

                    <form method="POST" action="login.php" onsubmit="return check()" class="mt-8 grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label for="Email" class="block text-sm font-medium text-gray-700"> Email </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="mt-1 w-full rounded p-2 outline-none border bg-white text-sm text-gray-700 shadow-sm"
                            />
                        </div>
                        <div class="col-span-6">
                            <label for="Password" class="block text-sm font-medium text-gray-700"> Password </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="mt-1 w-full rounded p-2 outline-none border bg-white text-sm text-gray-700 shadow-sm"
                            />
                        </div>

                        <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                            <button
                                class="inline-block shrink-0 rounded-md border border-black bg-gray-800 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-black"
                            >
                                Login
                            </button>

                            <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                                Don't have an account?
                                <a href="signup.php" class="text-gray-700 underline">Signup</a> .
                            </p>
                        </div>

                        <div id="error"></div>
                    </form>
                </div>
            </main>
        </div>
    </section>
</body>
<script>
    function check(){
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!email) {
            alert(`Email can't be empty!`);
            return false;
        }
        else if (!password) {
            alert(`Password can't be empty!`);
            return false;
        }
        return true; 
    }
</script>
</html>
