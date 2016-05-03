<?php
 //Start the session
require_once('startsession.php');

// Insert the page header
$page_title = 'Home page';

$dbh = new PDO('mysql:host=localhost;dbname=final', 'root', 'root');


// Grab the profile data from the database
if (!isset($_GET['user_id'])) {
  $query = "SELECT firstName, lastName FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
}
else {
  $query = "SELECT firstName, lastName FROM users WHERE id = '" . $_GET['user_id'] . "'";
}
$stmt = $dbh->prepare($query);
$stmt->execute();

$count =$stmt->rowCount();
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

  <div id="test" style="width: 1000px; height: 100px;margin-left: 13%; margin-top: 10px; ">
    <p style="font-size: 60px; margin-top: 20px">DR.</p>
    <?php
    if ($count == 1) {

      // The user row was found so display the user data
      $row = $stmt->fetch();
      echo '<p style="font-size: 70px; margin-left: 120px; margin-top: -77px;">' . $row['firstName'] . '</p>';
      echo '<p style="margin-left: 280px; font-size: 70px; margin-top: -80px">'. $row['lastName'] . '</p>';
    }
    ?>
  </div>
  <div style="background-color: #00b7bb; height: 20px; width: 100%"></div>

  <div style="height: 500px; width: 350px; margin-left: 150px; background-color: aqua; ">
    <p>test</p>
  </div>
  <div style="height: 500px; width: 350px; margin-left: 503px; background-color: black; ">
    <p>test</p>
  </div>
  <div style="height: 500px; width: 350px; margin-left: 150px; background-color: aqua; ">
    <p>test</p>
  </div>
  <div style="height: 500px; width: 350px; margin-left: 150px; background-color: black; ">
    <p>test</p>
  </div>
  </body>
</html>
