<?php
use GuzzleHttp\Client;
require 'vendor/autoload.php';
require
$client = new Client();
$res = $client->request('GET', ''.$_POST['site'].'/robots.txt');
echo $res->getStatusCode();

echo $res->getHeader('content-type');

echo $res->getBody();

