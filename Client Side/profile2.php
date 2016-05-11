<?php
    require_once("connect.php");
    $date = date('Y-m-d');

    // Grab the profile data from the database
    if(isset($_GET['id']) && isset($_GET['name']))
    {
        $query = "SELECT * FROM client where id = " . $_GET['id'] ."";
        $id = $_GET['id'];
    }

    else
    {
        $query = "SELECT * FROM client where id = " . $_SESSION['user_id'] ."";
        $id = $_SESSION['user_id'];
    }

    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch();

    if(@$_POST['add'])
    {
        $query = "INSERT INTO calendar (medicine_name, date, medicine_time, activity_name, user_id) VALUES (:name, :date, :time, :activity, :id)";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array('name'=>$_POST['medicine'], 'date'=>date('Y/m/d'), 'time'=>$_POST['time'], 'activity'=>$_POST['activity'], 'id'=>$id));
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
    <link rel="stylesheet" href="cal.css">
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
            <li><a href="../Business%20Side/reminderinput.php">Reminder</a></li>
            <li><a href="../Business%20Side/general.php">General Facts</a></li>
            <li><a href="../Business%20Side/logout.php">Log Out</a></li>
        </ul>
    </nav>';
<?php
}

else{ ?>
    <nav>
        <div class="navToggle">
            <div class="icon"></div>
        </div>
        <ul>
            <li><a href="patientList.php">Patient List</a></li>
            <li><a href="note.php">Note Pad</a></li>
            <li><a href="reminderinput.php">Reminder</a></li>
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
        <img src='../images/<?= $result['picture'] ?>' style="height: 220px; width: 220px; margin-top: -5px; margin-left: 15px;">
    </div>

    <div id="name" style="border: solid; border-color: black; height: 250px; width: 900px; margin-left: 410px; margin-top: -250px;">
       <?php
            $query = "SELECT * FROM client";

            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
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
        </script>

        <div id="calendar" style="margin-top: 20px; float: left; margin-left: 20px;">
            <div id="calendar_header" style="text-indent: 30%">
                <h1></h1>
            </div>

            <div id="calendar_weekdays"></div>
            <div id="calendar_content"></div>

            <div id="secondDiv" style="display: none; background-color: white;">
                <div id="divheader" style="text-indent: 30%">
                    <h2 id="header" style="text-decoration: underline; font-size: 40px; text-align: center; font-family: Times New Roman; color: black"><?= date('m-d-Y'); ?></h2>
                </div>

                <div class="information" style="height: 55%;">
                    <div>
                        <button class="close">&#10006;</button>

                            <table class="table" style="margin-top: 15px">
                                <tr>
                                    <th>Medication Name</th>
                                    <th>Time Taken</th>
                                    <th>Activity Name</th>
                                </tr>
                                <?php
                                $query = "SELECT * FROM calendar WHERE date = :date ORDER BY medicine_time";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array('date'=>$date));
                                $info = $stmt->fetchAll();

                                foreach($info as $result)
                                {
                                    $time = new DateTime($result['medicine_time']);
                                    echo '<tr><td>' . $result['medicine_name'] . '</td>';
                                    echo '<td>' . $time->format('h:i a') . '</td>';
                                    echo '<td>' . $result['activity_name'] . '</td></tr>';
                                }
                                ?>
                            </table>
                        </div>
                </div>
            </div>
        </div>

    </div>

    <div id="inputs" style="height: 600px; width: 550px; margin-left: 740px; margin-top: -600PX;">
        <form id="msform" method="post">
            <fieldset>
                <h2 class="fs-title">Input Today's Data</h2>
                <h3 class="fs-subtitle">Today's Date</h3>
                <input type="text" name="medicine" placeholder="Medication" />
                <input type="time" name="time" placeholder="Time Taken" />

                <input list="activities" name="activity" placeholder="Activities">
                <datalist id="activities">
                    <option value="Running">
                    <option value="Swimming">
                    <option value="Hiking">
                    <option value="Jogging">
                    <option value="Biking">
                </datalist>

                <input type="submit" name="add" value="+">
            </fieldset>
        </form>
    </div>
</body>
</html>