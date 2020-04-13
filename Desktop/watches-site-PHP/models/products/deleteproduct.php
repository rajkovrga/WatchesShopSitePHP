<?php
$data = json_decode(file_get_contents("php://input"));
require_once __DIR__ . "/../../config/config.php";

$id = $data->id;

$SQL = "DELETE FROM products where ProductId = :id";

$prep = $pdo->prepare($SQL);

$prep->execute([":id" => (int)$id]);

if($prep->rowCount() > 0)
{
    unset($pdo);
    http_response_code(200);
}
else
{
    unset($pdo);
    http_response_code(400);
}