<?php
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
    unset($_SESSION['userId']);
}

function getSessionAdmin()
{
    return $_SESSION['adminId'];
}

function isAdminSessionSet()
{
    return isset($_SESSION['adminId']);
}

function setAdminSession($adminId)
{
    $_SESSION['adminId'] = $adminId;
}

function deleteAdminSession()
{
    unset($_SESSION['adminId']);
}


function destroySession()
{
    session_unset();
    session_destroy();
}
