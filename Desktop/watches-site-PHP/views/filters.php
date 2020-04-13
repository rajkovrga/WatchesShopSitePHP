
            <div id="modal1" class="modal modal-fixed-footer row  col s8 m5">
                <div class="modal-content center">
                    <h5>Filtriranje</h5>
                    <p class="tool">Podesi cenu</p>
                    <?php

                        $minmaxSQL = "select MIN(Price) as minimum, MAX(Price) as maximum from products";
                        $minmaxPrep = $pdo->prepare($minmaxSQL);
                      $minmaxPrep->execute();
                    $result =  $minmaxPrep->fetch();
                    ?>
                    <div id="slider" data-min="<?=$result->minimum?>" data-max="<?=$result->maximum?>"></div>
                    <?php

                    ?>
                    <p class="tool">Pol</p>
                    <form action="#">
                        <?php

                        $genderSQL = "SELECT * FROM gender";

                        $genderPrep = executeQuery($genderSQL);
                        foreach ($genderPrep as $p):
                        ?>
                        <p class="lbl-parent">
                            <label class="lbl-checks">
                                <input type="checkbox" name="gender" class="gender" value="<?=$p->GenderId?>"/>
                                <span><?=$p->GenderName ?></span>
                            </label>
                        </p>
                        <?php endforeach;?>
                    </form>
                    <p class="tool">Tip kućišta</p>
                    <form action="#">
                        <?php

                        $housingSQL = "SELECT * FROM housing";

                        $housingPrep = executeQuery($housingSQL);
                        foreach ($housingPrep as $p):
                            ?>
                            <p class="lbl-parent">
                                <label class="lbl-checks">
                                    <input type="checkbox"  name="housing[]" class=" housing" value="<?=$p->HousingId?>"/>
                                    <span><?=$p->HousingName ?></span>
                                </label>
                            </p>
                        <?php endforeach;?>
                    </form>
                    <p class="tool"> Tip prikaza</p>
                    <form action="#">
                        <?php

                        $displaySQL = "SELECT * FROM display";

                        $displayPrep = executeQuery($displaySQL);
                        foreach ($displayPrep as $p):
                            ?>
                            <p class="lbl-parent">
                                <label class="lbl-checks">
                                    <input type="checkbox" name="display" class=" display" value="<?=$p->DisplayId?>"/>
                                    <span><?=$p->DisplayName ?></span>
                                </label>
                            </p>
                        <?php endforeach;?>
                    </form>
                    <p class="tool"> Tip mehanizma</p>
                    <form action="#">
                        <?php

                        $mechanismSQL = "SELECT * FROM mechanism";

                        $mechanismPrep = executeQuery($mechanismSQL);
                        foreach ($mechanismPrep as $p):
                            ?>
                            <p class="lbl-parent">
                                <label class="lbl-checks">
                                    <input type="checkbox" name="mechanism" class="mechanism" value="<?=$p->MechanismId?>"/>
                                    <span><?=$p->MechanismName ?></span>
                                </label>
                            </p>
                        <?php endforeach;?>
                    </form>
                    <p class="tool">Vodootpornost</p>
                    <form action="#">
                        <?php

                        $resistanceSQL = "SELECT * FROM resistance";

                        $resistancePrep = executeQuery($resistanceSQL);
                        foreach ($resistancePrep as $p):
                            ?>
                            <p class="lbl-parent">
                                <label class="lbl-checks">
                                    <input type="checkbox" name="resistance" class=" resistance" value="<?=$p->ResistanceId?>"/>
                                    <span><?=$p->ResistanceName ?> ATM</span>
                                </label>
                            </p>
                        <?php endforeach;?>
                    </form>

                </div>
    
                <div class="modal-footer">
                    <button  id="filter-btn" class="modal-close waves-effect waves-green btn-flat">filtriraj</button>

                    <button   class="modal-close waves-effect waves-green btn-flat">Izadji</button>
                </div>
            </div>