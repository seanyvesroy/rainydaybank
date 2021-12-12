<?php
    // Data to connect to local database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "RainyDayBank";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection        
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
