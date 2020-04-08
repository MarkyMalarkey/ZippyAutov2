<?php
    $dsn = 'mysql:c584md9egjnm02sk.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=gohxwbyds4cwhn2w';
    $username = 'xljcpmmrg9wcdrvd';
    $password = 'g6aruixjemak0ucv';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>
