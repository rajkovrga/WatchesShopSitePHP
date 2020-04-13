<?php
session_start();
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$statusId = $data->status;

echo var_dump(intval($id) == intval($_SESSION["id"]));
if(intval($id) == intval($_SESSION["id"]))
{
    http_response_code(401);
}
else
{

    require_once __DIR__ . '/../../config/config.php';

    try
    {

        $update = "UPDATE users SET StatusId = :status WHERE UserID = :id";
        $prep = $pdo->prepare($update);
        $prep->execute([":status"=>$statusId,
            ":id"=>$id]);
        unset($pdo);

        if($prep->rowCount() != 0)
        {
            http_response_code(200);
        }
        else
        {
            http_response_code(400);
        }

    }
    catch (PDOException $er)
    {
        unset($pdo);
        http_response_code(400);
        echo $er->getMessage();
    }
}