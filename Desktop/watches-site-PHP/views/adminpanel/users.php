<article id="tab3" class="col s12">
<section class="tab-item users">
    <h5 class="center">Kupci</h5>
    <table id="users-admin">
        <th>Korisnik</th>
        <th>Mejl</th>
        <th>Adresa</th>
        <th>Status</th>
        <tbody id="users-show">
       </tbody>

    </table>
</section>
</article>
<div id="modal8" class="modal modal-fixed-footer  modal-statuses col  xl4 l5 m6 s10 ">
    <div class="modal-content center">
        <form class="col s12">
        <h5>Korisnik</h5>
            <p id="lastfirstname"></p>
            <h5>Status</h5>
            <select name="statuses" id="statuses">
                <?php
                $statuses = executeQuery("SELECT * from statuses");
                foreach ($statuses as $s):
                ?>
                <?php if($s->StatusName !== "Neautorizovan"):?>
                <option value="<?=$s->StatusId?>"><?=$s->StatusName;?></option>
                <?php endif;?>
                <?php endforeach;?>
            </select>
            <div class="col s12 btn-forms">
                <button id="editstatus" type="button" class=" btn red waves-effect waves-light center">Dodeli</button>
            </div>
            <p class="center result-text" id="statuses-result"></p>
        </form>
    </div>

    <div class="modal-footer">
        <button class=" center modal-close waves-effect waves-green btn-flat">Zatvori</button>
    </div>
</div>



