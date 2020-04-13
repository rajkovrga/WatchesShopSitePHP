<?php
session_start();
$data = json_decode(file_get_contents("php://input"));
$idUser = $_SESSION["id"];
require_once __DIR__ . '/../../config/config.php';

try
{
    $pdo->beginTransaction();
    $newIndentSQL = "INSERT INTO `indent`(`UserId`) VALUES (:id)";
    $newIndent = $pdo->prepare($newIndentSQL);
    $newIndent->execute([":id" => $idUser]);
    $newId = $pdo->lastInsertId();

    $writeProductsSQL = "INSERT INTO `indentproduct`(`IndentId`, `ProductId`, `Count`) VALUES (:indent, :product, :c)";

    for($i = 0; $i < count($data); $i++)
    {
        $writeProducts = $pdo->prepare($writeProductsSQL);
        $writeProducts->execute([
            ":indent" => $newId,
            ":product" => $data[$i]->id,
            ":c" => $data[$i]->count
        ]);
    }


    if($writeProducts->rowCount() > 0)
    {
        $pdo->commit();
        unset($pdo);
        http_response_code(200);
    }
    else
    {
        $pdo->rollBack();
        unset($pdo);
        http_response_code(400);
    }


}
catch (PDOException $er)
{
    $pdo->rollBack();
    unset($pdo);
    echo $er->getMessage();
}