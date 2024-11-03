<?php
require_once "./config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check for deletion
    if (isset($_POST['add_record'])) {
        // Add record logic
        $name = htmlspecialchars($_POST['name']); 
        $pass = htmlspecialchars($_POST['password']); 
        $user_id = $_POST['add_record'];
        $webName = htmlspecialchars($_POST['webName']);

        if ($name == "" || $pass == "") {
            $error = "Input cannot be Empty";
            header("Location: mainpage.php?error=$error");
            exit();
        }

        // Checking for existing records
        
        $sql = "SELECT * FROM pwds WHERE name=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name,$user_id]);
        if ($stmt->rowCount() > 0) {
            header("Location: ./mainpage.php?alert=UserAlreadyExists");
            exit();
        }

        // Inserting the new record
        $sql = "INSERT INTO pwds (user_id, name, pwd,web_name) VALUES (?, ?, ?,?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$user_id, $name, $pass,$webName])) {
            header("Location: ./mainpage.php?success=RecordCreated");
            exit();
        } else {
            header("Location: ./mainpage.php?alert=RecordNotCreated");
            exit();
        }
    }

    // Check for update
    if (isset($_POST['update_record'])) {
        // Update record logic here
        $record_id = htmlspecialchars($_POST['record_id']);
        $name = htmlspecialchars($_POST['name']); 
        $pass = htmlspecialchars($_POST['password']); 

        // Update query here
        $sql = "UPDATE pwds SET name=?, pwd=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$name, $pass, $record_id])) {
            header("Location: ./mainpage.php?success=RecordUpdated");
            exit();
        } else {
            header("Location: ./mainpage.php?alert=RecordNotUpdated");
            exit();
        }
    }

    // Check for Deleteting Any one Specific
    if (isset($_POST['delete']) || isset($_GET['delete'])) {
        // Update record logic here
        $user_id = htmlspecialchars($_POST['user_id']);
        $record_id = htmlspecialchars($_POST['record_id']); 

        // Update query here
        $sql = "DELETE FROM `pwds` WHERE id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$record_id,$user_id])) {
            header("Location: ./mainpage.php?deleted=true");
            exit();
        } else {
            header("Location: ./mainpage.php?deleted=false");
            exit();
        }
    }
    // Deleting All users
    if (isset($_POST['delete_all'])) {
        // Update record logic here
        $user_id = htmlspecialchars($_POST['delete_all']); 

        // Update query here
        $sql = "DELETE  FROM `pwds` WHERE  user_id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$user_id])) {
            header("Location: ./mainpage.php?deleted=true");
            exit();
        } else {
            header("Location: ./mainpage.php?deleted=false");
            exit();
        }
    }
}


?>