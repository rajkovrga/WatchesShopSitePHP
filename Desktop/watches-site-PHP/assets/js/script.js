document.addEventListener("DOMContentLoaded", function () {
    $('.carousel').carousel();
    $(' textarea#message,input#contact-title').characterCounter();
    autoplay();
    function autoplay() {
        $('.carousel').carousel('next');
        setTimeout(autoplay, 4500);
    }
    M.AutoInit()
    cart();
    
    document.getElementById("contact").addEventListener("click",function () {
       let check = regexFunction("form-contact")
       if(check)
       {
           let res = document.getElementById("result-contact");

           axios({
               method:"post",
               url:"models/tools/contact.php",
            data:{
                message:document.getElementById("message").value,
                mail:document.getElementById("email-contact").value,
                title:document.getElementById("contact-title").value
            }
           })
               .then(function (response) {
                     document.getElementById("message").value = ""
                   document.getElementById("email-contact").value = ""
                   document.getElementById("contact-title").value = ""
                   if(response.status === 200)
                   {
                   
                    res.innerHTML = "Poslato";
                   }
                   else if(response.status === 400)
                   {
                       res.innerHTML = "Podaci nisu u dobrom formatu";

                   }
                   else
                   {
                    res.innerHTML = "Došlo je do greške";
                   }
               })
               .catch(function (err) {
                   res.innerHTML = "Došlo je do greške";
                   console.log(err);
               })
       }

    });
})

