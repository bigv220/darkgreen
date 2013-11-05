
if (!Array.prototype.push) {
    Array.prototype.push = function() {
        var startLength = this.length;
        for (var i = 0; i < arguments.length; i++)
            this[startLength + i] = arguments[i];
        return this.length;
    }
}

$Obj = function() 
{
    var elements = new Array();
    
    for (var i = 0; i < arguments.length; i++) {
        var element = arguments[i];
        if (typeof element == 'string')
            element = document.getElementById(element);
        
        if (arguments.length == 1)
            return element;
        
        elements.push(element);
    }
    
    return elements;
}

///////////////////////////////////////////
/*
  demo 字幕区域标签(div)的ID; 
  demo1/demo2 显示内容标签(div或td)的ID demo1为原始内容,demo2是它的拷贝; 
  direction 字幕方向(up,down,left,right) ; 
  delay 字幕播放的延迟时间(毫秒); 
  step 字幕播放的步长(即pix,步长越小,如step=1,滚动越平滑) 
*/
function Marquee(demo, demo1, demo2, direction, delay, step) 
{
    direction = direction.toLowerCase();
    
    if (((direction == "up" || direction == "down") && ($Obj(demo1).offsetHeight > $Obj(demo).offsetHeight)) || 
        ((direction == "left" || direction == "right") && ($Obj(demo1).offsetWidth > $Obj(demo).offsetWidth))) {
        $Obj(demo2).innerHTML = $Obj(demo1).innerHTML;
    } else {
        return;
    }

    var flag = true;
    var speed = delay == null ? 10 : parseInt(delay);
    var amount = step == null ? 1 : parseInt(step);

    var Marquee = function() {
        switch (direction) {
            case "up":
                if ($Obj(demo2).offsetTop - $Obj(demo).scrollTop <= 0) {
                    $Obj(demo).scrollTop -= $Obj(demo1).offsetHeight;
                } else {
                    $Obj(demo).scrollTop += amount;
                }
                break;
            case "left":
                if ($Obj(demo2).offsetWidth - $Obj(demo).scrollLeft <= 0) {
                    $Obj(demo).scrollLeft -= $Obj(demo1).offsetWidth;
                }  else {
                    $Obj(demo).scrollLeft += amount;
                }
                break;
            default:
                break;
        }
    }
    
    var timer = setInterval(Marquee, speed);
    $Obj(demo).onmouseover = function() {
        if (flag) {
            clearInterval(timer);
        }
    }
    
    $Obj(demo).onmouseout = function() {
        if (flag) {
            timer = setInterval(Marquee, speed);
        }
    }
}