var speed = 20;
var direction="top";
var tab = document.getElementById("scrollbox");
var tab1 = document.getElementById("scrollpic");
var tab2 = document.getElementById("scrollpic-copy");
var leftDir = document.getElementById("leftDir");
var rightDir = document.getElementById("rightDir");
tab2.innerHTML = tab1.innerHTML;
function marquee(){
    switch(direction){
        case "top":
            if(tab2.offsetHeight - tab.scrollTop <= 0){
                tab.scrollTop -= tab1.offsetHeight;
            }
            else{
                tab.scrollTop++;
            }
        break;
        case "bottom":
            if(tab.scrollTop <= 0){
                tab.scrollTop += tab2.offsetHeight;
            }
            else{
                tab.scrollTop--;
            }
        break;
    }
}
function changeDirection(dir){
   direction = dir;
}
var timer = setInterval(marquee,speed);
tab.onmouseover = function(){
	
	clearInterval(timer);};
tab.onmouseout = function(){timer = setInterval(marquee,speed);};

leftDir.onclick = function(){changeDirection("top");};
rightDir.onclick = function(){changeDirection("bottom");};
