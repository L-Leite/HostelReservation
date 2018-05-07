<?php
require 'db/hostel.php';

$isLoginIn = filter_input(INPUT_POST, 'doLogin') != null;

if ($isLoginIn) {
    $userName = filter_input(INPUT_POST, 'user');
    $passWord = filter_input(INPUT_POST, 'password');

    if ($hostelDb->getClientByDetails($userName, $passWord, $userResult)
        && ($userResult = array_filter($userResult) && !$empty($userResult))) {
        session_start();
        $_SESSION['currentUser'] = $userName;
        echo 'da';
    } else {
        //mostrar erro ao utilizador
    }
}
?>
<!doctype html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">

  <title>Signin Template for Bootstrap</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="libs/bootstrap/4.0.0/css/bootstrap.min.css" />

  <!-- CSS do login -->
  <link href="styles/login.css" rel="stylesheet">
</head>

<body class="text-center">
  <form class="form-signin">
    <img class="mb-4" src="images/logo.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
  </form>

  <!-- jQuery -->
  <script src="node_modules/jquery/dist/jquery.js"></script>

  <!-- Bootstrap e as suas dependências -->
  <script src="node_modules/popper.js/dist/umd/popper.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>

  <!-- jQuery-validate para os formulários -->
  <script src="node_modules/jquery-validation/dist/jquery.validate.js"></script>

  <!-- SHA3 para a palavra-passe do cliente -->
  <script src="node_modules/crypto-js/crypto-js.js"></script>

  <!-- TEMP: Remover isto. É usado para atualizar automaticamente páginas alteradas -->
  <script src="http://localhost:35729/livereload.js"></script>
</body>

</html>
