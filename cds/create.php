<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get posted data
$data = json_decode(file_get_contents("php://input"));
if (isset($data) && is_array($data)) {
    $id = $controller->createCDRecord($data);
    if ($id) {
        $url = $baseURL.'/cds/'.$id;
        $status = 'ok';
        header("HTTP/1.0 201 OK");
        header("Content-Type: application/json; charset=utf-8");
    } else {
        $status = 'Unable to create';
        header("HTTP/1.0 400 Error");
        header("Content-Type: application/problem+json; charset=utf-8");
    }

    echo json_encode(array(
            'status' => $status,
            'url' => $url,
        ));

}