<?php
session_start();
$data = json_decode(file_get_contents("php://input"));
require_once __DIR__ .'/../regexes.php';
$address = $data->address;


if(checkRegex($address,"address"))
{
    require_once __DIR__ . '/../../config/config.php';
    try{

        $updateSQL = "UPDATE `users` SET `Address`= :adr WHERE UserID = :id";

        $update = $pdo->prepare($updateSQL);
        $update->execute([":adr" => $address, ":id" => $_SESSION['id']]);

        if($update->rowCount() == 0)
        {
            unset($pdo);
            http_response_code(402);
        }
        else
        {
            unset($pdo);
            http_response_code(200);
        }
    }
    catch (PDOException $er)
    {
        unset($pdo);
        http_response_code(401);
        echo $er->getMessage();
    }

}
else{
    http_response_code(400);
}