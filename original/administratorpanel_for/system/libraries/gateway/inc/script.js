
function messageWindow(title, msg)
{
  var width="300", height="125";
  var left = (screen.width/2) - width/2;
  var top = (screen.height/2) - height/2;
  var styleStr = 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbar=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+',top='+top+',screenX='+left+',screenY='+top;
  var msgWindow = window.open("","msgWindow", styleStr);
  var head = '<head><title>'+title+'</title></head>';
  var body = '<center>'+msg+'<br><p><form><input type="button" value="   Done   " onClick="self.close()"></form>';
  msgWindow.document.write(head + body);
}

function submitForm(Id){
	formId = document.getElementById(Id);
	formId.submit();
	//alert(formId);
}

/**
 * @param projectID     ProjectID
 * @param type          Type of overlay content
 * @param price         Price (optional)
 * @param currency      Currency (optional)
 * @param forwardable   true: forward and close button; false: just close button
 * @param interval      interval of subscription
**/
function getOverlayInfo(projectID, type, price, currency, forwardable, interval, intervalType, itemID, callback) {

    Tracking.loadItemDescription(type);

    var elementAdd = '';
    returnResult = (typeof(callback) == 'function');

    //if (type.substr(0,7) == 'premium') {
    //    elementAdd = '_premium';
    //}

    //if (type == 'premium' || type == 'premiumbasic' || type == 'premiumbronze' || type == 'premiumsilver' || type == 'premiumgold') {
    if (type == 'premium'
        || type.indexOf('premiumbasic')!=-1
        || type.indexOf('premiumbronze')!=-1
        || type.indexOf('premiumsilver')!=-1
        || type.indexOf('premiumgold')!=-1
    ) {
        elementAdd = '_premium';
    }

    if (!returnResult) {
        if ($('overlay_info_button_close'+elementAdd)) {document.getElementById('overlay_info_button_close'+elementAdd ).style.display = 'none';}
        if ($('overlay_info_button_forward1'+elementAdd)) {document.getElementById('overlay_info_button_forward1'+elementAdd ).style.display = 'none';}
        if ($('overlay_info_button_forward2'+elementAdd)) {document.getElementById('overlay_info_button_forward2'+elementAdd ).style.display = 'none';}
        if ($('overlay_info_button_close'+elementAdd)) {document.getElementById('overlay_info_button_close'+elementAdd ).style.display = (forwardable) ? 'none' : 'inline';    }
        if ($('overlay_info_button_forward1'+elementAdd)) {document.getElementById('overlay_info_button_forward1'+elementAdd ).style.display = (!forwardable) ? 'none' : 'inline';    }
        if ($('overlay_info_button_forward2'+elementAdd)) {document.getElementById('overlay_info_button_forward2'+elementAdd ).style.display = (!forwardable) ? 'none' : 'inline';     }
        if ($('overlay_info'+elementAdd)) {
            document.getElementById('overlay_info'+elementAdd ).style.display = 'inline';
            var windowHeight = Util.getWindowSize();
            $('overlay_info'+elementAdd).style.left = windowHeight[0]/2 - $('overlay_info'+elementAdd).offsetWidth/2 +'px';
            try {
                $('overlay_info'+elementAdd).style.top = windowHeight[1]/2 - $('overlay_info'+elementAdd).offsetHeight/2 +'px';
            } catch (err) {

            }
        }
        if ($('overlay_info_content_box'+elementAdd)) {document.getElementById('overlay_info_content_box'+elementAdd ).innerHTML = '<div style="text-align: center;"><strong>Please wait...</strong></div>';}
    }

    var result = new Object();
    /*
    var request = new Json.Remote("api/api.php?"+getSession(), {onComplete: function(jsonObj){
            var result = new Object();
            if (jsonObj.result == 'OK') {
                delete jsonObj.result;

                for (i in jsonObj) {
                    result[i] = jsonObj[i];
                }
            }
            document.getElementById('overlay_info_content_box'+elementAdd ).innerHTML = result['overlay_info_content_box'];
            return result;
        }

    }).send({'action': 'gameapi.jsonoverlayInfo', 'args': {'req': {'projectID': projectID, 'type': type, 'price': price, 'currency': currency, 'lang': ''+getLanguage(), 'interval': interval, 'intervalType': intervalType, 'itemID': itemID} } });
    */

    var request = new Request.JSON({url: "api/api.php?"+getSession(), onComplete: function(jsonObj){
            var result = new Object();
            if (jsonObj.result == 'OK') {
                delete jsonObj.result;

                for (i in jsonObj) {
                    result[i] = jsonObj[i];
                }
            }
            if (returnResult) {
                callback(result['overlay_info_content_box']);
            } else {
                document.getElementById('overlay_info_content_box'+elementAdd ).innerHTML = result['overlay_info_content_box'];
            }
            return result;
        }

    }).get({'jsonVersion': 2, 'json': {'action': 'gameapi.jsonoverlayInfo', 'args': {'req': {'projectID': projectID, 'type': type, 'price': price, 'currency': currency, 'lang': ''+getLanguage(), 'interval': interval, 'intervalType': intervalType, 'itemID': itemID} } }});

}

function getOverlayInfoForToolTipper(item, callback)
{
    getOverlayInfo(
        item.projectID,
        item.type  + item.premiumType,
        item.price,
        item.currency,
        false,
        item.interval,
        item.intervalType,
        item.id,
        callback
    );
}

function getPaymentInfo(module, action, data, callback) {

    var result = new Object();
    /*
    var request = new Json.Remote("api/api.php?"+getSession(), {onComplete: function(jsonObj){
            var result = new Object();
            if (jsonObj.result == 'OK') {
                delete jsonObj.result;

                for (i in jsonObj.res) {
                    result[i] = jsonObj.res[i];
                }
            }
            callback(result);
            return;
        }

    }).send({'action': 'gameapi.jsonPaymentInfo', 'args': {'req': {'module': module, 'action': action, 'data': data} } });
    */
    var request = new Request.JSON({url: "api/api.php?"+getSession(), onComplete: function(jsonObj){
            var result = new Object();

            if (jsonObj.result == 'OK') {
                delete jsonObj.result;

                for (i in jsonObj.res) {
                    result[i] = jsonObj.res[i];
                }
            }
            callback(result);
            return;
        }

    }).get({'jsonVersion': 2, 'json': {'action': 'gameapi.jsonPaymentInfo', 'args': {'req': {'module': module, 'action': action, 'data': data} } }});

}

function setCloseSubscriptionExpireInfo(forever, callback) {

    var result = new Object();
    /*
    var request = new Json.Remote("api/api.php?"+getSession(), {onComplete: function(jsonObj){
            var result = new Object();
            if (jsonObj.result == 'OK') {
                delete jsonObj.result;
                try{
                for (i in jsonObj.res) {
                    result[i] = jsonObj.res[i];
                }
                } catch (e) {}
            }
            //callback(result);
            return;
        }

    }).send({'action': 'gameapi.jsonCloseSubscriptionExpireInfo', 'args': {'req': {'close': 1, 'forever': forever} } });
    */
    var request = new Request.JSON({url: "api/api.php?"+getSession(), onComplete: function(jsonObj){
            var result = new Object();
            if (jsonObj.result == 'OK') {
                delete jsonObj.result;
                try{
                for (i in jsonObj.res) {
                    result[i] = jsonObj.res[i];
                }
                } catch (e) {}
            }
            //callback(result);
            return;
        }

    }).get({'jsonVersion': 2, 'json': {'action': 'gameapi.jsonCloseSubscriptionExpireInfo', 'args': {'req': {'close': 1, 'forever': forever} } }});

}

function setCloseMinorUserInfo(forever, callback) {

    var result = new Object();
    var request = new Request.JSON({url: "api/api.php?"+getSession(), onComplete: function(jsonObj){
            var result = new Object();
            if (jsonObj.result == 'OK') {
                delete jsonObj.result;
                try{
                for (i in jsonObj.res) {
                    result[i] = jsonObj.res[i];
                }
                } catch (e) {}
            }
            //callback(result);
            return;
        }

    }).get({'jsonVersion': 2, 'json': {'action': 'gameapi.jsonCloseMinorUserInfo', 'args': {'req': {'close': 1, 'forever': forever} } }});

}

function getErrorMessageOverlay(message, element) {

    var result = new Object();
    var request = new Request.JSON({url: "api/api.php?"+getSession(), onComplete: function(jsonObj){
            var result = new Object();
            if (jsonObj.result == 'OK') {
                delete jsonObj.result;
                try{
                for (i in jsonObj.res) {
                    result[i] = jsonObj.res[i];
                }
                } catch (e) {}
            }
            //alert(result.html);
            element.innerHTML = result.html;
            return;
        }

    }).get({'jsonVersion': 2, 'json': {'action': 'gameapi.jsonErrorMessageOverlay', 'args': {'req': {'message': message} } }});

}


function setOverlayWait(sec)
{
    var selects = document.getElementsByTagName('select');
    for(i=0;i<selects.length;i++) {
        selects[i].style.display = 'none';
    }

    document.getElementById('overlay_wait').style.display = 'inline';
    document.getElementById('overlaybackground_wait').style.display = 'block';
    if(sec > 0) {
        setTimeout("unsetOverlayWait()",sec);
    }
}

function unsetOverlayWait()
{
    var selects = document.getElementsByTagName('select');
    for(i=0;i<selects.length;i++) {
        selects[i].style.display = 'inline';
    }
    document.getElementById('overlay_wait').style.display = 'none';
    document.getElementById('overlaybackground_wait').style.display = 'none';
}


function getSpecialZonk14Flash(baseURL, sessionName, sessionID) {
    document.write('<embed src="images/global/specials/specials_zonk_14.swf" FlashVars="baseURL='+baseURL+'&amp;'+sessionName+'='+sessionID+'" play="true" loop="true" menu="false" quality="best" width="744" height="310" name="" allowScriptAccess="sameDomain"  swLiveConnect="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
}

function preloadImages() {
    try {
        preload1 = new Image();
        preload1.src= '../images/global/attention_anim.gif';
        preload2 = new Image();
        preload2.src = '../images/global/background_darkchecker.gif';
    } catch (e) {
    }
}

// ----------------------------------------------------------------------------
//                                                                  Window Size
function getBrowserHeight() {
    return window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight);
}

function getBrowserWidth() {
    return window.innerWidth || (window.document.documentElement.clientWidth || window.document.body.clientWidth);
}

function resizeBrowserSize(embedded){
    var destWidth = 850;
    var destHeight = 640;

    if (embedded) {
        destWidth = 1300;
        destHeight = 680;
    }

    var width = getBrowserWidth();
    var height = getBrowserHeight();

    if (width < destWidth) {
        try {
            window.resizeBy(destWidth-width, 0);
            width=getBrowserWidth();
            height=getBrowserHeight();
        } catch(e) {}
    }
    if (height < destHeight) {
        try {
            var lastHeight = 0;
            while(lastHeight != height && getBrowserHeight() < destHeight) {
                lastHeight = height;
                window.resizeBy(0, 10);
                height = getBrowserHeight();
            }
        } catch(e) {}
    }
}

// ----------------------------------------------------------------------------
//                                                                 Cookie Check

function isCookieAllowed()
{
    var res = true;
    var sCheckValue = 'ccheck_'+$random(1234567,9876543);
    var c = Cookie.write('cCheck', sCheckValue);
    sResultCheck = Cookie.read('cCheck');
    if (sResultCheck != sCheckValue) {
        res = false;
    }
    Cookie.dispose('cCheck');
    return res;
}

// ----------------------------------------------------------------------------
//                                                                Support Popup
function popupopener(url) {
  var protocol = '';
  if (url.indexOf('://') == -1) {
      protocol = 'http://';
  }

  fenster = window.open(protocol + url, "Support", "width=975,height=690,status=yes,scrollbars=yes,resizable=yes");
  fenster.focus();
}



