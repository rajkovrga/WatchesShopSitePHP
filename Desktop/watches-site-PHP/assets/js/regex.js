
    let r =
    {
        name: /^[A-ZŠĐĐŽČĆ][a-zšđžčć]{2,12}(\s[A-Z][a-zšđžčć]{2,12})*$/,
        address: /^([A-ZŠĐĐŽČĆ][a-zšđžčć]{2,14})(([\s][A-ZŠĐĐŽČĆ][a-zšđžčć]{2,14})|([\s][a-zšđžčć]{3,15})){0,5}[\s]((([1-9]|[1-9][0-9]|[1-9][0-9][0-9])([\/]([0-9]|[1-9][0-9]|[1-9][0-9][0-9])){0,1})|([0-9][A-Za-z]|[1-9][0-9][A-Za-z])|[B][B])$/,
        password: /^(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/,
        mail: /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-zšđžčć]{2,6}(?:\.[a-zšđžčć]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/,
        title: /^[A-ZŠĐĐŽČĆ0-9a-zšđžčć\\\/\-\s]+$/,
        description: /^[A-ZŠĐĐŽČĆ0-9a-zšđžčć\\\/\-\s]+$/,
        dropdown:/^[^0]/,
        img:/(\.png|\.jpg|\.gif)$/,
        price:/^\d{1,6}$/
    };


    function regexFunction(classRegex) {
        let boxes = document.getElementsByClassName(classRegex);
        let result = 0;
        for (let i = 0; i < boxes.length; i++) {
            if (boxes[i].hasAttribute("data-type") && boxes[i].hasAttribute("data-regex")) {
              if(!regex.regex(boxes[i].getAttribute("data-type"), boxes[i].getAttribute("data-regex")))
              {
                  result++;
              }
            }
        }
       if(result === 0)
       {
           return true;
       }
       else
       {
           return false;
       }
    }

    function checkImg(element,size,error, pr = false)
    {
        if(element.files[0] !== undefined || pr)
        {
            const name = element.files[0].name;
            if(r["img"].test(name))
            {
                if(element.files[0].size <= size)
                {
                    error.innerHTML = "";
                    return true;
                }
                else
                {
                    error.innerHTML = "Slika je prevelika";
                    return false;
                }
            }
            else
            {
                error.innerHTML = "Slika nije u odgovarajućem formatu";
                return false;
            }
        }
        else
        {
            error.innerHTML = "Ubacite sliku";
            return false;
        }

    }

    function equalValues(firstElement, secondElement) {
        if (document.querySelector(firstElement).value === document.querySelector(secondElement).value) {
            regex.resulttrue(secondElement)
            return true;
        } else {
            regex.resultfalse(secondElement)
            return false;
        }
    }

    let regex = {
        "regex": function (regexType, regexElement) {
            let selector = document.querySelector(regexElement).value;
            if (r[regexType].test(selector.trim()) && selector.trim() !== "") {
                regex.resulttrue(regexElement,regexType)
                return true;
            } else {
                regex.resultfalse(regexElement,regexType)
                return false;
            }
        },
        "resulttrue": (regexElement,regexType) => {
            let element;
            if(regexType === "dropdown")
            { element = document.querySelector(regexElement).parentElement.nextElementSibling.nextElementSibling;
            }
            else
            {
                element = document.querySelector(regexElement).nextElementSibling.nextElementSibling;
            }
            if (element.classList.contains("error-show")) {
                element.classList.remove("error-show");
                element.classList.add("error-hide");
            }
        },
        "resultfalse": (regexElement,regexType) => {
            let element;
            if(regexType === "dropdown")
            { element = document.querySelector(regexElement).parentElement.nextElementSibling.nextElementSibling;
            }
            else
            {
                 element = document.querySelector(regexElement).nextElementSibling.nextElementSibling;
            }
            if (element.classList.contains("error-hide")) {
                element.classList.remove("error-hide");
                element.classList.add("error-show");
            }
        }
    };

