<?php

// curl utility function
function curl($endpoint, $method, $data = array()) {
  $c = curl_init(API_URL . '/' . $endpoint);

  $dataString = json_encode($data);

  $headers = array('Authentication:'. 'Bearer ' . API_KEY);

  if($method === 'post') {
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, $dataString);

    array_push(
      $headers,
      'Content-Type: application/json',
      'Content-Length: ' . strlen($dataString)
    );
  }
  curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

  $data = curl_exec($c);

  curl_close($c);

  return $data;
}
