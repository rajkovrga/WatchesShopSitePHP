<?php
require_once __DIR__ . "/../../config/config.php";
$sql = "SELECT * from author";
$query = executeQuery($sql);
$author = $query[0]->Author;
$desc = $query[0]->AuthDesc;
$word_app = new COM("Word.Application");
echo $author . " " . $desc;

$word_app->Visible = true;
$word_app->Documents->Add();
$word_app->Selection->TypeText("{$author}({$desc})");
header("Location: ../../index.php");