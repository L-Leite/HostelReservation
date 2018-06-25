<?php
// Set our root path here to we can include our app
$rootPath = dirname(dirname(__FILE__));

// path to hostel images relative to the public folder
$imagesRoot = 'images/hostel/';

// how many directories from the host to our page
// eg: localhost/test would be 1
$dirDistance = 1;

// used in php page redirections
$wwwRootDir = $_SERVER['SERVER_NAME'].'/'.'HostelReservation';

chdir($rootPath);
