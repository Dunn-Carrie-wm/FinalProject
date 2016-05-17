<?php
$dbc = new PDO('mysql:host=localhost;dbname=injection', 'root','root');

?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="Css/style.css" type="text/css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <!--Carousel CSS-->
    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 50%;
            margin: auto;
        }
    </style>


</head>

<body style="background-color: lightblue">
<div style="background-color: lightblue" id="#text">
    <!--NavBar-->
    <nav style="background-color: lightblue;">
        <div  style="background-color: lightblue;" class="navToggle" id="AboutUs">
            <div class="icon"></div>
        </div>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="Business%20Side/home.php">Doctor</a></li>
            <li><a href="Client%20Side/profile2.php">Patient</a></li>
            <li><a href="FAQ.php">FAQs</a></li>
        </ul>
    </nav>
</div>

<script>
    $(".navToggle").click (function(){
        $(this).toggleClass("open");
        $("nav").toggleClass("open");
    });
</script>
<!-----test comment--->

<div id="Text">
    <h1 style="color: white; margin-left: 200px;"> Injection </h1>
    <p style="color: white; margin-left: 200px;"> Established in 2016. Made For You. </p>
    <br>
    <h2 style="color: white;margin-left: 200px;"> About Us </h2> <br>
    <h3 style="color: white;margin-left: 200px;"> Lorem ipsum dolor sit amet, vitae mauris pellentesque eu, sit vehicula
        scelerisque,vitae id esse varius molestie, diam odio natoque integer
        rutrum id, platea pede leo neque delectus. Sociis aliquam non non,
        volutpat nullam orci, tristique praesent, nunc tellus justo sed, donec
        quisque. Cursus viverra suspendisse vestibulum nostra nibh,justo semper
        irure consequatur nec debitis. Velit non vestibulum mauris wisi diam ac,
        magnis ante odio vestibulum, sed odio quam aliquet curabitur est. Quis
        morbi fringilla,lectus molestie et arcu augue. Eget consequat praesent
        congue pede donec, in augue eget vel mauris non, quam justo vivamus, eu
        in vitae luctus sollicitudin. At in mollis eurhoncus et, viverra integer
        in varius in bibendum morbi, vestibulum nec nulla mi enimfaucibus, sit
        ut non consequat dolor ipsum, vivamus a metus. Eu mattis sit id, semper sit
        placerat massa et, augue aliquam nonummy semper pellentesque, velit nec
        id, luctus quis amet.Id nibh curabitur tellus consectetuer, unde aptent
        feugiat amet sit aliquam eros, non sedporttitor massa imperdiet proin,
        bibendum dignissim egestas dapibus libero nunc pharetra.Morbi dignissim
        turpis dictum, tortor morbi eget nobis duis ornare eros, tincidunt
        praesent sapien quis habitasse, enim semper sodales vestibulum. Dolor
        egestas nibh, metus tempus neca, vestibulum gravida ante, est nunc mus
        id sed pharetra, nec fringilla pretium. Amet velproin, congue convallis
        laoreet a mollis euismod, tincidunt sollicitudin, ut euismod platea,
        vel bibendum diam praesent orci wisi. </h3>
</div>
<!-- minor change-->
<?php require_once('carousel.php'); ?>
<center>
    <h2 style="color: white"> Contact Us  </h2>
    <h2 style="color: white"> Email: Injection@gmail.com </h2>
    <h2 style="color: white"> Phone #: 555-555-5555 </h2>
</center>

</body>
</html>