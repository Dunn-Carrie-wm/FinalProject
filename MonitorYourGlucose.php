<?php
$dbc = new PDO('mysql:host=localhost;dbname=injection', 'root','root');
?>
<!DOCTYPE html>
<html>
<head xmlns="http://www.w3.org/1999/html">
    <link rel="stylesheet" href="style.css">

    <script>
        function checkingGlucose (){
            x = document.getElementById("glucose");

            if (x.value <100){
                alert('Your Glucose Level is Low, please see our listed recommendations to maintain at a normal healthy level.');
            } else if(100<x.value>140){
                alert('Your Glucose Level is normal/healthy.');
            }else{
                alert('Your Glucose Level is High, please see our listed recommendations to maintain at a normal healthy level.');
            }
        }
    </script>
</head>
<body>
<br><br>
<center>
    <p> Enter glucose level below: </p>
    <input type="text" id="glucose"/> <br>
    <input type="button" value="submit" onclick="checkingGlucose()">
</center>

</body>
</html>
