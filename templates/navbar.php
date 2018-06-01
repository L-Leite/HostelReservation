<?php
$extraClass = '';

if (isset($darkNavbar) === true && $darkNavbar === true) {
    $extraClass = ' navbar-dark';
} else {
    $extraClass = ' navbar-fixed-top';
}

$isLoggedIn = isSessionSet();
?>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-xl navbar-togglable fixed-top
<?php echo $extraClass; ?>
    ">
   <div class="container">
     <div class="navbar-brand">
       <a href="index.php">
         <img src="images/logo.png" width="30" height="30"
          class="d-inline-block align-top" alt="">
         HostelR
       </a>
     </div>
     <div class="navbar-collapse">
       <ul class="navbar-nav ml-auto">
         <li class="navbar-item">
           <a class="navbar-link" href="index.php">Entrada</a>
         </li>
<?php if ($isLoggedIn === true) {
    echo '<li class="navbar-item">
           <a class="navbar-link" href="logout.php">Sair</a>
         </li>';
}
?>
       </ul>
     </div>
   </div>
 </nav>
