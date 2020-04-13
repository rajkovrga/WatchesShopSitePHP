<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../login/vendor/autoload.php';
$data = json_decode(file_get_contents("php://input"));

if(isset($data)) {
    $email = $data->mail;
    $message = $data->message;
    $title = $data->title;
    require_once __DIR__ . '/../regexes.php';
    if(filter_var($email,FILTER_VALIDATE_EMAIL) && checkRegex($message,"title")
    && checkRegex($title,"title"))
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPDebug = 3;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '';
            $mail->Password = '';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('');
            $mail->AddAddress("");
            $mail->IsHTML(true);
            $mail->Subject = $title;
            $mail->Body    = " 
                                <p>{$message} - <b>{$email}</b></p>";
            if(!$mail->send())
            {
                throw new \Exception('',400);
            }

        } catch (Exception $e) {
            throw new \Exception('',400);
        }
    }
    else
    {
        http_response_code(400);
    }

}
