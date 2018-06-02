<?php
?>
  <div class="col-lg-4 col-sm-6">
    <div class="card mb-4">
      <div class="card-body reserved">
        <img class="card-img-top mb-3" alt="<?php echo $hostelAddress; ?>"
          src="<?php echo $hostelImageUrl ?>">
        <p class="card-text mb-0"><?php echo $hostelAddress; ?></p>
        <p class="card-text mb-0">
          De
          <span class="text-success">
<?php echo $reserveStart; ?>
          </span>
          a 
          <span class="text-success">
<?php echo $reserveEnd; ?>
          </span>
          .
        </p>
        <p class="card-text text-muted">
          Reservado!
        </p>
        <form method="POST">
          <div class="d-flex justify-content-end align-items-right">
            <div class="btn-group">  
              <button type="submit" class="btn btn-sm btn-primary">
                Cancelar &raquo
              </button>
            </div>
          </div>
          <input type="hidden" name="id" value="<?php echo $reserveId;?>">
          <input type="hidden" name="doDelete" value="1">
        </form>
      </div>
    </div>
  </div>
