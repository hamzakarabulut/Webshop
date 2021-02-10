<?php
session_start();
if ($_SESSION['login'] != 111) {
    header("Location: ../index.html");
  }
  

include 'connection.php';
$sLastActivity=$_SESSION['lastActivity'];
$user_id =$_SESSION['UId'];
mysqli_query($fpconnection, "UPDATE bakeryuser SET lastActivity = '$sLastActivity' WHERE userId = '$user_id'");

    //autologout if tab is closed instead of proper logout
    $user_id = $_SESSION['UId'];
    $vorFunfMin = strtotime("-10 minute");
      
     $sLastActivity5 = date("Y-m-d H:i:s", $vorFunfMin);
     $result = mysqli_query($fpconnection, "UPDATE bakeryuser SET onlineStatus= 'OFFLINE' WHERE lastActivity < '$sLastActivity5'");
   
     $query = "SELECT * FROM bakeryuser WHERE onlineStatus = 'OFFLINE' WHERE userId ='$user_id'";
     $results = $fpconnection->query($query);
     if($results){
        session_destroy();
        header("location:../index.html");
    }


exit;

?>