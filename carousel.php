<?php
$dbc = new PDO('mysql:host=localhost;dbname=injection', 'root','root');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 70%;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <br>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">

            <div class="item active">
                <img src="http://weknowyourdreamz.com/images/people/people-06.jpg" alt="Testimonial" width="100" height="100">
                <div class="carousel-caption">
                    <p>"Monitoring diabetes has always been a struggle of mine <br> with this app my life has gotten so much easier"</p>
                </div>
            </div>

            <div class="item">
                <img src="http://www.lungcanceralliance.org/blog/wp-content/uploads/2014/04/Diana_Phone-Buddy2.jpg" alt="Testimonial" width="100" height="100">
                <div class="carousel-caption">
                    <p>"My daughter always asked me what my glucose level was the day before, <br> because she always wanted to make sure it was stabilizing <br> but now I can just pull up my previous days record & never <br> need to stress about remembering!"</p>
                </div>
            </div>

            <div class="item">
                <img src="http://farm9.staticflickr.com/8441/7980306672_e069cf6720_o.jpg" alt="Testimonial" width="100" height="100">
                <div class="carousel-caption">
                    <p>"My life has completely changed when I got this application!"</p>
                </div>
            </div>

            <div class="item">
                <img src="http://www.sun-gazing.com/wp-content/uploads/2015/02/Old-Lady-sdfsdfsdfEnters-Bank-With-A-Bag-Of-Cash.-How-She-Got-It-I-Can%E2%80%99t-Stop-Laughing.jpg" alt="Testimonial" width="100" height="100">
                <div class="carousel-caption">
                    <p>"I LOVE this application!"</p>
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

</body>
</html>
