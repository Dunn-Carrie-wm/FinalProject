<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reminders</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../Css/note.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>

<body>
<div style="background-color: white; height: 700px; width: 370px; position: absolute; margin-left: 10px; margin-top: 10px;">
    <h1 style="text-decoration: underline; font-size: 50px; margin-left: 125px; text-align: center; font-family: Times New Roman">Reminders</h1>
    <?php
    require_once("../connect.php");

    // Retrieve the user data from MySQL
    $query = "SELECT subject, message, date, confirm FROM remindersc WHERE user_id = :id ORDER BY date";
    $stmt = $dbh->prepare($query);
    $stmt->execute(array('id'=>$_SESSION['user_id']));
    $results = $stmt->fetchAll();

    echo '<table>';
    $text = array();
    $date = array();
    $count = 0;

    foreach($results as $row)
    {
        if($row['confirm'] == "false")
            echo '<tr id = "' . $count .'" class="title" style="border: dashed; border-color: #00b7bb; text-align: center; height: 60px; width: 100%; background-color: #75fd60"><td>'. $row['subject'].'</td>';
        else
            echo '<tr id = "' . $count .'" class="title" style="border: dashed; border-color: #00b7bb; text-align: center; height: 60px; width: 100%;"><td>'. $row['subject'].'</td>';

        array_push($text, $row['message']);
        array_push($date, $row['date']);
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

    $query = "INSERT INTO remindersc (email, subject, message, date, user_id) VALUES (:email, :subject, :message, :date, :id)";
    $stmt = $dbh->prepare($query);
    $stmt->execute(array(
        "email"=>$_POST['email'],
        "subject"=>$_POST['subject'],
        "message"=>$_POST['message'],
        "date"=>$_POST['date'],
        "id"=>$_SESSION['user_id']
    ));

    if(!empty($errorMessage))
    {
        echo("<p>There was an error with your form:</p>\n");
        echo("<ul>" . $errorMessage . "</ul>\n");
    }
    header("Location: reminder.php");
}
?>
<nav>
    <div class="navToggle">
        <div class="icon"></div>
    </div>
    <ul>
        <li><a href="patientList.php">Patient List</a></li>
        <li><a href="home.php">Home Page</a></li>
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
                var date = [];

                <?php
                foreach($text as $return)
                {
                ?>

                text.push("<?= $return;?>");
                <?php }

                foreach($date as $return)
                {
                $newDate = date("m-d-Y", strtotime($return));
                $return = $newDate;
                ?>
                date.push("<?= $return;?>");
                <?php } ?>

                $('#header').html($(this).text());
                var index = $(this).attr('id');
                $('#date').html(date[index]);
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
        <h2 style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black">New Reminder</h2>
    </div>

    <form class="w3-container" method="post">
        <p>
            <label for="date2">Date</label>
            <input id="date2" class="w3-input" type="date" name="date" required>
        </p>
        <br>
        <p>
            <label for="email">To: </label>
            <input id="email" class="w3-input" type="email" name="email" required>
        </p>
        <br>
        <p>
            <label for="subject">Subject</label>
            <input id="subject" class="w3-input" type="text" name="subject" required>
        </p>
        <br>
        <p>
            <label for="text1">Message</label>
            <input id="text1" class="w3-input" type="text" style="height: 100px;" name="message" required>
        </p>
        <br>
        <input name="formSubmit" value="Submit" class="btn btn-lg btn-primary btn-block btn-signin" type="submit" style="height: 50px; width: 300px; margin-left: 570px; border-radius: 10px;">
    </form>
</div>

<div id="result" style="height: 700px; width: 900px; margin-left: 400px; position: absolute; display: none;">
    <br>
    <div style="background-color: pink;">
        <h2 id="header" style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black"></h2>
    </div>

    <div style="height: 400px; width: 900px; font-size: 30px; border: dashed; border-color: black;">
        <div style="text-align: left; margin-left: 10px" id="date"></div>
        <div style="text-align: center;" id="text"></div>
    </div>
</div>
</body>
</html>