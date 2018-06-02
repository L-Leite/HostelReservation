<?php
require '../config/www.php';
require 'src/session.php';
require 'src/utils.php';

if (isSessionSet() === true) {
    header('Location: index.php');
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

  <title>Reserve hosteis | HostelReservation</title>

  <!-- Bootstrap's CSS -->
  <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css" />

  <!-- Font-Awesome's CSS -->
  <link rel="stylesheet" href="vendor/components-font-awesome/css/fontawesome-all.css">

  <!-- Base CSS -->
  <link rel="stylesheet" href="styles/base.css">

  <!-- Cover's CSS -->
  <link rel="stylesheet" href="styles/cover.css">
</head>

<body>
<?php require 'templates/navbar.php';?>

  <main role="main">
    <!-- Presentation jumbotron -->
    <div class="jumbotron bg-jumbotron">
      <div class="container">
        <h1 class="display-4">A reserva de hostéis facilitada</h1>
        <p>Encontre e reserve hostéis rapidamente com HostelReservation.</p>
        <p>
          <a class="btn btn-primary btn-lg"
            href="login.php" role="button">Entrar</a>
          <a class="btn btn-secondary btn-lg"
            href="signup.php" role="button">Criar conta</a>
        </p>
      </div>
    </div>
    <!-- easy search featurette -->
    <div class="container">
      <div class="row featurette">
        <div class="col-md-8">
          <h2 class="featurette-heading">Procura fácil</h2>
          <p class="lead">
            O HostelReservation foi feito para encontrar
            <span class="font-weight-bold">só o que precisa</span>,
            o mais facilmente possível.
          </p>
          <p><a class="btn btn-primary btn-lg"
            href="login.php" role="button">Entrar &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <img class="featurette-image img-fluid float-right rounded"
            alt="" style="width: auto; height: 500px;" src="images/hostel-1.png">
        </div>
      </div>
    </div>
    <hr class="featurette-divider">
    <!-- columns with the platform's features -->
    <div class="bg-dark row-column">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6">
            <h2 class="text-white text-center mb-4">
              Ainda não está impressionado?
            </h2>
            <p class="text-white text-muted text-center mb-5">
              Então veja o que mais oferecemos.
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 text-center border-right">
            <h4 class="mb-3">Em qualquer lado</h4>
            <p class="text-white text-muted">
              A nossa plataforma oferece hosteis em todo o país.
              A taxa de cobertura da nossa página chega aos 99.99999%.
              É quase impossível não ficar impressionado.
            </p>
          </div>
          <div class="col-md-4 text-center border-right">
            <h4 class="mb-3">Preços acessíveis</h4>
            <p class="text-white text-muted">
              Os preços mais baratos são garantidos aqui.
              Não existe em mais nenhum lado preços tão baratos comos os nossos.
            </p>
          </div>
          <div class="col-md-4 text-center">
            <h4 class="mb-3">Qualidade garantida</h4>
            <p class="text-white text-muted">
              Tudo isto e mais é conseguido com as melhores práticas.
              A qualidade inegualável distingue-nos online.
            </p>
          </div>
        </div>
      </div>
    </div>
    <hr class="featurette-divider">
    <!-- best quality featurette -->
    <div class="container">
      <div class="row featurette">
        <div class="col-md-4">
          <img class="featurette-image img-fluid float-right rounded"
            alt="" style="width: auto; height: 500px;" src="images/hostel-2.png">
        </div>
        <div class="col-md-8 text-right">
          <h2 class="featurette-heading">O melhor, num só sítio</h2>
          <p class="lead">
            Aqui só encontrará os melhores Hosteis no país inteiro.
            E tudo mais barato.
            <span class="font-weight-bold">só o que precisa</span>,
            o mais facilmente possível.
          </p>
          <p><a class="btn btn-primary btn-lg"
            href="list.php" role="button">Ver hosteis &raquo;</a></p>
        </div>
      </div>
    </div>
    <hr class="featurette-divider">
    <!-- create an account today -->
    <div class="bg-light row-column">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-8 col-lg-6">
            <h2 class="text-dark text-center mb-4">
              Então do que é que está à espera?
            </h2>
            <p class="text-dark text-muted text-center">
              Crie uma conta e reserve o seu hostel preferido hoje.
            </p>
          </div>
          <div class="col-md-auto">
            <p>
              <a class="btn btn-primary btn-lg"
                href="signup.php" role="button">Começar &raquo;</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php require 'templates/footer.php';?>

  <!-- jQuery -->
  <script src="vendor/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap and its dependencies -->
  <script src="vendor/popper.js/dist/umd/popper.min.js"></script>
  <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Changes the navbar color -->
  <script src="js/navbar.js"></script>
</body>

</html>
