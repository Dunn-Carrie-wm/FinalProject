<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login </title>
    <link href="https://assets.onestore.ms/cdnfiles/onestorerolling-1601-22000/shell/v3/scss/shell.min.css"
          rel="stylesheet" type="text/css" media="screen"/>
    <link href="login.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php
try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=final', 'root', 'root');

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
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

    $stmt = $dbh->prepare("SELECT * FROM users WHERE username = :username AND password = :password");

    $result = $stmt->execute(
        array(
            'username' =>$_POST['username'],
            'password' =>$_POST['password']
        )
    );
    $userinfo = $stmt->fetch();

    if($userinfo){
        print_r($stmt->errorInfo());

        header("Location: home.php");
    }

    if(!empty($errorMessage))
    {
        echo("<p>There was an error with your form:</p>\n");
        echo("<ul>" . $errorMessage . "</ul>\n");
    }


}?>


<div class="site__container">
    <h1 style="text-align: center; font-size: 70px;">Sign In</h1>
    <div class="grid__container">

        <form method="post" class="form form--login">

            <div class="form__field">
                <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
                <input type="text" name="username" placeholder="Username or E-mail"/>

            </div>

            <div class="form__field">
                <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
                <input type="password" name="password" placeholder="Password"/>

            </div>

            <div class="form__field">
                <input type="submit" name="formSubmit" value="Submit"/>
            </div>

        </form>

        <p class="text--center">Not a member? <a href="signup.php">Sign up now</a> <span class="fontawesome-arrow-right"></span></p>

    </div>

</div>

</body>
</html>