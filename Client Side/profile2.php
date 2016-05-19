<?php
    //Start the session
    require_once('../connect.php');

    if (!isset($_SESSION['client_id']) && !isset($_SESSION['user_id'])) {
        echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
        exit();
    }

    $date = date('Y-m-d');

    // Grab the profile data from the database
    if(isset($_GET['id']) && isset($_GET['name']))
    {
        $query = "SELECT * FROM client WHERE id = " . $_GET['id'] ."";
        $id = $_GET['id'];
    }

    else
    {
        if(isset($_SESSION['client_id']))
        {
            $query = "SELECT * FROM client WHERE id = " . $_SESSION['client_id'] ."";
            $id = $_SESSION['client_id'];
        }
    }

    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch();

    if(@$_POST['add'])
    {
        $query = "INSERT INTO calendar (medicine_name, date, medicine_time, activity_name, glucose, meal, user_id) VALUES (:name, :date, :time, :activity, :glucose, :meal, :id)";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array('name'=>$_POST['medicine'], 'date'=>date('Y/m/d'), 'time'=>$_POST['time'], 'activity'=>$_POST['activity'], 'glucose' => $_POST['glucose'], 'meal'=>$_POST['meal'], 'id'=>$id));
    }

    if(@$_POST['remove'])
    {
        $query = "DELETE FROM calendar WHERE calendar_id = :id";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array('id'=>$_POST['remove']));
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../Css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/cal.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <style>
        .close
        {
            float: right;
            width: 70px;
            height: 55px;
            background: transparent no-repeat;
            border: none;
            cursor: pointer;
            overflow: hidden;
            outline: none;
            font-size: 175%;
        }
        #secondDiv
        {
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            width: 480px;
            height: 580px;
            z-index: 15;
        }
        .information
        {
            margin-left: auto;
            margin-right: auto;
            margin-top: 5.5%;
            border: solid;
            z-index: 3;
            background: rgba(255, 255, 255, 1);
            position: relative;
        }
         #divheader{
             width: 100%;
             height: 85px;
             text-align: center;
             background-color: #FF6860;
             padding: 18px 0;
             -webkit-border-radius: 12px 12px 0px 0px;
             -moz-border-radius: 12px 12px 0px 0px;
             border-radius: 12px 12px 0px 0px;
         }
        #divheader h2{
            font-size: 1.5em;
            color: #FFFFFF;
            float:left;
            width:70%;
        }
    </style>
</head>

<body>
<?php
if(isset($_GET['id'])) {
    ?>
    <nav>
        <div class="navToggle">
            <div class="icon"></div>
        </div>
        <ul>
            <li><a href="../Business%20Side/home.php">Home Page</a></li>
            <li><a href="../Business%20Side/patientList.php">Patient List</a></li>
            <li><a href="../Business%20Side/note.php">Note Pad</a></li>
            <li><a href="../Business%20Side/reminders.php">Reminder</a></li>
            <li><a href="../Business%20Side/general.php">General Facts</a></li>
            <li><a href="../Business%20Side/logout.php">Log Out</a></li>
        </ul>
    </nav>
<?php
}

else{ ?>
    <nav>
        <div class="navToggle">
            <div class="icon"></div>
        </div>
        <ul>
            <li><a href="notec.php">Note Pad</a></li>
            <li><a href="remindersc.php">Reminder</a></li>
            <li><a href="general.php">General Facts</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
<?php
}
?>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script>
        $(".navToggle").click (function(){
            $(this).toggleClass("open");
            $("nav").toggleClass("open");
        });
    </script>

    <div id="profile" style="height: 250px; width: 250px; margin-left: 150px; margin-top: 20px; border: dashed; border-color: #00b7bb; ">
        <img src='../images/<?= $result['picture'] ?>' style="height: 200px; width: 200px; margin-top: 5px; margin-left: 15px;">
    </div>

    <div id="name" style="border: solid; border-color: black; height: 250px; width: 900px; margin-left: 410px; margin-top: -250px;">
       <?php
            echo"<br> <br> <br>";

            echo "<p style='font-size: 50px; margin-left: 20px;'>" . $result['firstName'] . ' ' . $result['lastName'] . "</p>";
            echo "<p style='font-size: 40px; margin-left: 20px;'>" . $result['type'] . "</p>";
        ?>
    </div>

    <div id="calender" style="height: 600px; width: 560px; margin-left: 150px; ">
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="cal.js"></script>

        <script>
            $(document).ready(function(){
                $(".today").click(function(){
                    $('#secondDiv').show();
                });

                $(".close").click(function(){
                    $('#secondDiv').hide();
                });
            });

            function checkingGlucose()
            {
                var x = document.forms["addInput"]["glucose"].value;
                if(x != null && x != "")
                {
                    if (x < 100)
                        alert('Your glucose level is low, please see our listed recommendations to maintain a normal healthy level.');
                    else if((100 <= x) && (x <= 140))
                        alert('Your glucose level is normal/healthy.');
                    else
                        alert('Your glucose level is high, please see our listed recommendations to maintain a normal healthy level.');
                }
            }
        </script>

        <?php
            if(isset($_GET['id']) && isset($_GET['name'])){?>

        <div id="secondDiv" style="background-color: white; margin-top: 15px; width: 86%">
            <div id="divheader" style="text-indent: 30%;">
                <h2 id="header" style="text-decoration: underline; font-size: 40px; text-align: center; font-family: Times New Roman; color: black"><?= date('m-d-Y'); ?></h2>
            </div>

            <div class="information" style="height: 65%; margin-top: 10px;">
                <div>
                    <table class="table" style="margin-top: 15px">
                        <tr>
                            <th>Medication Name</th>
                            <th>Time Taken</th>
                            <th>Glucose</th>
                            <th>Meal</th>
                            <th>Activity Name</th>
                        </tr>
                        <?php
                        $query = "SELECT * FROM calendar WHERE date = :date AND user_id = :id";
                        $stmt = $dbh->prepare($query);
                        $stmt->execute(array('date'=>$date, 'id'=>$id));
                        $info = $stmt->fetchAll();

                        foreach($info as $result)
                        {
                            echo '<tr><td>' . $result['medicine_name'] . '</td>';

                            if($result['medicine_time'] == 0)
                                echo "<td></td>";
                            else
                            {
                                $time = new DateTime($result['medicine_time']);
                                echo '<td>' . $time->format('h:i a') . '</td>';
                            }

                            if($result['glucose'] == 0)
                                echo "<td></td>";
                            else
                                echo '<td>' . $result['glucose'] . '</td>';

                            echo '<td>' . $result['meal'] . '</td>';
                            echo '<td>' . $result['activity_name'] . '</td>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <?php

            }
            else
            {
            ?>

        <div id="calendar" style="margin-top: 48px; float: left; margin-left: 20px;">
            <div id="calendar_header" style="text-indent: 30%">
                <h1></h1>
            </div>

            <div id="calendar_weekdays"></div>
            <div id="calendar_content"></div>

            <div id="secondDiv" style="display: none; background-color: white;">
                <div id="divheader" style="text-indent: 30%;">
                    <h2 id="header" style="text-decoration: underline; font-size: 40px; text-align: center; font-family: Times New Roman; color: black"><?= date('m-d-Y'); ?></h2>
                </div>

                <div class="information" style="height: 55%;">
                    <div>
                        <button class="close">&#10006;</button>

                        <form method="post">
                            <table class="table" style="margin-top: 15px">
                                <tr>
                                    <th>Medication Name</th>
                                    <th>Time Taken</th>
                                    <th>Glucose</th>
                                    <th>Meal</th>
                                    <th>Activity Name</th>
                                </tr>
                                <?php
                                $query = "SELECT * FROM calendar WHERE date = :date AND user_id = :id";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array('date'=>$date, 'id'=>$id));
                                $info = $stmt->fetchAll();

                                foreach($info as $result)
                                {
                                    echo '<tr><td>' . $result['medicine_name'] . '</td>';

                                    if($result['medicine_time'] == 0)
                                        echo "<td></td>";
                                    else
                                    {
                                        $time = new DateTime($result['medicine_time']);
                                        echo '<td>' . $time->format('h:i a') . '</td>';
                                    }

                                    if($result['glucose'] == 0)
                                        echo "<td></td>";
                                    else
                                        echo '<td>' . $result['glucose'] . '</td>';

                                    echo '<td>' . $result['meal'] . '</td>';
                                    echo '<td>' . $result['activity_name'] . '</td>';
                                    echo '<td> <button class="delete" type="submit" name="remove" value="'. $result['calendar_id'] .'">-</button></td></tr>';
                                }
                                ?>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="inputs" style="height: 600px; width: 550px; margin-left: 740px; margin-top: -600PX;">
        <form id="msform" method="post" name="addInput">
            <fieldset>
                <h2 class="fs-title">Input Today's Data</h2>
                <h3 class="fs-subtitle"><?= date("m-d-Y"); ?></h3>
                <input id="time" type="time" name="time"/>
                <input id="medicine" type="text" name="medicine" placeholder="Medication" />
                <input id="meal" type="text" name="meal" placeholder="Meal" />
                <input id="glucose" type="text" name="glucose" placeholder="Glucose" />

                <input list="activities" name="activity" placeholder="Activities">
                <datalist id="activities">
                    <option value="Running">
                    <option value="Swimming">
                    <option value="Hiking">
                    <option value="Jogging">
                    <option value="Biking">
                </datalist>

                <input type="submit" name="add" id="add" value="+" onclick="checkingGlucose()">
            </fieldset>
        </form>
    </div>
    <?php } ?>
</body>
</html>