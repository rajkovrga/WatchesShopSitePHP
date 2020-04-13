document.addEventListener("DOMContentLoaded",function () {
    $("#preload-f").show();

let noneFav = document.getElementsByClassName("none-fav")[0];
    showFavorites()
    function showFavorites() {
        if(localStorage.getItem("favorite"))
        {

            let fav = JSON.parse(localStorage.getItem("favorite"))
            if(fav.length > 0)
            {
            axios({
                method:"POST",
                url:"models/products/getfavorites.php",
                data:fav
            })
                .then(function (response) {
                    if(noneFav.classList.contains("f-flex"))
                    {
                        noneFav.classList.remove("f-flex")
                        noneFav.classList.add("f-none");
                    }
                    let obj = response.data;
                    showContent(obj);
                    $("#preload-f").hide();

                    let rm = document.getElementsByClassName("icon-rm")
                    for(let j = 0; j < rm.length;j++)
                    {
                        rm[j].addEventListener("click",function () {
                            let newFav = [];
                            console.log(rm[j].getAttribute("data-id"))
                            for(let i = 0; i < fav.length;i++)
                            {
                                if(fav[i] != rm[j].getAttribute("data-id"))
                                {
                                    newFav.push(fav[i]);
                                }
                            }
                            localStorage.setItem("favorite",JSON.stringify(newFav))
                            showFavorites()
                        })

                    }
                })
                .catch(function (err) {
                console.log(err)
                });
            }
        else
            {
                if(noneFav.classList.contains("f-none"))
                {
                    noneFav.classList.remove("f-none")
                    noneFav.classList.add("f-flex");
                }
                document.getElementById("fav-elements").innerHTML = "";
                $("#preload-f").hide();

            }
        }
        else
        {
            if(noneFav.classList.contains("f-none"))
            {
                noneFav.classList.remove("f-none")
                noneFav.classList.add("f-flex");
            }
            document.getElementById("fav-elements").innerHTML = "";
            $("#preload-f").hide();

        }
    }

function showContent(obj) {
let ret = "";
obj.forEach(x => {
    ret += `  <tr>
            <td><img src="assets/img/products/${x.Image}" alt=""></td>
            <td> ${x.ProductName} </td>
            <td>${x.Price},00din</td>
            <td><a href="index.php?page=product&id=${x.ProductId}"> <i class="material-icons close-icon">search</i></a></td>
            <td>
                   <i class="material-icons close-icon icon-rm" data-id="${x.ProductId}">close</i>
            </td>
        </tr>`;
});
document.getElementById("fav-elements").innerHTML = ret;
    }
});