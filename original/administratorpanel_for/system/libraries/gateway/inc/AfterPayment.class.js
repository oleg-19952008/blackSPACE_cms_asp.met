var AfterPayment = {

    execPostSuccessVoucherButton: function(req) {

        //Schaun ob Div existiert und dann leeren bzw. Gutschein-Button setzen
        if ($('voucherButtonDiv')) {

            $('voucherButtonDiv').innerHTML = "";
            $('voucherButtonDiv').setStyle('padding', "0px");

            //Button soll angezeigt werden?
            if (req['showVoucherButton']) {
                var elem = new Element('div',{
                    'id':'voucherButton',
                    'html':Payment.lang.get('voucherButtonText')
                });
                elem.onclick = function() {
                    Payment.showAdditionalOverlay('voucher');
                }
                $('voucherButtonDiv').adopt(elem);
            }
        }

        //Schauen ob Paymentmethoden eingschränkt sind, diese dann auflösen
        if (Payment.restrictedAccounts.length > 0 || Payment.allowedAccounts.length > 0) {
            Payment.restrictedAccounts = [];
            Payment.allowedAccount = [];

            if (Payment.methodOpen === true) {
                Payment.checkPayments();
                Payment.checkFastPay();
            }
            Payment.showVoucherSmsPhone();

            //check secure methods activated
            if (Payment.onlySecureMethods === true) {
                HandlePayment.secureMethodCallBack(false);
            }
        }

    },

    execPostSuccessTrackingPixel: function (req) {
        if ($('trackingPixelDiv')) {
            var elem = new Element('div',{
                    'id':'trackingPixelIframe',
                    'html':req['trackingPixelIframe']
                });
            $('trackingPixelDiv').adopt(elem);
        }
    },

    execPostSuccessProgressbar: function (req) {
        Payment.updateStep(req['step'] + 0);
    }

}