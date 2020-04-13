document.addEventListener("DOMContentLoaded",function() {
    document.getElementById("login").addEventListener("click", function () {
        let regexes = regexFunction("login-form");
        if(regexes)
        {
            axios({
                method:"post",
                url:"/models/login/login.php",
                data:{
                    email:document.getElementById("email-login").value,
                    password:document.getElementById("password-log").value,
                }
            })
            .then(function(response)
            {
                if(response.status === 200)
                {
                   location.assign("index.php");
                }

            })
            .catch(function(error,code)
            {
                console.log(error)
             if(error.response.status == 400)
            {
                document.getElementById("login-result").innerHTML = "Podaci nisu u dobrom formatu";

            }
            else if(error.response.status == 401)
            {
                document.getElementById("login-result").innerHTML = "Podaci nisu dobri ili je nalog neaktivan";
            }
            else
             {
                  document.getElementById("login-result").innerHTML = "Došlo je do greške";

             }
            })
        }
        
     });

 
    
});