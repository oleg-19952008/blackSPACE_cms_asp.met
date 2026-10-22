var Util = {
    fade: function(element, from, to, time, aFinish) {
        var elem = $(element);
        elem.set('morph', {duration: time});
        if(typeof(aFinish) !== 'undefined') {
            elem.get('morph').removeEvents('complete');
            elem.set('morph', {onComplete: aFinish});
        }
        elem.morph({opacity:[from,to]});
    },
    
    fadeIn: function(element, from, to, time, afterFinish) {
        $(element).setStyle('display', 'block');
        Util.fade(element, from, to, time, function(){
            if(typeof(afterFinish) !== 'undefined') afterFinish();
            $$('input.focus').each(function(element)  {
                HandlePayment.setFocusToField(element.id);        
            });
        });
    },
    
    fadeOut: function(element, from, to, time, afterFinish) {
        Util.fade(element, from, to, time, function() {
            $(element).setStyle('display', 'none');
            if(typeof(afterFinish) !== 'undefined') afterFinish();
        });
    },
    
    apiRequest: function(action, params, callback) {
        return new Request.JSON({
            url:"api/api.php?"+getSession(),
            onComplete:callback
        }).get({'jsonVersion': 2, 'json': {'action': action, 'args': {'req': params } }});
    },
    
    moduleApiRequest: function(module, action, data, callback) {
        return new Request.JSON({
            url:"api/api.php?"+getSession(),
            onComplete: callback
        }).get({'jsonVersion': 2, 'json': {'action': 'gameapi.jsonPaymentInfo', 'args': {'req': {'module': module, 'action': action, 'data': data} } }});
    },
    
    parseFloat: function(num) {
        if(typeof(num) === 'number') return parseFloat(num);
        var ret=(num.replace(/[^\d\.,]+/,'').replace(/,/,'.'));
        return parseFloat(ret);
    },
    
    trim: function(str) {
        return str.replace(/^\s+|\s+$/, '');
    },
    
    /* Returns an Array of inner window measurements, browser independent */
    getWindowSize: function() {
        var width = 0, height = 0;
        if(typeof(window.innerWidth) == 'number') {
            width = window.innerWidth;
            height = window.innerHeight;
        } else if ( document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight) ) {
            width = document.documentElement.clientWidth;
            height = document.documentElement.clientHeight;
        } else if( document.body && (document.body.clientWidth || document.body.clientHeight) ) {
            width = document.body.clientWidth;
            height = document.body.clientHeight;
        }
        return [width, height];
    },
    
    getBetterWindowSize: function() {
        var width = 0, height = 0, scrollX = 0, scrollY = 0, x1 = 0, y1 = 0;
        
        if (typeof(window.innerWidth) == 'number') {
            width = window.innerWidth+window.pageXOffset;
            height = window.innerHeight+window.pageYOffset;
            scrollX = window.pageXOffset;
            scrollY = window.pageYOffset;
        } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
            width = document.documentElement.clientWidth+document.documentElement.scrollLeft;
            height = document.documentElement.clientHeight+document.documentElement.scrollTop;
            scrollX = document.documentElement.scrollLeft;
            scrollY = document.documentElement.scrollTop;
        } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
            width = document.body.clientWidth+document.body.scrollLeft;
            height = document.body.clientHeight+document.body.scrollTop;
            scrollX = document.body.scrollLeft;
            scrollY = document.body.scrollTop;
        } else if (document.getElementById) {
            width = window.innerWidth+window.pageXOffset;
            height = window.innerHeight+window.pageYOffset;
            scrollX = window.pageXOffset;
            scrollY = window.pageYOffset;
        }
        
        if (
            navigator.userAgent.indexOf("Opera") != -1
            || navigator.userAgent.indexOf("opera") != -1
        ) {
            x1 = Math.max(
                width,
                document.documentElement.scrollWidth
            );
            
            y1 = Math.max(
                height,
                document.documentElement.scrollHeight
            );
        } else {
            x1 = Math.max(
                document.documentElement.scrollWidth,
                document.documentElement.offsetWidth,
                document.body.scrollWidth,
                document.body.offsetWidth
            );
            
            y1 = Math.max(
                document.documentElement.scrollHeight,
                document.documentElement.offsetHeight,
                document.body.scrollHeight,
                document.body.offsetHeight
            );
        }
        
        return [width, height, scrollX, scrollY, x1, y1];
    },
    
    MovingText:function(elem, width, frame) {
        var self = this;
        this.elem = $(elem);
        this.movement = '-'+ (width - frame) +'+px';
        this.start = function(direction) {
            
            setTimeout(
                function() {
                    self.elem.get('morph').removeEvents('complete');
                    self.elem.set('morph', {duration: 2000, onComplete: function() {self.start(direction*-1)}});
                    if(direction == -1) {
                        self.elem.morph({marginLeft: self.movement});
                    } else {
                        self.elem.morph({marginLeft:'0px'});
                    }
                }, 500
            );
        }
        
        this.start(-1);
    },
    
    addMovingText: function(checkelem, elem, divName) {
        var testDiv = $(elem).clone();
        testDiv.id = $(elem).id + "_test";
        testDiv.set('class', $(checkelem).get('class'));
        testDiv.set("style", testDiv.get("style")+";width:auto!important;overflow:visible;visibility:hidden;float:left;");
        
        if (divName) {
            $(divName).adopt(testDiv);
        } else {
            $('bodyCenter').adopt(testDiv);
        }
        
        if(testDiv.offsetWidth > $(checkelem).getStyle('width').toInt() + 1) {
            new Util.MovingText(elem, testDiv.offsetWidth, $(checkelem).getStyle('width').toInt());
        }
        
        $(testDiv).dispose();
    }
}
