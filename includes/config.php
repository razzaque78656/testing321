<?php
$host = 'sql312.infinityfree.com';
$dbname = 'if0_37632321_Pass_Manage_db';
$username = 'if0_37632321';
$password = '59K2hIoxXrzHTI';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
