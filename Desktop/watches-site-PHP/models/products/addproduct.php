<?php
$data = json_decode(file_get_contents("php://input"));

require_once __DIR__ . '/../regexes.php';
$display = $data->display;
$housing = $data->housing;
$name = $data->name;
$mechanism = $data->mechanism;
$res = $data->resistance;
$gender = $data->gender;
$price = $data->price;
if(checkRegex($display,"num") && checkRegex($housing,"num") && checkRegex($name,"title")
&& checkRegex($mechanism,"num") && checkRegex($res,"num") && checkRegex($gender,"num")
&& checkRegex($price,"price"))
{
try
{
    require_once __DIR__ . '/../../config/config.php';

    $SQLSelect = $pdo->prepare("SELECT * FROM `products` WHERE ProductName=:name");
    $SQLSelect->execute([":name"=>$name]);
    $pdo->beginTransaction();

    if($SQLSelect->rowCount() == 0)
    {
        $SQLInsert = "INSERT INTO `products`( `ProductName`, `GenderId`, `DisplayId`, `MechanismId`, `HousingId`, `ResistanceId`,`Price`) 
                      VALUES (:name,:gender,:display,:mech,:housing,:res,:price)";

        $insert = $pdo->prepare($SQLInsert);
        $insert->execute([
            ":name"=>$name,
            ":gender"=>$gender,
            ":display"=>$display,
            ":mech"=>$mechanism,
            ":housing"=>$housing,
            ":res"=>$res,
            ":price"=>$price
        ]);

        if($insert->rowCount() != 0)
        {

            $id = $pdo->lastInsertId();
            $obj =
                [
                "id" => $id
                ];
            $pdo->commit();
            unset($pdo);
            echo json_encode($obj);
        }
        else
        {
            http_response_code(403);
            unset($pdo);
        }

    }
    else
    {
        http_response_code(402);
        unset($pdo);
    }

}
catch(PDOException $e)
{
    echo $e->getMessage();
    $pdo->rollBack();
    unset($pdo);
}

}
else
{
    http_response_code(401);
}



