<?php


if(isset($_POST['id']) && isset($_FILES['file']))
{
    $id = $_POST['id'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $tmp = $_FILES['file']['tmp_name'];
    $type = $_FILES['file']['type'];

    try
    {
        require_once __DIR__ . '/../../config/config.php';


        $select = $pdo->prepare("SELECT * FROM products where ProductId = :id");
        $select->execute([":id" => $id]);
        if($select->rowCount() === 0)
        {
            http_response_code(400);
            unset($pdo);
        }
        else
        {
            $flat = true;
            if($size > 2621440)
            {
            $flat = false;
                unset($pdo);
                http_response_code(403);

            }
            if(!preg_match("/[\/jpeg|\/jpg|\/png|\/gif]$/",$type))
            {
                $flat = false;
                unset($pdo);
                http_response_code(405);
            }
            if(!$flat)
            {
            $delete = "DELETE FROM products where ProductId = :id";
            $prepare = $pdo->prepare($delete);
            $prepare->execute([":id"=>$id]);
            unset($pdo);
            }
            else
            {

            $ext = explode(".",$name)[1];
            $nameImg = "image" . $id. "." .$ext;

            $path = "../../assets/img/products/".$nameImg;

            list($width,$height) = getimagesize($tmp);

            $newWidth= 250;
            $newHeight=250;
            $emptyImg = imagecreatetruecolor($newWidth,$newHeight);

            switch($type)
            {
                case "image/jpeg":
                    $img = imagecreatefromjpeg($tmp);
                    break;
                case "image/jpg":
                    $img = imagecreatefromjpeg($tmp);
                    break;
                case "image/png":
                    $img = imagecreatefrompng($tmp);
                    break;
                case "image/gif":
                    $img = imagecreatefromgif($tmp);
                    break;
            }

            imagecopyresampled($emptyImg,$img,0,0,0,0,$newWidth,$newHeight,$width,$height);

            switch($type)
            {
                case "image/jpeg":
                    imagejpeg($emptyImg,$path,75);
                    break;
                case "image/jpg":
                    imagejpeg($emptyImg,$path,75);
                    break;
                case "image/png":
                    imagepng($emptyImg,$path);
                    break;
                case "image/gif":
                    imagegif($emptyImg,$path);
                    break;
            }

            $update = "UPDATE `products` SET Image = :img WHERE ProductId = :id";
            $addimage = $pdo->prepare($update);

            $addimage->execute([
                ":img"=>$nameImg,
                ":id"=>$id
            ]);

            if($addimage->rowCount() != 0)
            {
                echo "TU";
                unset($pdo);
                http_response_code(200);
            }
            else
            {
                unset($pdo);
                http_response_code(401);
            }


        }

        }
    }
    catch(PDOException $er)
    {
        unset($pdo);
        http_response_code(401);
        echo $er->getMessage();
    }

}