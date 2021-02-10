<?php
session_start();
include 'connection.php';

$sUserId = $_SESSION['UId'];

$sLastActivity = date("Y-m-d H:i:s");
mysqli_query($fpconnection, "UPDATE bakeryuser SET lastActivity = '$sLastActivity' WHERE userId = '$sUserId'");
mysqli_query($fpconnection, "UPDATE bakeryuser SET onlineStatus = 'OFFLINE' WHERE userId = '$sUserId'");
session_destroy();
header("location:../index.html");
?>