<?php
require '../config/www.php';
require 'src/session.php';
require 'src/utils.php';

try {
    $isLoginIn = isPostVarSet('doLogin');

    if ($isLoginIn == true) {
        if (!isPostVarSet('username')
          || !isPostVarSet('password')) {
            echo json_encode(array('status' => 'error'));
            die();
        }
        require 'src/db.php';

        $username = getPostVar('username');
        $password = getPostVar('password');
        $goodLogin = $hostelDb->loginClient(
            $username,
            $password
        );

        if ($goodLogin) {
            setSession($username);
            echo json_encode(array('status' => 'ok'));
        } else {
            echo json_encode(array('status' => 'error',
              'message' => 'invalidClient'));
        }

        die();
    }
} catch (\Exception $e) {
    echo json_encode(array('status' => 'error',
      'message' => $e->getMessage()));
    die();
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

  <title>Entre na sua conta - HostelReservation</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />

  <!-- CSS base -->
  <link href="styles/base.css" rel="stylesheet">

  <!-- CSS do login -->
  <link href="styles/login.css" rel="stylesheet">
</head>

<body>
  <?php require('templates/navbar.php'); ?>

  <main class="text-center">
    <form class="form-signin" id="loginForm" method="POST">
      <img class="mb-4" src="images/logo.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Entre na sua conta</h1>
      <div id="errorContainer" class="alert alert-danger" style="display:none;">
        <span></span>
      </div>
      <div class="form-group">
        <label for="inputUsername" class="sr-only">Nome de utilizador</label>
        <input type="text" data-rule-maxlength="45" data-rule-required="true" data-rule-password="Por favor escreva o seu nome de utilizador." id="inputUsername" name="username" class="form-control" placeholder="O seu nome de utilizador" required>
        <label for="inputPassword" class="sr-only">Palavra-passe</label>
        <input type="password" data-rule-maxlength="45" data-rule-required="true" id="inputPassword" data-rule-password="Por favor escreva uma palava-passe." name="password" class="form-control" placeholder="A sua palavra-passe" required>
      </div>
      <input type="hidden" name="doLogin" value="1">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </main>

  <!-- jQuery -->
  <script src="vendor/jquery/dist/jquery.js"></script>

  <!-- Bootstrap e as suas dependências -->
  <script src="vendor/popper.js/dist/umd/popper.js"></script>
  <script src="vendor/bootstrap/dist/js/bootstrap.js"></script>

  <!-- jQuery-validate para os formulários -->
  <script src="vendor/jquery-validation/dist/jquery.validate.js"></script>

  <!-- SHA3 para a palavra-passe do cliente -->
  <script src="vendor/crypto-js/crypto-js.js"></script>

  <!-- Para redirecionar para uma página -->
  <script src="js/utils.js"></script>

  <script>
    $('#loginForm').validate({
      debug: true,
      errorPlacement: function (error, element) {
        $('#errorContainer').toggle().find('span').html(error)
    },
      submitHandler: function(form) {
        var inputPassword = $('#inputPassword').val()
        var hashedPassword = CryptoJS.SHA3(inputPassword)

        var postData = {}
        for (var i = 0;i < form.length; ++i) {
          var input = form[i]
          if (input.name) {
            postData[input.name] = input.value
          }
        }

        postData['password'] = hashedPassword.toString()

        $.post(form.action, postData)
          .done(function(data){
            var statusData = $.parseJSON(data)
            var status = statusData['status']
            if (status == 'ok') {
              redirectToPage('list.php');
            }
            else {
              var message = statusData['message']

              if (message === 'invalidClient') {
                $('#errorContainer').show('fast')
                  .find('span').html('Por favor insira a sua informação corretamente.')
              }
              else {
                $('#errorContainer').show('fast')
                  .find('span').html('Ocorreu um erro ao criar a sua conta.')
              }
            }
          })
          .fail(function(){
            $('#errorContainer').show('fast')
              .find('span').html('Ocorreu um erro ao criar a sua conta.')
          })
      }
    });
  </script>

  <!-- TEMP: Remover isto. É usado para atualizar automaticamente páginas alteradas -->
  <script src="http://localhost:35729/livereload.js"></script>
</body>

</html>
