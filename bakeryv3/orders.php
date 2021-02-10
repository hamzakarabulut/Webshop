<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}

require 'php/connection.php';
require 'php/functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Login kontrol
if (!isset($_SESSION['login']) || $_SESSION['login'] != 111) {
  header('Location: index.html');
}

// get user id
$user_id = $_SESSION['UId'];





$user = getUser($user_id);

$alert = false;
$alert_message = false;

if (isset($_GET["action"])) {

  if ($_GET["action"] == "one-click-buy") {
    $order_id = $_GET['id'];

    $eski_sip_bilgileri = getOrder($order_id);

    $alert = true;

    $yeniSiparisId = addOrder($user_id, $eski_sip_bilgileri["shipment_type"], $eski_sip_bilgileri["total"], $eski_sip_bilgileri["shipment"], $eski_sip_bilgileri["adress"], $eski_sip_bilgileri["tel"], $eski_sip_bilgileri["order_date"]);

    if ($yeniSiparisId) {

      $siparis_urunler = getOrderedProducts($eski_sip_bilgileri["id"]);
      while ($row = $siparis_urunler->fetch_assoc()) {
        addProductsToOrder($yeniSiparisId, $row["artikel_id"], $row["quantity"]);
      }



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
        $mail->addAddress($user['email'], $_SESSION['userNm']);     // Add a recipient
        $mail->addBCC('bcc1@example.com', 'Alex');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Ihre Bestellung';

        $result3 = getOrder($order_id);
        $sAddress = $result3["adress"];
        $sTel = $result3["tel"];
        $sOrderDate = date("d.m.Y");
        $sShipmenttype = $result3["shipment_type"];
        $sShipmentAmount = $result3["shipment"];
        $total = $result3["total"];
        $sUsername = $_SESSION['userNm'];
        $mailContent = "
        <style type='text/css'>
         p{font-family:Arial, Helvetica, sans-serif;}
        </style>
        <p>Sehr geehrte/r <b>$sUsername</b>,</br> <br>
        Vielen Dank f&uuml;r Ihre Bestellung in unserem Shop!<br><br>
        <hr>
        <b>Bestellinfos</b><br>
        Versandart: $sShipmenttype <br>
        Telefon: $sTel <br>
        Adresse: $sAddress <br>
        Bestelldatum: $sOrderDate<br><br>
       
        <b>Ihre Bestellung:</b><br><br>
        
        <table id='mytable' class='table table-bordred table-striped'>
          <tr>
            <th>Artikelmenge</th>
            <th>Artikel</th>
            <th>Preis (Stk)</th>
          </tr";

        $result3 = getOrder($order_id);
        $products = getOrderedProducts($order_id);
        while ($row = $products->fetch_assoc()) {

          $artikelid = $row["artikel_id"];
          $result2 = getProduct($artikelid);
          $artikelqty = $row["quantity"];

          $price = $result2["product_price"];
          $name = $result2["product_name"];
          $mailContent .= "   <tr>
                                    <td>$artikelqty</td>
                                    <td>$name</td>
                                    <td>$price&euro;</td>
                                </tr>";
        }

        $mailContent .= " <tr>
                              <td>Versandkosten</td>
                              <td></td>
                              <td>$sShipmentAmount&euro;</td>
                          </tr>
                           <tr>
                              <td>Gesamt</td>
                              <td></td>
                              <td>$total&euro;</td>
                          </tr>
        </table>
        <hr>
        Bei Fragen zur Bestellung oder &Auml;hnlichem schreiben Sie uns eine <a href='http://localhost/bakery-son/contactForm.html'>Mail</a>! <br><br>
        
        Ihr KMG-Team";;
        $mail->Body = $mailContent;
        //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }


      $alert_message = "Ihre Bestellung wurde gestellt";
    } else {
      echo  "one-click-buy Fehler ";
    }
  }
}


?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="css/global.css">
  <link href="fontawesome/css/font-awesome.css" rel="stylesheet" />
  <link href="fontawesome/css/font-awesome.css" rel="stylesheet" />
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="javaScript/jquery-2.1.4.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <title>HOME</title>
</head>

<?php
if ($alert) {
?>
  <script>
    $(document).ready(function() {
      swal("<?php echo $alert_message; ?>", "", "success");
    });
  </script>
<?php
}
?>

<body>

  <header>
    <div class="container_nav" id="navbar">
      <nav id="navbar">
        <ul>
          <li><img src="img/logoHatT.png" alt="logo" style="width: 30%; height:30%;"></li>
          <li><a href="home.html">Home</a></li>
        </ul>
      </nav>
      <nav>
        <ul>
          <li><a href="cake.php">Kuchen/Torten</a></li>
          <li><a href="muffin.php">Muffin</a></li>
          <li><a href="drinks.php">Getr&auml;nke</a></li>
        </ul>
      </nav>
      <nav id="navbar" class="space">
        <ul>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="fontawesome/svgs/solid/user-circle.svg" alt="account" width="20" height="20">
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="orders.php">Meine Bestellungen</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="php/logout.php">Logout</a>
            </div>
          </li>
          <li><a href="contactForm.html"><img src="fontawesome/svgs/solid/envelope.svg" alt="account" width="20" height="20"></a></li>
          <li><a href="cart.php"><img src="fontawesome/svgs/solid/shopping-cart.svg" alt="account" width="20" height="20"></a></li>
        </ul>
      </nav>
    </div>
  </header>



  <div class="container">
    <div class="row">


      <div class="col-md-12">
        <div class="table-responsive">


          <table id="mytable" class="table table-bordred table-striped">

            <thead>

              <th> Name</th>
              <th>Addresse</th>
              <th>Email</th>
              <th>Tel</th>
              <th>Shipment</th>
              <th>Total</th>
              <th>Buy-Click-Again</th>
            </thead>
            <tbody>
              <?php
              $result = getAllOrdersOfUser($user_id);
              while ($row = $result->fetch_assoc()) {
              ?>
                <tr>
                  <td><?php echo $user['firstName'] . " " . $user['surname']; ?></td>
                  <td><?php echo $row['adress']; ?></td>
                  <td><?php echo $user['email']; ?></td>
                  <td><?php echo $row['tel']; ?></td>
                  <td>
                    <?php
                    echo $row['shipment_type'];
                    ?>
                  </td>
                  <td><?php echo $row['total']; ?></td>
                  <td>
                    <a class="btn btn-primary btn-xs" href="orders.php?action=one-click-buy&id=<?php echo $row['id']; ?>">
                      <span class="glyphicon glyphicon-refresh"></span></a>
                  </td>
                </tr>


                <tr>
                  <td colspan=""> </td>
                  <td colspan="6">
                    <?php
                    $siparis_urunler = getOrderedProducts($row['id']);
                    while ($row_item = $siparis_urunler->fetch_assoc()) {
                      $urun_detay = getProduct($row_item['artikel_id']);
                    ?>
                      <?php echo $urun_detay['product_name'] . " (" . $row_item['quantity'] . ")"; ?></br>
                    <?php
                    }
                    ?>
                  </td>
                </tr>
              <?php
              }
              ?>









            </tbody>

          </table>


        </div>

      </div>
    </div>
  </div>




  <!--footer-->
  <footer style="transform: translateY(142%);">
    <div class="row" id="footerStyle" style="text-align: center; position:; bottom:0">

      <div class="col">
        <img src="img/logoTransperent.png" alt="logo" style="width: 50%; height:auto; padding-top: 8px; padding-bottom: 8px;">
      </div>

      <div class="col">
        <br><br>
        <b>
          <p>Recht und Datenschutz</p>
        </b>
        <ul>
          <li><a href="impressum.html">Impressum</a></li>
          <li><a href="Datensschutzaerklerung.html">Datenschutzerklärung</a></li>
          <li><a href="AGB.html">AGB</a></li>
          <li><a href="shipment.html">Zahlung und Versand</a></li>
        </ul>
      </div>

      <div class="col">
        <br><br>
        <b>
          <p>Bezahlarten</p>
        </b>
        <ul>
          <li><img src="fontawesome/svgs/brands/cc-visa.svg" alt="visa" width="8%" height="auto">
            <img src="fontawesome/svgs/brands/cc-discover.svg" alt="visa" width="8%" height="auto">
            <img src="fontawesome/svgs/brands/cc-mastercard.svg" alt="visa" width="8%" height="auto">
            <img src="fontawesome/svgs/brands/cc-amex.svg" alt="visa" width="8%" height="auto">
          </li>
        </ul>
        <b>
          <p>Social Media</p>
        </b>
        <ul>
          <li><a href="#"><img src="fontawesome/svgs/brands/instagram.svg" alt="instagram" width="7%" height="auto"></a>
            <a href="#"><img src="fontawesome/svgs/brands/facebook-square.svg" alt="facebook" width="7%" height="auto"></a>
            <a href="#"><img src="fontawesome/svgs/brands/twitter.svg" alt="twitter" width="7%" height="auto"></a>
          </li>
        </ul>
      </div>

      <div class="col">
        <br><br>
        <b>
          <p>Kugemu Bakery</p>
        </b>
        <ul>
          <li>Sitz der B&auml;ckerei</li>
          <li>Alteburgstra&szlig;e 150</li>
          <li>72762 Reutlingen</li>
          <li><a href="contactForm.html">Kontakt</a></li>
          <li><a href="php/welcome.php">Zur Begrü&szlig;ung</a></li>
          <li id="updateUser"></li>
        </ul>
      </div>
    </div>
  </footer>

  <script>
    function updateUserStatus() {
      <?php
      if ($_SESSION['login'] == '111') {
      ?>
        $.ajax({
          url: 'updateOnlinestatus.php',
          type: 'post',

          success: function(response) {
            // Show response
            $("#updateUser").html(response);
          }
        });
      <?php
      } ?>

    };

    updateUserStatus();

    setInterval(function() {
      updateUserStatus();
    }, 1000);



    function saveScreendata() {
      var screenWidth = screen.width;
      var screenHeight = screen.height;
      $.ajax({
        url: 'saveScreendata.php',
        type: 'post',
        data: {
          screenWidth: screenWidth,
          screenHeight: screenHeight
        }
      });
    };

    saveScreendata();


    //autologout if user is not active
    function activityWatcher() {
      var isActive = 0;
      //The number of seconds that have passed
      //since the user was active.
      var secondsSinceLastActivity = 0;

      //Seven minutes. 60 x 7 = 420 seconds.
      var maxInactivity = (420);
      setInterval(function() {
        secondsSinceLastActivity++;
        <?php $lastActive = date("Y-m-d H:i:s") ?>
        <?php $_SESSION['lastActivity'] = date("Y-m-d H:i:s") ?>
        if (secondsSinceLastActivity > maxInactivity) {
          window.location.href = "logout.php";
        }
      }, 1000);

      //reset seconds if user is active
      function activity() {
        secondsSinceLastActivity = 0;
      }

      //An array of DOM events that should be interpreted as
      //user activity.
      var activityEvents = [
        'mousedown', 'mousemove', 'keydown',
        'scroll', 'touchstart'
      ];

      //add these events to the document.
      //register the activity function as the listener parameter.
      activityEvents.forEach(function(eventName) {
        document.addEventListener(eventName, activity, true);
      });
    }

    activityWatcher();

    //for Logout if only Tab is closed
    function updateActivity() {
      $.ajax({
        url: 'updateActivity.php',
        type: 'post',
      });
    };

    setInterval(function() {
      updateActivity();
    }, 120000);

    updateActivity();
  </script>

</body>

</html>