function cart() {

    if(localStorage.getItem("cart"))
    {
        let obj = JSON.parse(localStorage.getItem("cart"))
        let newObj = [];
        if(obj.length != 0)
        {
            obj.forEach(x => {
                newObj.push(x.id)
            })
            axios({
                url:"models/products/getfavorites.php",
                method:"post",
                data:newObj
            })
                .then(function (response) {
                    let retObj = response.data;
                    retObj.forEach(x => {
                        obj.forEach(y => {
                            if(x.ProductId == y.id)
                            {
                                Object.assign(x,{"count":y.count});
                            }
                        })

                    });
                    showCart(retObj)

                    let closes = document.getElementsByClassName("cls-cart");

                    for(let i = 0; i < closes.length;i++) {

                        closes[i].addEventListener("click", function () {

                            let id = this.getAttribute("data-id");
                            let cartItemsLS = JSON.parse(localStorage.getItem("cart"))
                            let newCart = [];
                            cartItemsLS.forEach(y => {
                                if (y.id != id) {
                                    newCart.push(y);
                                }
                            });
                            localStorage.setItem("cart", JSON.stringify(newCart))
                            cart()
                        });

                    }

                })
                .catch(function (err) {
                    console.log(err)
                })
        }
       else
        {
            showCart([])
            document.getElementById("collect-prices").innerHTML = 0
        }
    }
}
function showCart(obj) {
    ret = "";
    let errText = document.getElementById("cart-empty")
    errText.classList.add("f-none")
    obj.forEach(x => {
        ret +=  `
         <div class="cart-item red">
                        <img src="assets/img/products/${x.Image}" alt="" />
                        <h4> <a href="index.php?page=product&id=${x.ProductId}">${x.ProductName}</a> </h4>
                        <p>${x.Price},00din (${x.count}kom.)</p>
                        <div data-id="${x.ProductId}" class="close cls-cart">
                            <i class="material-icons">close</i>
                        </div>
                    </div>
        `;
    });
    let r = 0;
    obj.forEach( x => {
        r += x.Price*x.count;
    })
    document.getElementById("collect-prices").innerHTML =r
    document.getElementById("cart-items").innerHTML = ret;
    if(obj.length === 0)
    {
        if(errText.classList.contains("f-none"))
        {
            errText.classList.remove("f-none")
            errText.classList.add("f-flex");
        }
        document.getElementById("cart-items").innerHTML = "";
    }
}

