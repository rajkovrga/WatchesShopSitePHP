<?php
ob_start();
require_once __DIR__ .'/../../config/config.php';
$excel = new COM("Excel.Application");
$excel->Visible = 1;
$file = $excel->WorkBooks->Open(PATH. '/data/indents.xlsx');
$sheet = $file->WorkSheets("Sheet1");
$sheet->activate;
$SELECT = "SELECT i.IndentId as ID,ip.Count as Count, p.ProductName,p.Price as price, u.FirstName as FirstName ,
u.LastName as LastName, u.Address as address, u.Address as email FROM indent i inner join indentproduct ip on i.IndentId = ip.IndentId inner JOIN
products p on ip.ProductId = p.ProductId inner join users u on i.UserId = u.UserID";
$prep = $pdo->prepare($SELECT);
$prep->execute();
$result = $prep->fetchAll(PDO::FETCH_CLASS);
$prep2 = $pdo->prepare($SELECT);
$prep2->execute();
$result2 = $prep2->fetchAll(PDO::FETCH_NUM);
$count =  $prep->columnCount();
$e = $result[0];
$column = array_keys((array)$e);
$num = 0;
unset($pdo);
for($i = "A"; $i < "Z";$i++)
{
    if($count == $num)
    {
        break;
    }
    $data = $sheet->Range($i."1");
    $data->activate;
    $data->Value = (string)$column[$num];
    $num += 1;
}
$num = 0;
$count =   count($result2);
for ($i = 0; $i < $count;$i++)
{
    for($j = 0; $j < count($result2[$i]);$j++)
    {
        $num = 0;
        for($a = "A";$a <"Z";$a++)
        {
            $num+=1;
            if($num > count($result2[$i]))
            {
                $num = 0;
                break;
            }
            else
            {
                $b = (string)($a.(int)($i+2));
                $data = $sheet->Range($b);
                $data->activate;
                $data->Value = (string)$result2[$i][$num-1];
            }
        }
        break;
    }
}
$file->Save();
$file->Saved = true;
$filename = "download.xls";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
readfile(PATH."/data/products.xlsx");
header("Location: ../../index.php?page=admin");
