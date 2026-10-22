function SmallToolTipper(element, tip, functionparameter){
    var self = this;
    this.elem = $(element);

    this.text = tip;

    this.shown = false;

    this.mouse = {};

    this.handleMouseMove = function(e, mouse){
        $('toolTipLayer').style.width = '';
        $('toolTipLayer').style.left = (mouse.x + 16) + 'px';
        $('toolTipLayer').style.top = (mouse.y + 16) + 'px';
        $('toolTipLayer').innerHTML = self.text;
        $('toolTipLayer').style.display = 'block';
    }

    this.hide = function(){
        $('toolTipLayer').style.display = 'none';
    }

    this.elem.onmousemove = function(e){
        e = e || window.event;
        var mouse = {};
        if (e.pageX || e.pageY) {
            mouse.x = e.pageX;
            mouse.y = e.pageY;
        } else {
            mouse.x = e.clientX + document.body.scrollLeft - document.body.clientLeft;
            mouse.y = e.clientY + document.body.scrollTop - document.body.clientTop;
        }

        if(mouse.x != self.mouse.oldX || mouse.y != self.mouse.oldY) {
            clearTimeout(tooltiptimer);
            tooltiptimer = null;
            self.mouse.oldX = mouse.x;
            self.mouse.oldY = mouse.y;
            self.handleMouseMove(e, mouse);
        }
    }

    this.elem.onmouseout = function(){
        if (tooltiptimer === null) {
            tooltiptimer = setTimeout(function(){
                if (!isNotooltiphide()) {
                    self.hide()
                }
            }, 50);
        }

    }
}
var tooltiptimer = null;


function ToolTipper(element, tip, functionparameter){
    var self = this;
    this.elem = $(element);
    this.text = '';
    this.getFunction = '';
    this.functionParameter = '';
    if (typeof(tip) == 'function') {
        this.getFunction = tip;
        this.functionParameter = functionparameter;
    } else {
        this.text = tip;
    }

    this.shown = false;

    this.out = false;

    this.timer = null;

    this.mouse = {};

    this.handleMouseMove = function(e, mouse){
        self.mouse = mouse;
        if (self.text.length==0 && self.getFunction) {
            var method = self.getFunction;
            self.text = ' ';
            method(self.functionParameter, self.setText);

            //self.elem.onmousemove(e);
        }

        if(this.text.length > 1) {
            this.setText(self.text);
        }
    }

    this.setText = function(text) {
       self.text = text;

       if (self.out == false) {
            $('toolTipLayer').innerHTML = self.text;

            if (self.text.indexOf("<!-- overlay info box width -->") >= 0) {
                $('toolTipLayer').style.width = '500px';
            } else {
                $('toolTipLayer').style.width = '400px';
            }

            $('toolTipLayer').style.display = 'block';

            calculateToolTipPosition(
                self.mouse.x, self.mouse.y, Payment.windowSize[0],
                Payment.windowSize[1], $('toolTipLayer').offsetWidth,
                $('toolTipLayer').offsetHeight
            );
        } else {
            //alert('ggfdg');
            self.hide();
        }
    }

    this.hide = function(){
        $('toolTipLayer').style.display = 'none';
    }

    this.elem.onmousemove = function(e){
        self.out = false;
        e = e || window.event;
        var mouse = {};

        if (e.pageX || e.pageY) {
            mouse.x = e.pageX;
            mouse.y = e.pageY;
        } else {
            mouse.x = e.clientX + document.body.scrollLeft - document.body.clientLeft;
            mouse.y = e.clientY + document.body.scrollTop - document.body.clientTop;
        }

        if(mouse.x != self.mouse.oldX || mouse.y != self.mouse.oldY) {
            clearTimeout(tooltiptimer);
            tooltiptimer = null;
            mouse.oldX = mouse.x ;
            mouse.oldY = mouse.y;
            self.handleMouseMove(e, mouse);
        }
    }

    this.elem.onmouseout = function(){
        self.out = true;
        if (tooltiptimer === null) {
            tooltiptimer = setTimeout(function(){
                if (!isNotooltiphide()) {
                    self.hide();
                }
            }, 50);
        }

    }
}

function calculateToolTipPosition(mouseX, mouseY, windowW, windowH, layerW, layerH) {
    //calculate style left
    if ((mouseX + layerW + 16) > windowW) {
     var offsetX = (mouseX + layerW + 16) - windowW;
        $('toolTipLayer').style.left = ((mouseX - offsetX) + 16) + 'px';
    } else {
        $('toolTipLayer').style.left = (mouseX + 16) + 'px';
    }

    //calculate style top
    if ((mouseY + layerH + 5) > windowH) {
        if (offsetX > 0) {
            $('toolTipLayer').style.top = ((mouseY - layerH) - 5) + 'px';
        } else {
            var offsetY = (mouseY + layerH + 5) - windowH;
            $('toolTipLayer').style.top = ((mouseY - offsetY) + 5) + 'px';
        }
    } else {
        $('toolTipLayer').style.top = (mouseY + 5) + 'px';
    }
}

var tooltiptimer = null;
