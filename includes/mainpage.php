<?php
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    header("Location: ./login.php");
    die();
}
require_once './config.php';
require_once './userfetch.php';
require_once './validate.php';

// Fetching all passwords of users
$user_id = $_SESSION['userID'];
$result = userfetch($conn, $user_id);

// Fetch user details for profile display
$user_details = getUserDetails($conn, $user_id); // Function to fetch user details (name and image)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="./main.js" defer></script>
    <link rel="icon" href="./assets/download (2).png" type="image/png">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="./assets/download (2).png" alt="Logo" class="h-12 w-12 mr-3">
                <h1 class="text-2xl font-semibold text-gray-800">Password Manager</h1>
            </div>
            <div class="flex items-center space-x-4">
                <!-- User Profile Area -->
                <div class="flex items-center">
                    <img src="<?php //echo htmlspecialchars($user_details['profile_image']); ?>" alt="Profile Image" class="h-10 w-10 rounded-full mr-2">
                    <span class="text-gray-800 font-semibold"><?php echo htmlspecialchars($user_details['username']); ?></span>
                </div>
                <a href="./logout.php">
                    <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                        Logout
                    </button>
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Manage Your Passwords</h2>
            <div class="flex space-x-4">
                <button onclick="addModal()" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                    + Add New Record
                </button>
                <a href="./generate_pass.php">
                    <button class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                        Generate Random Password
                    </button>
                </a>
                <form action="./validate.php" method="POST">
                    <button type="submit" name="delete_all" value="<?php echo $user_id ?>" class="bg-red-500 text-white py-2 px-6 rounded-md hover:bg-red-600 transition">
                        Delete All Users
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase">Website</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase">Username</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase">Passwords</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result) { ?>
                        <?php foreach ($result as $data) { ?>
                            <tr class="border-b">
                                <td class="px-6 py-4 text-gray-700"><?php echo htmlspecialchars($data['web_name']); ?></td>
                                <td class="px-6 py-4 text-gray-700"><?php echo htmlspecialchars($data['name']); ?></td>
                                <td class="px-6 py-4 text-gray-700 cursor-pointer copyable">
                                    <span style="margin-right: 5px;" title="Click to Copy to Clipboard">📋</span>
                                    <span onclick="copyToClipboard(this)"><?php echo htmlspecialchars($data['pwd']); ?></span>
                                </td>
                                <td class="px-6 py-4 flex space-x-4">
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition edit-button"
                                            onclick="openUpdateModal( <?php echo $data['id']; ?>, '<?php echo addslashes($data['name']); ?>', '<?php echo addslashes($data['pwd']); ?>')">
                                        Edit
                                    </button>
                                    <form action="./validate.php?delete=true" method="post">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <input type="hidden" name="record_id" value="<?php echo $data['id']; ?>">
                                        <button name="delete" type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition delete-button">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="text-center p-4">
                                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg">
                                    <p class="font-semibold">No Users Found!</p>
                                    <p class="mt-1">Please click the button below to add a new record.</p>
                                    <button onclick="addModal()" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                        + Add New Record
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4 mt-auto">
        <p>&copy; 2024 Password Manager. All rights reserved.</p>
    </footer>

    <!-- Add New Record Modal -->
    <div id="addModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-80 transform transition-all duration-300 scale-90 opacity-0 modal-content">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Add New Record</h2>
            <form action="./validate.php?add=true" method="POST">
                <div class="mb-4">
                    <label for="addUsername" class="block text-sm font-medium text-gray-700 mb-1">Website Name</label>
                    <input type="text" id="addUsername" name="webName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter website Name">
                </div>
                <div class="mb-4">
                    <label for="addUsername" class="block text-sm font-medium text-gray-700 mb-1">Website Name</label>
                    <input type="text" id="addUsername" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Username">
                </div>
                <div class="mb-6">
                    <label for="addPassword" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="addPassword" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter password">
                </div>
                <button type="submit" value="<?php echo $user_id ?>" name="add_record" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold">Add Record</button>
            </form>
            <button onclick="closeModal('addModal')" class="mt-4 w-full bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-300 font-semibold">Close</button>
        </div>
    </div>

    <!-- Update Record Modal -->
    <div id="updateModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-80 transform transition-all duration-300 scale-90 opacity-0 modal-content">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Update Record</h2>
            <form action="./validate.php?update=true" method="POST">
                <div class="mb-4">
                    <label for="updateUsername" class="block text-sm font-medium text-gray-700 mb-1">Website Name</label>
                    <input type="text" id="updateUsername" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter name">
                </div>
                <div class="mb-6">
                    <label for="updatePassword" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="updatePassword" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter password">
                </div>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="update_record" value="true">
                <input type="hidden" id="recordId" name="record_id" value="<?php echo $data['id']?>">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold">Update Record</button>
            </form>
            <button onclick="closeModal('updateModal')" class="mt-4 w-full bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-300 font-semibold">Close</button>
        </div>
    </div>
</body>
</html>
