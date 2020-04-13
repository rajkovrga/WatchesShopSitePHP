
<div id="tab1" class="col s12 ">

    <div class="add-products ">
        <h5 class="center">Dodavanje</h5>
        <form class="col" enctype="multipart/form-data">
            <div class="row">
                <div class="input-field col s11 addproduct-form"  data-regex="#price" data-type="price">
                    <input id="price" type="number" min="0"/>
                    <label for="price">Cena</label>
                    <span class="helper-text error-hide">Cena nije odgovarajuca</span>
                </div>
                <div class="input-field col s11 addproduct-form"  data-regex="#title-product" data-type="title">
                    <input id="title-product" type="text">
                    <label for="name">Naziv</label>
                    <span class="helper-text error-hide">Unesite naziv</span>
                </div>
                <div class="file-field input-field col s11">
                    <div class="btn red">
                        <span>Slika</span>
                        <input id="image"  type="file">


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
                            <option value="<?= $g->GenderId;?>"><?= $g->GenderName;?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Pol</label>
                    <span class="helper-text error-hide">Odaberite pol</span>

                </div>
                <div class="input-field col s11 addproduct-form"   data-regex="#display" data-type="dropdown">
                    <?php
                    $display = executeQuery("SELECT * FROM `display`");
                    ?>
                    <select name="display" id="display">
                        <option value="0">Odaberite..</option>

                        <?php foreach($display as $d):?>
                            <option value="<?= $d->DisplayId;?>"><?= $d->DisplayName;?></option>
                        <?php endforeach; ?>                                            </select>
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
                            <option value="<?= $m->MechanismId;?>"><?= $m->MechanismName;?></option>
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

                        <?php foreach($resistance as $r):?>
                            <option value="<?= $r->ResistanceId;?>"><?= $r->ResistanceName;?> ATM</option>
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
                            <option value="<?= $h->HousingId;?>"><?= $h->HousingName;?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Tip kućišta</label>
                    <span class="helper-text error-hide">Niste odabrali tip kućišta</span>
                    <span class="helper-text" id="response"></span>

                </div>
                <div class="col s12 btn-forms">
                    <button id="addproduct" type="button" class=" btn red waves-effect waves-light">Dodaj</button>

                </div>

            </div>
        </form>
    </div>

</div>
