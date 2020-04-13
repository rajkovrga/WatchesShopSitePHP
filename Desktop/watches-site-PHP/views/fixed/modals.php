<div id="modal2" class="modal bottom-sheet modal-fixed-footer ">
            <div class="modal-content " id="mycart">
                <h3>Korpa</h3>
                <div class="cart-items" id="cart-items"></div>
                <p id="cart-empty" class="center">U korpi trenutno nema proizvoda</p>
            </div>
     
        <div class="modal-footer cart-footer modal-cart-footer">
            <p>Ukupna suma: <b><span id="collect-prices">25000</span> din</b></p>
           <span>
               <a href="#!" class="modal-close waves-effect waves-green btn-flat">IZADJI</a>
            <a href="<?php
            if(!isset($_SESSION["login"]))
            {
                echo "index.php?page=login";
            }
            else{
                echo "#";
            }
            ?>" id="buy" class=" waves-effect waves-green btn-flat">KUPI</a></span>
        </div>
    </div>
    
    <div id="modal3" class="modal row mymodal-contact mymodal-style col s8 m5">
                    <div class="modal-content center modal-padding">
                        <div class="close modal-close">
                            <i class="material-icons">close</i>
                        </div>
                        <h5>Kontakt</h5>
                        <div class="row">
                                <form class="col s12">
                                  <div class="row">
                                    <div class="input-field col s12 form-contact" data-regex="#email-contact" data-type="mail">
                                      <input id="email-contact" type="email"/>
                                      <label for="email-contact">E-mail</label>
                                        <span class="helper-text error-hide">Nije dobar format mejla</span>
                                    </div>
                                    <div class="input-field col s12 form-contact" data-regex="#contact-title" data-type="title">
                                        <input id="contact-title" type="text">
                                        <label for="contact-title">Naslov</label>
                                        <span class="helper-text error-hide">Nije dobar format naslova</span>
                                          </div>
                                    <div class="input-field col s12 form-contact" data-regex="#message" data-type="description">
                                            <textarea id="message" data-length="120" rows="10" class="materialize-textarea "></textarea>
                                            <label for="message">Poruka</label>
                                              <span class="helper-text error-hide">Nije dobar format opisa</span>
                                        <div class="col s12 btn-forms tab-item">
                                            <button id="contact" type="button" class=" btn red waves-effect waves-light">Pošalji</button>
                                        <p id="result-contact"></p>
                                        </div>
                                    </div>
                                  </div>
                                </form>
                              </div>
                    </div>

                </div>
                <div id="modal4" class="modal modal-fixed-footer row mymodal-style mymodal-author col s8 m5">
                        <div class="modal-content center tab-item">
                            <h5>Autor</h5>
                           <img src="assets/img/ezgif.com-gif-maker.gif" alt="">
                           <p>Rajko Vrga</p>
                            <a class="white-text"  href="models/word/getword.php"> <button type="button"  class="btn col btn-other red">Word</button></a>

                        </div>
            
                        <div class="modal-footer modal-contact">
                            <button class=" center modal-close waves-effect waves-green btn-flat">Zatvori</button>
                        </div>
                    </div>
                    <a class="btn-floating cart btn-large btn modal-trigger waves-effect waves-light myred1" href="#modal2"><i class="material-icons">shopping_cart
        </i></a>


   