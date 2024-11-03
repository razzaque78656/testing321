<?php
$username = $email = "";
if(isset($_GET['data'])){
    $username = $_GET['username'];
    $email = $_GET['email'];

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./includes/alert.js" defer></script>
    <link rel="shortcut icon" href="./includes/assets/download (2).png" type="image/x-icon/png">
  <link rel="manifest" href="manifest.json">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container mx-auto flex max-w-4xl shadow-lg rounded-lg overflow-hidden">
        <!-- Left Side: Form -->
        <div class="w-1/2 p-8 bg-white">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Create an Account</h2>
            <form action="./includes/signup.php" method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500"
                           placeholder="Username" value="<?php echo $username ?>">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" placeholder="Email" value="<?php echo $email ?>">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="pass" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" placeholder="Password">
                </div>
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="confirm-password" name="cpass" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" placeholder="Confirm Password">
                </div>
                <div>
                    <label for="Profile Picture" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="file" id="confirm-password" name="file" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    Sign Up
                </button>
                <p class="mt-4 text-center text-gray-600">
                    Already have an account? <a href="./includes/login.php" class="text-blue-600 hover:underline">Log in</a>
                </p>
            </form>
        </div>
        <!-- Right Side: Image -->
        <div class="w-1/2 hidden md:flex items-center justify-center bg-blue-500">
            <img src="./includes/assets/main_img.png" alt="Signup Image" class="rounded-lg shadow-lg">
        </div>
    </div>

    <script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker
        .register('/projects/Password_Manager_Project/sw.js')
        .then((registration) => {
          console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch((error) => {
          console.error('Service Worker registration failed:', error);
        });
    });
  }
</script>
</body>
</html>
