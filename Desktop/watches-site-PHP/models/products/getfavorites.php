<?php
$data = json_decode(file_get_contents("php://input"));
require_once __DIR__ . "/../../config/config.php";
$SQL = "SELECT * FROM products where " . CreateIN($data,"ProductId","products");
$prep = executeQuery($SQL);
echo json_encode($prep);

