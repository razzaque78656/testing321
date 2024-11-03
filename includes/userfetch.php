<?php
$result = "";
function userfetch($conn,$user_id){
    $sql = "Select * from pwds where user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll();

    if($stmt->rowCount() > 0){
        return $result;
    }else {
        return false;

    }

    // Add Data to DB Fucntion
    function name(){

    }
}

function getUserDetails($conn, $user_id){

    $sql = "Select * from users where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $result = $stmt->fetch();
    return $result;
}