
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
  demo ��Ļ�����ǩ(div)��ID; 
  demo1/demo2 ��ʾ���ݱ�ǩ(div��td)��ID demo1Ϊԭʼ����,demo2�����Ŀ���; 
  direction ��Ļ����(up,down,left,right) ; 
  delay ��Ļ���ŵ��ӳ�ʱ��(����); 
  step ��Ļ���ŵĲ���(��pix,����ԽС,��step=1,����Խƽ��) 
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