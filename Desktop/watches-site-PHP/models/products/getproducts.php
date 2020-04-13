<?php

$data = json_decode(file_get_contents("php://input"));
require_once __DIR__ . '/../../config/config.php';
$start = $data->start;
$end = 9;
$sql = "SELECT * FROM `products` ORDER BY ProductId desc LIMIT :start , :end1";
$prepare = $pdo->prepare($sql);
$prepare->bindParam(":start",intval($start),PDO::PARAM_INT);
$prepare->bindParam(":end1",intval($end),PDO::PARAM_INT);
$prepare->execute();
    $countSQL = "SELECT * FROM `products`";
    $count = $pdo->prepare($countSQL);
    $count->execute();
unset($pdo);
$ret = [
    "num" => $count->rowCount(),
    "obj" =>$prepare->fetchAll()

];
http_response_code(200);
echo json_encode($ret);