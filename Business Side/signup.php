<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Sign up </title>
    <link href="https://assets.onestore.ms/cdnfiles/onestorerolling-1601-22000/shell/v3/scss/shell.min.css"
          rel="stylesheet" type="text/css" media="screen"/>
    <link href="signup.css" rel="stylesheet" type="text/css">

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
    if(empty($_POST['firstName']))
    {
        $errorMessage = "<li>You forgot to enter your first name.</li>";
    }
    if(empty($_POST['lastName']))
    {
    $errorMessage = "<li>You forgot to enter your last name.</li>";
    }
    if(empty($_POST['username']))
    {
        $errorMessage = "<li>You forgot to enter your username.</li>";
    }
    if(empty($_POST['email']))
    {
        $errorMessage = "<li>You forgot to enter your email.</li>";
    }
    if(empty($_POST['password']))
    {
        $errorMessage = "<li>You forgot to enter your password.</li>";
    }
    if(empty($_POST['place']))
    {
        $errorMessage = "<li>You forgot to enter your work place.</li>";
    }
    if(empty($_POST['status']))
    {
        $errorMessage = "<li>You forgot to enter your medical status.</li>";
    }



    $stmt = $dbh->prepare("INSERT INTO users (firstName, lastName, username, email, password, place, status ) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $result = $stmt->execute(array($_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['place'], $_POST['status']));

    if(!$result){
        print_r($stmt->errorInfo());
    }
    else{
        $msg = 'Thank you for subscribing to Injection.';
        $from = 'admin@injection.com';
        mail($_POST['email'], 'Injection' , $msg, 'From:' . $from);
    }

    if(!empty($errorMessage))
    {
        echo("<p>There was an error with your form:</p>\n");
        echo("<ul>" . $errorMessage . "</ul>\n");
    }

}?>


<div class="site__container">
    <h1 style="text-align: center; font-size: 70px;">Sign up</h1>
    <div class="grid__container">

        <form method="post" class="form form--login">

            <div class="form__field">
                <label class="fontawesome-user" for="login__firstName"><span class="hidden">First Name</span></label>
                <input type="text" name="firstName" placeholder="First Name"/>

            </div>

            <div class="form__field">
                <label class="fontawesome-user" for="login__lastName"><span class="hidden">Last Name</span></label>
                <input type="text" name="lastName" placeholder="Last Name"/>

            </div>

            <div class="form__field">
                <label class="fontawesome-lock" for="login__password"><span class="hidden">Email</span></label>
                <input type="text" name="email" placeholder="Email"/>

            </div>

            <div class="form__field">
                <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
                <input type="text" name="username" placeholder="Username"/>

            </div>


            <div class="form__field">
                <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
                <input type="password" name="password" placeholder="Password"/>

            </div>

            <div class="form__field">
                <label class="fontawesome-user" for="login__place"><span class="hidden">Where Do You Work?</span></label>
                <input type="text" name="place" placeholder="Where Do You Work?"/>

            </div>

            <div class="form__field">
                <label class="fontawesome-user" for="login__status"><span class="hidden">Medical Status?</span></label>
                <input type="text" name="status" placeholder="Medical Status?"/>

            </div>

            <div class="form__field">
                <input type="submit" name="formSubmit" value="Submit" />
            </div>

        </form>

    </div>

</div>

</body>
</html>