<?php
 
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "inet.su";
    
    $connect = mysqli_connect($server, $username, $password, $database);
    
    if(!$connect) {
        die('Error connect DB');
    }
?>