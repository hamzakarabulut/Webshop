<?php
session_start();
if ($_SESSION['login'] != 111) {
  header("Location: ../index.html");
}

include 'connection.php';
$sUserId = $_SESSION['UId'];
$lastActive = date("Y-m-d H:i:s");
$_SESSION['lastActivity'] = $lastActive;

?>


<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <link href="../fontawesome/css/font-awesome.css" rel="stylesheet">
  <link href="../fontawesome/css/font-awesome.css" rel="stylesheet">
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../javaScript/jquery-2.1.4.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../javaScript/jquery-2.1.4.min.js"></script>
  <link rel="stylesheet" href="../css/global.css">
  <!-- background imAGE TODO-->
  <link rel="stylesheet" href="../css/login.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>WELCOME</title>

</head>

<body>


  <header>
    <div class="container_nav" id="navbar">
      <nav id="navbar">
        <ul>
          <li><img src="../img/logoHatT.png" alt="logo" style="width: 30%; height:30%;"></li>
          <li><a href="../home.html">Home</a></li>
        </ul>
      </nav>
      <nav>
        <ul>
          <li><a href="../cake.php">Kuchen/Torten</a></li>
          <li><a href="../muffin.php">Muffin</a></li>
          <li><a href="../drinks.php">Getr&auml;nke</a></li>
        </ul>
      </nav>
      <nav id="navbar" class="space">
        <ul>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="../fontawesome/svgs/solid/user-circle.svg" alt="account" width="20" height="20">
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="../orders.php">Meine Bestellungen</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
          </li>
          <li><a href="../contactForm.html"><img src="../fontawesome/svgs/solid/envelope.svg" alt="account" width="20" height="20"></a></li>
          <li><a href="../cart.php"><img src="../fontawesome/svgs/solid/shopping-cart.svg" alt="account" width="20" height="20"></a></li>
        </ul>
      </nav>
    </div>
  </header>


  <div class="login-reg-panel" id="welcome">

    <h2>Hallo <b><?php echo $_SESSION['userNm'] ?>!</b><br> Du warst zuletzt eingeloggt am <?php echo date("d.m.Y", strtotime($_SESSION['lastLoginTime'])) ?></h2>
    <div id=updateUser></div>
  </div>





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