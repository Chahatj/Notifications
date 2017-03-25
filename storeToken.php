<?php

 $servername = "localhost";
 $username = "id1149884_notification";
 $password = "notification";
try {
    $conn = new PDO("mysql:host=$servername;dbname=id1149884_mydb", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     
     $token=$_GET["token"];

    
     
    $sql="insert into  TokenStore values(?)";
     
    $result =$conn->prepare($sql);
     $result->execute([$token]);
    
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }



    ?>