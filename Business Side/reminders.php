<?php
//Start the session
require_once('../connect.php');

if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reminders</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../Css/note.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>

<body>
<div style="background-color: white; height: 700px; width: 370px; position: absolute; margin-left: 10px; margin-top: 10px;">
    <h1 style="text-decoration: underline; font-size: 50px; margin-left: 125px; text-align: center; font-family: Times New Roman">Reminders</h1>
    <?php
        // Retrieve the user data from MySQL
        $query = "SELECT * FROM reminders WHERE user_id = :id ORDER BY date";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array('id'=>$_SESSION['user_id']));
        $results = $stmt->fetchAll();

        echo '<table>';
        $text = array();
        $date = array();
        $email = array();

        $count = 0;
        foreach($results as $row)
        {
            if($row['confirm'] == "true")
                echo '<tr id = "' . $count .'" class="title" style="border: dashed; border-color: #00b7bb; text-align: center; height: 60px; width: 100%;"><td>'. $row['subject'].'</td>';
            else
                echo '<tr id = "' . $count .'" class="title" style="background-color: lightgreen; border: dashed; border-color: #00b7bb; text-align: center; height: 60px; width: 100%;"><td>'. $row['subject'].'</td>';

            array_push($text, $row['message']);
            $newDate = date("m-d-Y", strtotime($row['date']));
            array_push($date, $newDate);
            array_push($email, $row['email']);
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

    $stmt = $dbh->prepare("INSERT INTO reminders (email, subject, message, date, user_id) VALUES (:email, :subject, :message, :date, :id)");
    $result = $stmt->execute(array('email'=>$_POST['to'], 'subject'=>$_POST['subject'], 'message'=>$_POST['message'], 'date'=>$_POST['date'], 'id'=>$_SESSION['user_id']));

    if(!empty($errorMessage))
    {
        echo("<p>There was an error with your form:</p>\n");
        echo("<ul>" . $errorMessage . "</ul>\n");
    }
    header("Location: reminders.php");
}
?>
<nav>
    <div class="navToggle">
        <div class="icon"></div>
    </div>
    <ul>
        <li><a href="home.php">Home Page</a></li>
        <li><a href="patientList.php">Patient List</a></li>
        <li><a href="note.php">Note Pad</a></li>
        <li><a href="general.php">General Facts</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul>
</nav>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="index.js"></script>

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
                var email = [];

                <?php
                foreach($text as $return)
                {
                ?>
                text.push("<?= $return;?>");
                <?php
                }

                foreach($date as $return)
                {
                ?>
                date.push("<?= $return;?>");
                <?php
                }

                foreach($email as $return)
                {
                ?>
                email.push("<?= $return;?>");
                <?php } ?>

                $('#header').html($(this).text());
                var index = $(this).attr('id');
                $('#date').html(date[index]);
                $('#text').html("Reminder: " + text[index]);
                $('#email').html("To: " + email[index]);
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
            <label for="date1">Date</label>
            <input id="date1" class="w3-input" type="date" name="date" required>
        </p>
        <br>
        <p>
            <label for="to2">To</label>
            <input list="to" id="to2" name="to" class="w3-input" required>
            <datalist id="to">
                <?php
                    $query = "SELECT email, firstName, lastName FROM client WHERE doctor_id = :id";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute(array('id'=>$_SESSION['user_id']));
                    $results = $stmt->fetchAll();

                    foreach($results as $result)
                        echo "<option value='". $result['email'] ."'>". $result['firstName'] . " " . $result['lastName'] ."</option>";
                ?>
            </datalist>
        </p>
        <br>
        <p>
            <label for="Subject">Subject</label>
            <input id="Subject" class="w3-input" type="text" name="subject" required>
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

<div id="result" style=" height: 700px; width: 900px; margin-left: 400px; position: absolute; display: none; ">
    <br>

    <div style="background-color: pink;">
        <h2 id="header" style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black"></h2>
    </div>

    <div style="height: 400px; width: 900px; font-size: 30px; border: dashed; border-color: black">
        <div id="date" style="margin-left: 25px"></div>
        <div id="email" style="margin-left: 25px"></div>
        <div id="text" style="margin-left: 25px"></div>
    </div>
</div>
</body>
</html>