<?php
require './WeatherController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /weather
// everything else results in a 404 Not Found
if ($uri[2] !== 'weather') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// The id is, of course, mandatory and must be a city name:
$id = null;
if (isset($uri[3]) && $uri[3] !== 'top') {
    $id = $uri[3];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and id to the WeatherController and process the HTTP request:
$controller = new WeatherController($requestMethod, $id);
$controller->processRequest();
?>