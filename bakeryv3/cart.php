<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}
require 'php/connection.php';
require 'php/functions.php';

// Login kontrol
if (!isset($_SESSION['login']) || $_SESSION['login'] != 111) {
  header('Location: index.html');
}

// get user id
$user_id = $_SESSION['UId'];


$alert = false;
$alert_message = false;

if (isset($_GET["action"])) {

  if ($_GET["action"] == "add") {
    $artikel_id = $_GET['id'];

    $alert = true;

    if (addToCart($user_id, $artikel_id)) {
      $alert_message = "Produkt hinzugefügt";
?>
      <script>
        window.location.href = "cart.php";
      </script>
    <?php
    } else {
      $alert_message =  "Fehler beim Hinzufügen des Produkts";
    }
  } elseif ($_GET["action"] == "clear") {
    $cart_item_id = $_GET['id'];

    $alert = true;

    if (deleteProduct($cart_item_id)) {
      $alert_message =  "Produkte wurde gelöscht";
    ?>
      <script>
        window.location.href = "cart.php";
      </script>
    <?php
    } else {
      $alert_message =  "Fehler beim Löschen: ";
    }
  } elseif ($_GET["action"] == "delete1") {
    $cart_item_id = $_GET['id'];

    $alert = true;

    if (reduceAmount($cart_item_id)) {
      $alert_message =  "Produkte wurde gelöscht";
    ?>
      <script>
        window.location.href = "cart.php";
      </script>
<?php

    } else {
      $alert_message =  "Fehler beim Löschen: ";
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

<body style="min-height: max-content;">


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
    <?php
    // get users's cart
    $result = getCart($user_id);
    ?>
    <div class="card shopping-cart">
      <div class="card-header bg-dark text-light">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        Warenkorb
        <a href="javascript:history.go(-1)" class="btn btn-outline-info btn-sm pull-right">weiter Einkaufen</a>
        <div class="clearfix"></div>
      </div>

      <div class="card-body">

        <?php

        $total = 0;

        while ($row = $result->fetch_assoc()) {
          $item = getProduct($row["artikel_id"]);
          $total += $item["product_price"] * $row["quantity"];
          if ($row["quantity"] == 0) { ?>
            <script>
              window.location.href = "cart.php?action=clear&id='<?php echo $row["id"]; ?>'";
            </script>
          <?php    }
          ?>
          <!-- PRODUCT -->
          <div class="row">
            <div class="col-12 col-sm-12 col-md-2 text-center">
              <img class="img-responsive" src="<?php echo $item["product_image"]; ?>" alt="preview" width="120" height="80">
            </div>
            <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
              <h4 class="product-name"><strong><?php echo $item["product_name"]; ?></strong></h4>
              <h4>
                <small><?php echo $item["product_desc"]; ?></small>
              </h4>
            </div>
            <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
              <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                <h6><strong><?php echo $item["product_price"]; ?> <span class="text-muted">x</span></strong></h6>
              </div>
              <div class="col-4 col-sm-4 col-md-4">
                <div class="quantity">
                  <input type="button" value="+" class="plus" onclick="window.location.href='cart.php?action=add&id=<?php echo $item['id']; ?>'">
                  <input type="number" step="1" max="99" min="1" value="<?php echo $row["quantity"]; ?>" title="Qty" class="qty" size="4">
                  <!-- TODO-->
                  <input type="button" value="-" class="minus" onclick="window.location.href='cart.php?action=delete1&id=<?php echo $row['id']; ?>'">


                </div>
              </div>
              <div class="col-2 col-sm-2 col-md-2 text-right">
                <a href="cart.php?action=clear&id=<?php echo $row["id"]; ?>">
                  <button type="button" class="btn btn-outline-danger btn-xs">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
                </a>
              </div>
            </div>
          </div>
          <hr>
          <!-- END PRODUCT -->
        <?php
        }
        ?>
        <div class="pull-right">
          <a href="" class="btn btn-outline-secondary pull-right">

          </a>
        </div>
      </div>
      <div class="card-footer">
        <div class="pull-right" style="margin: 10px">
          <a href="payment.php" class="btn btn-success pull-right">Zur Kasse</a>
          <div class="pull-right" style="margin: 5px">
            Total price: <b><?php echo $total; ?></b>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--footer-->
  <footer style="transform: translateY(142%); ">
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