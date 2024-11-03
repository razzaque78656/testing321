<!-- PHP COde is Here ! -->

<?php
$rand_pass = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn'])) {
    $upper_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lower_chars = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $symbols = '!@#$%^&*()_+~`|}{[]:;?><,./-=';

    // Shuffle character strings
    $upper_chars = str_shuffle($upper_chars);
    $lower_chars = str_shuffle($lower_chars);
    $numbers = str_shuffle($numbers);
    $symbols = str_shuffle($symbols);

    // Get password length and inclusion of symbols from form
    $password_length = isset($_POST['passwordLength']) ? (int)$_POST['passwordLength'] : 12;
    $include_symbols = isset($_POST['includeSymbols']);

    // Initialize the base character pool without symbols by default
    $base_chars = substr($upper_chars, 0, $password_length / 3) .
                  substr($lower_chars, 0, $password_length / 3) .
                  substr($numbers, 0, $password_length / 3);

    // Add symbols to the pool if checkbox is selected
    if ($include_symbols) {
        $base_chars .= substr($symbols, 0, ceil($password_length / 4));
    }

    // Shuffle base characters and trim to the exact desired length
    $rand_pass = str_shuffle($base_chars);
    $rand_pass = substr($rand_pass, 0, $password_length);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
    <link rel="icon" href="./assets/download (2).png" type="image/png">

</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Generate Password</h2>
        
        <!-- Password Generation Form -->
        <form action="" method="POST">
            <!-- Password Display -->
            <div class="relative mb-4">
                <input type="text" id="generatedPassword"  value="<?php if(isset($rand_pass)){echo $rand_pass;} ?>" name="generatedPassword" readonly 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-800 font-mono text-lg"
                       placeholder="Your secure password will appear here" />
                <button type="button" onclick="copyPassword()" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-700">
                    Copy
                </button>
            </div>

            <!-- Password Length Slider -->
            <div class="mb-4">
                <label for="passwordLength"  class="text-sm font-medium text-gray-700">Password Length: <span id="passwordLengthDisplay">8</span></label>
                <input type="range" id="passwordLength" name="passwordLength" min="6" max="20" value="8" class="w-full"
                       oninput="document.getElementById('passwordLengthDisplay').textContent = this.value">
            </div>

            <!-- Include Symbols Checkbox -->
            <div class="flex items-center mb-6">
                <input type="checkbox" id="includeSymbols" name="includeSymbols"  class="mr-2" />
                <label for="includeSymbols" class="text-sm text-gray-700">Include Symbols</label>
            </div>

            <!-- Generate Password Button -->
            <button type="submit" name="btn"
                    class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-200 mb-4">
                Generate Password
            </button>

            <!-- Go Back Button -->
             <a href="./mainpage.php">

                 <button type="button"  
                 class="w-full py-2 px-4 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition duration-200">
                 Go Back
                </button>
            </a>
        </form>
    </div>

    <script>
        function copyPassword() {
    const passwordField = document.getElementById('generatedPassword');
    
    // Use navigator.clipboard.writeText to copy the password
    navigator.clipboard.writeText(passwordField.value).then(() => {
        // Display success alert with SweetAlert2
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Password copied to clipboard!',
            showConfirmButton: false,
            timer: 1500 // Auto close after 1.5 seconds
        });
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}

    </script>
</body>
</html>

