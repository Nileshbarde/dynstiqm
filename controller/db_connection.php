<?php
    $servername = "localhost";
    $username = "dynstydb_dynstiqm";
    $password = "Dynstiqm@$2324";
    $dbname = "dynstydb_dynstiqm";

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "lpweb";
    
    
    $conn = mysqli_connect("$servername","$username","$password","$dbname");
    

    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>	