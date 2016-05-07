<!DOCTYPE html>
<html lang="en">
<head>
    <title> Sign up </title>

    <link href="../Business%20Side/signup.css" rel="stylesheet" type="text/css">
    <link href="https://assets.onestore.ms/cdnfiles/onestorerolling-1601-22000/shell/v3/scss/shell.min.css"
          rel="stylesheet" type="text/css" media="screen"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../Css/style.css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <style>
        #signUp input
        {
            background-color: lightblue;
            color: white;
        }
    </style>
</head>
<body>
<?php
    require_once("connect.php");

    if(@$_POST['formSubmit'] == "Submit")
    {
        $errorMessage = "";

        $stmt = $dbh->prepare("INSERT INTO client (firstName, lastName, username, email, password, type) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute(array($_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['type']));
        if(!$result){
            print_r($stmt->errorInfo());
        }
        else{
            $msg = 'Thank you for subscribing to Injection.';
            $from = 'admin@injection.com';
            mail($_POST['email'], 'Injection' , $msg, 'From:' . $from);
            header("Location: login.php");
        }

        if(!empty($errorMessage))
        {
            echo("<p>There was an error with your form:</p>\n");
            echo("<ul>" . $errorMessage . "</ul>\n");
        }
    }
?>
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

<h1 style="text-align: center; color: #00b7bb; margin-top: 2%; font-size: 50px;">Sign Up</h1>
<div class="container" >

    <div class="card card-container" style="background-color: black">

        <img id="profile-img" class="profile-img-card" src="profile.png"/>

        <span style="color: orangered"></span>

        <form id="signUp" method="post" class="form-signin">
            <br>
            <div style="width: 50%; float: left; padding-right: 2%">
                <input type="text" class="inputEmail" name="firstName" placeholder="First Name" required autofocus>
                <input type="text" class="inputEmail" name="lastName" placeholder="Last Name" required>
                <input type="text" class="inputEmail" name="username" placeholder="Username" required>
            </div>

            <div style="width: 50%; float: left">
                <input type="email" class="inputEmail" name="email" placeholder="Email" required>
                <input type="password" class="inputEmail" name="password" placeholder="Password" required>

                <select name="type" form="signUp" required>
                    <option value="" selected="selected">Type of Diabetes</option>
                    <option value="Type 1">Type 1</option>
                    <option value="Type 2">Type 2</option>
                    <option value="Prediabetes">Prediabetes</option>
                    <option value="Gestational">Gestational</option>
                </select>
            </div>

            <a href="login.php" style="float: left; margin-bottom: 10px">Already have an account? Sign in</a>
            <button name="formSubmit" value="Submit" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Submit</button>
        </form>
    </div>
</div>
</body>
</html>