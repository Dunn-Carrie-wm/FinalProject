<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Login | User</title>
    <link href="https://assets.onestore.ms/cdnfiles/onestorerolling-1601-22000/shell/v3/scss/shell.min.css"
          rel="stylesheet" type="text/css" media="screen"/>
    <link href="../Css/login.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../Css/style.css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <style>
        input
        {
            background-color: lightblue;
            color: white;
        }
    </style>
</head>

<body>
<?php
    require_once("../connect.php");

    if(@$_POST['formSubmit'] == "Submit")
    {
        $errorMessage = "";

        if(empty($_POST['username']))
        {
            $errorMessage = "<li>You forgot to enter your username.</li>";
        }
        if(empty($_POST['password']))
        {
            $errorMessage = "<li>You forgot to enter your last password.</li>";
        }

        $stmt = $dbh->prepare("SELECT * FROM client WHERE username = :username AND password = :password");

        $result = $stmt->execute(
            array(
                'username' =>$_POST['username'],
                'password' =>$_POST['password']
            )
        );
        $userinfo = $stmt->fetch();

        if($userinfo){
            print_r($stmt->errorInfo());
            $_SESSION['client_id'] = $userinfo['id'];

            header("Location: profile2.php");
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
            <li><a href="../homepage.php">Home Page</a></li>
            <li><a href="../Business%20Side/login.php">Doctor</a></li>
            <li><a href="../Client%20Side/login.php">Patient</a></li>
            <li><a href="../FAQ.php">FAQs</a></li>
        </ul>
    </nav>
    <script src="../Business%20Side/index.js"></script>

    <h1 style="text-align: center; color: #00b7bb; margin-top: 4%">Login</h1>

    <div class="container">
        <div class="card card-container" style="background-color: black">
            <img id="profile-img" class="profile-img-card" src="../images/profile.png"/>
            <span style="color: orangered"></span>

            <form method = "post" class="form-signin">
                <br>
                <input type="text" class="form-control, inputEmail" name="username" placeholder="Username" required autofocus>

                <input type="password" class="form-control, inputPassword" name="password" placeholder="Password" required>
                <a href="signup.php">Don't have an account? Sign up</a>

                <input style="margin-top: 10px" name="formSubmit" value="Submit" class="btn btn-lg btn-primary btn-block btn-signin" type="submit" >
            </form>
        </div>
    </div>
</body>
</html>