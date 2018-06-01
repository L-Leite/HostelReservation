<?php
// exposes session functions and starts it

function hasSessionStarted()
{
    return session_status() == PHP_SESSION_ACTIVE;
}

function getSessionUser()
{
    return $_SESSION['userId'];
}

function isSessionSet()
{
    return isset($_SESSION['userId']);
}

function setSession($userId)
{
    $_SESSION['userId'] = $userId;
}

function deleteSession()
{
    unset($_SESSION['username']);
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
