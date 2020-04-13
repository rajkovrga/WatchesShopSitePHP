<?php

session_start();
$data = json_decode(file_get_contents("php://input"));
require_once __DIR__ .'/../regexes.php';
$old = $data->old;
$new = $data->new;
$user = $_SESSION['id'];

if(checkRegex($new,"password") && checkRegex($old,"password") )
{
    require_once __DIR__ . '/../../config/config.php';

    try{

        $select = "SELECT * FROM users where UserID = :id";
        $prepSelect = $pdo->prepare($select);
        $prepSelect->execute([":id"=>$user]);
        $rez = $prepSelect->fetch();
        echo $rez->Password;
        if(password_verify($old,$rez->Password))
        {

            $updateSQL = "UPDATE `users` SET `Password`= :pass WHERE UserID = :id";

            $update = $pdo->prepare($updateSQL);
            $update->execute([
                ":id" => $user,
                ":pass" =>password_hash($new,PASSWORD_BCRYPT)
            ]);

            if($update->rowCount() > 0)
            {
                unset($pdo);
                http_response_code(200);
            }
            else
            {
                unset($pdo);
                http_response_code(403);
            }

        }
        else{
            unset($pdo);
            http_response_code(402);
        }



    }
    catch (PDOException $er)
    {
        unset($pdo);
        http_response_code(401);
        echo $er->getMessage();
    }


}
else
{
    http_response_code(400);
}