<?php
    define('DB_ENCODING', 'utf8');

    $dbHost = 'localhost';
    $dbName = 'HostelManagement';
    $dbUser = 'site';
    $dbPassword = '30050';  
    
    $dbConn = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $userPassword,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
