<?php
$isReserved = $hostelDb->isCurrentlyReserved($hostelId, getSessionUser());
?>
  <div class="col-lg-4 col-sm-6">
    <div class="card mb-4">
      <div class="card-body
<?php if ($isReserved === true) {
    echo ' reserved';
}
?>
          ">
        <img class="card-img-top mb-3" alt="<?php echo $hostelAddress; ?>"
          src="<?php echo $hostelImageUrl ?>">
        <p class="card-text mb-0"><?php echo $hostelAddress; ?></p>
        <p class="card-text text-muted">
<?php if ($isReserved === true) {
    echo 'Reservado!';
} else {
    echo $hostelRooms.' quartos disponíveis.';
}?>
        </p>
        <div class="d-flex justify-content-between align-items-center">
          <div class="btn-group">
            <a type="button" class="btn btn-sm btn-primary"
              href="details.php?id=<?php echo $hostelId ?>">Mais &raquo</a>
          </div>
          <small class="text-muted">
            Preço por quarto: €<?php echo $hostelPrice ?>
          </small>
        </div>
      </div>
    </div>
  </div>
