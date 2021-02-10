<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}
$sEmail="";
if(isset($_POST['email'])){
    $sEmail=$_POST['email'];
}

    include 'connection.php';

    $sql = "SELECT * FROM bakeryuser where email='$sEmail'";
    $result = $fpconnection->query($sql);
    
    if($result->num_rows > 0){
       $response = "<span style='color:red;'> Es existiert bereits ein Konto mit dieser E-Mail-Adresse</span>";   
    }else{
    $response = "";
    } 
    echo $response;
    exit;
?>