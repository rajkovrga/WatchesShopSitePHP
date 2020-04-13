document.addEventListener("DOMContentLoaded",function () {

    document.getElementById("editprofile").addEventListener("click",function () {
        let regex = regexFunction("profile-form")
        if(regex)
        {
            axios({
                method:"post",
                url:"models/profile/editprofile.php",
                data:{
                    address: document.getElementById("address-prof").value
                }
            })
                .then(function (response) {
                    let res = document.getElementById("profile-result")
                if(response.status === 200)
                {
                    res.innerHTML = "Uspešno ste promenili podatke"

                    document.getElementById("address-show").innerHTML = document.getElementById("address-prof").value;

                }
                else if(response.status == 400)
                {
                    res.innerHTML = "Podaci nisu u dobrom formatu"
                }
                else if(response.status== 401)
                {
                    res.innerHTML = "Došlo je do greške";
                }
                else                     if(response.status == 402)
                    {
                        res.innerHTML = "Unesite nove podatke";
                }
            })
                .catch(function (error) {
                    if(error.response.status === 402)
                    {
                        document.getElementById("profile-result").innerHTML = "Unesite nove podatke";
                    }
                    else
                    {
                        document.getElementById("profile-result").innerHTML = "Došlo je do greške";
                    }
                })
        }

    });

    document.getElementById("change").addEventListener("click",function () {
        let equal = equalValues("#new-pass","#new-pass2")
        let regex = regexFunction("changepass-form")
        let old = document.getElementById("old-pass")
        let res = true;
        document.getElementById("pass-lost").innerHTML = ""
        let err = document.getElementById("change-result");

        if(!r["password"].test(old.value))
        {
            res = false;
            document.getElementById("pass-lost").innerHTML = "Lozinka nije u dobrom formatu"
        }
        if(regex && equal && res)
        {

            axios({
                method:"post",
                url:"models/profile/changepassword.php",
                data:{
                    "old":old.value,
                    "new":document.getElementById("new-pass").value
                }
            })
                .then(function (response) {
                    if(response.status == 400)
                    {
                        err.innerHTML = "Neki podatak nije u dobrom formatu"
                    }
                    else if(response.status == 401)
                    {
                        err.innerHTML = "Došlo je do neke greške, pokušajte ponovo"
                    }
                    else if(response.status == 402)
                    {
                        document.getElementById("pass-lost").innerHTML = "Lozinka ne odgovara";
                    }
                    else if(response.status == 403)
                    {
                        err.innerHTML = "Došlo je do neke greške, pokušajte ponovo"
                    }
                    else if(response.status == 200)
                    {
                        document.getElementById("new-pass").value = "";
                        document.getElementById("new-pass2").value = "";
                        document.getElementById("pass-lost").innerHTML = "";
                        old.value = "";
                        err.innerHTML = "Lozinka uspešno promenjena"
                    }
                })
                .catch(function (error) {
                    if(error.response.status == 402)
                    {
                        document.getElementById("pass-lost").innerHTML = "Lozinka ne odgovara";
                    }
                })

        }
    });


});
