document.addEventListener("DOMContentLoaded",function () {

    document.getElementById("buy").addEventListener("click",function () {

        if(localStorage.getItem("cart"))
        {
            let obj = JSON.parse(localStorage.getItem("cart"))
            if(obj.length != 0)
            {
                if( confirm("Da li ste sigurni?") )
                {
                    axios({
                        method: "post",
                        url:"models/products/addindent.php",
                        data:JSON.stringify(obj)
                    })
                        .then(function (response) {
                            if(response.status === 200)
                            {
                                localStorage.removeItem("cart")
                                location.assign("index.php?page=profile");
                            }
                            else
                            {
                                alert("Dogodila se greška, možda neki proizvod više ne postoji, ispraznite kasu i kupujte ponovo")
                            }
                        })
                        .catch(function (error) {
                            console.log(error)
                        })
                }

            }
        else
            {
                console.log("NEMA")
            }
        }
        else {
            console.log("NEMA")
        }



    });


});