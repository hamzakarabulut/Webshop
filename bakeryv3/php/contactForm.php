<?php

session_start();

if ($_SESSION['login'] != 111) {
  //logout
  header("Location: ../index.html");
  
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$sName="";
$sEmail="";
$sBetreff="";
$sNachricht="";
$bEmailSuccess=false;

if(isset($_POST['name'])){
    $sName=$_POST['name'];
}
if(isset($_POST['betreff'])){
    $sBetreff=$_POST['betreff'];
}
if(isset($_POST['email'])){
    $sEmail=$_POST['email'];
}
if(isset($_POST['nachricht'])){
    $sNachricht=$_POST['nachricht'];
}

if($sEmail=="" || $sBetreff=="" ){
   echo "So geht das nicht!";
 }
 else{
   $bEmailSuccess=true;
}

if($bEmailSuccess){
    try{
        include 'connection.php';

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
            $mail->setFrom($sEmail, $sName);
            $mail->addAddress('info@mailtrap.io','Mailtrap' );     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $sBetreff;
            $mailContent = $sNachricht;
            $mail->Body = $mailContent;
            $mail->AltBody = $sNachricht;

            $mail->send();

            echo " <script type='text/javascript'>
            alert('Ihre Nachricht wurde versendet');
            window.location.href = '../home.html'; </script> ";
             
           
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

      mysqli_close($fpconnection);
    }catch(Exception $e){
        echo "Fehler beim verbinden der Datenbank";
    }

}
?>