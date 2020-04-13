document.addEventListener("DOMContentLoaded",function () {

    document.getElementById("updateproduct").addEventListener("click",function () {
        let image = document.getElementById("image");
        let errorImg = document.getElementById("img-error");
        let regexes = regexFunction("addproduct-form");
        let img;
        if(image.files[0] !== undefined)
        {

            img = checkImg(image,(2621440),errorImg);
            image = image.files[0];
        }
        else
        {
            image = 0;
            img = true;
        }
        let err = document.getElementById("response");
        if(regexes && img)
        {
            let id = this.getAttribute("data-id")
            let fm = new FormData();
            fm.append("file",image);
            fm.append("data",
                JSON.stringify({ name:document.getElementById("title-product").value,
                    gender:document.getElementById("gender").value,
                    display:document.getElementById("display").value,
                    housing:document.getElementById("housing").value,
                    resistance:document.getElementById("resistance").value,
                    mechanism: document.getElementById("mechanism").value,
                    price:document.getElementById("price").value,
                    id:this.getAttribute("data-id")
                }))
            axios.post("models/products/updateproduct.php",fm, {
                    headers:
                        {
                            "Content-type": "multipart/form-data"
                        }
            })
                .then(function (response) {
                    if(response.status === 200)
                    {
                       location.assign(`index.php?page=product&id=${id}`)
                    }
                })
                .catch(function (error) {
                    if (error.status === 401) {
                        err.innerText = "Neki podatak nije u dobrom formatu";
                    } else if (error.status === 402)
                    {
                        err.innerText = "Ovaj naziv već postoji";
                    }
                    else if(error.status === 403)
                    {
                        err.innerText = "Dogodila se greška, pokušajte ponovo";

                    }
                    else if(error.status === 444){
                        err.innerText = "Dogodila se greška, pokušajte ponovo";
                    }
                    console.log(error)
                })
        }
    });

    document.getElementById("delete").addEventListener("click",function () {
        if(confirm("Da li ste sigurni?"))
        {
            axios({
                method:"post",
                url:"models/products/deleteproduct.php",
                data:{id:this.getAttribute("data-id")}
            })
                .then(function (response) {
                    if(response.status == 200)
                    {
                     location.assign("index.php?page=products");
                    }
                    else
                    {
                        alert("Greška..")
                    }
                })
                .catch(function () {
                    
                })
            
        }
    });


});