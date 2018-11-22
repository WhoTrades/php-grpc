<?php

$url = '10.200.128.148:35554/grpc-json/txsecurities/v1/search/ru/USD';
$data_string = '';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Content-Type: application/json',
                   'Content-Length: ' . strlen($data_string))
);

$response = curl_exec($ch);

curl_close($ch);

var_dump($response);