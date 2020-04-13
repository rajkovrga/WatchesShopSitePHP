<section id="tab4" class="col s12">

    <article class="tab-item">
        <h5 class="center">Posete</h5>

        <table class="striped table-pages">
            <th>Stranica</th>
            <th>%</th>
            <th>24h</th>
            <?php
                $file = fopen("data/pages","r");
                $data = file("data/pages");

                $sum = 0;

                foreach ($data as $d)
                {
                    $sum += (int)explode("-",$d)[1];
                }

                foreach ($data as $d):
                    $row = explode("-",$d);
                ?>
                <tr>
                    <td><?=$row[0]?>.php</td>
                    <td><?=round((int)$row[1]/$sum*100)?>%</td>
                    <td><?=getViewersPage(trim(explode("-",$d)[0]))?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </article>

</section>