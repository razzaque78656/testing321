<?php
$username = $pass = "";
if(isset($_GET['user'])){
    $username = $_GET['user'];
    $pass = $_GET['pass'];

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="shortcut icon" href="./assets/download (2).png" type="image/x-icon/png">


    <script src="./alert.js" defer></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
        
        <!-- Login Form Section -->
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-2xl font-bold text-gray-800">Signin</h2>
            <form action="./loginChecker.php" method="post" class="mt-4">
                <div class="mb-4">
                    <label class="block text-gray-600">Email</label>
                    <input type="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" name="email" value="<?php echo $username; ?>" placeholder="Email">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600">Password</label>
                    <input type="text" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" name="pass" value="<?php echo $pass;?>" placeholder="Password">
                </div>
                <button class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition duration-300">Sign in</button>
            </form>

            <!-- Social Login -->
            <div class="mt-6 text-center">
                <p class="text-gray-500">or sign in with</p>
                <div class="flex justify-center mt-4">
                    <a href="#" class="mx-2 p-3 border rounded-full text-blue-600 hover:bg-blue-100"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="#" class="mx-2 p-3 border rounded-full text-red-500 hover:bg-red-100"><i class="fab fa-google"></i> Google</a>
                    <a href="#" class="mx-2 p-3 border rounded-full text-blue-400 hover:bg-blue-100"><i class="fab fa-twitter"></i> Twitter</a>
                </div>
            </div>
        </div>

        <!-- Welcome Message Section -->
        <div class="w-full md:w-1/2 bg-green-500 text-white p-8 flex flex-col items-center justify-center">
            <h2 class="text-3xl font-bold">Welcome back!</h2>
            <p class="mt-4 text-center">We are so happy to have you here. It’s great to see you again. We hope you had a safe and enjoyable time away.</p>
            <p class="mt-4">No account yet? <a href="../" class="underline">Signup</a></p>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
