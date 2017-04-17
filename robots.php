<?php
use GuzzleHttp\Client;
require_once 'index.php';
require 'vendor/autoload.php';
use GuzzleHttp\Exception\RequestException;

echo "<table border=1>";

$client = new Client();

try {
    $client->request('GET', $_POST['site'] . '/robots.txt');
} catch (RequestException $e){
    echo "<tr><td>"."<strong>№</strong>"."</td><td>"."<strong>Название проверки</strong>"."</td><td>"."<strong>Статус</strong>"."</td><td>".""."</td><td>"."<strong>Текущее состояние</strong>"."</td>";
    echo "<tr><td colspan='5' height='21'></td></tr>";
    echo "<tr><td rowspan='2'>"."1"."</td><td rowspan='2'>"."Проверка наличия файла robots.txt"."</td>";
    echo "<td rowspan='2'>"."Ошибка"."</td><td>"."Cостояние"."</td><td>"."Файл robots.txt отсутствует"."</td>";
    echo "<tr><td>"."Рекомендации"."</td><td>"."Программист: Создать файл robots.txt и разместить его на сайте."."</td></tr>";
}

$res = $client->request('GET', $_POST['site'] . '/robots.txt');


if ($res) {
    echo "<tr><td>"."<strong>№</strong>"."</td><td>"."<strong>Название проверки</strong>"."</td><td>"."<strong>Статус</strong>"."</td><td>".""."</td><td>"."<strong>Текущее состояние</strong>"."</td>";
    echo "<tr><td colspan='5' height='21'></td></tr>";
    echo "<tr><td rowspan='2'>"."1"."</td><td rowspan='2'>"."Проверка наличия файла robots.txt"."</td>";
    echo "<td rowspan='2'>"."ОК"."</td><td>"."Cостояние"."</td><td>"."Файл robots.txt присутствует"."</td>";
    echo "<tr><td>"."Рекомендации"."</td><td>"."Доработки не требуются"."</td>";

    $filename = $_POST['site'].'/robots.txt';

    $textget = file_get_contents($filename);
    htmlspecialchars($textget);

    echo "<tr><td colspan='5' height='21'></td></tr>";
    echo "<tr><td rowspan='2'>"."2"."</td><td rowspan='2'>"."Наличие директивы"."</td>";
    if (preg_match("/Host/", $textget)) {

        echo "<td rowspan='2'>"."ОК"."</td><td>"."Состояние"."</td><td>"."Директива 'Host' есть"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Доработки не требуются"."</td></tr>";

        echo "<tr><td colspan='5' height='21'></td></tr>";
        echo "<tr><td rowspan='2'>"."3"."</td><td rowspan='2'>"."Проверка количества директив Host, прописанных в файле"."</td>";

        if (preg_match("/Host/", $textget) == 1){

            echo "<td rowspan='2'>"."ОК"."</td><td>"."Состояние"."</td><td>"."В файле прописана 1 директива Host"."</td>";
            echo "<tr><td>"."Рекомендации"."</td><td>"."Доработки не требуются"."</td></tr>";

        } else {
            echo "<tr><td rowspan='2'>"."Ошибка"."</td><td>"."Состояние"."</td><td>"."В файле прописано несколько директив Host"."<tr><td>";
            echo "<tr><td>"."Рекомендации"."</td><td>"."Программист: Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта"."</td></tr>";
        }
    } else {
        echo "<td rowspan='2'>"."Ошибка"."</td><td>"."Состояние"."</td><td>"."Директивы 'Host' нету"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил."."</td></tr>";
    }


    echo "<tr><td colspan='5' height='21'></td></tr>";
    echo "<tr><td rowspan='2'>"."4"."</td><td rowspan='2'>"."Проверка размера файла robots.txt"."</td>";

    $fsize = 0;
    $fh = fopen($filename, "r");
    while(($str = fread($fh, 1024)) != null) {
        $fsize += strlen($str);
    }

    if ($fsize < 32000){

        echo "<td rowspan='2'>"."ОК"."</td><td>"."Состояние"."</td><td>"."Размер файла robots.txt составляет "."$fsize"." байт, что находится в пределах допустимой нормы"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Доработки не требуются"."</td></tr>";

    } else {

        echo "<td rowspan='2'>"."Ошибка"."</td><td>"."Состояние"."</td><td>"."Размер файла robots.txt составляет "."$fsize"." байт, что превышает допустимую норму"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Программист: Максимально допустимый размер файла robots.txt составляем 32000 байт. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32000 байт"."</td></tr>";
    }


    echo "<tr><td colspan='5' height='21'></td></tr>";
    echo "<tr><td rowspan='2'>"."5"."</td><td rowspan='2'>"."Проверка указания директивы Sitemap"."</td>";
    if (preg_match("/Sitemap/", $textget)) {

        echo "<td rowspan='2'>"."ОК"."</td><td>"."Состояние"."</td><td>"."Директива Sitemap указана"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Доработки не требуются"."</td></tr>";

    } else {

        echo "<td rowspan='2'>"."Ошибка"."</td><td>"."Состояние"."</td><td>"."В файле robots.txt не указана директива Sitemap"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Программист: Добавить в файл robots.txt директиву Sitemap"."</td></tr>";
    }


    echo "<tr><td colspan='5' height='21'></td></tr>";
    echo "<tr><td rowspan='2'>"."6"."</td><td rowspan='2'>"."Проверка кода ответа сервера для файла robots.txt"."</td>";

    $sc = $res->getStatusCode();

    if ($res->getStatusCode() == 200){

        echo "<td rowspan='2'>"."ОК"."</td><td>"."Состояние"."</td><td>"."Файл robots.txt отдаёт код ответа сервера 200"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Доработки не требуются"."</td></tr>";
    } else {

        echo "<td rowspan='2'>"."Ошибка"."</td><td>"."Состояние"."</td><td>"."При обращении к файлу robots.txt сервер возвращает код ответа"."$sc"."</td>";
        echo "<tr><td>"."Рекомендации"."</td><td>"."Программист: Файл robots.txt должен отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200"."</td></tr>";
    }

}
echo "</table>";