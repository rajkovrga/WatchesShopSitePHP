document.addEventListener("DOMContentLoaded",() =>
{
    document.getElementById("addproduct").addEventListener("click",() =>{
        let image = document.getElementById("image");
        let errorImg = document.getElementById("img-error");
        let regexes = regexFunction("addproduct-form");
        let img = checkImg(image,(2621440),errorImg);
    let err = document.getElementById("response");
        if(regexes && img)
        {

            axios({
                method:"post",
                url:"models/products/addproduct.php",
                data:
                    {
                       name:document.getElementById("title-product").value,
                       gender:document.getElementById("gender").value,
                        display:document.getElementById("display").value,
                        housing:document.getElementById("housing").value,
                        resistance:document.getElementById("resistance").value,
                        mechanism: document.getElementById("mechanism").value,
                        price:document.getElementById("price").value
                    }
            })
                .then(function (response) {
                        if(response.status === 200)
                        {
                            let file = new FormData();
                            file.append("file",image.files[0]);
                            file.append("id",response.data.id);
                            let id = response.data.id;
                            axios.post("models/products/addimage.php",file,
                                {
                                    headers:
                                        {
                                            "Content-type":"multipart/form-data"
                                        }
                                })
                                .catch(function (response) {
                                    if(response.status === 200)
                                    {
                                        location.assign("../../index.php?page=oneproduct&id="+id);
                                    }
                                })
                                .error(function(error)
                                {
                                  if (error.status === 402)
                                    {
                                        err.innerText = "Veličina fajla nije dobra";
                                    }
                                    else if(error.status === 403)
                                    {
                                        err.innerText = "Fajl nije u dobrom formatu";

                                    }  else
                                    {
                                    err.innerText = "Došlo je do greške";
                                }
                                    })
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
                })
        }
    })
});