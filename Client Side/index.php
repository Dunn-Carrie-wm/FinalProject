<?php require_once("connect.php");?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home Page</title>
        <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../Css/style.css">
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    </head>

    <body>
        <nav>
            <div class="navToggle">
                <div class="icon"></div>
            </div>
            <ul>
                <?php
                if(isset($_SESSION['user_id']))
                    echo "<li><a href=\"profile.php\">Profile</a></li>";
                else
                    echo "<li><a href=\"login.php\">Profile</a></li>";
                ?>
                <li><a href="noteinput.php">Note Pad</a></li>
                <li><a href="reminderinput.php">Reminder</a></li>
                <li><a href="general.php">General Facts</a></li>

                <?php
                    if(isset($_SESSION['user_id']))
                        echo "<li><a href=\"logout.php\">Log Out</a></li>";
                    else
                        echo "<li><a href=\"login.php\">Log In</a></li>";
                ?>
            </ul>
        </nav>

        <script>
            $(".navToggle").click (function(){
                $(this).toggleClass("open");
                $("nav").toggleClass("open");
            });
        </script>
    </body>
</html>