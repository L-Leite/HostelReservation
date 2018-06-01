<?php
require '../config/www.php';
require 'src/session.php';

if (isSessionSet()) {
    deleteSession();
}

header('Location: index.php');
