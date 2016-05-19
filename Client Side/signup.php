<!DOCTYPE html>
<html lang="en">
<head>
    <title> Sign up </title>

    <link href="../Css/signup.css" rel="stylesheet" type="text/css">
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
    require_once("../connect.php");

    define('MM_UPLOADPATH', '../images/');
    define('MM_MAXFILESIZE', 32768);      // 32 KB
    define('MM_MAXIMGWIDTH', 120);        // 120 pixels
    define('MM_MAXIMGHEIGHT', 120);       // 120 pixels

    if(@$_POST['formSubmit'] == "Submit")
    {
        $picture = $_FILES['picture']['name'];
        $picture_type = $_FILES['picture']['type'];
        $picture_size = $_FILES['picture']['size'];
        @list($picture_width, $picture_height) = getimagesize($_FILES['picture']['tmp_name']);
        $error = false;

        // Validate and move the uploaded picture file, if necessary
        if (!empty($picture))
        {
            if ((($picture_type == 'image/gif') || ($picture_type == 'image/jpeg') || ($picture_type == 'image/pjpeg') ||
                    ($picture_type == 'image/png')) && ($picture_size > 0) && ($picture_size <= MM_MAXFILESIZE))
            {
                if (@$_FILES['file']['error'] == 0)
                {
                    // Move the file to the target upload folder
                    $target = MM_UPLOADPATH . basename($picture);

                    if (!(move_uploaded_file($_FILES['picture']['tmp_name'], $target))) {
                        // The new picture file move failed, so delete the temporary file and set the error flag
                        @unlink($_FILES['picture']['tmp_name']);
                        $error = true;
                        echo '<p style="text-align: center;">Sorry, there was a problem uploading your picture.</p>';
                    }
                    else
                    {
                        $stmt = $dbh->prepare("INSERT INTO client (firstName, lastName, username, email, password, type, picture, doctor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $result = $stmt->execute(array($_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['type'], $picture, $_POST['doctor']));
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
                }
            }
            else {
                // The new picture file is not valid, so delete the temporary file and set the error flag
                @unlink($_FILES['picture']['tmp_name']);
                $error = true;
                echo '<p style="text-align: center">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
                    ' KB.</p>';
            }
        }
    }
?>

    <script>
        $(".navToggle").click (function(){
            $(this).toggleClass("open");
            $("nav").toggleClass("open");
        });
    </script>

<h1 style="text-align: center; color: #00b7bb; margin-top: 2%; font-size: 50px;">Sign Up</h1>
<div class="container" >

    <div class="card card-container" style="background-color: black">

        <img id="profile-img" class="profile-img-card" src="../images/profile.png"/>

        <span style="color: orangered"></span>

        <form enctype="multipart/form-data" id="signUp" method="post" class="form-signin">
            <br>
            <div style="width: 50%; float: left; padding-right: 2%">
                <input type="text" class="inputEmail" name="firstName" placeholder="First Name" required autofocus>
                <input type="text" class="inputEmail" name="lastName" placeholder="Last Name" required>
                <input type="text" class="inputEmail" name="username" placeholder="Username" required>
                <label for="picture" style="color: white">Picture:</label>
                <input style="margin-bottom: 10px" type="file" id="picture" name="picture" required>
            </div>

            <div style="width: 50%; float: left">
                <input type="email" class="inputEmail" name="email" placeholder="Email" required>
                <input type="password" class="inputEmail" name="password" placeholder="Password" required>

                <select name="type" form="signUp" style="width: 136px" required>
                    <option value="" selected="selected">Type of Diabetes</option>
                    <option value="Type 1">Type 1</option>
                    <option value="Type 2">Type 2</option>
                    <option value="Prediabetes">Prediabetes</option>
                    <option value="Gestational">Gestational</option>
                </select>

                <select name="doctor" form="signUp" style="margin-top: 3px; width: 136px" required>
                    <option value="" selected="selected">Select Your Doctor</option>
                    <option value="">N/A</option>
                    <?php
                        require_once("../connect.php");
                        $query = "SELECT id, firstName, lastName FROM users";
                        $stmt = $dbh->prepare($query);
                        $stmt->execute();
                        $results = $stmt->fetchAll();

                        foreach($results as $result)
                        {
                            $name = $result['firstName'] . " " . $result['lastName'];
                            echo "<option value='" . $result['id'] ."'>" . $name . "</option>";
                        }
                    ?>
                </select>
            </div>

            <a href="login.php" style="float: left; margin-bottom: 10px">Already have an account? Sign in</a>
            <button name="formSubmit" value="Submit" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Submit</button>
        </form>
    </div>
</div>
</body>
</html>