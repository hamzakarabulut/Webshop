<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}

require 'php/connection.php';
require 'php/functions.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Muffin</title>

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="css/global.css">
  <link href="fontawesome/css/font-awesome.css" rel="stylesheet" />
  <link href="fontawesome/css/font-awesome.css" rel="stylesheet" />
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="javaScript/jquery-2.1.4.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>

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

  <div class="container_footer container-fluid" id="footer-padding">

    <?php
    $sql = "SELECT * FROM products WHERE id < 7";
    $products = $fpconnection->query($sql);

    while ($row = $products->fetch_assoc()) {
    ?>
      <div class="col-md-6">
        <div class="card flex-md-row mb-4 box-shadow h-md-250">
          <div class="card-body d-flex flex-column align-items-start">
            <h3 class="text-dark mb-0"> <?php echo $row['product_name']; ?></h3> <br>
            <p class="text-dark mb-0"> <?php echo $row['product_desc']; ?> <br>
              Stückpreis: <?php echo $row['product_price']; ?> € </p> 
            <a id="shopIcon" href="cart.php?action=add&id=<?php echo $row['id']; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="8%" height="auto" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
              </svg>
            </a>
          </div>
          <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 295px; height: 250px;" src="<?php echo $row['product_image']; ?>" data-holder-rendered="true">
        </div>
      </div>

    <?php
    }
    ?>
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