<?php
  session_start();
  include 'connection.php';
  /*
  if ($_SESSION['login'] != 111) {
    //logout
    header("Location: ../index.html");
  }
  */

  //zur kontrolle
  //echo var_dump($_POST);
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
    
  require '../PHPMailer/src/Exception.php';
  require '../PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/src/SMTP.php';

$sEmail="";
$bRegistrationSuccess=false;
// $sSessionUserId = $_SESSION['uid'];


if(isset($_POST['email'])){
    $sEmail=$_POST['email'];
}
if($sEmail==""){
  echo "So geht das nicht!";
}
else{
  $bRegistrationSuccess=true;
}


if($bRegistrationSuccess=true){

    try{
	  

        //RANDOM PASSWORD
        function random_password($length){
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!-.[]?*()';
          $password = '';
          $characterListLength = mb_strlen($characters, '8bit') - 1;
          foreach(range(1, $length) as $i){
            $password .= $characters[random_int(0, $characterListLength)];
          }
          return $password;
        }

        $sql = "SELECT * FROM bakeryuser where email ='$sEmail'";
        $result = $fpconnection->query($sql);
        
        if($result && $result->num_rows > 0){
          while($row = $result->fetch_assoc()){
            $_SESSION['UId'] = $row["userId"];
            $_SESSION['userNm'] = $row["userName"];
            $_SESSION['mail'] = $row["email"];
            $_SESSION['login'] = 111;
          }

          $password = random_password(8);
          $hashedPassword = hash('sha512', $password);
          mysqli_query($fpconnection, "UPDATE bakeryuser SET password = '$hashedPassword' WHERE email = '$sEmail'");

          //SEND MAIL
          $mail = new PHPMailer(true);

          try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = '4ef654e0958d80';                     // SMTP username
            $mail->Password   = '13d057c496dae3';                               // SMTP password
            $mail->SMTPSecure =  'tls';    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged PHPMailer::ENCRYPTION_STARTTLS;    
            $mail->Port       = 2525;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('info@mailtrap.io', 'Mailtrap');
            $mail->addAddress($sEmail);     // Add a recipient    
            //$mail->addCC('cc1@example.com', 'Elena');
            //$mail->addBCC('bcc1@example.com', 'Alex');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Ihre neuen Zugangsdaten im KMG-Shop';
            //MAYBE TO DO USERNAME GET
            $mailContent = "Wir haben Ihre Anfrage zum <a href='http://localhost/bakery/firstLogin.html'>Zur&uuml;cksetzen</a> Ihres Passwortes entgegengenommen.<br>
            Ihr Passwort f&uuml;r den erneuten Login lautet: <b>$password</b></br><br>
            Ihr KMG-Team";
            $mail->Body = $mailContent;
            //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo "<script>
                  alert('E-Mail wurde versandt. Sie werden zum erneuten Login weitergeleitet.');
                  window.location.href='../firstLogin.html';
                  </script>";  
          } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }

        } else{
          echo "<script>
                alert('Ein Konto mit dieser E-Mail-Adresse existiert nicht. Bitte versuchen sie es nochmal.');
                window.location.href='../reset-password.html';
                </script>";          
        }
        mysqli_close($fpconnection);
    }
    catch(Exception $e){
        echo "Fehler beim verbinden der Datenbank";
    }
}
?>
