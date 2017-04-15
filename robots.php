<?php
use GuzzleHttp\Client;
require_once 'index.php';
require 'vendor/autoload.php';

$client = new Client();
$res = $client->request('GET', $_POST['site'].'/robots.txt');

if ($res->getStatusCode() != 404) {
    $fsize=0;
    $filename = $_POST['site'].'/robots.txt';
    $fh = fopen($filename, "r");
    while(($str = fread($fh, 1024)) != null) {
        $fsize += strlen($str);
    }

    $textget = file_get_contents($filename);
    htmlspecialchars($textget);

    if (preg_match("/Host/", $textget)) {

        echo nl2br("Директива 'Host' есть\n");

        if (preg_match("/Host/", $textget)>=2){

            echo nl2br("Должна быть только одна директива 'Host'\n");
        }
    } else {
        echo nl2br( "Директивы 'Host' нет\n ");
    }

    if (preg_match("/Sitemap/", $textget)) {

        echo nl2br("Директива 'Sitemap' есть\n");

    } else {

        echo nl2br("Директивы 'Sitemap' нет\n");

    }
    echo "Размер файла: ".$fsize. " байт";
}

