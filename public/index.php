<?php
require '../config/www.php';
require 'src/session.php';

if (isSessionSet()) {
    header('Location: list.php');
} else {
    header('Location: cover.php');
}
