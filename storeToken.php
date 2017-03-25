<?php

 $servername = "localhost";
 $username = "Your Database Username";
 $password = "Your Database Password";
try {
    $conn = new PDO("mysql:host=$servername;dbname=Your database id in phpMyAdmin", $username, $password);
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
