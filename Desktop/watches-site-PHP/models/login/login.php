<?php

session_start();
$data = json_decode(file_get_contents("php://input"));

if(isset($data))
{
    $mail = $data->email;
    $password = $data->password;
    require_once __DIR__ .'/../regexes.php';

    if(filter_var($mail,FILTER_VALIDATE_EMAIL) && checkRegex($password,"password"))
    {
        require_once __DIR__ . '/../../config/config.php';
        $sql = "SELECT * FROM users u inner join statuses s on u.StatusId = s.StatusId where Mail = :mail and Activate = 1";
        $prepare = $pdo->prepare($sql);
        $prepare->execute([
            ":mail" => $mail
        ]);
            $result = $prepare->fetch();
        if($prepare->rowCount() != 0)
        {
          
            if(password_verify($password,$result->Password))
            {
                $_SESSION["login"] = true;
                $_SESSION["id"] = $result->UserID;
                $_SESSION["mail"] = $result->Mail;
                $_SESSION["s_id"] = $result->StatusId;

                $_SESSION["status"] = $result->StatusName;

                $addonlineSQL = "UPDATE users SET Online = 1 where UserId = :id";
                $addonline = $pdo->prepare($addonlineSQL);
                $addonline->execute([":id" => $result->UserID]);



                unset($pdo);
                http_response_code(200);
                
            }
            else
            {
                unset($pdo);
                http_response_code(401);
            }
        }
        else
        {
            unset($pdo);
            http_response_code(401);

        }

    }
    else
    {
        http_response_code(400);
    }

}
else
{
    header("Location: ../../index.php");
}