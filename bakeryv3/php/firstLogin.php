<?php
  session_start();
  if (!isset($_SESSION['login']) || $_SESSION['login'] != 111) {
    //logout
    header("Location: ../index.html");
  }

  date_default_timezone_set('UTC');

$sEmail="";
$sPassword="";
$sNewPassword="";
$bRegistrationSuccess=false;

if(isset($_POST['hashedPassword'])){
    $sPassword=$_POST['hashedPassword'];
}
if(isset($_POST['hashedPasswordNew'])){
    $sNewPassword=$_POST['hashedPasswordNew'];
}
if(isset($_POST['hashedPasswordConfirm'])){
  $sNewPasswordConfirm=$_POST['hashedPasswordConfirm'];
}
if(isset($_POST['email'])){
    $sEmail=$_POST['email'];
}
if($sEmail=="" || $sPassword==""|| $sNewPassword=="" ){
  echo "So geht das nicht!";
}
if($sNewPassword != $sNewPasswordConfirm)
{  echo "<script>
  alert('Passwörter stimmen nicht überein');
  window.location.href = '../firstLogin.html';
  </script>";
}else{
  $bRegistrationSuccess=true;
}


if($bRegistrationSuccess=true){

    try{
	    include 'connection.php';
   
	  
        $sql = "SELECT * FROM bakeryuser where email ='$sEmail' AND password='$sPassword'";
        $result = $fpconnection->query($sql);
       
      while($row = $result->fetch_assoc()){
  
        $_SESSION['UId'] = $row["userId"];
        $_SESSION['userNm'] = $row["userName"];
        $_SESSION['mail'] = $row["email"];
        $_SESSION['login'] = 111;
            //einlogzeit user
        $_SESSION['zeit'] = time();
      }
        
        if($result && $result->num_rows > 0)
        { 
          
          mysqli_query($fpconnection, "UPDATE bakeryuser SET password = '$sNewPassword' WHERE email = '$sEmail' AND password='$sPassword'");
          echo "<script>
                 alert('Bestätigung der Registrierung war erfolgreich.');
                 window.location.href = '../index.html';
                 </script>";
        } else{
          echo "<script>
                alert('Username oder Passwort falsch! Bitte versuchen sie es nochmal.');
                window.location.href='../firstLogin.html';
                </script>";          
        }

        mysqli_close($fpconnection);
    }
    catch(Exception $e){
        echo "Fehler beim verbinden der Datenbank";
    }
}
?>

