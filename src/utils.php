<?php
function isArrayEmpty($inArray)
{
    $inArray = array_filter($inArray);
    return empty($inArray);
}

function isGetVarSet($getVar)
{
    return isset(array_filter($_GET)[$getVar]);
}

function getGetVar($getVar)
{
    return filter_input(INPUT_GET, $getVar);
}

function isPostVarSet($postVar)
{
    return isset(array_filter($_POST)[$postVar]);
}

function getPostVar($postVar)
{
    return filter_input(INPUT_POST, $postVar);
}

function getCurrentPage()
{
    return basename($_SERVER['PHP_SELF']);
}

function getRequestedPath()
{
    $paths = explode('/', $_SERVER['REQUEST_URI']);

    $desiredIndex = $GLOBALS['dirDistance'] + 1;

    if (sizeof($paths) + 1 < $desiredIndex) {
        return false;
    }

    $getStart = strpos($paths[$desiredIndex], '?');

    return substr($paths[$desiredIndex], 0, $getStart ? $getStart : strlen($paths[$desiredIndex]));
}

function isAdminRequest()
{
    $paths = explode('/', $_SERVER['REQUEST_URI']);
    $desiredIndex = $GLOBALS['dirDistance'] + 1;

    $getStart = strpos($paths[$desiredIndex], '?');

    return $paths[$desiredIndex] === 'admin';
}

function getAdminRequest()
{
    $paths = explode('/', $_SERVER['REQUEST_URI']);
    $desiredIndex = $GLOBALS['dirDistance'] + 2;

    if (sizeof($paths) + 1 < $desiredIndex) {
        return false;
    }

    $getStart = strpos($paths[$desiredIndex], '?');

    return substr($paths[$desiredIndex], 0, $getStart ? $getStart : strlen($paths[$desiredIndex]));
}

function redirectTo($page)
{
    header('Location: http://'.$GLOBALS['wwwRootDir'].'/'.$page, true, 307);
    die();
}

function isWebResource($extension)
{
    return $extension === 'js'
        || $extension === 'css'
        || $extension === 'gif'
        || $extension === 'jpg'
        || $extension === 'jpeg'
        || $extension === 'png';
}
