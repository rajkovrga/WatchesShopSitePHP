document.addEventListener("DOMContentLoaded",function () {
    users()
    changeStatus()
    getIndents()
    changeIndent()
    document.getElementById("backindent").addEventListener("click",function () {
        let box = document.getElementById("indent-id");
        let errBox = document.getElementById("indent-error")
        errBox.innerHTML= ""
        if(r["dropdown"].test(box.value))
        {
            axios({
                method:"post",
                url:"models/admin/backindent.php",
                data:{
                    id:box.value
                }
            })
                .then(function (response) {
                    if(response.status == 200)
                    {
                        getIndents();
                        box.value = "";
                    }
                    else if(response.status == 401)
                    {
                        errBox.innerHTML = "Id ne postoji ili je narudžbina aktivna";
                    }
                    else
                    {
                        errBox.innerHTML= "Došlo je do greške"
                    }
                })
                .catch(function (error) {
                    if(error.response.status == 401)
                    {
                        errBox.innerHTML = "Id ne postoji ili je narudžbina aktivna";
                    }
                    else
                    {
                        errBox.innerHTML= "Došlo je do greške"
                    }

                    console.log(error)
                })
        }
        else
        {
            errBox.innerHTML = "Id nije u dobrom formatu";
        }
    });
});

function users()
{
    axios({
        method:"post",
        url:"models/admin/getusers.php"
    })
        .then(function (response) {
            showUsers(response.data)
            changeStatus()
        })
        .catch(function (error) {
            console.log(error)
        })


}
function showUsers(obj) {
    let res = "";
    obj.forEach(x => {
        res += `
   
    <tr>
            <td>${x.FirstName} ${x.LastName}</td>
            <td>${x.Mail}</td>
            <td>${x.Address}</td>
            <td><a href="#modal8" class="statuses modal-trigger" data-id="${x.UserID}">${x.StatusName}</a></td>
            <td>`;

        if(x.Online == 1)
        {
            res += `    <i class="material-icons green-text">
                    fiber_manual_record
                </i>`;
        }
        else
        {
            res += `   <i class="material-icons red-text">
                        fiber_manual_record
                    </i>`;
        }
        res +=`</td>
        </tr>`
    });
    document.getElementById("users-show").innerHTML = res;
}
function getIndents() {
    axios({
        method:"post",
        url:"models/admin/getindents.php"
    })
        .then(function (response) {
            showIndents(response.data)
        })
        .catch(function (error) {
            console.log(error)
        })

}
function showIndents(obj) {
    let ret = "";
    let date
    if(obj.length !== 0)
    {
        obj.forEach(x => {
            date =  x.IndentDate
            ret += `
                <li>
                    <section class="collapsible-header"> <p>ID: ${x.IndentId}</p> <p>Datum: ${date.split(" ")[0]}</p>     </section>
                    <section class="collapsible-body body-indent">
                        <ul>`;
            let num = 0;
            x.ItemsIndent.forEach(y => {
                num += parseInt(y.Price);
                ret += `<li><p>SECTOR ${y.ProductName}</p>
                                    <p> ${y.Price},00din</p>
                                    <p>Br komada: ${y.Count}</p></li>
                            <?php endforeach; ?>`
            })
            ret += `<li class="info-li">
                                <p>Poručilac: ${x.FirstName}  ${x.LastName}</p>
                            </li>
                            <li class="info-li">
                                <p>Adresa: ${x.Address}</p>
                            </li>
                            <li class="info-li">
                                <p>Ukupna cena: ${num},00din</p>
                            </li>

                        </ul>
                        <article class="sented">
                            <div class="switch">
                                <label>
                                    Aktivno
                                    <input id="profile-switch-input input-sent" data-id="${x.IndentId}"  type="checkbox">
                                    <span  id="profile-switch-lever" class="lever"></span>
                                    Poslato
                                </label>
                            </div>
                        </article>
                    </section>
                </li>
      
       
`;
        })
    }
    else
    {
        ret +=` <li id="noindent">
            <p class="center">Nema ni jednog naloga za slanje trenutno</p>
        </li>`
    }

    document.getElementById("indents-show").innerHTML = ret;
    changeIndent()
}
function changeIndent() {
    let checkSwitch = document.querySelectorAll(".switch [type='checkbox']");
    for (let i = 0; i < checkSwitch.length;i++)
    {
        checkSwitch[i].addEventListener("change",function (e) {
            if(this.checked)
            {
                if(confirm("Da li ste sigurni?"))
                {
                    axios({
                        method:"POST",
                        url:"models/admin/sendindent.php",
                        data:{id:this.getAttribute("data-id")}
                    })
                        .then(function (response) {
                            if(response.status === 200)
                            {
                                getIndents()
                            }
                            else
                            {
                                alert("Dogodila se greška")
                            }
                        })
                        .catch(function (err) {
                            console.log(err)
                            alert("Dogodila se greška")
                        })
                }
                else
                {
                    checkSwitch[i].checked = false;
                }

            }
        })

    }
}
function  changeStatus() {
    let statuses =  document.getElementsByClassName("statuses");
    for(let i = 0; i < statuses.length;i++)
    {
        statuses[i].addEventListener("click",function () {
            axios({
                method:"post",
                url:"models/admin/setstatusmodal.php",
                data:JSON.stringify({
                    id:this.getAttribute("data-id")
                })
            })
                .then(function (response) {
                    let obj = response.data;
                    document.getElementById("editstatus").setAttribute("data-id",obj.UserID);
                    document.getElementById("statuses-result").innerHTML = "";
                    document.getElementById("lastfirstname").innerHTML = obj.FirstName + " " + obj.LastName;
                })
                .catch(function (error) {
                    console.log(error)
                })
        });
    }

    document.getElementById("editstatus").addEventListener("click",function () {
        let err =document.getElementById("statuses-result");
        axios({
            method:"post",
            url:"models/admin/changestatus.php",
            data:{
                id:this.getAttribute("data-id"),
                status:document.getElementById("statuses").value
            }
        })
            .then(function (response) {
                err.innerHTML = ""

                if(response.status === 200)
                {
                    err.innerHTML = "Uspešno promenjen status"
                    users()

                }
                else if(response.status === 401)
                {
                    err.innerHTML = "Ne možete sebi da menjate status"
                }
                else
                {
                    err.innerHTML = "Došlo je do greške, nije promenjen status"
                }
            })
            .catch(function (error) {
                console.log(error);
            })
    });
}