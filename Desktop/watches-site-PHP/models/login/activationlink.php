<?php
require_once __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function sendLink($token, $email, $id, $pdo)
{
            $link = "http://{$_SERVER['HTTP_HOST']}/models/login/activateuser.php?token={$token}&id={$id}";

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
                $mail->AddAddress($email);
                $mail->IsHTML(true);
                $mail->Subject = "Aktivacija naloga";
                $mail->Body = " 
                                <p>Aktivirajte Vas nalog </p>
                                <br>
                                 <a href='{$link}'>Aktivacioni link</a>";
                if (!$mail->send()) {
                    $pdo->rollBack();
                    throw new \Exception('', 400);
                }

            } catch (Exception $e) {
                $pdo->rollBack();
                throw new \Exception('', 400);
            }


}