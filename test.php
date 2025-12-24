<?php

    require "src/config/Database.php";



    $connection = new Database("db","UnityClinic_CLI","root","root");



    $conn =  $connection->Connect();
    if ($conn) {
        # code...
        echo "connection reussie!";
    }
