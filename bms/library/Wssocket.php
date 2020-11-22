<?php

class Wssocket
{

  function runcode($lenh="sendall",$env="",$str="",$to=""){
    try{
      require APPPATH . '/third_party/elephant/vendor/autoload.php';

if($_SERVER['HTTP_HOST']=="localhost"||$_SERVER['HTTP_HOST']=="127.0.0.1"||$_SERVER['HTTP_HOST']=="::1")
$url='https://knq.cehsoft.com';
else
$url='http://127.0.0.1:3001';
$url='http://127.0.0.1:3001';
      $client = new ElephantIO\Client(new ElephantIO\Engine\SocketIO\Version2X($url, [
        'headers' => [
          'X-My-Header: websocket rocks',
          'Authorization: Bearer 12b3c4d5e6f7g8h9i'
        ]
      ]));
      $client->initialize();
      $pass="cehnodepass";
      $client->emit('d25b4bd4c72aa2c07ee87adb10b59f16', [
        'pass'=>$pass,
        'lenh'=>$lenh,
        'env'=>$env,
        'str'=>$str]
      );

      $client->close();
      return true;
    }
    catch(Exception $e) {
      return false;
    }
  }







// function runcode($lenh="sendall",$env="",$str="",$to=""){
// 	if($_SERVER['HTTP_HOST']=="localhost"||$_SERVER['HTTP_HOST']=="127.0.0.1"||$_SERVER['HTTP_HOST']=="::1")
// 	$url = 'http://127.0.0.1:3001/d25b4bd4c72aa2c07ee87adb10b59f16';
// 		else
//   	$url = 'http://127.0.0.1:3001/d25b4bd4c72aa2c07ee87adb10b59f16';
// $post = [
// 	'pass' => 'cehnodepass',
//     'lenh' => $lenh,
//     'env' => $env,
//     'str'   => $str,
//     'to'=>$to
// ];

// $ch = curl_init( $url );
// curl_setopt( $ch, CURLOPT_POST, 1);
// curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($post));
// //curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt( $ch, CURLOPT_HEADER, 0);
// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

// $response =  preg_replace('/[^A-Za-z0-9\-]/', '',curl_exec( $ch ));
// $reback=false;
// if($response=="ok")
// {
//  $reback=true;
// }
//   return $reback;
//   }
// end classs
}