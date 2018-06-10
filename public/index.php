<?php
require '../config/www.php';
require 'vendor/autoload.php';
require 'src/session.php';
require 'src/utils.php';

use App\Controller;

session_start();

$loader = new Twig_Loader_Filesystem('templates');
$loader->addPath('templates/client', 'client');
$loader->addPath('templates/admin', 'admin');

$twig = new Twig_Environment(
    $loader,
    array('cache' => 'cache', 'auto_reload' => true, 'strict_variables' => true)
);

$twig->addGlobal('imgRoot', $imagesRoot);

if (isAdminRequest() === true) {
    $requestedPath = getAdminRequest();
    $isLoggedIn = isAdminSessionSet();

    $twig->addGlobal('curPage', $requestedPath);
    $twig->addGlobal('loggedIn', $isLoggedIn);

    if ($isLoggedIn === true) {
        if ($requestedPath === 'reservations'
            || $requestedPath === 'login') {
            // draw login
            $reservations = new Controller\Admin\ReservationsController($twig);
            $reservations->render();
        } elseif ($requestedPath == null) {
            // go to login
            header('Location: ./reservations');
        } elseif ($requestedPath === 'logout') {
            // do logout and go back to cover
            if (isAdminSessionSet()) {
                deleteAdminSession();
            }
            header('Location: ./login');
        } else {
            http_response_code(404);
            $notFound = new Controller\NotFoundController($twig);
            $notFound->render();
        }
    } else {
        if ($requestedPath === 'login') {
            // draw login
            $login = new Controller\Admin\LoginController($twig);
            if ($login->shouldRender() === true) {
                $login->render();
            } else {
                $login->handlePost();
            }
        } elseif ($requestedPath == null) {
            // go to login
            header('Location: login');
        } else {
            http_response_code(404);
            $notFound = new Controller\NotFoundController($twig);
            $notFound->render();
        }
    }
} else {
    $requestedPath = getRequestedPath();
    $isLoggedIn = isSessionSet();
    
    $twig->addGlobal('curPage', $requestedPath);
    $twig->addGlobal('loggedIn', $isLoggedIn);

    if ($isLoggedIn === true) {
        if ($requestedPath === 'list') {
            // draw list
            $list = new Controller\Client\ListController($twig);
            $list->render();
        } elseif ($requestedPath === 'details') {
            // draw details
            $details = new Controller\Client\DetailsController($twig);
            if ($details->shouldRender() === true) {
                $details->render();
            } else {
                $details->handlePost();
            }
        } elseif ($requestedPath === 'reserved') {
            // draw reserved
            $reserved = new Controller\Client\ReservedController($twig);
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
        if ($requestedPath === 'list'
        || $requestedPath === 'reserved'
        || $requestedPath === 'details') {
            header('Location: login');
        } elseif ($requestedPath === 'login') {
            // draw login
            $login = new Controller\Client\LoginController($twig);
            if ($login->shouldRender() === true) {
                $login->render();
            } else {
                $login->handlePost();
            }
        } elseif ($requestedPath === 'signup') {
            $signup = new Controller\Client\SignupController($twig);
            if ($signup->shouldRender() === true) {
                $signup->render();
            } else {
                $signup->handlePost();
            }
        } elseif ($requestedPath === 'cover') {
            $cover = new Controller\Client\CoverController($twig);
            $cover->render();
        } elseif ($requestedPath == null) {
            // go to cover
            header('Location: cover');
        } else {
            http_response_code(404);
            $notFound = new Controller\NotFoundController($twig);
            $notFound->render();
        }
    }
}
