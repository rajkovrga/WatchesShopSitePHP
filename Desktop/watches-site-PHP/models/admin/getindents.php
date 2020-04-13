<?php
require_once __DIR__ . '/../../config/config.php';

try
{
    $firstSELECT = executeQuery("SELECT * FROM indent i inner join users u on i.UserId = u.UserId where Sent = 0");

foreach ($firstSELECT as $f)
{
    $f->ItemsIndent = getProductsForIndent($f->IndentId,$pdo);
}
unset($pdo);
http_response_code(200);
echo json_encode($firstSELECT);
}
catch (PDOException $er)
{
    http_response_code(400);
    unset($pdo);
    echo $er->getMessage();
}

function getProductsForIndent($id,$pdo)
{
$query = "SELECT * FROM indentproduct ip inner join products p on p.ProductId = ip.ProductId where IndentId = :id";
$prep = $pdo->prepare($query);
$prep->execute([":id"=>$id]);
return $prep->fetchAll();
}
