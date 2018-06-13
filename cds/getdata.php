<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

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
    if ($row = $controller->getMusicCDByID($id)) {
        $item = array(
            "cd_id" => $row['cd_id'],
            "cd_artist_name" => $row['cd_artist_name'],
            "cd_album_title" => $row['cd_album_title'],
            "cd_release_year" => $row['cd_release_year'],
            "cd_album_catalog_no" => $row['cd_album_catalog_no'],
            "cd_genre" => $row['cd_genre'],
            "cd_composer" => $row['cd_composer'],
            "cd_owner" => $row['cd_owner']
        );
        $status = 'ok';
        echo json_encode(array(
                'status' => $status,
                'data' => $item
        ));
    } else {
        echo json_encode(array(
            'status' => $status,
            'data' => $item
        ));
    }
} else {
    header("HTTP/1.0 200 OK");
    header("Content-Type: application/json; charset=utf-8");
    $stmt = $controller->getMusicCDs();
    $count = $stmt->rowCount(); //get count
    $status = 'No record found';
    $MusicCDArray = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $MusicCDItem = array(
            "cd_id" => $row['cd_id'],
            "cd_artist_name" => $row['cd_artist_name'],
            "cd_album_title" => $row['cd_album_title'],
            "cd_release_year" => $row['cd_release_year'],
            "cd_album_catalog_no" => $row['cd_album_catalog_no'],
            "cd_genre" => $row['cd_genre'],
            "cd_composer" => $row['cd_composer'],
            "cd_owner" => $row['cd_owner']
        );
        array_push($MusicCDArray, $MusicCDItem);
    }
    if (!empty($count)) {
        $status = 'ok';
    }
    echo json_encode(array(
            'status' => $status,
            'count' => $count,
            'records' => $MusicCDArray)
    );
}
?>