<?php
require '../config/www.php';
require 'src/session.php';

if (isSessionSet() === false) {
    header('Location: index.php');
}

require 'src/db.php';

// makes navbar dark
$darkNavbar = true;

$hostelsInfo = $hostelDb->getAllHostelsInfo();
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

  <title>Lista de hosteis | HostelReservation</title>

  <!-- Bootstrap's CSS -->
  <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css" />

  <!-- Font-Awesome's CSS -->
  <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css" />

  <!-- Base CSS -->
  <link href="styles/base.css" rel="stylesheet">

  <!-- Cover's CSS -->
  <link href="styles/cover.css" rel="stylesheet">
</head>

<body>
<?php require 'templates/navbar.php';?>

  <main role="main" class="bg-light py-5 mt-md-5">
    <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Lista de hosteis</h1>
      <p class="lead">Escolha o seu hostel preferido!</p>
    </div>
    <div class="album pb-5">
      <div class="container">
        <div class="row">
<?php
foreach ($hostelsInfo as $h) {
    $hostelId = $h['id'];
    $hostelAddress = $h['address'];
    $hostelImageUrl = $imagesRoot . $h['image_url'];
    $hostelPrice = $h['room_price'];
    $hostelRooms = $h['rooms_available'];
    include 'templates/hostel.php';
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
</body>

</html>
