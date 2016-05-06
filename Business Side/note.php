<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Note Pad</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="note.css">
    <script src="note.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
</head>
<body>

<div style="background-color: white; height: 700px; width: 370px; position: absolute; margin-left: 10px; margin-top: 10px;">
<h1 style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman">Notes</h1>
    <?php
   $dbh = new PDO('mysql:host=localhost;dbname=injection', 'root', 'root');

    // Retrieve the user data from MySQL
    $query = "SELECT title, date FROM note";
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $results = $stmt ->fetchAll();


    echo '<table >';
            foreach($results as $row)
            {
                echo '<tr style="border: dashed; border-color: #00b7bb; text-align: center; height: 60px; width: 100%;"><td>'. $row['title'].'</td>';
            }
    echo '</table>'
    ?>
</div>
<?php
try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=injection', 'root', 'root');

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
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

    $stmt = $dbh->prepare("INSERT INTO note (title, date, text ) VALUES (?, ?, ?)");

    $result = $stmt->execute(array($_POST['title'], $_POST['date'], $_POST['text']));

    if(!$result){
        print_r($stmt->errorInfo());
    }
    if(!empty($errorMessage))
    {
        echo("<p>There was an error with your form:</p>\n");
        echo("<ul>" . $errorMessage . "</ul>\n");
    }

}?>
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

<div style=" height: 700px; width: 900px; margin-left: 400px; position: absolute; ">
    <br>
    <div style="background-color: pink;">
        <h2 style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black">New Entry</h2>
    </div>

    <form class="w3-container" method="post">
        <p>
            <label>Title</label>
            <input class="w3-input" type="text" name="title">
        </p>
            <br>
        <p>
            <label>Date</label>
            <input class="w3-input" type="date" name="date">
        </p>
            <br>
        <p>
            <label>Text</label>
            <input class="w3-input" type="text" style="height: 100px;" name="text">
        </p>
        <br>

        <input name="formSubmit" value="Submit" class="btn btn-lg btn-primary btn-block btn-signin" type="submit" style="height: 50px; width: 300px; margin-left: 570px; border-radius: 10px;">
    </form>
</div>

<div id="" style=" height: 700px; width: 900px; margin-left: 400px; position: absolute; ">
    <br>
    <div style="background-color: pink;">
        <h2 style="text-decoration: underline; font-size: 50px; text-align: center; font-family: Times New Roman; color: black">New Entry</h2>
    </div>

    <form class="w3-container" method="post">
        <p>
            <label>Title</label>
            <input class="w3-input" type="text" name="title">
        </p>
        <br>
        <p>
            <label>Date</label>
            <input class="w3-input" type="date" name="date">
        </p>
        <br>
        <p>
            <label>Text</label>
            <input class="w3-input" type="text" style="height: 100px;" name="text">
        </p>
        <br>

        <input name="formSubmit" value="Submit" class="btn btn-lg btn-primary btn-block btn-signin" type="submit" style="height: 50px; width: 300px; margin-left: 570px; border-radius: 10px;">
    </form>
</div>


</body>
</html>
