<?php
    require('../config/db.php');
    require('hostel.php');

    define('DB_ENCODING', 'utf8');
    
    $dbConn = new PDO(
        'mysql:host='.$dbHost.';dbname='.$dbName,
        $dbUser,
        $dbPassword,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $hostelDb = new HostelReservation($dbConn);
