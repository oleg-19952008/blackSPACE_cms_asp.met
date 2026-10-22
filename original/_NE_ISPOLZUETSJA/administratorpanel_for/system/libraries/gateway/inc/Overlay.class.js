function Overlay(text) {
    var self = this;
    this.text = text;

    this.getCssClass = function() {
        var overlayClass = 'smallOverlay';
        //Neu hier wird die große Templatehöhe gesetzt wenn es sich um ein Success oder ein Fail-Template handelt
        if (this.text.indexOf("<!-- overlay big template -->") >= 0) {
            overlayClass = "bigOverlay";
        } else if (this.text.indexOf("<!-- overlay middle template -->") >= 0) {
            overlayClass = "middleOverlay";
        } else if (this.text.indexOf("<!-- overlay small template -->") >= 0) {
            overlayClass = "promoOverlay";
        } else if (this.text.indexOf("<!-- overlay scriptpay additional overlay template -->") >= 0) {
            overlayClass = "scriptpayAdditionalOverlay";
        } else {
            var matches = this.text.match(/<!-- overlay template class=([a-zA-z0-9]+) -->/i);
            if (matches && matches[1]) {
                overlayClass = matches[1] + "Overlay";
            }
        }
        return overlayClass;
    }

    this.execPostJavascript = function() {
        if (this.text && this.text.indexOf("<!-- overlay debit fastpay overlay -->") >= 0) {
            new ToolTipper('overlayNotices', $('fastPayOverlayerText').value);
        }

        if (this.text && this.text.indexOf("<!-- overlay 3D Secure overlay -->") >= 0) {
            new ToolTipper('verifiedIcon', $('verifiedOverlayerText').value);
        }

        if (this.text && this.text.indexOf("<!-- overlay subscription extended info -->") >= 0) {
            new ToolTipper('recurringCancelationNote', $('recurringCancelationNoteText').value);
        }

        if (this.text && this.text.indexOf("<!-- Zeevex Iframe overlay -->") >= 0) {
            $('ZeevexForm').submit();
        }

        if (this.text && this.text.indexOf("<!-- Iframe overlay automatic submit magic-->") >= 0) {
            $('IframeForm').submit();
        }
    }

    this.execActions = function() {

        // automatic forwarding
        var matches = this.text.match(/<!-- automatic forward url=([^ ]+) timeout=([0-9]+) -->/i);
        if (matches && matches[1] && matches[2]) {
            this.execAutomaticForwarding(matches[1], matches[2]);
        }
    }

    this.execPostActions = function() {
        this.execPostJavascript();
    }

    this.execAutomaticForwarding = function(url, timeout) {
        (function(url, timout){
            window.location.href = url;
        }).delay(timeout * 1000, this, [url, timeout]);
    }

}