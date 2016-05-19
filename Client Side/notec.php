<?php
//Start the session
require_once('../connect.php');

if (!isset($_SESSION['client_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Note Pad</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="../Css/note.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>
<body>

<div style="background-color: white; height: 700px; width: 370px; position: absolute; margin-left: 10px; margin-top: 10px;">
<h1 style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman">Notes</h1>
    <?php
    // Retrieve the user data from MySQL
    $query = "SELECT title, text FROM notec WHERE user_id = :id";
    $stmt = $dbh->prepare($query);
    $stmt->execute(array('id'=>$_SESSION['client_id']));
    $results = $stmt->fetchAll();

    echo '<table>';
    $text = array();
    $count = 0;
            foreach($results as $row)
            {
                echo '<tr id = "' . $count .'" class="title" style="border: dashed; border-color: #00b7bb; text-align: center; height: 60px; width: 100%;"><td>'. $row['title'].'</td>';
                array_push($text, $row['text']);
                $count++;
            }
    echo '</table>'
    ?>
</div>
<?php
if(@$_POST['formSubmit'] == "Submit")
{
    $errorMessage = "";
    if(empty($_POST['title']))
    {
        $errorMessage = "<li>You forgot to enter your title.</li>";
    }
    if(empty($_POST['date']))
    {
        $errorMessage = "<li>You forgot to enter your note date.</li>";
    }
    if(empty($_POST['text']))
    {
        $errorMessage = "<li>You forgot to enter your note.</li>";
    }

    $stmt = $dbh->prepare("INSERT INTO notec (title, date, text, user_id) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute(array($_POST['title'], $_POST['date'], $_POST['text'], $_SESSION['client_id']));

    if(!empty($errorMessage))
    {
        echo("<p>There was an error with your form:</p>\n");
        echo("<ul>" . $errorMessage . "</ul>\n");
    }
    header("Location: notec.php");
}
?>
<nav>
    <div class="navToggle">
        <div class="icon"></div>
    </div>
    <ul>
        <li><a href="profile2.php">Home Page</a></li>
        <li><a href="remindersc.php">Reminder</a></li>
        <li><a href="general.php">General Facts</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul>
</nav>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>
    $(".navToggle").click (function(){
        $(this).toggleClass("open");
        $("nav").toggleClass("open");
    });

</script>

<script>
    $(document).ready(function(){
        var toggle = 0;
        $(".title").click(function(){
            if(toggle == 0)
            {
                $('#entry').hide();
                $('#result').show();
                toggle++;
                var text = [];

                <?php
                    foreach($text as $return)
                    {
                 ?>

                        text.push("<?= $return;?>");
                <?php } ?>

                $('#header').html($(this).text());
                var index = $(this).attr('id');
                $('#text').html(text[index]);
            }
            else
            {
                $('#entry').show();
                $('#result').hide();
                toggle--;
            }
        });
    });
</script>

<div id="entry" style=" height: 700px; width: 900px; margin-left: 400px; position: absolute; ">
    <br>
    <div style="background-color: pink;">
        <h2 style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black">New Entry</h2>
    </div>

    <form class="w3-container" method="post">
        <p>
            <label for="title">Title</label>
            <input id="title" class="w3-input" type="text" name="title" required>
        </p>
            <br>
        <p>
            <label for="date">Date</label>
            <input id="date" class="w3-input" type="date" name="date" required>
        </p>
            <br>
        <p>
            <label for="text1">Text</label>
            <input id="text1" class="w3-input" type="text" style="height: 100px;" name="text" required>
        </p>
        <br>

        <input name="formSubmit" value="Submit" class="btn btn-lg btn-primary btn-block btn-signin" type="submit" style="height: 50px; width: 300px; margin-left: 570px; border-radius: 10px;">
    </form>
</div>

<div id="result" style=" height: 700px; width: 900px; margin-left: 400px; position: absolute; display: none; ">
    <br>
    <div style="background-color: pink;">
        <h2 id="header" style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black">Test</h2>
    </div>

    <div id="text" style=" height: 400px; width: 900px; text-align: center; font-size: 30px; border: dashed; border-color: black">

    </div>
</div>
</body>
</html>
