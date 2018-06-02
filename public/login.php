<?php
require '../config/www.php';
require 'src/db.php';
require 'src/session.php';
require 'src/utils.php';

if (isSessionSet() === true) {
    header('Location: index.php');
}

try {
    $isLoginIn = isPostVarSet('doLogin');

    if ($isLoginIn === true) {
        if (!isPostVarSet('username')
            || !isPostVarSet('password')
        ) {
            echo json_encode(array('status' => 'error'));
            die();
        }
        $username = getPostVar('username');
        $password = getPostVar('password');
        $goodLogin = $hostelDb->loginClient(
            $username,
            $password
        );

        if ($goodLogin) {
            setSession($goodLogin);
            echo json_encode(array('status' => 'ok'));
        } else {
            echo json_encode(
                array('status' => 'error',
                    'message' => 'invalidClient')
            );
        }

        die();
    }
} catch (\Exception $e) {
    echo json_encode(
        array('status' => 'error',
            'message' => $e->getMessage())
    );
    die();
}
?>
<!doctype html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">

  <title>Entre na sua conta | HostelReservation</title>

  <!-- Bootstrap's CSS -->
  <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css" />

  <!-- Base CSS -->
  <link rel="stylesheet" href="styles/base.css">

  <!-- Login CSS -->
  <link rel="stylesheet" href="styles/login.css">
</head>

<body>
<?php //require('templates/navbar.php'); ?>

  <main class="text-center">
    <form class="form-signin" id="loginForm" method="POST">
      <img class="mb-4" src="images/logo.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Entre na sua conta</h1>
      <div id="errorContainer" class="alert alert-danger" style="display:none;">
        <span></span>
      </div>
      <div class="form-group">
        <label for="inputUsername" class="sr-only">Nome de utilizador</label>
        <input type="text" id="inputUsername" name="username"
          class="form-control" placeholder="O seu nome de utilizador" required>
        <label for="inputPassword" class="sr-only">Palavra-passe</label>
        <input type="password" id="inputPassword" name="password"
          class="form-control" placeholder="A sua palavra-passe" required>
      </div>
      <input type="hidden" name="doLogin" value="1">
      <button class="btn btn-lg btn-primary btn-block mb-3"
        type="submit">Entrar</button>
      <p class="mb-0">
        <a href="signup.php">Ainda não tenho conta</a>
      </p>
      <p>
        <a href="index.php">Voltar para pagina inicial</a>
      </p>
      <!--<p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>-->
    </form>
  </main>

  <!-- jQuery -->
  <script src="vendor/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap and its dependencies -->
  <script src="vendor/popper.js/dist/umd/popper.min.js"></script>
  <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- SHA3 for the user's password -->
  <script src="vendor/crypto-js/crypto-js.js"></script>

  <!-- So we can redirect page -->
  <script src="js/utils.js"></script>

  <script>
    $('#loginForm').submit(function(e) {
      e.preventDefault()

      var form = e.target
      var inputs = $(form).find('input')

      var inputPassword = $('#inputPassword').val()
      var hashedPassword = CryptoJS.SHA3(inputPassword)

      var postData = {}
      for (var i = 0; i < inputs.length; ++i) {
        var input = inputs[i]
        if (input.name) {
          postData[input.name] = input.value
        }
      }

      postData['password'] = hashedPassword.toString()

      $.post(form.action, postData)
        .done(function(data){
          var statusData = $.parseJSON(data)
          var status = statusData['status']
          if (status === 'ok') {
            redirectToPage('list.php');
          }
          else {
            var message = statusData['message']

            if (message === 'invalidClient') {
              $('#errorContainer').show('fast')
                .find('span')
                .html('Por favor insira a sua informação corretamente.')
            }
            else {
              $('#errorContainer').show('fast')
                .find('span')
                .html('Ocorreu um erro ao criar a sua conta.')
            }
          }
        })
        .fail(function(){
          $('#errorContainer').show('fast')
            .find('span')
            .html('Ocorreu um erro ao criar a sua conta.')
        })
    })
  </script>
</body>

</html>
