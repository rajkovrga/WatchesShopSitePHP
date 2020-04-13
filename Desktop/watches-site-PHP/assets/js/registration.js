document.addEventListener("DOMContentLoaded",function() {
    document.getElementById("registration").addEventListener("click", function () {
        let equal = equalValues("#password-reg","#password-reg2")
        let regexes = regexFunction("registration-form");

        if(equal && regexes)
        {
            axios({
                method:"post",
                url:"models/login/registration.php",
                data:{
                    fname:document.getElementById("fname").value,
                    lname:document.getElementById("lname").value,
                    email:document.getElementById("email-reg").value,
                    password:document.getElementById("password-reg").value,
                    address:document.getElementById("address-reg").value
                }
            })
            .then(function(response)
            {console.log(response.status)
                if(response.status == 200)
                {
                   document.getElementById("registration-result").innerHTML = "Poslat aktivacioni link";
                   //  document.getElementById("fname").value = ""
                   // document.getElementById("lname").value = ""
                   // document.getElementById("email-reg").value = ""
                   //  document.getElementById("password-reg").value = ""
                   // document.getElementById("address-reg").value = ""
                   // document.getElementById("password-reg2").value = ""
                }
        else if(response.status == 406)
        {
            document.getElementById("registration-result").innerHTML = "Mejl je zauzet";

        }
                else
                {
                    document.getElementById("registration-result").innerHTML = "Došlo je do greške";

                }
            })
            .catch(function(er)
            {
                if(er.response.status == 406)
                {
                    document.getElementById("registration-result").innerHTML = "Mejl je zauzet";
                }
                else
                {
                    document.getElementById("registration-result").innerHTML = "Došlo je do greške";
                }
            })
        }
        
     });


    
});