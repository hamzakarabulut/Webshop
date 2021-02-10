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
$sUsername =  $_SESSION['userNm'];

if (isset($_POST['address'])) {
    $sAddress = $_POST['address'];
}
if (isset($_POST['phone_number'])) {
    $sTel = $_POST['phone_number'];
}
if (isset($_POST['shipment'])) {
    $sShipmenttype = $_POST['shipment'];
}

$user = getUser($user_id);



$alert = false;
$alert_message = false;

if (isset($_POST["paymentForm"])) {

    $shipment = ($_POST["shipment"] == 'Normal') ? 0.00 : 5.00;

    $sShipmentAmount = $shipment;

    // calculate total
    $result = getCart($user_id);
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $item = getProduct($row["artikel_id"]);
        $total += $item["product_price"] * $row["quantity"];
    }
    $total += $shipment;


    $yeniSiparisId = addOrder($user_id, $_POST["shipment"], $total, $shipment, $_POST["address"], $_POST["phone_number"]);



    if ($yeniSiparisId) {

        // Add order items    
        $result = getCart($user_id);
        while ($row = $result->fetch_assoc()) {
            addProductsToOrder($yeniSiparisId, $row["artikel_id"], $row["quantity"]);
        }

        //SEND MAIL
        $mail = new PHPMailer(true);

        try {
            $sOrderDate = date("d.m.Y");
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

            $result = getCart($user_id);

            while ($row = $result->fetch_assoc()) {
                addProductsToOrder($yeniSiparisId, $row["artikel_id"], $row["quantity"]);
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
            $mailContent .= "  <tr>
                                    <td>Versandkosten</td>
                                    <td></td>
                                    <td>$sShipmentAmount&euro;</td>
                                </tr>
                                <tr>
                                    <td>Gesamt</td>
                                    <td></td>
                                    <td>$total&euro;</td>
                                </tr>
            </table> <hr>
            Bei Fragen zur Bestellung oder &Auml;hnlichem schreiben Sie uns eine <a href='http://localhost/bakery-son/contactForm.html'>Mail</a>! <br><br>
            
            Ihr KMG-Team";;
            $mail->Body = $mailContent;
            //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        // clear warenkorb
        clearCart($user_id);

        // redirect to orders page
        header('Location: orders.php');
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

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }



        .quantity {
            float: left;
            margin-right: 15px;
            background-color: #eee;
            position: relative;
            width: 80px;
            overflow: hidden
        }

        .quantity input {
            margin: 0;
            text-align: center;
            width: 15px;
            height: 15px;
            padding: 0;
            float: right;
            color: #000;
            font-size: 20px;
            border: 0;
            outline: 0;
            background-color: #F6F6F6
        }

        .quantity input.qty {
            position: relative;
            border: 0;
            width: 100%;
            height: 40px;
            padding: 10px 25px 10px 10px;
            text-align: center;
            font-weight: 400;
            font-size: 15px;
            border-radius: 0;
            background-clip: padding-box
        }

        .quantity .minus,
        .quantity .plus {
            line-height: 0;
            background-clip: padding-box;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            /* -webkit-background-size: 6px 30px;
    -moz-background-size: 6px 30px; */
            color: #bbb;
            font-size: 20px;
            position: absolute;
            height: 50%;
            border: 0;
            right: 0;
            padding: 0;
            width: 25px;
            z-index: 3
        }

        .quantity .minus:hover,
        .quantity .plus:hover {
            background-color: #dad8da
        }

        .quantity .minus {
            bottom: 0
        }

        .shopping-cart {
            margin-top: 20px;
        }
    </style>
    <title>HOME</title>
</head>

<?php
if ($alert) {
?>
    <script>
        $(document).ready(function() {
            swal("<?php echo $alert_message; ?>");
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



    <div class="col-lg"></div>


    <div class="container wrapper">
        <div class="row cart-head">
            <div class="container">
                <div class="row">
                    <p></p>
                </div>

            </div>
        </div>
        <div class="row cart-body">
            <form class="form-horizontal" method="post" action="payment.php">
                <input type="hidden" name="paymentForm" value="1">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                    <!--REVIEW ORDER-->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Review Order <div class="pull-right"><small><a class="afix-1" href="cart.php">Edit Cart</a></small></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // get users's warenkorb
                            $result = getCart($user_id);

                            $total = 0;

                            while ($row = $result->fetch_assoc()) {
                                $item = getProduct($row["artikel_id"]);
                                $total += $item["product_price"] * $row["quantity"];
                            ?>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">
                                        <img class="img-responsive" src="<?php echo $item["product_image"]; ?>" />
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="col-xs-12"><?php echo $item["product_name"]; ?></div>
                                        <div class="col-xs-12"><small>Quantity:<span><?php echo $row["quantity"]; ?></span></small></div>
                                    </div>
                                    <div class="col-sm-3 col-xs-3 text-right">
                                        <h6><?php echo $item["product_price"] * $row["quantity"]; ?> <span>€</span></h6>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <hr />
                                </div>
                            <?php
                            }
                            ?>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Subtotal</strong>
                                    <div class="pull-right"><span><?php echo $total; ?></span><span> €</span></div>
                                </div>
                                <div class="col-xs-12">
                                    <small>Shipping</small>
                                    <div class="pull-right" id="shipping_price"><span>-</span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <hr />
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Order Total</strong>
                                    <div class="pull-right" id="total_price"><span><?php echo $total; ?></span><span> €</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--REVIEW ORDER END-->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                    <!--SHIPPING METHOD-->
                    <div class="panel panel-info">
                        <div class="panel-heading">Address</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>Shipping Infos</h4>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <strong>First Name:</strong>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo $user['firstName']; ?>" disabled />
                                </div>
                                <div class="span1"></div>
                                <div class="col-md-6 col-xs-12">
                                    <strong>Last Name:</strong>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo $user['surname']; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Email Address:</strong></div>
                                <div class="col-md-12"><input type="text" name="email_address" class="form-control" value="<?php echo $user['email']; ?>" disabled /></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Address:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" name="address" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Phone Number:</strong></div>
                                <div class="col-md-12"><input type="number" name="phone_number" class="form-control" value="" /></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Shipment:</strong></div>
                                <div class="col-md-12">
                                    <input type="radio" name="shipment" class="" value="Normal" id="s_n" onClick="recalculateTotal('normal');" /> <label for="s_n" style="font-weight:400;">Normal</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" name="shipment" class="" value="Express" id="s_e" onClick="recalculateTotal('express');" /> <label for="s_e" style="font-weight:400;">Express (+5 €)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--SHIPPING METHOD END-->
                    <!--CREDIT CART PAYMENT-->
                    <div class="panel panel-info">
                        <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Secure Payment</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12"><strong>Card Type:</strong></div>
                                <div class="col-md-12">
                                    <select id="CreditCardType" name="CreditCardType" class="form-control">
                                        <option value="5">Visa</option>
                                        <option value="6">MasterCard</option>
                                        <option value="7">American Express</option>
                                        <option value="8">Discover</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Credit Card Number:</strong></div>
                                <div class="col-md-12"><input type="text" class="form-control" maxlength="16" name="car_number" value="" /></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Card CVV:</strong></div>
                                <div class="col-md-12"><input type="text" maxlength="3" class="form-control" name="car_code" value=""></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <strong>Expiration Date</strong>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="">
                                        <option value="">Month</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="">
                                        <option value="">Year</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <button type="submit" class="btn btn-primary btn-submit-fix">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--CREDIT CART PAYMENT END-->
                </div>

            </form>
        </div>
        <div class="row cart-footer">

        </div>
    </div>

    <!--footer-->
    <footer>
        <div class="row" id="footerStyle" style="text-align: center;">

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