document.addEventListener("DOMContentLoaded",function () {
    let PAGE_EL = 9;
    let NOW = 1;
    let box = document.getElementById("pagination");
    let left = document.getElementById("left");
    let right = document.getElementById("right");
    let pag = false;
    $("#empty-result").hide();

    sendStartEnd(0,9,pag,PAGE_EL,NOW,box,left,right,existFilter());
    right.addEventListener("click", function () {
        let nowValue = parseInt(box.getAttribute("data-now")) + 1;
        if (nowValue === (countItems(parseInt(box.getAttribute("data-db")), PAGE_EL) + 1)) {
            nowValue = nowValue - 1;
        }
        sendStartEnd(parseInt(document.getElementById("active").getAttribute("data-start"))+parseInt(PAGE_EL), 9,
            true,PAGE_EL,nowValue, box, left, right,existFilter())
    });
    left.addEventListener("click", function () {
        let nowValue = parseInt(box.getAttribute("data-now")) - 1;
        if (nowValue < 1) {
            nowValue = parseInt(nowValue) + 1;
        }
        sendStartEnd(document.getElementById("active").getAttribute("data-start")-PAGE_EL, 9,
            true,PAGE_EL,nowValue, box, left, right,existFilter())
    });
    document.getElementById("filter-btn").addEventListener("click",function () {
            if(localStorage.getItem("filter"))
            {
                localStorage.removeItem("filter")
            }
            sendStartEnd(0, 9,
                true,PAGE_EL,1, box, left, right,true)
        });
});
function sendStartEnd(start,end,pag,PAGE_EL,NOW,box,left,right,filter = false) {
    if(!filter)
    {
        $("#preload").show();
        axios({
            url:"models/products/getproducts.php",
            method:"post",
            dataType:"json",
            data:{
                start:parseInt(start),
                end:end
            }
        })
            .then(function (response) {
                let arr = response.data;
                box.setAttribute("data-db",arr.num);
                pagination(box.getAttribute("data-db"), PAGE_EL, NOW, box,left,right)
                showProducts(arr.obj)
                $("#preload").hide();

            })
            .catch(function (error) {
                console.log(error)
            })
    }
    else
    {
    let obj ;
    if(!localStorage.getItem("filter"))
    {
    obj =  getChecked();
    localStorage.setItem("filter",JSON.stringify(obj));

    }
    else
    {
        obj = JSON.parse(localStorage.getItem("filter"));
        checkingBoxes(obj.gender,"gender")
        checkingBoxes(obj.mechanism,"mechanism")
        checkingBoxes(obj.housing,"housing")
        checkingBoxes(obj.display,"display")
        checkingBoxes(obj.resistance,"resistance")
    }
        obj.start = start;
        $("#preload").show();

 axios({
        url:"models/products/filter.php",
        method:"post",
        dataType:"json",
        data: obj

    })
        .then(function (response) {
            let arr = response.data;
            box.setAttribute("data-db",arr.num);
            pagination(parseInt(box.getAttribute("data-db")), PAGE_EL, NOW, box,left,right)
            showProducts(arr.obj)
            $("#preload").hide();

        })
        .catch(function (error) {
            console.log(error)
        })
    }
}
function checkFavorites(id) {
if(localStorage.getItem("favorite")) {
    let fav = JSON.parse(localStorage.getItem("favorite"));
    if (fav.includes(parseInt(id))) {
        return true;
    }
    return false;
}
else
{
    return false;
}
}
function existFilter() {
    if(localStorage.getItem("filter"))
    {
    return true;
    }
    return false;
}
function showProducts(arr) {
    ret = "";
    arr.forEach(element =>  {
            ret += `<article  data-id="${element.ProductId}">
            <section class="product-img">
                <img src="assets/img/products/${element.Image}" alt="${element.ProductName}">
            </section>
            <p>${element.Price},00 din</p>
            <h2>SECTOR ${element.ProductName}</h2>
            <section class="detalis-item">
                <a href="index.php?page=product&id=${element.ProductId}" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">search</i></a>
            </section>
            <section class="hearth" data-id="${element.ProductId}">
                <i class="material-icons">`;
            if(checkFavorites(element.ProductId))
            {
               ret += "favorite";
            }
            else
            {
                ret += " favorite_border ";
            }
            ret +=`</i>
            </section>
        </article>`;
    })
    if(arr.length == 0)
    {
        $("#empty-result").show();
    }
    else
    {
        $("#empty-result").hide();
    }
    document.getElementById("product-items").innerHTML = ret;
    $(".hearth i").click(function () {
        let thisHeart = $(this);
        if(thisHeart[0].innerHTML.trim() === "favorite_border")
        {
            if(addToFavorite($(this).parent().data("id")))
            {
                thisHeart[0].innerHTML = "favorite";
            }
        }
        else
        {
            removeFavorite($(this).parent().data("id"));
            thisHeart[0].innerHTML = "favorite_border";
        }
    });
}
function addToFavorite(id) {
    if(localStorage.getItem("favorite"))
    {
        let fav = JSON.parse(localStorage.getItem("favorite"))
        if(fav.length >=10)
        {
            return false;
        }
        else
        {
            fav.push(id);
            localStorage.setItem("favorite",JSON.stringify(fav))
        }
    }
    else
    {
        let fav = [];
        fav.push(id);
        localStorage.setItem("favorite",JSON.stringify(fav))
    }
return true;
}
function removeFavorite(id) {
    let fav = JSON.parse(localStorage.getItem("favorite"));
    let newFav = [];
    for(let i = 0; i < fav.length;i++)
    {
        if(fav[i] != id)
        {
            newFav.push(fav[i]);
        }
    }
    localStorage.setItem("favorite",JSON.stringify(newFav))
}
function pagination(countFromDb, pageItems, now, box, left_btn, right_btn) {
    let pagItems = countItems(countFromDb, pageItems)
    box.setAttribute("data-now", now)
    if (pagItems > 1) {
        let items = createPaginationContent(pagItems, now, pageItems)
        box.innerHTML = items;
       neutralize(now, countItems(countFromDb, pageItems), left_btn, right_btn,countFromDb)
    }
    neutralize(now, countItems(countFromDb, pageItems), left_btn, right_btn,countFromDb)

    let elementItem = document.getElementsByClassName("item");
    for (let i = 0; i < elementItem.length; i++) {
        elementItem[i].addEventListener("click", function () {
            let nowN = parseInt(elementItem[i].getAttribute("data-id"));
            sendStartEnd(elementItem[i].getAttribute("data-start"), 9,
            true,pageItems,nowN, box, left_btn, right_btn,existFilter())
        })
    }
}
function countItems(countFromDb, pageItems) {
    return Math.ceil(countFromDb / pageItems)
}
function neutralize(now, count, leftBtn, rightBtn,dbCount) {
    if(dbCount <= 9)
    {
        document.getElementById("pagination").style.display = "none";
    }
    else
    {
        document.getElementById("pagination").style.display = "flex";
    }
    if (now < 2) {
        leftBtn.style.display = "none";
    }
    else {
        leftBtn.style.display = "block";
    }
    if (now === count || count == 0) {
        rightBtn.style.display = "none";
    }
    else {
        rightBtn.style.display = "block";
    }
}
function createPaginationContent(pagItems, now, pageItems) {
    let elementi = "";

    for (let i = now - 1; i <= now + 1; i++) {
        if ((i < pagItems + 1) && (i > 0 || i > 1)) {
            elementi += `<li class=" item waves-effect`;
            if (i == now) {
                elementi += ` active" id="active"`;
            }
            else
            {
                elementi+=`"`;
            }
            elementi += ` data-id='${i}' data-end="${pageItems}" data-start='${i * pageItems - pageItems}'><a href="#nav">${i}</a></li>`;
        }
    }
    return elementi;
}
function getChecked() {
    let getObj = {};
    var gender = [];
    $.each($("input[name='gender']:checked"), function() {
        gender.push($(this).val());
    });
    getObj.gender = (gender.length===0)?true:gender
    var display = [];
    $.each($("input[name='display']:checked"), function() {
        display.push($(this).val());
    });
    getObj.display = (display.length===0)?true:display;

    var mechanism = [];
    $.each($("input[name='mechanism']:checked"), function() {
        mechanism.push($(this).val());
    });
    getObj.mechanism = (mechanism.length===0)?true:mechanism;
    var resistance = [];
    $.each($("input[name='resistance']:checked"), function() {
        resistance.push($(this).val());
    });
    getObj.resistance = (resistance.length===0)?true:resistance;
    var housing = [];
    $.each($("input[name='housing']:checked"), function() {
        housing.push($(this).val());
    });
    getObj.housing = (housing.length===0)?true:housing;

    getObj.min = document.querySelectorAll("#slider .noUi-tooltip")[0].children[0].innerHTML;
    getObj.max = document.querySelectorAll("#slider .noUi-tooltip")[1].children[0].innerHTML;

    getObj.end = 9;
    return getObj;
}
function checkingBoxes(arr,name) {
if(typeof arr != "object")
    return;
        let nameCheck = document.getElementsByName(name);
        arr.forEach(x => {
            for (let i = 0; i < nameCheck.length; i++) {
                if (x == nameCheck[i].value) {
                    nameCheck[i].setAttribute("checked", true);
                }
            }


        })

}
