<?php
require_once './config.php';
$username = $email = $pass = $cpass = "";
$file = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetching form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $data = "&username=$username&email=$email";
    $file = $_FILES['file'];

    // Form Validation
    if (empty($username) || empty($email) || empty($pass) || empty($cpass)) {
        $em = "InputAllFields";
        header("Location: ../index.php?error=$em&data=$data");
        die();
    }

    // Username Validation
    if (isset($username)) {
        $regex = '/^(?=.*[0-9])[a-zA-Z0-9]{3,}$/';
        if (!preg_match($regex, $username)) {
            $em = "UsernameNotValid";
            header("Location: ../index.php?error=$em&data=$data");
            die();
        }
    }

    // Email Validation
    if (isset($email)) {
        $regex = "/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/";
        if (!preg_match($regex, $email)) {
            $em = "InvalidEmail";
            header("Location: ../index.php?error=$em&data=$data");
            die();
        } else {
            // Check if email already exists
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $em = "EmailAlreadyRegistered";
                header("Location: ../index.php?error=$em&data=$data");
                die();
            }
        }
    }

    // Password Validation
    if (isset($pass)) {
        $regex = "/^(?=.*\d)[A-Za-z\d]{6,}$/";
        if (!preg_match($regex, $pass)) {
            $em = "InvalidPassword";
            header("Location: ../index.php?error=$em&data=$data");
            die();
        } elseif ($pass !== $cpass) {
            $em = "PasswordDoesn'tMatch";
            header("Location: ../index.php?error=$em&data=$data");
            die();
        } else {
        }
    }

    // File Upload and Validation
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $img_name = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $parts = explode('.', $img_name);
        $format = strtolower(end($parts));
        $allowed = ['jpg', 'jpeg'];

        if (in_array($format, $allowed)) {
            $img_new_name = "$username.$format";
            $upload_path = "../uploads/$img_new_name";

            if (move_uploaded_file($tmp_name, $upload_path)) {
                $sql = "INSERT INTO users (username, email, password, pp) VALUES (:username, :email, :pwd, :pp)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pwd', $pass);
                $stmt->bindParam(':pp', $img_new_name);
                $result = $stmt->execute();

                if ($result) {
                    header("Location: ./login.php?success=AccountCreated");
                    exit();
                }
            } else {
                $em = "FailedUploadImage";
                header("Location: ../index.php?error=$em&data=$data");
                die();
            }
        } else {
            $em = "UnsupportedFileFormat";
            header("Location: ../index.php?error=$em&data=$data");
            die();
        }
    } else {
        // Handle case with no file upload
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :pwd)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $pass);
        $result = $stmt->execute();

        if ($result) {
            header("Location: ./login.php?success=AccountCreated");
            exit();
        }
    }
}
?>
