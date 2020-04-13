<?php
function work($status,$name,$pdo,$num = false)
{
    if(!$num)
    {
        $sql = "select * from statuswork sw inner join statuses s on sw.StatusId = s.StatusId inner join works w on w.WorkId = sw.WorkId where sw.StatusId = :id and WorkName = :name";
        $prep = $pdo->prepare($sql);
        $prep->execute([":id" => $status,
            ":name"=>$name]);
        if($prep->rowCount() != 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return true;
    }

}

?>

