<?php

$servername = "localhost";
$username = "Your Database Username";
$password = "Your Database Password";

    $conn = new PDO("mysql:host=$servername;dbname=Your database id at phpMyAdmin", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define( 'API_ACCESS_KEY', 'Api key cloud messaging' );

$myToken = $_GET["token"];
echo $myToken;

$sql = " SELECT * FROM TokenStore WHERE token!='$myToken' ";

$resultt = $conn->prepare($sql);
$resultt->execute();

$token = array();

if ($resultt->rowCount()>0) 
{
  while($row =$resultt->fetch())
     {
        $token[]=$row["token"]; 
        echo $row["token"];  

      }
}

var_dump($token);

$title = $_POST["title"];
$notification = $_POST["message"];


$msg =
[
  'message'   => $notification,
  'title'   => $title
];

$fields = 
[
  'registration_ids'  => $token,
  'data'      => $msg
];
 
$headers = 
[
  'Authorization: key=' . API_ACCESS_KEY,
  'Content-Type: application/json'
];

echo 'hello';
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;
