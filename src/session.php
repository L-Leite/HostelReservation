<?php
    function hasSessionStarted()
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    function isSessionSet()
    {
        return isset($_SESSION['username']);
    }

    function setSession($username)
    {
        $_SESSION['username'] = $username;
    }

    function deleteSession()
    {
        unsset($_SESSION['username']);
    }

    function destroySession()
    {
        session_unset();
        session_destroy();
    }

// auto start session for any file that includes us
if (hasSessionStarted() == false) {
    session_start();
}
