<?php
require './WeatherxController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// all of our endpoints start with /users
// everything else results in a 404 Not Found
if ($uri[2] !== 'weatherx')
{
    header("HTTP/1.1 404 Not Found");
    exit();
}

$id = null;
if (isset($uri[3]))
{
    $id = $uri[3];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and id to the WeatherController and process the HTTP request:
$controller = new WeatherxController($requestMethod, $id);
$controller->processRequest();
?>
