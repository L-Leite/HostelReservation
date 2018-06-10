<?php
require '../config/www.php';
require 'vendor/autoload.php';
require 'src/session.php';
require 'src/utils.php';

use App\Controller;

session_start();

$loader = new Twig_Loader_Filesystem('templates');
$loader->addPath('templates/client', 'client');

$twig = new Twig_Environment(
    $loader,
    array('cache' => 'cache', 'auto_reload' => true, 'strict_variables' => true)
);

$requestedPath = getRequestedPath($_SERVER['REQUEST_URI']);
$isLoggedIn = isSessionSet();

//$twig->addGlobal('curPage', getCurrentPage());
$twig->addGlobal('curPage', $requestedPath);
$twig->addGlobal('imgRoot', $imagesRoot);
$twig->addGlobal('loggedIn', $isLoggedIn);

if ($isLoggedIn === true) {
    if ($requestedPath === 'list') {
        // draw list
        $list = new Controller\ListController($twig);
        $list->render();
    } elseif ($requestedPath === 'details') {
        // draw details
        $details = new Controller\DetailsController($twig);
        if ($details->shouldRender() === true) {
            $details->render();
        } else {
            $details->handlePost();
        }
    } elseif ($requestedPath === 'reserved') {
        // draw reserved
        $reserved = new Controller\ReservedController($twig);
        if ($reserved->shouldRender() === true) {
            $reserved->render();
        } else {
            $reserved->handlePost();
        }
    } elseif ($requestedPath === 'logout') {
        // do logout and go back to cover
        if (isSessionSet()) {
            deleteSession();
        }
        header('Location: cover');
    } else {
        // go to list
        header('Location: list');
    }
} else {
    if ($requestedPath === 'login') {
        // draw login
        $login = new Controller\LoginController($twig);
        if ($login->shouldRender() === true) {
            $login->render();
        } else {
            $login->handlePost();
        }
    } elseif ($requestedPath === 'signup') {
        $signup = new Controller\SignupController($twig);
        if ($signup->shouldRender() === true) {
            $signup->render();
        } else {
            $signup->handlePost();
        }
    } elseif ($requestedPath === 'cover') {
        $cover = new Controller\CoverController($twig);
        $cover->render();
    } else {
        // go to cover
        header('Location: cover');
    }
}
