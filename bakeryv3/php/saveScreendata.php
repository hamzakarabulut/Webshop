<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}
$screenWidth="";
$screenHeight="";
$user_id = $_SESSION['UId'];
if(isset($_POST['screenWidth'])){
    $screenWidth=$_POST['screenWidth'];
}
if(isset($_POST['screenHeight'])){
    $screenHeight=$_POST['screenHeight'];
}
	include 'connection.php';
    

    mysqli_query($fpconnection, "UPDATE bakeryuser SET screenWidth = '$screenWidth' WHERE userId = '$user_id'");
    mysqli_query($fpconnection, "UPDATE bakeryuser SET screenHeight = '$screenHeight' WHERE userId = '$user_id'");

    exit;
    
?>