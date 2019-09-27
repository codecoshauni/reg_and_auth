<?php

require_once('../src/autoloader.php');
spl_autoload_register('autoloader');

set_exception_handler(function ($exception) {
    error_log($exception->__toString());
    header("HTTP/1.0 503 Service Unavailable");
    die();
});

if (!file_exists('../db/users.xml')) {
    $xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<users></users>
XML;
    $f = fopen("../db/users.xml", "w");
    fwrite($f, $xmlstr);
    fclose($f);
}

$usersXml = simplexml_load_file('../db/users.xml');
$users = new App\Model\XmlGateway($usersXml);

$validator = new App\Model\Validator($users);

$router = new App\Routs\Router($users, $validator);
$router->run();
