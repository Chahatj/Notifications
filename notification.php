<?php

$servername = "localhost";
$username = "id1149884_notification";
$password = "notification";

    $conn = new PDO("mysql:host=$servername;dbname=id1149884_mydb", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define( 'API_ACCESS_KEY', 'AAAAsTBZMVI:APA91bHsAShx8HAytmg8lWwK6QaLPOsm77mWLh9u5ijIW34Vg_r66MYibHvBstxkuF1uq1f2JVg_DONrHtnnd03TRAp2tawsl1GeVatQsU5TbKSCpr8_xz8lpdyp-5XZfzvdvhDr7rJc' );

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