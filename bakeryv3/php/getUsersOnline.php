<!-- // session_start();
// include 'connection.php';

// $sLastActivity="";
// if(isset($_POST['lastActivity'])){
//     $sLastActivity=$_POST['lastActivity'];
// }


//     if(isset($_POST["action"]))
// {
//  if($_POST["action"] == "update_time")
//  {
//     $sLastActivity = date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
//     mysqli_query($fpconnection, "UPDATE bakeryuser SET lastActivity = '$sLastActivity' WHERE email = '$sEmail'");
//  }
//  if($_POST["action"] == "fetch_data")
//  {
//   $output = '';
//   $lastOnline = DATE_SUB(NOW(), INTERVAL 5 SECOND);
//   $sql = "SELECT * from bakeryuser where lastActivity='$lastOnline'";
//   $result = $fpconnection->query($sql);
//   $row = $result->fetchAll();
//   $countUserOnline = $result->rowCount();
//   $output = 'zahl user ' .$countUserOnline;

//   echo $output;
//  }
// }







    // $sCurrentTime = date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));

    // $sql = "SELECT * FROM bakeryuser where lastActivity='$sCurrentTime'";
    // $result = $fpconnection->query($sql);

    // if($result->num_rows > 0){
    //     $response = "<span style='color:red;'> users online </span>";   
    //  }else{
    //  $response = "";
    //  } 
    //  echo $response;
    //  exit;
  -->