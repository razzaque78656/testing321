<?php
session_start();

unset( $_SESSION['loggedIn']);
header("Location: ./login.php");
session_destroy();
// setcookie("UserID", "", time() - 3600, "/");  // Expire the UserID cookie
setcookie("LoggedIn", "", time() - 3600, "/");
exit();