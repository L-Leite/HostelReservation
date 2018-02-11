<?php
require 'src/session.php';

if (!isSessionSet() === false)
  header('Location: cover.html');
?>
<!doctype html>
<html lang="pt-pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Hello, world!</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="libs/bootstrap/4.0.0/css/bootstrap.min.css" />
  </head>
  <body>
    <h1>Hello, world!</h1>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="libs/jquery/jquery-3.3.1.min.js" />
    <script src="libs/popper.js/1.12.9/popper.min.js" />
    <script src="libs/bootstrap/4.0.0/js/bootstrap.min.js" />
  </body>
</html>
