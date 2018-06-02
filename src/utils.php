<?php
// utility functions to speed up code writing

function isArrayEmpty($inArray)
{
    $inArray = array_filter($inArray);
    return empty($inArray);
}

function isGetVarSet($postVar)
{
    return isset(array_filter($_GET)[$postVar]);
}

function getGetVar($postVar)
{
    return filter_input(INPUT_GET, $postVar);
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
