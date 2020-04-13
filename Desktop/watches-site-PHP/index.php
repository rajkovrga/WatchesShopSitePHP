<!DOCTYPE html>
<html lang="en">


<?php
    session_start();
    ob_start();
    require_once __DIR__ . "/config/config.php";
    require_once __DIR__ . "/data/functions.php";
    require_once __DIR__ . '/models/tools/works.php';
    require_once __DIR__ . '/views/fixed/header.php'; ?>
<body>
    <?php require_once __DIR__ . '/views/fixed/menu.php'; ?>
    <?php

if(!isset($_GET["page"]))
{
  require_once __DIR__ . '/views/home.php'; 
}
else
{
    switch (trim($_GET["page"])) {
        case 'home':
            setView("home");
            require_once __DIR__ . '/views/home.php';
            break;
        case 'profile':
            setView("profile");
            require_once __DIR__ . '/views/profile.php';
            break;
        case 'login':
            setView("login");
            require_once __DIR__ . '/views/login.php';
            break;
        case 'products':
            setView("products");
                require_once __DIR__ . '/views/products.php';
                require_once __DIR__ . '/views/filters.php';
            break;

        case 'favorite':
            setView("favorite");
            require_once __DIR__ . '/views/favorite.php';
            break;
        case "product":
            if(!isset($_GET['id']))
            {
                header("Location: index.php?page=products");
            }
            require_once __DIR__ . '/views/oneproduct.php';
            break;
        case '403':
            require_once __DIR__ . '/views/fixed/403.php';
            break;
        case 'logout':
            require_once __DIR__ . '/models/login/logout.php';
            break;
        case 'admin':
            setView("admin");
            require_once __DIR__ . '/views/admin.php';
            break;
        default:
            require_once __DIR__ . '/views/fixed/404.php';
            break;
    }
}

?>

    <?php require_once __DIR__ . '/views/fixed/modals.php'; ?>

    <?php require_once __DIR__ . '/views/fixed/footer.php';?>

    <?php if(isset($_SESSION['login'])): ?>
        <script src="assets/js/buying.js"></script>
    <?php endif; ?>
    <?php


if(isset($_GET["page"]))
{
switch ($_GET["page"]) {
case 'admin':
require_once __DIR__ . '/views/scripts/addproduct.php';
    require_once __DIR__ . '/views/scripts/adminscript.php';
break;
    case 'login':
        require_once __DIR__ . '/views/scripts/loginscript.php';
        break;
    case 'products':
    require_once __DIR__ . '/views/scripts/scriptproducts.php';
    break;
    case 'profile':
        require_once __DIR__ . '/views/scripts/profilescript.php';

        break;
    case 'favorite':
    require_once __DIR__ . '/views/scripts/favoritescript.php';
    break;
    case 'product':
        require_once __DIR__ . '/views/scripts/oneproductscript.php';
        if(isset($_SESSION["login"]))
        {
            if(work($_SESSION["s_id"],"adminpanel",$pdo))
            {
                require_once __DIR__ . '/views/scripts/updatescript.php';
            }
        }
        break;
}
}

?>
    <?php unset($pdo);  ?>

  </body>

</html>