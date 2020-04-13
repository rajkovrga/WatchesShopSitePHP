<?php
$data = json_decode(file_get_contents("php://input"));
require_once __DIR__ . "/../../config/config.php";

$id = $data->id;

$SQL = "SELECT * FROM products p INNER JOIN mechanism m ON m.MechanismId = p.MechanismId
 inner join display d on d.DisplayId = p.DisplayId inner join housing h on h.HousingId = p.HousingId
  inner join resistance r on r.ResistanceId = p.ResistanceId
 inner join gender g on g.GenderId = p.GenderId where p.ProductId = :id";

$prep = $pdo->prepare($SQL);
$prep->execute([":id" => $id]);


if($prep->rowCount() == 0)
{
http_response_code(400);
unset($pdo);
}
else
{
   echo json_encode($prep->fetch());
    http_response_code(200);
    unset($pdo);
}
