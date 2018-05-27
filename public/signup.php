<?php
require '../config/www.php';
require 'src/session.php';
require 'src/utils.php';

try {
    $isSigningUp = isPostVarSet('doSignup');

    if ($isSigningUp == true) {
        if (!isPostVarSet('firstn')
      || !isPostVarSet('lastn')
      || !isPostVarSet('username')
      || !isPostVarSet('password')
      /*|| !isPostVarSet('address')
      || !isPostVarSet('phone')
      || !isPostVarSet('email')*/) {
            echo json_encode(array('status' => 'error'));
            die();
        }
        require 'src/db.php';

        $firstName = getPostVar('firstn');
        $lastName = getPostVar('lastn');
        $username = getPostVar('username');
        $password = getPostVar('password');
        $address = getPostVar('address');
        $phoneNumber = getPostVar('phone');
        $email = getPostVar('email');
        $goodClient = $hostelDb->newClient(
            $firstName,
            $lastName,
            $address,
            $phoneNumber,
            $email,
            $username,
            $password
        );

        if ($goodClient) {
            setSession($username);
            echo json_encode(array('status' => 'ok'));
        } else {
            echo json_encode(array('status' => 'error',
              'message' => 'userAlreadyExists'));
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

  <title>Crie uma conta | HostelReservation</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css" />

  <!-- CSS base -->
  <link href="styles/base.css" rel="stylesheet">

  <!-- CSS do login -->
  <link href="styles/login.css" rel="stylesheet">
</head>

<body>
  <?php //require('templates/navbar.php'); ?>

  <main class="text-center">
    <form class="form-signin" id="signupForm" method="POST">
      <img class="mb-4" src="images/logo.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Crie uma conta</h1>
      <div id="errorContainer" class="alert alert-danger" style="display:none;">
        <span></span>
      </div>
      <div class="form-group">
        <label for="inputFirstN" class="sr-only">Primeiro nome</label>
        <input type="text" data-rule-maxlength="45" data-rule-required="true" id="inputFirstN" name="firstn" class="form-control" placeholder="O seu primeiro nome" required autofocus>
        <label for="inputLastN" class="sr-only">Último nome</label>
        <input type="text" data-rule-maxlength="45" data-rule-required="true" id="inputLastN" name="lastn" class="form-control" placeholder="O seu segundo nome" required>
      </div>
      <div class="form-group">
        <label for="inputUsername" class="sr-only">Nome de utilizador</label>
        <input type="text" data-rule-maxlength="45" data-rule-required="true" data-rule-password="Por favor escreva o seu nome de utilizador." id="inputUsername" name="username" class="form-control" placeholder="O seu nome de utilizador" required>
        <label for="inputPassword" class="sr-only">Palavra-passe</label>
        <input type="password" data-rule-maxlength="45" data-rule-required="true" id="inputPassword" data-rule-password="Por favor escreva uma palava-passe." name="password" class="form-control" placeholder="A sua palavra-passe" required>
        <label for="inputConfPassword" class="sr-only">Confirmação da palavra-chave</label>
        <input type="password" data-rule-maxlength="45" data-rule-required="true" data-rule-password="Por favor repita a sua palava-passe." data-rule-equalTo="#inputPassword" id="inputConfPassword" class="form-control" placeholder="Insira a sua palavra-passe novamente" required>
      </div>
      <div class="form-group">
        <h5>Opcional</h5>
        <label for="inputAddress" class="sr-only">Morada</label>
        <input type="text" max="45" id="inputAddress" name="address" class="form-control" placeholder="A sua morada">
        <label for="inputPhone" class="sr-only">Telemóvel</label>
        <input type="text" id="inputPhone" matches="[0-9]+" name="phone" class="form-control" placeholder="O seu telemóvel">
        <label for="inputEmail" class="sr-only">Endereço de email</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="O seu endereço de email">
      </div>
      <div style="display:none">
        <span id="errorMessage"></span>
      </div>
      <input type="hidden" name="doSignup" value="1">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Criar conta</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </main>

  <!-- jQuery -->
  <script src="vendor/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap e as suas dependências -->
  <script src="vendor/popper.js/dist/umd/popper.min.js"></script>
  <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- jQuery-validate para os formulários -->
  <script src="vendor/jquery-validation/dist/jquery.validate.js"></script>

  <!-- SHA3 para a palavra-passe do cliente -->
  <script src="vendor/crypto-js/crypto-js.js"></script>

  <!-- Para redirecionar para uma página -->
  <script src="js/utils.js"></script>

  <script>
    $('#signupForm').submit(function(form) {
      console.log('teste')
      form.preventDefault()

      if ($('#inputPassword').value !== $('#inputConfPassword').value) {
        $('#errorContainer').show('fast')
          .find('span').html('Por favor repita a sua palavra-passe corretamente.')
        return
      }

      var inputPassword = $('#inputPassword').val()
      var hashedPassword = CryptoJS.SHA3(inputPassword)

      var postData = {}
      for (var i = 0; i < form.length; ++i) {
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

            if (message === 'userAlreadyExists') {
              $('#errorContainer').show('fast')
                .find('span').html('Este utilizador já existe!')
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
    })
  </script>

  <!-- TEMP: Remover isto. É usado para atualizar automaticamente páginas alteradas -->
  <script src="http://localhost:35729/livereload.js"></script>
</body>

</html>
