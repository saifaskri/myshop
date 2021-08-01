
//function to hide a elemnt by pressing an other elemnt
// or the elemnt him self  attribute are just classes names
//first is your button seconde attribute is element to toggel
//can choose the display type and none is possibel too 
  
function HideElement(button,element,DisplayType="block"){
    var b = document.getElementsByClassName(button);
    b[0].addEventListener("click",()=>{
    var hide = document.getElementsByClassName(element);
    if(hide[0].style.display!="none"){
    hide[0].style.display="none";
    }else{hide[0].style.display=DisplayType;}})   
}
//===========================================================
