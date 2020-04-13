<?php


require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/tools/redirect.php';
$status = "Neautorizovan";

if(isset($_SESSION["status"]))
{
$status = $_SESSION["status"];
}
$menuSQL = "SELECT DISTINCT  * FROM menuitems mi inner join statusmenu sm on mi.ItemId = sm.ItemId 
            inner join statuses s on sm.StatusId = s.StatusId where s.StatusId = :id 
            or StatusName = :name order by positionview";
$menuPrepare = $pdo->prepare($menuSQL);
$menuPrepare->execute([
    ":id" => 3,
    ":name" => $status
]);

$menuPrepare = $menuPrepare->fetchAll();

?>


<ul id="dropdown1" class="dropdown-content dropdown-margin mypink ">
<?php foreach($menuPrepare as $m): ?>
<?php if($m->PositionId == 1): ?>
            <li><a  href="index.php?page=<?= $m->ItemHref ?>"  class="textwhite"><?= $m->ItemName ?></a></li>
            <li class="divider"></li>
<?php endif; ?>
<?php endforeach; ?>  
    </ul>
    <nav id="nav" class="myred1">
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo"> <img src="assets/img/logo.png" class="logo" alt="mobile logo">
            </a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
            <?php foreach($menuPrepare as $m): ?>
<?php if($m->PositionId == 3): ?>
            <li><a href="index.php?page=<?= $m->ItemHref ?>"><?= $m->ItemName ?></a></li>
           
<?php endif; ?>
<?php endforeach; ?>  
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Još<i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li class="mob-logo">
            <img src="assets/img/logo.png" alt="mobile logo">
        </li>
        <?php foreach($menuPrepare as $m): ?>
<?php if($m->PositionId == 3): ?>
            <li><a href="index.php?page=<?=$m->ItemHref?>"><?= $m->ItemName ?></a></li>
           
<?php endif; ?>
<?php endforeach; ?>  
        <ul class="collapsible">
            <li>
                <div class="collapsible-header mobile-dropdown"> <span>Još <i class="material-icons right">arrow_drop_down</i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                       
                    <?php foreach($menuPrepare as $m): ?>
<?php if($m->PositionId == 1): ?>
            <li><a href="index.php?page=<?=$m->ItemHref?>"><?= $m->ItemName ?></a></li>
            <li class="divider"></li>
<?php endif; ?>
<?php endforeach; ?>  
                    </ul>
                </div>
            </li>
        </ul>
    </ul>