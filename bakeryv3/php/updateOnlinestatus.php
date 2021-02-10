<?php
session_start();
if ($_SESSION['login'] != 111) {
    header("Location: ../index.html");
  }
  

include 'connection.php';

    $sql = "SELECT * FROM bakeryuser where onlineStatus= 'ONLINE'";
    $result = $fpconnection->query($sql);
    
    if($result->num_rows > 0){
       $rowcount=mysqli_num_rows($result);
       $response = "<span style='color:green;'><b> Momentan User online: $rowcount</b></span>";   
    }
    else{
        header("Location: ../index.html");
        $response = " ";
    } 
    echo $response;
    exit;

?>
