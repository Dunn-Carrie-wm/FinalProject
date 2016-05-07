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
  if (!isset($_SESSION['user_id'])) {
      if (isset($_COOKIE['user_id']) && isset($_COOKIE['username']))
      {
          $_SESSION['user_id'] = $_COOKIE['user_id'];
          $_SESSION['username'] = $_COOKIE['username'];
      }
  }