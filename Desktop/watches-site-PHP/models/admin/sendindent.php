<?php
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
require_once __DIR__ . '/../../config/config.php';

try
{

    $UPDATE = "UPDATE indent SET Sent = 1 where IndentId = :id";
    $prep = $pdo->prepare($UPDATE);
    $prep->execute([":id" => (int)$id]);


        unset($pdo);
        http_response_code(200);

}
catch (PDOException $er)
{
    unset($pdo);
    http_response_code(400);
    echo $er->getMessage();
}
