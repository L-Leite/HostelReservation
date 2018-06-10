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

function getRequestedPath($url)
{
    $paths = explode('/', $url);

    $desiredIndex = $GLOBALS['dirDistance'] + 1;

    if (sizeof($paths) > $desiredIndex + 1) {
        return false;
    }

    $getStart = strpos($paths[$desiredIndex], '?');

    return substr($paths[$desiredIndex], 0, $getStart ? $getStart : strlen($paths[$desiredIndex]));
}
