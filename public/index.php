<?php
// redirects the user to the hostel list page if logged in,
// else send him to the cover

require '../config/www.php';
require 'src/session.php';

if (isSessionSet()) {
    header('Location: list.php');
} else {
    header('Location: cover.php');
}
