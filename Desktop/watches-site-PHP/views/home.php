<section class="l12 m12 s12 xl12 gif-animate red lighten-1">
    <article class="p-title">
        <h3>Dobrodošli</h3>
        <p>Zvanični sajt za kupovinu SECTOR satova</p>
    </article>
</section>

<section class="l12 m12 s12 xl12   products-home lighten-1">
    <article id="text-products">
        <h2>Pogledajte širok asortiman satova i odaberite sat baš za vas</h2>
        <a href="index.php?page=products">Pogledaj</a>
    </article>
</section>
<section class="carousel newest">
    <h4>Najnoviji satovi</h4>
    <?php

    $newSQL = "SELECT * from products ORDER BY ProductDate DESC LIMIT 5";
    $new = executeQuery($newSQL);
    foreach ($new as $n):
    ?>

    <a class="carousel-item item-home-slider" href="index.php?page=product&id=<?=$n->ProductId?>">

        <article class="item-home-slider2">
            <section class="product-img">
                <img src="assets/img/products/<?=$n->Image?>" alt="<?=$n->ProductName?>">
            </section>
            <p><?=$n->Price?>,00 din</p>
            <h5>SECTOR <?=$n->ProductName?></h5>


        </article>

    </a>

    <?php endforeach; ?>
</section>