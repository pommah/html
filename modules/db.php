<?php
    $host = '127.0.0.1';
    $dbname = 'learn';
    $user = 'root';
    $pass = 'root';
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
?>