<?php
require '../config/www.php';
require 'src/db.php';
require 'src/session.php';
require 'src/utils.php';

$darkNavbar = true;

try {
    $todayDate = date('Y-m-d');
    $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
    $maxDate = date('Y-m-d', strtotime('+14 day'));

    $isReservating = isPostVarSet('doReserve');

    if ($isReservating == true) {
        if (!isPostVarSet('userId')
            || !isPostVarSet('hostelId')
            || !isPostVarSet('startDate')
            || !isPostVarSet('endDate')
        ) {
            echo json_encode(array('status' => 'error'));
            die();
        }
        $userId = getPostVar('userId');
        $hostelId = getPostVar('hostelId');
        $startDate = getPostVar('startDate');
        $endDate = getPostVar('endDate');

        if ($startDate < $todayDate
          || $endDate > $maxDate) {
            echo json_encode(array('status' => 'badDate'));
            die();
        }

        $hostelDb->newReservation(
            $userId,
            $hostelId,
            $startDate,
            $endDate
        );
        echo json_encode(array('status' => 'ok'));
        die();
    } if (isSessionSet() === true
        && isGetVarSet('id') === true
    ) {      
        $clientId = getSessionUser();
        $hostelId = getGetVar('id');

        $hostelInfo = $hostelDb->getHostelInfo($hostelId);

        $hostelId = $hostelInfo['id'];
        $hostelAddress = $hostelInfo['address'];
        $hostelDescription = $hostelInfo['description'];
        $hostelImageUrl = $imagesRoot . $hostelInfo['image_url'];
        $hostelPrice = $hostelInfo['room_price'];
        $hostelRooms = $hostelInfo['rooms_available'];
    } else {
        header('Location: index.php');
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

  <title><?php echo $hostelAddress;?> | HostelReservation</title>

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
    <!-- Modal -->
    <div class="modal" id="reserveModal" tabindex="-1"
      role="dialog" aria-labelledby="reserveModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content text-white">
          <div class="modal-header bg-dark">
            <h5 class="modal-title" id="reserveModalLabel">
              Reserva de <?php echo $hostelAddress;?>
            </h5>
            <button type="button" class="close"
              data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="reserveForm" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label for="reserveStart">Início da reserva</label>
                <input type="date"
                  min="<?php echo $todayDate; ?>"
                  max="<?php echo $maxDate; ?>"
                  class="form-control"
                  id="reserveStart" name="startDate" required>
              </div>   
              <div class="form-group">
                <label for="reserveEnd">Fim da reserva</label>
                <input type="date"
                  min="<?php echo $tomorrowDate; ?>"
                  max="<?php echo $maxDate; ?>"
                  class="form-control"
                  id="reserveEnd" name="endDate" required>
              </div>   
              <input type="hidden" name="userId"
                value="<?php echo $clientId;?>">     
              <input type="hidden" name="hostelId"
                value="<?php echo $hostelId;?>">     
              <input type="hidden" name="doReserve" value="1">        
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Voltar
              </button>
              <button type="submit" class="btn btn-primary text-white">
                Reservar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="card my-5" >
        <div class="card-background"
          style="background-image: url('./<?php echo $hostelImageUrl ?>')">
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $hostelAddress;?></h5>
          <p class="card-text"><?php echo $hostelDescription;?></p>
          <p class="card-text mb-0">
            <small class="text-muted">
              Quartos disponíveis: <?php echo $hostelRooms;?>
            </small>
          </p>
          <p class="card-text">
            <small class="text-muted">
              Preço de renda: <?php echo $hostelPrice;?>
            </small>
          </p>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-primary"
                data-toggle="modal" data-target="#reserveModal">
                Reservar
              </button>
            </div>
            <div class="btn-group">
              <a type="button" class="btn btn-secondary" href="list.php">Voltar</a>
            </div>
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

  <!-- Velocity.js for animations -->
  <script src="vendor/velocity-animate/velocity.min.js"></script>
  <script src="vendor/velocity-animate/velocity.ui.min.js"></script>

  <!-- So we can redirect page -->
  <script src="js/utils.js"></script>

  <script>
    // animates the modal
    $('#reserveModal').on('show.bs.modal', function(e) {       
      $(this).find('.modal-dialog').velocity('transition.shrinkIn', {duration: 300})
    })
    // override default submit
    $('#reserveForm').submit(function(e) {
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
