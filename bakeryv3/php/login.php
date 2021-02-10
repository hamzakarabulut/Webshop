<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}
	
    if ($_SESSION['login'] != 111) {
        //logout
        header("Location: ../index.html");
    }
	

    $sEmail="";
    $sPassword="";
    $sLastLogin="";
    $bLoginSuccess = false;
    $bEmailAndPassword = false;

    $alert = false;
    $alert_message = false;

      // //Sind POST Werte vorhanden?
     if(isset($_POST['email'])){
         $sEmail=$_POST['email'];
     }
     if(isset($_POST['hashedPassword'])){
         $sPassword=$_POST['hashedPassword'];
     }
    if(isset($_POST['lastLogin'])){
        $sLastLogin=$_POST['lastLogin'];
    }

     if($sEmail=="" || $sPassword==""){
         echo "So geht das nicht!";
     }
     else{
         $bEmailAndPassword=true;
     }

     if($bEmailAndPassword){
            try{
                include 'connection.php';
				
                
                $sql = "SELECT * from bakeryuser where email='$sEmail' and password='$sPassword'";
                $result = $fpconnection->query($sql);
                
                if($result && $result->num_rows > 0){

                     while($row = $result->fetch_assoc()){
                               //Werte in Sesssion speichern
                             $_SESSION['UId'] = $row["userId"];
                             $_SESSION['userNm'] = $row["userName"];
                             $_SESSION['mail'] = $row["email"];
                             $_SESSION['lastLoginTime'] = $row["lastLogin"];
                             $_SESSION['lastActivity'] = $row["lastActivity"];
                             $_SESSION['login'] = 111;
                                 //einlogzeit user
                             $_SESSION['zeit'] = time();
                     }
               
                    $sLastLogin = date("Y-m-d H:i:s");
                    $sLastActivity = date("Y-m-d H:i:s");
                    mysqli_query($fpconnection, "UPDATE bakeryuser SET lastLogin = '$sLastLogin' WHERE email = '$sEmail'");
                    mysqli_query($fpconnection, "UPDATE bakeryuser SET lastActivity = '$sLastActivity' WHERE email = '$sEmail'");
                    mysqli_query($fpconnection, "UPDATE bakeryuser SET onlineStatus = 'ONLINE' WHERE email = '$sEmail'");
                    $bLoginSuccess = true;
                    
            
                }else{
                echo '<script type="text/javascript">
                            alert("Email oder Passwort ist falsch");
                            window.location.href = "../index.html";
                        </script>';
                }
                 
                mysqli_close($fpconnection);
            }catch(Exception $e){
                 echo "Fehler beim verbinden der Datenbank";
            }
           
            if($bLoginSuccess){
                header("Location: welcome.php");
            } 
        }    
?>

