<?php
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
require_once __DIR__ . '/../../config/config.php';
try
{
    $query = "SELECT UserID,LastName,FirstName,StatusId from users where UserID = :id";
    $prep = $pdo->prepare($query);
    $prep->execute([":id" => $id]);
    unset($pdo);
    echo json_encode($prep->fetch());

}
catch (PDOException $er)
{
    unset($pdo);
    echo $er->getMessage();
}


