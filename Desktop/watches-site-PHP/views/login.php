

    <div class="row login-reg-forms ">

<div class="login  col l6 m6 s12">
    <h4 class="left">Logovanje</h4>
    <form class="col s12">
        <div class="row">
            <div class="input-field col s11 login-form" data-regex="#email-login" data-type="mail">
                <input id="email-login" type="email">
                <label for="email">Email</label>
                <span class="helper-text error-hide">Nije dobar format mejla</span>
            </div>
            <div class="input-field col s11 login-form" data-regex="#password-log" data-type="password">
                <input id="password-log" type="password">
                <label for="password-log">Lozinka</label>
                <span class="helper-text error-hide">Format lozinke nije dobar</span>
                <div class="col s12 btn-forms">
                        <button id="login" type="button" class=" btn red waves-effect waves-light">Uloguj se</button>
                    </div>
                    <p class="center result-text" id="login-result"></p>

            </div>
        </div>
    </form>
</div>
<div class="login  col l6 m6 s12">
        <h4 class="left">Registracija</h4>

    <form class="col s12">

        <div class="row">
                <div class="input-field col s5 registration-form"  data-regex="#fname" data-type="name">
                        <input id="fname" type="text" placeholder="Ime">
                        <label for="fname">Ime</label>
                        <span class="helper-text error-hide">Ime nije dobro</span>

                    </div>
            <div class="input-field col s5 registration-form" data-regex="#lname" data-type="name" >
                <input id="lname" type="text" placeholder="Prezime">
                <label for="lname ">Prezime</label>                       
                 <span class="helper-text error-hide">Prezime nije dobro</span>

            </div>
            <div class="input-field col s10 registration-form"  data-regex="#address-reg" data-type="address">
                    <input id="address-reg" placeholder="Pere Perica (25/12) | (5A) | (BB)" type="text" >
                    <label for="address-reg">Adresa</label>
                    <span class="helper-text error-hide">Adresa nije dobra</span>
                </div>
            <div class="input-field col s10 registration-form" data-regex="#email-reg" data-type="mail" >
                <input id="email-reg" type="text" placeholder="Mail">
                <label for="email-reg" >Email</label>
                <span class="helper-text error-hide">E-mail nije dobar</span>
            </div>
            <div class="input-field col s10 registration-form" data-regex="#password-reg" data-type="password">
                    <input id="password-reg" type="password" placeholder="Lozinka">
                    <label for="password-reg">Lozinka</label>
                    <span class="helper-text error-hide">Lozinka nije dobra</span>
                </div>
                <div class="input-field col s10 registration-form">
                        <input id="password-reg2" type="password" placeholder="Ponovite lozinku">
                        <label for="password-reg2">Ponovite lozinku</label>
                        <span class="helper-text error-hide">Lozinke nisu jednake</span>
                        <div class="col s12 btn-forms">
                                <button id="registration" type="button" class=" btn red waves-effect waves-light">Registracija</button>
                            </div>
                            <p class="center result-text" id="registration-result"></p>
                    </div>
               
                   
        </div>
        
    </form>
</div>


</div>
