<?php
session_start();
require_once "./config.php";
$username = $password = $em = $data =$name = $user_id= $email = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['email'];
    $password = $_POST['pass'];

    $data = "user=$username&pass=$password";

if($username != "" || $password != ""){
    $sql = "Select * from users where email=?";
    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(":email",$username);
    $result = $stmt->execute([$username]);
    if($stmt->rowCount() > 0){
        $user = $stmt->fetch();
        $userpass = $user['password'];
        $user_id = $user['id'];

            if(password_verify($password,$userpass)){

                $_SESSION['loggedIn'] = "true";
                $_SESSION['userID'] = $user_id;

                // setcookie("UserID", $user_id, time()+(86400 * 30), "/");
                
                setcookie("LoggedIn","true.$user_id",time()+ (86400 * 30),"/");

                // sleep(2);
                
                print_r($_SESSION);
                    header("Location:./mainpage.php?success=LoggedIn");
            }else {
                $em = "IncorrectPass";
                header("Location:./login.php?error=$em&$data");

            }
    }else {
        
        $em = "InvalidUserPass";
        header("Location:./login.php?error=$em&$data");

    }

    }else {
        $em = "InputAllFields";
        header("Location:./login.php?error=$em");

    }
}