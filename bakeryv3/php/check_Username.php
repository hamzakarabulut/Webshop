<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}
$sUsername="";
if(isset($_POST['userName'])){
    $sUsername=$_POST['userName'];
}
	include 'connection.php';

    $sql = "SELECT * FROM bakeryuser where userName='$sUsername'";
    $result = $fpconnection->query($sql);
    
    if($result->num_rows > 0){
       $response = "<span style='color:red;'> Not available.</span>";   
    }else{
    $response = "";
    } 
    echo $response;
    exit;
?>