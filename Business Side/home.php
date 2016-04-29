<?php
//// Start the session
//require_once('startsession.php');
//
//// Insert the page header
//$page_title = 'View Profile';
//
//
//// Make sure the user is logged in before going any further.
//if (!isset($_SESSION['user_id'])) {
//  echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
//  exit();
//}
//// Connect to the database
//$dbh = new PDO('mysql:host=localhost;dbname=final', 'root', 'root');
//
//// Grab the profile data from the database
//if (!isset($_GET['user_id'])) {
//  $query = "SELECT first_name FROM doctor WHERE user_id = '" . $_SESSION['user_id'] . "'";
//}
//else {
//  $query = "SELECT first_name FROM doctor WHERE user_id = '" . $_GET['user_id'] . "'";
//}
//$stmt = $dbh->prepare($query);
//$stmt->execute();
//
//$count =$stmt->rowCount();
//?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="style.css">
  </head>

  <body>

  <nav>
    <div class="navToggle">
      <div class="icon"></div>
    </div>
    <ul>
      <li><a href="patientList.php">Patient List</a></li>
      <li><a href="noteinput.php">Note Pad</a></li>
      <li><a href="reminderinput.php">Reminder</a></li>
      <li><a href="general.php">General Facts</a></li>
      <li><a href="logout.php">Log Out</a></li>
   </ul>
  </nav>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="index.js"></script>

  <div id="test" style="width: 100%; height: 100px;margin-left: 13%; margin-top: 10px;">
<!--    --><?php
//    if ($count == 1) {
//      // The user row was found so display the user data
//      $row = $stmt->fetch();
//      if (!empty($row['first_name'])) {
//        echo '<p>' . $row['first_name'] . '</p>';
//      } else {
//        echo '<p class="error">There was a problem accessing your profile.</p>';
//      }
//    }
//    ?>
  </div>
  </body>
</html>
