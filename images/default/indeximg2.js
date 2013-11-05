var speedtwo = 20;
var direction2="top";
var tab4 = document.getElementById("scrollbox2");
var tab5 = document.getElementById("scrollpic2");
var tab3 = document.getElementById("scrollpic-copy2");
var leftDir2 = document.getElementById("leftDir2");
var rightDir2 = document.getElementById("rightDir2");
tab3.innerHTML = tab5.innerHTML;
function marqueetwo(){
    switch(direction2){
        case "top":
            if(tab3.offsetHeight - tab4.scrollTop <= 0){
                tab4.scrollTop -= tab5.offsetHeight;
            }
            else{
                tab4.scrollTop++;
            }
        break;
        case "bottom":
            if(tab4.scrollTop <= 0){
                tab4.scrollTop += tab3.offsetHeight;
            }
            else{
                tab4.scrollTop--;
            }
        break;
    }
}
function changeDirection2(dir){
   direction2 = dir;
}

var timertwo = setInterval(marqueetwo,speedtwo);
tab4.onmouseover = function(){
	clearInterval(timertwo);
	};
tab4.onmouseout = function(){timertwo = setInterval(marqueetwo,speedtwo);};
leftDir2.onclick = function(){changeDirection2("top");};
rightDir2.onclick = function(){changeDirection2("bottom");};