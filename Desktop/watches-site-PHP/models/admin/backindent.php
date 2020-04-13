<?php
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

require_once __DIR__ . '/../../config/config.php';

try
{

    $SQL = "SELECT * FROM indent where IndentId = :id";
    $prep = $pdo->prepare($SQL);
    $prep->execute([":id" => (int)$id]);

    if($prep->rowCount() == 0)
    {
        unset($pdo);
        http_response_code(401);
    }
    else
    {
        $UPDATE = "UPDATE indent SET Sent = 0 where IndentId = :id";
        $pr = $pdo->prepare($UPDATE);
        $pr->execute([":id" => (int)$id]);
        if($pr->rowCount() != 0)
        {
            unset($pdo);
            http_response_code(200);
        }
        else
        {
            unset($pdo);
            http_response_code(400);
        }
    }

}
catch (PDOException $er)
{
    unset($pdo);
    http_response_code(400);
    echo $er->getMessage();
}