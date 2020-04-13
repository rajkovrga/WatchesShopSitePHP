<?php


require_once __DIR__ . '/../regexes.php';

$data = json_decode($_POST["data"]);
$id = $data->id;
$display = $data->display;
$housing = $data->housing;
$nameprod = $data->name;
$mechanism = $data->mechanism;
$res = $data->resistance;
$gender = $data->gender;
$price = $data->price;

if(checkRegex($display,"num") && checkRegex($housing,"num") && checkRegex($nameprod,"title")
    && checkRegex($mechanism,"num") && checkRegex($res,"num") && checkRegex($gender,"num")
    && checkRegex($price,"price"))
{
    require_once __DIR__ . '/../../config/config.php';
    $sql = "SELECT * FROM products where ProductId = :id";
    $pr = $pdo->prepare($sql);
    $pr->execute([":id"=>$id]);
    $prp = $pr->fetch();
    $prImg = $prp->Image;

    $nameImg = $prp->Image;
    if($pr->rowCount() != 0)
    {
        if(isset($_FILES['file']))
        {
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $tmp = $_FILES['file']['tmp_name'];
            $type = $_FILES['file']['type'];
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

            if($flat)
            {
                unlink("../../assets/img/products/" . $prImg);

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
                    @    $img = imagecreatefromjpeg($tmp);
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

               @ imagecopyresampled($emptyImg,$img,0,0,0,0,$newWidth,$newHeight,$width,$height);

                switch($type)
                {
                    case "image/jpeg":
                        imagejpeg($emptyImg,$path);
                        break;
                    case "image/jpg":
                        imagejpeg($emptyImg,$path);
                        break;
                    case "image/png":
                        imagepng($emptyImg,$path);
                        break;
                    case "image/gif":
                        imagegif($emptyImg,$path);
                        break;
                }

            }
        }
        $updateSQL = "UPDATE `products` SET ProductName = :namepr, Price = :price, GenderId = :gender,`DisplayId`= :display,`MechanismId`= :mechanism , `HousingId`=
                  :housing , ResistanceId = :resistance, Image = :image WHERE `ProductId`  = :id";

        $prepare = $pdo->prepare($updateSQL);
        $prepare->execute([
            ":namepr" => $nameprod,
            ":price" => $price,
            ":gender" => $gender,
            ":housing" => $housing,
            ":resistance" => $res,
            ":display" => $display,
            ":id" => $id,
            ":image" => $nameImg,
            ":mechanism" => $mechanism
        ]);


            unset($pdo);
            http_response_code(200);

    }
    else
    {
        unset($pdo);
        http_response_code(407);

    }




}
else
{
    http_response_code(401);
}