<?php 

if(isset($_GET["page"]) && isset($_SESSION['status']))
{
    $sql = "SELECT * FROM statusmenu st inner join menuitems mi on st.ItemId = mi.ItemId inner join statuses ss 
    on ss.StatusId = st.StatusId WHERE (ss.StatusName = :name and mi.ItemHref = :href) or 
    (ss.StatusName = :sname and mi.ItemHref = :href2)";
    try
    {
        $prepare = $pdo->prepare($sql);
        $prepare->execute([
            ":href" => $_GET["page"],
            ":href2" => $_GET["page"],
            ":name" => $_SESSION["status"],
            ":sname" => 'Neautorizovan'
        ]);
        if($prepare->rowCount() == 0)
        {
          header('Location: ../../index.php');
        }
    }
    catch(PDOException $er)
    {
        echo $er->getMessage();
    }
}