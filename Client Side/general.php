<?php
//Start the session
require_once('../connect.php');

if (!isset($_SESSION['client_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>General Facts</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../Css/style.css">
</head>

<body>

<nav>
    <div class="navToggle">
        <div class="icon"></div>
    </div>
    <ul>
        <li><a href="profile2.php">Home Page</a></li>
        <li><a href="notec.php">Note Pad</a></li>
        <li><a href="remindersc.php">Reminder</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul>
</nav>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="../Business%20Side/index.js"></script>

</body>

</html>