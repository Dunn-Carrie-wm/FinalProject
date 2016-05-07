<?php
    session_start();

    if (isset($_SESSION['user_id']))
    {
        // If the user is logged in, delete the session vars to log them out
        if (isset($_SESSION['user_id']))
        {
            // Delete the session vars by clearing the $_SESSION array
            $_SESSION = array();

            // Delete the session cookie by setting its expiration to an hour ago (3600)
            if (isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time() - 3600);

            // Destroy the session
            session_destroy();
        }

        // Delete the user ID and username cookies by setting their expirations to an hour ago (3600)
        setcookie('user_id', '', time() - 3600);
        setcookie('username', '', time() - 3600);

        // Redirect to the login page
        header('Location: login.php');

        unset($_COOKIE['user_id']);
        setcookie('user_id', '', time() - 3600, '/'); // empty value and old timestamp
        unset($_SESSION['user_id']);
    }