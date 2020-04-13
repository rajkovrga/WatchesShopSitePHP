<?php
   $regexes = [
    "address" => "/^([A-ZŠĐĐŽČĆ][a-zšđžčć]{2,14})(([\s][A-ZŠĐĐŽČĆ][a-zšđžčć]{2,14})|([\s][a-zšđžčć]{3,15})){0,5}[\s]((([1-9]|[1-9][0-9]|[1-9][0-9][0-9])([\/]([0-9]|[1-9][0-9]|[1-9][0-9][0-9])){0,1})|([0-9][A-Za-z]|[1-9][0-9][A-Za-z])|[B][B])$/",
    "name" => "/^[A-ZŠĐĐŽČĆ][a-zšđžčć]{2,12}(\s[A-Z][a-zšđžčć]{2,12})*$/",
    "password" => "/^(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/",
    "title" => "/^[A-ZŠĐĐŽČĆ0-9a-zšđžčć\s\-]+$/",
    "description" => "/^[A-ZŠĐĐŽČĆ0-9a-zšđžčć\s\-]+$/",
       "num" => "/[^0]/",
       "price" => "/^\d{1,6}$/"
];         

   
  

 function checkRegex($value,$type)
 {
     
 global $regexes;
     if(preg_match($regexes[$type],strval($value)))
      { return true;}
else
{
    echo $value;
    echo $type;
 return false;
}
   
 }