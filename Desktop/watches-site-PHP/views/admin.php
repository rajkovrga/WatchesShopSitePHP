<?php
    if(isset($_SESSION["s_id"]))
    {
        if(!work($_SESSION["s_id"],"adminpanel",$pdo))
        {
           header("Location: index.php");
        }
    }
    else
    {
        header("Location: index.php");
    }
?>
    <section class="row profile-content ">
        <h3 class="center">Admin panel</h3>
        <ul class="admin-menu tabs" >
            <li class="tab"><a class="active" href="#tab1">Novi proizvod</a></li>
            <li class="tab"><a  href="#tab2">Narudžbine</a></li>
            <li class="tab"><a  href="#tab3">Kupci</a></li>
            <li class="tab"><a  href="#tab4">Posete</a></li>
            <li class="tab"><a  href="#tab5">Ostalo</a></li>
        </ul>
        <?php
              require_once __DIR__ . '/adminpanel/panel.php';
        ?>
    </section>

