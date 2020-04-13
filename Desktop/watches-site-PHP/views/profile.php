<?php
   
      if(isset($_SESSION["id"]))
{

  $sql = "SELECT * from users where UserID = :id";
  $prepare = $pdo->prepare($sql);
  $prepare->execute([":id" => intval($_SESSION["id"])]);
  $result = $prepare->fetch();
}
else
{
  header("Location: index.php?page=login");
}

      ?>


<div class="row profile-content ">



        <h3 class="center">Korisnički nalog</h3>
        <p class="center"><i class="material-icons icon">account_circle</i></p>
        <span>
            <p class="center user-det"><b>Ime: </b><?= $result->FirstName; ?></p>
        </span>
        <p class="center user-det"><b>Prezime: </b><?= $result->LastName; ?></p> </span>
    <p class="center user-det"><b>Adresa: </b><span id="address-show"><?= $result->Address; ?></span></p> </span>

        <p class="center user-det"><b>E-mail: </b><span id="mail-show"><?= $result->Mail; ?></span></p> </span>
        <br>
        <button href="#modal6" class="btn modal-trigger waves-effect waves-light red">
            Izmeni podatke
        </button>        <br>
        <button href="#modal7" class="waves-effect modal-trigger waves-light btn red">
                Izmeni lozinku
            </button>
        <h4 class="center">Narudžbine</h4>
        <ul class="collapsible ">
            <?php
            $indents = "SELECT * FROM indent where UserId = :id ORDER BY IndentId desc";
                $elements = $pdo->prepare($indents);
                $elements->execute([":id" => $_SESSION["id"]]);
                $content = $elements->fetchAll();
            ?>
            <?php if($elements->rowCount() > 0):?>
                <?php foreach ($content as $c): ?>
                <li>
                  <div class="collapsible-header"> <p>ID: <?= $c->IndentId ?></p> <p>Datum: <?= date('Y-m-d',strtotime($c->IndentDate)) ?></p>     </div>
                  <div class="collapsible-body">
                      <ul>
                          <?php
                          $productSQL = "SELECT * FROM indent i inner join indentproduct ip on i.IndentId = ip.IndentId inner join products p on ip.ProductId = p.ProductId where ip.IndentId = :id";
                          $products = $pdo->prepare($productSQL);
                          $products->execute([":id"=> $c->IndentId]);
                            $res = $products->fetchAll();
                            $prices = 0;
                            foreach ($res as $r):
                                $prices += (int)$r->Price * $r->Count;
                          ?>
                          <li><p>SECTOR <?=$r->ProductName?></p>
                          <p> <?= $r->Price ?>,00din</p>
                          <p>Br komada: <?= $r->Count ?></p></li>
                          <?php endforeach; ?>
                                <li>
                                    <p>Ukupna cena: <?= $prices?>,00din</p>
                                </li>
                          <li>
                              <p>Status: <?= ($r->Sent == 1)?"Poslato":"Aktivan"?></p>
                          </li>
                      </ul>

                  </div>
                </li>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php if($elements->rowCount() == 0):?>
                <li>
                  <p class="center">Niste ostvarili jos ni jednu kupovinu</p>
                </li>
              </ul>
    <?php endif; ?>
        
    </div>


<div id="modal6" class="modal modal-fixed-footer row  col s8 m5">
    <div class="modal-content center">
        <form class="col s12">
            <?php
            $user = $pdo->prepare("SELECT * from users where UserId = :id");
            $user->execute([":id" => $_SESSION['id']]);
            $rez = $user->fetch();
            ?>
            <div class="row">
                <div class="input-field col s12 profile-form"  data-regex="#address-prof" data-type="address">
                    <input id="address-prof" value="<?= $rez->Address ?>" placeholder="Pere Perica (25/12) | (5A) | (BB)" type="text" >
                    <label for="address-prof">Adresa</label>
                    <span class="helper-text error-hide">Adresa nije dobra</span>
                </div>

                <div class="col s12 btn-forms">
                    <button id="editprofile" type="button" class=" btn red waves-effect waves-light center">Izmeni</button>
                </div>
                <p class="center result-text" id="profile-result"></p>

            </div>

        </form>
    </div>
    <div class="modal-footer modal-contact">
        <button class=" center modal-close waves-effect waves-green btn-flat">Zatvori</button>
    </div>
</div>

<div id="modal7" class="modal modal-fixed-footer row mymodal-style mymodal-author col s8 m5">
    <div class="modal-content center">
        <form class="col s12">

            <div class="row">
                <div class="input-field col s12" >
                    <input id="old-pass"  type="password" >
                    <label for="address-reg">Trenutna lozinka</label>
                    <span class="helper-text" id="pass-lost"></span>
                </div>
                <div class="input-field col s12 changepass-form"  data-regex="#new-pass" data-type="password">
                    <input id="new-pass"   type="password"  >
                    <label for="new-pass">Nova lozinka</label>
                    <span class="helper-text error-hide">Lozinka nije u dobrom formatu</span>
                </div>
                <div class="input-field col s12" >
                    <input id="new-pass2"  type="password" >
                    <label for="new-pass2">Ponoviti lozinku</label>
                    <span class="helper-text error-hide">Lozinke se ne slažu</span>
                </div>
                <div class="col s12 btn-forms">
                    <button id="change" type="button" class=" btn red waves-effect waves-light center">Izmeni lozinku</button>
                </div>
                <p class="center result-text" id="change-result"></p>
            </div>

        </form>
    </div>

    <div class="modal-footer modal-contact">
        <button class=" center modal-close waves-effect waves-green btn-flat">Zatvori</button>
    </div>
</div>