<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "sismapeg";
    
    $konek = new mysqli($hostname, $username, $password, $database);
    if($konek->connect_error){
        // If failed to connect, shut it down with die()
        die("Connection failed: ".$connect->connect_error);
    }