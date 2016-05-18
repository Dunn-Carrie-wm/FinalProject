<?php
//Start the session
require_once('../connect.php');

if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
}

$query = "SELECT * FROM client WHERE doctor_id = :id";
$stmt = $dbh->prepare($query);
$stmt->execute(array('id'=>$_SESSION['user_id']));
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../Css/style.css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <style>
        td
        {
            text-align: left;
        }
        table
        {
            table-layout: fixed;
        }
    </style>
</head>

<body>
<nav>
    <div class="navToggle">
        <div class="icon"></div>
    </div>
    <ul>
        <li><a href="home.php">Home Page</a></li>
        <li><a href="note.php">Note Pad</a></li>
        <li><a href="reminders.php">Reminder</a></li>
        <li><a href="general.php">General Facts</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul>
</nav>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="index.js"></script>

<div style="text-align: center">

    <h1 style="text-align: center; color: #00b7bb">Patient List</h1><br>

    <table class="table" align="center">
        <thead>
        <tr>
            <th>Picture</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user){ ?>
            <tr>
                <td><img src='../images/<?= $user['picture'] ?>' style="width: 120px; height: 115px"></td>
                <td><?= $user['firstName']; ?></td>
                <td><?= $user['lastName']; ?></td>

                <?php
                echo '<td><a href="../Client%20Side/profile2.php?id=' . $user['id'] .
                    '&amp;name=' . $user['firstName'] . " " . $user['lastName'] . '">View Profile</a>';
                ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>