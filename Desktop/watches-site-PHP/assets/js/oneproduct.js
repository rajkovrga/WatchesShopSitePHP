document.addEventListener("DOMContentLoaded",function()
{
    let quant = document.getElementById("quantity")
    cartCounter()
function cartCounter() {
    let val = document.getElementById("quantity");
    document.getElementById("plus").addEventListener("click",function () {
         if(val.value < 10)
         {
             val.value = (parseInt(val.value)+1);
         }
    });
    document.getElementById("minus").addEventListener("click",function () {
        if(val.value > 1)
        {
            val.value = (parseInt(val.value)-1);
        }
    });
}
if(localStorage.getItem("cart"))
{
    let cart = JSON.parse(localStorage.getItem("cart"));
    cart.forEach(x => {
        if(x.id == quant.getAttribute("data-id"))
        {
            quant.value = x.count;
        }
    });
}

document.getElementById("add").addEventListener("click",function () {
    let obj;
    let countProd = document.getElementById("quantity").value;
if(localStorage.getItem("cart"))
{
let cart = JSON.parse(localStorage.getItem("cart"));
let count = 0;
cart.forEach(x => {
    count+= parseInt(x.count);
})
let res = checkItem(this.getAttribute("data-id"),count,countProd)
    if((count+parseInt(countProd)) > 10)
    {
        if(res)
        {
            alert("Nije dozvoljeno imati vise od 10 proizvoda u korpi")
        }
        else if((count+parseInt(countProd)) > 10 && res)
        {
            alert("Nije dozvoljeno imati vise od 10 proizvoda u korpi")
        }
        else
        {
            addToCart(cart,this.getAttribute("data-id"))
        }
    }
    else
    {
        addToCart(cart,this.getAttribute("data-id"))
    }
}
else
{
    obj =
        {
            "id":this.getAttribute("data-id"),
            "count":countProd
        }
    localStorage.setItem("cart",JSON.stringify([obj]))
    cart()
}
function addToCart(cartItems,id) {
    let br = true;
    cartItems.forEach(x => {
        if(x.id === id)
        {
            x.count = countProd;
            br = false;
        }
    })

    if(br)
    {
        cartItems.push({
            "id":id,
            "count":countProd
        });
    }
    localStorage.setItem("cart",JSON.stringify(cartItems))
    cart()
}

});

function checkItem(id,num,newNum) {
    let vrd = true;
        let cart = JSON.parse(localStorage.getItem("cart"))
            cart.forEach(x=> {
                if(x.id == id)
                {
                    console.log(parseInt(num)-parseInt(x.count)+parseInt(newNum))
                        if(!((parseInt(num)-parseInt(x.count)+parseInt(newNum)) > 10))
                        {
                            vrd = false;
                        }
                }
            })
    return vrd;
}



function showProduct(id) {
    axios({
        method:"post",
        url:"models/products/getoneproduct.php",
        data:
            {
                "id":id
            }
    })
        .then(function (response) {
            if(response.status === 200)
            {
                let obj = response.data;
            }
            else if(response.status === 400)
            {
                location.assign("index.php?page=products");
            }
        })
        .catch(function (error) {
            console.log(error);
        })
}});

