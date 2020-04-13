<?php
$sql = "SELECT * FROM products p INNER JOIN mechanism m ON m.MechanismId = p.MechanismId
 inner join display d on d.DisplayId = p.DisplayId inner join housing h on h.HousingId = p.HousingId
  inner join resistance r on r.ResistanceId = p.ResistanceId
 inner join gender g on g.GenderId = p.GenderId where p.ProductId = :id";
$prep = $pdo->prepare($sql);
$prep->execute([":id" => $_GET['id']]);
$r = $prep->fetch();
if($prep->rowCount() === 0)
{
    header("Location: index.php");
}
$status = (isset($_SESSION["s_id"]))?$_SESSION["s_id"]:"Neautorizovan";

?>
    <h4 class="center" id="title-watch">SECTOR <?=$r->ProductName?></h4>

<section class="product-detalis row ">
    <div class="oneproduct  ">
        <div class="oneproduct-img"> <img id="img-product" src="assets/img/products/<?=$r->Image?>" alt="one product img"> </div>
        <div class="oneproduct-detalis">
            <div class="detalis left">
                <h5>Detalji modela</h5>
                <h6>Cena</h6>
                <p id="housingTitle"><?=$r->Price?>,00din</p>
                <h6>Vrsta kućišta</h6>
                <p id="housingTitle"><?=$r->HousingName?></p>
                <h6>Mehanizam</h6>
                <p id="mechanismTitle"><?=$r->MechanismName?></p>
                <h6>Pol</h6>
                <p id="genderTitle"><?=$r->GenderName?></p>
                <h6>Vodootpornost</h6>
                <p id="resistanceTitle"><?=$r->ResistanceName?> ATM</p>
                <h6>Tip prikaza</h6>
                <p id="displayTitle"><?=$r->DisplayName?></p>
                <?php if(work($status,"adminpanel",$pdo)): ?>
                <button id="update" href="#modal5" class="prd-btn  modal-trigger"  data-id="<?=$r->ProductId?>"> Izmeni
                </button>
                <button id="delete" class="prd-btn"  data-id="<?=$r->ProductId?>">
                    Obriši
                </button>
                <?php endif; ?>
                <h4>Dodaj u korpu</h4>

                <div class="qunatity">
                    <button id="minus">-</button>
                    <input type="text" readonly value="1"   data-id="<?=$r->ProductId?>" id="quantity">
                    <button id="plus">+</button>
                </div>
                <div class="add-cart" >
                    <button id="add" class="prd-btn" onclick="M.toast({html: 'Dodato u korpu',displayLength:1000})" data-id="<?=$r->ProductId?>"> <i class="material-icons">add_shopping_cart
                            </i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

if(work($status,"buyproducts",$pdo)): ?>

<div id="modal5" class="modal modal-fixed-footer row mymodal-style mymodal-author col s8 m5">
    <div class="modal-content center">
        <h4 class="center">Izmena proizvoda</h4>
        <form class="col" enctype="multipart/form-data">
            <div class="row">
                <div class="input-field col s11 addproduct-form"  data-regex="#price" data-type="price">
                    <input id="price" value="<?=$r->Price?>" type="number" min="0"/>
                    <label for="price">Cena</label>
                    <span class="helper-text error-hide">Cena nije odgovarajuca</span>
                </div>
                <div class="input-field col s11 addproduct-form"  data-regex="#title-product" data-type="title">
                    <input id="title-product"  value="<?=$r->ProductName?>" type="text">
                    <label for="name">Naziv</label>
                    <span class="helper-text error-hide">Unesite naziv</span>
                </div>


                <div class="file-field input-field col s11">
                    <div class="btn red">
                        <span>Slika</span>
                        <input id="image" type="file">


                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path" placeholder="Ubacite sliku..." type="text">
                        <span id="img-error" class="helper-text "></span>
                    </div>
                </div>
                <div class="input-field col s11 addproduct-form"  data-regex="#gender" data-type="dropdown">
                    <?php
                    $gender = executeQuery("SELECT * FROM `gender`");
                    ?>
                    <select name="gender" id="gender">
                        <option value="0">Odaberite..</option>

                        <?php foreach($gender as $g):?>
                            <option

                                <?php if($g->GenderId == $r->GenderId):?>
                                    <?=" selected "?>
                                <?php endif;?>

                                    value="<?= $g->GenderId;?>"><?= $g->GenderName;?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Pol</label>
                    <span class="helper-text error-hide">Odaberite pol</span>

                </div>
                <div class="input-field col s11 addproduct-form"   data-regex="#display" data-type="dropdown">
                    <?php
                    $display = executeQuery("SELECT * FROM `display`");
                    ?>
                    <select name="display" value="<?=trim($r->DisplayId)?>" id="display">
                        <option value="0">Odaberite..</option>

                        <?php foreach($display as $d):?>

                            <option

                                    <?php if($d->DisplayId == $r->DisplayId):?>
                                     <?=" selected "?>
                                    <?php endif;?>

                                    value="<?= $d->DisplayId;?>"><?= $d->DisplayName;?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Tip prikaza</label>
                    <span class="helper-text error-hide">Niste odabrali prikaz</span>

                </div>
                <div class="input-field col s11 addproduct-form"  data-regex="#mechanism" data-type="dropdown">
                    <?php
                    $mech = executeQuery("SELECT * FROM `mechanism`");
                    ?>
                    <select name="mechanism" id="mechanism">
                        <option value="0">Odaberite..</option>

                        <?php foreach($mech as $m):?>
                            <option
                                <?php if($m->MechanismId == $r->MechanismId):?>
                                    <?=" selected "?>
                                <?php endif;?>

                                    value="<?= $m->MechanismId;?>"><?= $m->MechanismName;?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Mehanizam</label>
                    <span class="helper-text error-hide">Niste odabrali mehanizam</span>

                </div>
                <div class="input-field col s11 addproduct-form"  data-regex="#resistance" data-type="dropdown">
                    <?php
                    $resistance = executeQuery("SELECT * FROM `resistance`");
                    ?>
                    <select name="resistance" id="resistance">
                        <option value="0">Odaberite..</option>

                        <?php foreach($resistance as $rs):?>
                            <option
                                <?php if($rs->ResistanceId == $r->ResistanceId):?>
                                    <?=" selected "?>
                                <?php endif;?>

                                    value="<?= $rs->ResistanceId;?>"><?= $rs->ResistanceName;?> ATM</option>
                        <?php endforeach; ?>
                    </select>
                    <label>Vodootpornost</label>
                    <span class="helper-text error-hide">Niste odabrali vodootpornost</span>

                </div>
                <div class="input-field col s11 addproduct-form"  data-regex="#housing" data-type="dropdown">
                    <?php
                    $housing = executeQuery("SELECT * FROM `housing`");
                    ?>
                    <select name="housing" id="housing">
                        <option value="0">Odaberite...</option>

                        <?php foreach($housing as $h):?>
                            <option
                                <?php if($h->HousingId == $r->HousingId):?>
                                    <?=" selected "?>
                                <?php endif;?>


                                    value="<?= $h->HousingId;?>"><?= $h->HousingName;?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Tip kućišta</label>
                    <span class="helper-text error-hide">Niste odabrali tip kućišta</span>
                    <span class="helper-text" id="response"></span>

                </div>
                <div class="col s12 btn-forms">
                    <button id="updateproduct" data-id="<?=$r->ProductId?>" type="button" class=" btn red waves-effect waves-light">Izmena</button>
                </div>

            </div>
        </form>
    </div>

    <div class="modal-footer modal-contact">
        <button class=" center modal-close waves-effect waves-green btn-flat">Zatvori</button>
    </div>
</div>
<?php endif; ?>




