<?php

if(isset($_SESSION))
{
    require_once __DIR__ . '/../../config/config.php';
    $addonlineSQL = "UPDATE users SET Online = 0 where UserId = :id";
    $addonline = $pdo->prepare($addonlineSQL);
    $addonline->execute([":id" => $_SESSION["id"]]);
    unset($pdo);
    session_destroy();
header("Location: ../../index.php");

}
else
{
header("Location: ../../index.php");
}