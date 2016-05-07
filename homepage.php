<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="Css/style.css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body>
    <script>
        $(document).ready(function(){
            var toggle = 0;
            $(".test").click(function()
            {
                if(toggle == 0)
                {
                    $(".show").fadeIn( "slow", function() {});
                    toggle++;
                }
                else
                {
                    $(".show").fadeOut( "slow", function() {});
                    toggle--;
                }

                $("#title").html($(this).text());
            });
        });
    </script>

    <div class="test">
        <p>Something</p>
    </div>

    <div class="test">
        <p>Something2</p>
    </div>

    <div class="test">
        <p>Something3</p>
    </div>

    <div class="show" style="display: none">
        <h2 id="title"></h2>
    </div>
</body>
</html>