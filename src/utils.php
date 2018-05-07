<?php
function isArrayEmpty($inArray)
{
  $inArray = array_filter($inArray);
  return empty($inArray);
}

function isPostVarSet($postVar)
{
  return isset(array_filter($_POST)[$postVar]);
}

function getPostVar($postVar)
{
  return filter_input(INPUT_POST, $postVar);
}
?>
