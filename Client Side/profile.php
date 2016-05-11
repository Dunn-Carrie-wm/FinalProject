<?php
    require_once("connect.php");
    define('MM_UPLOADPATH', '../images/');
    define('MM_MAXFILESIZE', 32768);      // 32 KB
    define('MM_MAXIMGWIDTH', 120);        // 120 pixels
    define('MM_MAXIMGHEIGHT', 120);       // 120 pixels

    if(@$_POST['addMedicine'])
    {
        $query = "INSERT INTO calendar (medicine_name, date, medicine_time) VALUES (:name, :date, :time)";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array('name'=>$_POST['medicine'], 'date'=>date('Y/m/d'), 'time'=>$_POST['time']));
    }

    if(@$_POST['addActivity'])
    {
        $query = "INSERT INTO calendar (activity_name, date) VALUES (:name, :date)";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array('name'=>$_POST['activity'], 'date'=>date('Y/m/d')));
    }

    if(@$_POST['remove'])
    {
        $query = "DELETE FROM calendar WHERE calendar_id = :id";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array('id'=>$_POST['remove']));
    }


    if (isset($_POST['submit']))
    {
        $old_picture = trim($_POST['old_picture']);
        $new_picture = trim($_FILES['new_picture']['name']);
        $new_picture_type = $_FILES['new_picture']['type'];
        $new_picture_size = $_FILES['new_picture']['size'];
        @list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
        $error = false;

        // Validate and move the uploaded picture file, if necessary
        if (!empty($new_picture))
        {
            if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
                    ($new_picture_type == 'image/png')) && ($new_picture_size > 0))
            {
                if (@$_FILES['file']['error'] == 0)
                {
                    // Move the file to the target upload folder
                    $target = MM_UPLOADPATH . basename($new_picture);
                    if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
                        // The new picture file move was successful, now make sure any old picture is deleted
                        if (!empty($old_picture) && ($old_picture != $new_picture) && ($old_picture != "profile.png")) {
                            @unlink(MM_UPLOADPATH . $old_picture);
                        }
                    }
                    else {
                        // The new picture file move failed, so delete the temporary file and set the error flag
                        @unlink($_FILES['new_picture']['tmp_name']);
                        $error = true;
                        echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
                    }
                }
            }
            else {
                // The new picture file is not valid, so delete the temporary file and set the error flag
                @unlink($_FILES['new_picture']['tmp_name']);
                $error = true;
                echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
                    ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
            }
        }

        // Update the profile data in the database
        if (!$error)
        {
            // Only set the picture column if there is a new picture
            if (!empty($new_picture))
            {
                $query = "UPDATE client SET picture = :picture WHERE id = :user_id";
                $stmt = $dbh->prepare($query);
                $stmt->execute(array("picture"=>$new_picture, "user_id"=>$_SESSION['user_id']));
            }

            // Confirm success with the user
            echo '<p>Your profile has been successfully updated.</p>';
            $dbh = null;
        }
    } // End of check for form submission
    else
    {
        // Grab the profile data from the database
        if(isset($_GET['id']) && isset($_GET['name']))
            $query = "SELECT * FROM client where id = " . $_GET['id'] ."";
        else
            $query = "SELECT * FROM client where id = " . $_SESSION['user_id'] ."";

        $stmt = $dbh ->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result != NULL)
            $old_picture = $result['picture'];

        else
            echo '<p class="error">There was a problem accessing your profile.</p>';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profile Page</title>
        <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../Css/style.css">
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="../Css/calendar.css" rel="stylesheet">

        <style>
            #medicine, #activity
            {
                width: 5%;
                float: left;
            }
            .delete
            {
                padding-left: 8px;
                padding-right: 8px;
            }
        </style>
    </head>

    <body>
        <div style="width: 100%">
            <nav>
                <div class="navToggle">
                    <div class="icon"></div>
                </div>

                <ul>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="noteinput.php">Note Pad</a></li>
                    <li><a href="reminderinput.php">Reminder</a></li>
                    <li><a href="general.php">General Facts</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            </nav>

            <script>
                $(".navToggle").click (function(){
                    $(this).toggleClass("open");
                    $("nav").toggleClass("open");
                });
            </script>

            <div>
                <div style="width: 15%; right: 0; top: 0; position: absolute">
                    <img src='../images/<?= $result['picture'] ?>' style="width: 15%; float: left; top: 0; border: solid darkslategray; margin-left: 150px; position: absolute;">

                    <form method="post">
                        <label for="new_picture">Picture:</label>
                        <input type="file" id="new_picture" name="new_picture" />
                        <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
                        <input type="submit" value="Change Picture" name="submit" />
                    </form>
                <div>

                <div style="margin-top: 10px;">
                    <?php
                        echo "<p style='margin-left: 375px; font-size: x-large'>" . $result['firstName'] . ' '. ' ' .$result['lastName'] . "</p>";
                        echo "<p style='margin-left: 375px; font-size: x-large'>" . $result['type'] . "</p>";
                    ?>
                </div>
                <div id="cal" style="height: 300px; margin-top: 130px;">
                   <?php $results = draw_calendar($month,$year, $dbh, $monthName);
                    echo $results[0];
                   ?>
                </div>

                <div style="margin-left: 350px;">
                    <table style="margin-top: 15px">
                        <tr>
                            <td>
                                <form method="post">
                                    <table class="table" id="medicine" align="center" style="margin-top: 10px; margin-left: 15px">
                                        <tr>
                                            <th>Medication Name</th>
                                            <th>Time Taken</th>
                                        </tr>
                                        <?php
                                        $query = "SELECT * FROM calendar WHERE date = :date AND medicine_name != '' ORDER BY medicine_time";
                                        $stmt = $dbh->prepare($query);
                                        $stmt->execute(array('date'=>$results[1]));
                                        $info = $stmt->fetchAll();

                                        foreach($info as $result)
                                        {
                                            $time = new DateTime($result['medicine_time']);
                                            echo '<tr>';
                                            echo '<td>' . $result['medicine_name'] . '</td>';
                                            echo '<td>' . $time->format('h:i a') . '</td>';
                                            echo '<td> <button class="delete" type="submit" name="remove" value="'. $result['calendar_id'] .'">-</button></td>';
                                            echo '<tr>';
                                        }
                                        ?>
                                        <tr>
                                            <td><input type="text" name="medicine"></td>
                                            <td><input type="time" name="time"></td>
                                            <td><input type="submit" name="addMedicine" value="+"></td>
                                        </tr>
                                    </table>
                                </form>
                            </td>

                            <td>
                                <form method="post">
                                    <table class="table" id="activity" align="center" style="margin-top: 5px; margin-left: 15px">
                                        <tr>
                                            <th>Activity Name</th>
                                        </tr>
                                        <?php
                                        $query = "SELECT * FROM calendar WHERE date = :date AND activity_name != ''";
                                        $stmt = $dbh->prepare($query);
                                        $stmt->execute(array('date'=>$results[1]));
                                        $info = $stmt->fetchAll();

                                        foreach($info as $result)
                                        {
                                            echo '<tr>';
                                            echo '<td>' . $result['activity_name'] . '</td>';
                                            echo '<td> <button class="delete" type="submit" name="remove" value="'. $result['calendar_id'] .'">-</button></td>';
                                            echo '<tr>';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <input list="activities" name="activity">

                                                <datalist id="activities">
                                                    <option value="Running">
                                                    <option value="Swimming">
                                                    <option value="Hiking">
                                                    <option value="Jogging">
                                                    <option value="Biking">
                                                </datalist>
                                            </td>

                                            <td><input type="submit" name="addActivity" value="+"></td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>