<?php include "db_connect.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkEmailQuery = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('User is already registered.Try to login!');</script>";
    } else {
        $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $name, $email, $password);
        
        if($stmt->execute()){
            echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: Could not register user. Please try again.');</script>";
        }
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

    <main
      class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6"
    >
      <div class="max-w-xl lg:max-w-3xl">
      <a class="block text-blue-600" href="">
          <img src="assets\logo.png" alt="testx" class="h-12">
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">
          Welcome to The Blog
        </h1>

        <h2 class="mt-4 text-2xl text-gray-500">
          User Registration
        </h2>

        <form method="POST" action="signup.php" onsubmit="return check()" class="mt-8 grid grid-cols-6 gap-6">
        
        <div class="col-span-6">
            <label for="name" class="block text-sm font-medium text-gray-700"> Name </label>

            <input
              type="text"
              id="name"
              name="name"
              class="mt-1 w-full rounded p-2 outline-none border bg-white text-sm text-gray-700 shadow-sm"
            />
          </div>
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
            <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>

            <input
              type="password"
              id="password"
              name="password"
              class="mt-1 w-full rounded p-2 outline-none border bg-white text-sm text-gray-700 shadow-sm"
            />
          </div>
        <div class="col-span-6">
            <label for="cpassword" class="block text-sm font-medium text-gray-700">Confirm Password </label>

            <input
              type="password"
              id="cpassword"
              name="cpassword"
              class="mt-1 w-full rounded p-2 outline-none border bg-white text-sm text-gray-700 shadow-sm"
            />
          </div>



          <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
          <button
              class="inline-block shrink-0 rounded-md border border-black bg-gray-800 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-black"
            >
              Create an account
            </button>

            <p class="mt-4 text-sm text-gray-500 sm:mt-0">
              Already have an account?
              <a href="login.php" class="text-gray-700 underline">Log in</a>.
            </p>
          </div>
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
            const cpassword = document.getElementById('cpassword').value.trim();
            const name = document.getElementById('name').value.trim();

            if (!email) {
                alert(`email cant't be empty!`);
                return false;
            }
            else if (!password) {
                alert(`password cant't be empty!`);
                return false;
            }
            else if (!cpassword) {
                alert(`confirm password cant't be empty!`);
                return false;
            }
            else if (!name) {
                alert(`confirm password cant't be empty!`);
                return false;
            }
            else if (password !== cpassword) {
                alert('Passwords do not match!');
                return false;
            }
            return true; 
        }
</script>
</html>