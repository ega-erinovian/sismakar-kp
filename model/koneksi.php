<?php
    $hostname = "localhost";
    $username = "sis123b_ifupnyk";
    $password = "ifupnyk2022";
    $database = "sis123b_sismapeg";
    
    $konek = new mysqli($hostname, $username, $password, $database);
    if($konek->connect_error){
        // If failed to connect, shut it down with die()
        die("Connection failed: ".$connect->connect_error);
    }