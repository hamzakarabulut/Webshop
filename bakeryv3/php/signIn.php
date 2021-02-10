<script src="../javaScript/jquery-3.min.js"></script>
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

$sFirstname = "";
$sSurname = "";
$sUsername = "";
$sEmail = "";
$bRegistrationSuccess = false;

if (isset($_POST['firstName'])) {
  $sFirstname = $_POST['firstName'];
}
if (isset($_POST['surname'])) {
  $sSurname = $_POST['surname'];
}
if (isset($_POST['email'])) {
  $sEmail = $_POST['email'];
}
if (isset($_POST['userName'])) {
  $sUsername = $_POST['userName'];
}

if ($sEmail == "" || $sFirstname == "" || $sSurname == "" || $sUsername == "") {
  echo "So geht das nicht!";
} else {
  $bRegistrationSuccess = true;
}

if ($bRegistrationSuccess) {
  try {
    include 'connection.php';


    //RANDOM PASSWORD
    function random_password($length)
    {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!-.[]?*()';
      $password = '';
      $characterListLength = mb_strlen($characters, '8bit') - 1;
      foreach (range(1, $length) as $i) {
        $password .= $characters[random_int(0, $characterListLength)];
      }
      return $password;
    }


    $sql = "SELECT * FROM bakeryuser where email ='$sEmail' OR userName='$sUsername'";
    $result = $fpconnection->query($sql);

    if ($result && $result->num_rows > 0) {

      $sql = "SELECT * FROM bakeryuser where email ='$sEmail'";
      $result3 = $fpconnection->query($sql);
      if ($result3 && $result3->num_rows > 0) {


        // not nötig

        echo '    <script type="text/javascript">
              alert("Es existiert breits ein Konto unter dieser E-Mail-Adresse. Bitte versuchen Sie es erneut.");
              window.location.href = "../signIn.html";
            </script>';
      } else {
?>
        <script type="text/javascript" src="../javaScript/jquery-2.1.4.min.js">
          alert("Der Benutzername ist bereits vergeben. Bitte versuchen Sie es erneut.");
          window.location.href = "../signIn.html";
        </script>
  <?php
      }
    } else {
      //random and hashed password
      $password = random_password(8);
      $hashedPassword = hash('sha512', $password);
      $sql2 = "INSERT INTO bakeryuser(userName,firstName,surname,email,password) VALUES
          ('$sUsername','$sFirstname','$sSurname','$sEmail', '$hashedPassword')";
      $result2 = $fpconnection->query($sql2);

      //SEND MAIL
      $mail = new PHPMailer(true);

      try {
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through -> Server simulator mailtrap.io (https://mailtrap.io/)
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = '4ef654e0958d80';                     // SMTP username
        $mail->Password   = '13d057c496dae3';                               // SMTP password
        $mail->SMTPSecure =  'tls';                               // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged PHPMailer::ENCRYPTION_STARTTLS;    
        $mail->Port       = 2525;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('info@mailtrap.io', 'Mailtrap');
        $mail->addAddress($sEmail, $sUsername);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Ihre Registrierung im KMG-Shop';
        $mailContent = "
            <style type='text/css'>
             p{font-family:Arial, Helvetica, sans-serif;}
            </style>
            <p>Sehr geehrte/r <b>$sUsername</b>,</br> <br>
            Wir freuen uns Sie in unserem Shop willkommen zu heissen!! <br>
            Zum Best&auml;tigen Ihrer Regsitrierung m&uuml;ssen Sie sich mit unserem vorgegebenen Passwort <a href='http://localhost/bakery-son/firstLogin.html'>anmelden</a> <br>
            und ein neues Passwort setzen. <br>
            Ihr Passwort f&uuml;r den ersten Login lautet: <b>$password</b></br><br>
            Ihr KMG-Team";
        $mail->Body = $mailContent;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        ?>
        <script type="text/javascript">
          alert("Sie wurden erfolgreich registriert. Aktualisieren Sie Ihr Passwort aus der Mail.");
          window.location.href = "../firstLogin.html";
        </script>
        <?php
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }

    mysqli_close($fpconnection);
  } catch (Exception $e) {
    echo "Fehler beim verbinden der Datenbank";
  }
}

?>