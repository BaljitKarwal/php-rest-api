<?php
/*
 * Delete Code
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($id && !is_numeric($id)) {
    header("HTTP/1.0 400 Bad Request");
    header("Content-Type: application/problem+json; charset=utf-8");
    $status = 'Bad request';
    echo json_encode(array(
            'status' => $status
        )
    );
} elseif (isset($id)) {
    header("HTTP/1.0 200 OK");
    header("Content-Type: application/json; charset=utf-8");
    $status = 'No record found';
    $item = array();
    if ($controller->deleteRecord($id)) {
        header("Content-Type: application/json; charset=utf-8");
        $status = 'Record deleted';
    }
    echo json_encode(array(
        'status' => $status,
    ));
}