<section class="tab-item" id="preload">
<img src="assets/img/preload.svg" alt="">
</section>
<section class="col s12  products-items" id="product-items">
    
    </section>
<section class="tab-item" id="empty-result">
    <p class="center">Nema rezultata filtriranja</p>
</section>
    <ul class="pagination" >
        <li id="left"><a href="#nav"><i class="material-icons">chevron_left</i></a></li>
        <?php $allSQL = "SELECT COUNT(*) as number from products";
            $prepare = $pdo->prepare($allSQL);
            $prepare->execute();
            $res = $prepare->fetch();
        ?>
        <span id="pagination" data-all="<?=$res->number?>">
        </span>
        <li id="right" class="waves-effect"><a href="#nav"><i class="material-icons">chevron_right</i></a></li>
    </ul>
    <a class="btn-floating btn-large modal-trigger waves-effect waves-light red " data-target="modal1" href="#modal1"
        id="filter-items"><i class="material-icons">settings</i></a>
   
