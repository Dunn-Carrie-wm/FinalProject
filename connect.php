<?php
    date_default_timezone_set('America/Phoenix');

    /*** mysql hostname ***/
    $hostname = 'localhost';
    /*** mysql username ***/
    $username = 'root';
    /*** mysql password ***/
    $password = 'root';

    try
    {
        $dbh = new PDO("mysql:host=$hostname;dbname=injection", $username, $password);
        // set the PDO error mode to exception
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    session_start();

    // If the session vars aren't set, try to set them with a cookie
    if (!isset($_SESSION['user_id']))
    {
        if (isset($_COOKIE['user_id']))
          $_SESSION['user_id'] = $_COOKIE['user_id'];
    }

    // If the session vars aren't set, try to set them with a cookie
    if (!isset($_SESSION['client_id']))
    {
        if (isset($_COOKIE['client_id']))
            $_SESSION['client_id'] = $_COOKIE['client_id'];
    }

    function send_mail($email,$message,$subject)
    {
        require_once('mailer/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->AddAddress($email);
        $mail->Username="juan.chavez@west-mec.org";
        $mail->Password="8Bc9ZZ15";
        $mail->SetFrom('juan.chavez@west-mec.org','Injection');
        $mail->AddReplyTo("juan.chavez@west-mec.org","Injection");
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }

    for($i = 1; $i <= 2; $i++)
    {
        if($i == 1)
            $table = "s";
        else if ($i == 2)
            $table = "sc";

        $today = date("Y-m-d");
        $query = "SELECT * FROM reminder" . $table;
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();

        foreach($results as $row)
        {
            $date = $row['date'];

            if ($date <= $today)
            {
                if($row['confirm'] == 'true')
                {
                    $email = $row['email'];
                    $message = $row['message'];
                    $subject = $row['subject'];

                    send_mail($email, $message, $subject);

                    $query = "UPDATE reminder" . $table . " SET confirm = 'false' WHERE id = :id";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute(array("id"=>$row['id']));
                }
            }
        }
    }