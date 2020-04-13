<?php
 require_once __DIR__ . '/../../config/connection.php';
    if($_GET["token"] && $_GET["id"])
    {
        try{
            require_once __DIR__ . '/../../config/config.php';
        
            $sql = "SELECT * FROM users where UserId = :id AND Token = :token";
            $prepare = $pdo->prepare($sql);
            $prepare->execute([
            ":id" => $_GET["id"],
            ":token" => $_GET["token"]
        ]);

        if($prepare->rowCount() === 1)
        {
                $update = "UPDATE users SET Token = :null, Activate = :ok where UserId = :id";
                $active = $pdo->prepare($update);
                $active->execute([
                    ":null" => null,
                    ":ok" => 1,
                    ":id" => $_GET["id"]
                ]);
                if($active->rowCount() != 0)
                {
                    unset($pdo);
                    header("Location: ../../index.php?page=login");
                }
                else
                {
                    unset($pdo);
                    header("Location: ../../index.php?page=login");
                }
        }
        else
        {
            unset($pdo);
            header("Location: ../../index.php?page=login");

        }
        }
        catch(PDOException $er){
            unset($pdo);
            echo $er->getMessage();
        }
        

        

    }
    else
    {
        header("Location:  ../../index.php");
    }