<?php
use GuzzleHttp\Client;
require_once 'request.html';
require 'vendor/autoload.php';

$client = new Client();
$res = $client->request('GET', $_POST['site'].'/robots.txt');

if ($res->getStatusCode() != 404) {
    $fsize=0;
    $filename = $_POST['site'].'/robots.txt';
    $fh = fopen($filename, "r");
    while(($str = fread($fh, 1024)) != null) $fsize += strlen($str);

    echo "Размер файла: ".$fsize. " байт";

}
