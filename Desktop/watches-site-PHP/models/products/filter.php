<?php
$data = json_decode(file_get_contents("php://input"));

$mechanism = $data->mechanism;
$display = $data->display;
$gender = $data->gender;
$housing = $data->housing;
$resistance = $data->resistance;
$min = (int)$data->min-1;
$max = (int)$data->max+1;
$start = intval($data->start);
$end = 9;
try{
    require_once __DIR__ . "/../../config/config.php";
    $SQL = "SELECT * FROM products where " . createIN($mechanism,"MechanismId", "mechanism") . " AND "
        . createIN($display,"DisplayId","display"). " AND "
        . createIN($gender,"GenderId","gender") . " AND "
        . createIN($housing,"HousingId","housing"). " AND "
        . createIN($resistance,"ResistanceId","resistance") . " AND Price >= {$min} and Price <= {$max}";
    $count = $pdo->prepare($SQL);
    $count->bindParam(":start",intval($start),PDO::PARAM_INT);
    $count->execute();

    $SQLSecond = $SQL . " ORDER BY ProductId desc LIMIT :start , 9";
    http_response_code(200);
    $prep = $pdo->prepare($SQLSecond);
    $prep->bindParam(":start",intval($start),PDO::PARAM_INT);
    $prep->execute();
    $ret = [
        "num" => $count->rowCount(),
        "obj" =>$prep->fetchAll()

    ];
    unset($pdo);

    echo json_encode($ret);
}
catch(PDOException $er)
{
    unset($pdo);
    echo $er->getMessage();
}



