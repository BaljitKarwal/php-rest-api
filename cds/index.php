<?php
//check php version
$phpVersion = phpversion();
if ($phpVersion < 5.6) {
    return 'This api uses php version 5.6 or more';
}
use Controller\MainController;

include "../vendor/autoload.php";
$request_method = $_SERVER["REQUEST_METHOD"];
$baseURL = 'localhost';
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if ($request_uri) {
    $urlSegments = explode('/', $request_uri[0]);
    $urlSegment0 = isset($urlSegments[0])?$urlSegments[0]: NULL;
    $urlSegment1 = isset($urlSegments[1])?$urlSegments[1]: NULL;
    $urlSegment2 = isset($urlSegments[2])?$urlSegments[2]: NULL;
    $urlSegment3 = isset($urlSegments[3])?$urlSegments[3]: NULL;
}

// include database
include "../config/database.php";
$database = new Database();
$db = $database->getConnection();
$data = NULL;
$controller = new MainController();

switch($request_method)
{
    case 'GET':
        $id = NULL;
        if(isset($urlSegment3) && !empty($urlSegment3)) {
            $id = $urlSegment3;
        }
        include "getdata.php";
    case 'POST':
        include "create.php";
        break;
    case 'PUT':
        include "update.php";
        break;
    case 'DELETE':
        $id = NULL;
        if(isset($urlSegment3) && !empty($urlSegment3)) {
            $id = $urlSegment3;
        }
        include "delete.php";
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        header("Content-Type: application/problem+json; charset=utf-8");
        break;
}