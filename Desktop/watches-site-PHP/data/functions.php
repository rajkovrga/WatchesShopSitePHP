<?php
function setView($name)
{
    $file1 = fopen("data/log","a");
    $user = (isset($_SESSION["mail"]))?$_SESSION["mail"]:"neulogovan";
    $row = $name."\t".$user."\t" . $_SERVER['REMOTE_ADDR'] ."\t".date("j/n/Y H:i:s"). "\n";
    fwrite($file1,$row);
    fclose($file1);
    $file = fopen("data/pages","r");
    $data = file("data/pages");
    fclose($file);
    $new = "";
  
    foreach ($data as $d)
    {
        $row = explode("-",$d);

        if(trim($row[0]) == $name)
        {
            $num = (int)$row[1] + 1;
            $newRow = $row[0]."-".$num;
            $new .= $newRow . "\n";
        }
        else
        {
            $new .= $d;
        }

    }
    $file = fopen("data/pages","w");
    fwrite($file,$new);
    fclose($file);
 
}

function getViewersPage($name)
{
    $file = fopen("data/log","r");
    $data = file("data/log");
    fclose($file);
    $num = 0;
    foreach ($data as $d)
    {
        if(strtotime(trim(explode("\t",$d)[3])) < strtotime(date('j/n/Y H:i:s', strtotime('-1 day'))))
        {
            if(trim(explode("\t",$d)[0]) == trim($name))
            {
                $num += 1;
            }
        }
    }
    return (int)$num;
}
?>