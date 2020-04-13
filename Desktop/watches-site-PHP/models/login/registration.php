<?php
$data = json_decode(file_get_contents("php://input"));
$fname = $data->fname;
$lname = $data->lname;
$address = $data->address;
$password = $data->password;
$email = $data->email;
require_once __DIR__ .'/../regexes.php';
if(checkregex($fname,"name") && checkregex($lname,"name") && checkregex($address,"address")
 && checkregex($password,"password") && filter_var($email,FILTER_VALIDATE_EMAIL))
{
try
{
    require_once __DIR__ . '/../../config/config.php';
    $pdo->beginTransaction();
    $select = "SELECT * FROM users where Mail = :mail";
    $prep = $pdo->prepare($select);
    $prep->execute([":mail"=>$email]);

    if($prep->rowCount() !=0)
    {
        unset($pdo);
        http_response_code(406);
    }
    else{

    $sql = "INSERT INTO `users`( `FirstName`, `LastName`, `Address`, `Mail`, `Password`, `StatusId`,`Token`,`Activate`,`Online`) VALUES( :fname, :lname, :address, :mail, :password, :status, :token, :activate, :onlineUser)";
    $stringToken = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASLFJASLF832959832HR39RH29URhjsfhasofhasoufsa";
    $str = str_shuffle($stringToken);
    $token = substr($str,0,10);
    $registrationUser = $pdo->prepare($sql);
    $registrationUser->execute([
        ":lname" => $lname,
        ":fname" => $fname,
        ":mail" => $email,
        ":address" => $address,
        ":password" => password_hash($password,PASSWORD_BCRYPT),
        ":status" => 1,
        ":token" => $token,
        ":activate" => 0,
        ":onlineUser"=>0
    ]);
    require_once __DIR__ . "/activationlink.php";
    sendLink($token,$email,$pdo->lastinsertId(),$pdo);
    $pdo->commit();
    }

}catch(PDOException $er)
{
    http_response_code(401);

    $pdo->rollback();
    unset($pdo);
    echo $er->getMessage();
}
}
else
{
http_response_code(400);
}