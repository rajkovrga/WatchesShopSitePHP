<?php
require_once __DIR__ . '/../../config/config.php';
try
{
    $sql = "SELECT * FROM users u inner join statuses s on u.StatusId = s.StatusId";
   $res = executeQuery($sql);
    unset($pdo);
    echo json_encode($res);
}
catch (PDOException $er)
{
    unset($pdo);
    echo $er->getMessage();
}