<?php
require '../config/www.php';
require 'src/db.php';
require 'src/session.php';
require 'src/utils.php';

// makes navbar dark
$darkNavbar = true;

try {
    if (isSessionSet() === false) {
        header('Location: index.php');
    }

    $isDeleting = isPostVarSet('doDelete');

    if ($isDeleting === true) {
        if (!isPostVarSet('id')) {
            echo json_encode(array('status' => 'error'));
            die();
        }
        $id = getPostVar('id');
        $reserveInfo = $hostelDb->getReservation($id);

        if ($reserveInfo['client_id'] != getSessionUser()) {
            echo json_encode(
                array('status' => 'error',
                    'message' => 'invalidClient')
            );
            die();
        }
        
        $hostelDb->removeReservation($id);

        echo json_encode(array('status' => 'ok'));
        die();
    } else {
        $hostelsInfo = $hostelDb->getAllReservedHostelsInfo(getSessionUser());
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

  <title>Hosteis reservados | HostelReservation</title>

  <!-- Bootstrap's CSS -->
  <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css" />

  <!-- Font-Awesome's CSS -->
  <link rel="stylesheet" href="vendor/components-font-awesome/css/fontawesome-all.css">

  <!-- Base CSS -->
  <link href="styles/base.css" rel="stylesheet">

  <!-- Cover's CSS -->
  <link href="styles/cover.css" rel="stylesheet">
</head>

<body>
<?php require 'templates/navbar.php';?>

  <main role="main" class="bg-light py-5 mt-md-5">
    <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">As suas reservas</h1>
      <p class="lead">A lista de todos os hosteis que tem reservados.</p>
      <p class="lead text-primary">Pode cancelar a sua reserva a qualquer altura!</p>
    </div>
    <div class="album pb-5">
      <div class="container">
        <div class="row justify-content-center">
<?php
if (empty($hostelsInfo) === true) {
    echo '<div class="alert alert-primary info justify-content-middle" role="alert">
        Não tem qualquer reserva!
    </div>';
} else {
    foreach ($hostelsInfo as $h) {
        $hostelAddress = $h['address'];
        $hostelImageUrl = $imagesRoot . $h['image_url'];
        $reserveId = $h['id'];
        $reserveStart = $h['reservation_start'];
        $reserveEnd = $h['reservation_end'];
        include 'templates/hostel_reserved.php';
    }
}
?>
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

  <!-- So we can redirect page -->
  <script src="js/utils.js"></script>
  
  <script>
    // override default submit
    $('form').submit(function(e) {
      e.preventDefault()

      var form = e.target
      var inputs = $(form).find('input')

      var postData = {}
      for (var i = 0; i < inputs.length; ++i) {
        var input = inputs[i]
        if (input.name) {
          postData[input.name] = input.value
        }
      }

      $.post(form.action, postData)
        .done(function(data){
          var statusData = $.parseJSON(data)
          var status = statusData['status']
          if (status === 'ok') {
            redirectToPage('list_reserved.php');
          }
          else {
            $('#errorContainer').show('fast')
              .find('span')
              .html('Ocorreu um erro ao registar.')
          }
        })
        .fail(function(){
          $('#errorContainer').show('fast')
            .find('span')
            .html('Ocorreu um erro registar.')
        })
    })
  </script>
</body>

</html>
