/**
 * Created by JetBrains PhpStorm.
 * User: vfayos
 * Date: 11.06.12
 * Time: 12:03
 * To change this template use File | Settings | File Templates.
 */

/**
 * JavaScript for open social version of darkorbit.
 * /tpl/opensocial.tpl
 *
 */

var internalPartnerPromotion = {

    //Key mapping
    LOTTERY_PARTNER: "Lottery_Partner",
    LOTTERY_ITEMS: "Lottery_Items",

    library:null,

    remainCapsules:null,
    ticketsLotteryPartner:null,
    ticketsLotteryItems:null,
    countryForbidden:null,
    converterValues:[1,5,10,100,0],    //maximum the user has: "remainCapsules"


    Initialize:function (remainCapsules, ticketsLotteryPartner, ticketsLotteryItems, countryForbidden, aKeys, callBack) {

        // Get new library object for storing elements
        this.library = new Storage();

        this.remainCapsules = remainCapsules;
        this.ticketsLotteryPartner = ticketsLotteryPartner;
        this.ticketsLotteryItems = ticketsLotteryItems;
        this.countryForbidden = countryForbidden;
        this.aKeys = aKeys;

        this.fetchElements();
        this.initializeEventListeners();

        this.checkDialogCallBack(callBack);


    },

    fetchElements:function () {

        var btnSunConverter         = jQuery('#btnSunConverter'),
            btnMoonConverter        = jQuery('#btnMoonConverver'),
            btnPayment              = jQuery('#btnPayment'),
            moonSelector            = jQuery('#moonSelector'),
            sunSelector             = jQuery('#sunSelector'),
            amountMoonConverter     = jQuery('.setAmountMoonConverter'),
            html                    = jQuery('html'),
            amountSunConverter          = jQuery('.setAmountSunConverter'),
            moonSelectorConverter      = jQuery('#moonSelectorConverter'),
            sunSelectorConverter      = jQuery('#sunSelectorConverter'),
            closePrizeLayer           = jQuery('#closePrizeLayer'),
            btnPrizeLayer           = jQuery('#btnPrizeLayer');



        this.library.set('btnSunConverter', btnSunConverter);
        this.library.set('btnMoonConverter', btnMoonConverter);
        this.library.set('btnPayment', btnPayment);
        this.library.set('moonSelector', moonSelector);
        this.library.set('sunSelector', sunSelector);
        this.library.set('amountMoonConverter', amountMoonConverter);
        this.library.set('amountSunConverter', amountSunConverter);
        this.library.set('moonSelectorConverter', moonSelectorConverter);
        this.library.set('sunSelectorConverter', sunSelectorConverter);
        this.library.set('btnPrizeLayer', btnPrizeLayer);
        this.library.set('closePrizeLayer', closePrizeLayer);
        this.library.set('html', html);
    },

    checkDialogCallBack: function($c){

        switch($c){
            case internalPartnerPromotion.LOTTERY_ITEMS:
                Tools.Popup.Presets.showSuccessDialog(internalPartnerPromotion.aKeys.popupMoonConverterText);
            break;
            case internalPartnerPromotion.LOTTERY_PARTNER:
                Tools.Popup.Presets.showSuccessDialog(internalPartnerPromotion.aKeys.popupSunConverterText);
            break;
        }

    },

    initializeEventListeners:function () {

        var btnMoonConverter = this.library.get('btnMoonConverter');
        var btnSunConverter = this.library.get('btnSunConverter');
        var btnPayment = this.library.get('btnPayment');
        var sunSelector = this.library.get('sunSelector');
        var amountSunConverter = this.library.get('amountSunConverter');
        var moonSelector = this.library.get('moonSelector');
        var amountMoonConverter = this.library.get('amountMoonConverter');
        var moonSelectorConverter = this.library.get('moonSelectorConverter');
        var sunSelectorConverter = this.library.get('sunSelectorConverter');
        var btnPrizeLayer = this.library.get('btnPrizeLayer');
        var closePrizeLayer = this.library.get('closePrizeLayer');
        var html = this.library.get('html');

        /** button payment button */
        Tools.addDefaultMouseEventBehaviour(btnPayment);

        /** button payment button */
        Tools.addDefaultMouseEventBehaviour(closePrizeLayer);
        closePrizeLayer.live("click",
            this.Events.onBtnClosePrizeLayer);

        /** prize layer button */
        Tools.addDefaultMouseEventBehaviour(btnPrizeLayer);
        btnPrizeLayer.live("click",
            this.Events.onBtnPrizeLayer);


        /** moon select button */
        Tools.addDefaultMouseEventBehaviour(moonSelector);
        moonSelector.live('click',
            this.Events.onMoonSelector);

        /** select amount in moon list */
        Tools.addDefaultMouseEventBehaviour(amountMoonConverter);
        amountMoonConverter.live('click',
            this.Events.onAmountMoonConverter);

        /** sun select button */
        Tools.addDefaultMouseEventBehaviour(sunSelector);
        sunSelector.live('click',
            this.Events.onSunSelector);

        /** select amount in sun list */
        Tools.addDefaultMouseEventBehaviour(amountSunConverter);
        amountSunConverter.live('click',
            this.Events.onAmountSunConverter);

        /** button to convert capsules in moon converter */
        Tools.addDefaultMouseEventBehaviour(moonSelectorConverter);
        moonSelectorConverter.live('click',
            this.Events.onBtnMoonConverter);

        /** button to convert capsules in sun converter */
        Tools.addDefaultMouseEventBehaviour(sunSelectorConverter);
        sunSelectorConverter.live('click',
            this.Events.onBtnSunConverter);

        /** document events **/
        html.live('click',
            this.Events.onDocument);

    },

    Events:{

        /**
         *
         *
         */
        onDocument : function (event){
            jQuery("#amountMoonSelectorList").css("visibility","hidden");
            jQuery("#amountSunSelectorList").css("visibility","hidden");
        },

        /**
         * on Moon converted click
         */
        onBtnMoonConverter : function (event) {

            //check if the button its disabled.
            if(internalPartnerPromotion.remainCapsules > 0){
                jQuery('#form_Lottery_Items').submit();
                //window.location.href = "indexInternal.es?action=internalPaymentPartnerPromotion&subAction=" + internalPartnerPromotion.LOTTERY_ITEMS + "&quantity=" + jQuery("#moonSelector").text();
            } else {

                if (internalPartnerPromotion.remainCapsules == 0){

                    // Open popup
                    var popupContent = internalPartnerPromotion.aKeys.popupNoCapsules;
                    Tools.Popup.Presets.showErrorDialog(popupContent, "Ok");
                }

            }
        },

        /**
         * on Sun converted click
         */
        onBtnSunConverter:function (event) {

            //check if the button its disabled.
            if (internalPartnerPromotion.remainCapsules > 0 && internalPartnerPromotion.countryForbidden == 0) {
                jQuery('#form_Lottery_Partner').submit();
                //window.location.href = "indexInternal.es?action=internalPaymentPartnerPromotion&subAction=" + internalPartnerPromotion.LOTTERY_PARTNER + "&quantity=" + jQuery("#sunSelector").text();
            } else {

                if (internalPartnerPromotion.remainCapsules == 0) {

                    // Open popup
                    var popupContent = internalPartnerPromotion.aKeys.popupNoCapsules;
                    Tools.Popup.Presets.showErrorDialog(popupContent, "Ok");
                } else {
                    if (internalPartnerPromotion.countryForbidden == 1) {

                        var popupContent = internalPartnerPromotion.aKeys.popupCountryNoAllowed;
                        Tools.Popup.Presets.showErrorDialog(popupContent, "Ok");
                    }
                }
            }
        },

        /**
         * Set visible the moon selector list
         *
         */
        onMoonSelector:function (event) {


            if (internalPartnerPromotion.remainCapsules > 0) {

                if (jQuery("#amountMoonSelectorList").css("visibility") == "visible") {
                    jQuery("#amountMoonSelectorList").css("visibility", "hidden");
                } else {
                    jQuery("#amountMoonSelectorList").css("visibility", "visible");
                }

                if (jQuery("#amountSunSelectorList").css("visibility") == "visible") {
                    jQuery("#amountSunSelectorList").css("visibility", "hidden");
                }

                event.stopPropagation();

            } else {

                if (internalPartnerPromotion.remainCapsules == 0){

                    // Open popup
                    var popupContent = internalPartnerPromotion.aKeys.popupNoCapsules;
                    Tools.Popup.Presets.showErrorDialog(popupContent, "Hi");
                }



            }



        },


        /**
         * Set visible the sun selector list
         *
         */
        onSunSelector:function (event) {


            if (internalPartnerPromotion.remainCapsules > 0 && internalPartnerPromotion.countryForbidden == 0) {

                if (jQuery("#amountSunSelectorList").css("visibility") == "visible") {
                    jQuery("#amountSunSelectorList").css("visibility", "hidden");
                } else {
                    jQuery("#amountSunSelectorList").css("visibility", "visible");
                }

                if (jQuery("#amountMoonSelectorList").css("visibility") == "visible") {
                    jQuery("#amountMoonSelectorList").css("visibility", "hidden");
                }


                event.stopPropagation();
            } else {

                if (internalPartnerPromotion.remainCapsules == 0) {

                    // Open popup
                    var popupContent = internalPartnerPromotion.aKeys.popupNoCapsules;
                    Tools.Popup.Presets.showErrorDialog(popupContent, "Ok");
                } else {
                    if (internalPartnerPromotion.countryForbidden == 1) {

                        var popupContent = internalPartnerPromotion.aKeys.popupCountryNoAllowed;
                        Tools.Popup.Presets.showErrorDialog(popupContent, "Ok");
                    }
                }
            }



        },

        /**
         *
         * Set value in custom select moon converter
         * @param event
         */
        onAmountMoonConverter : function(event){


            jQuery("#moonSelector").text(event.currentTarget.innerHTML);
            jQuery("#capsule_quantity_items").attr('value', event.currentTarget.innerHTML);


            if (event.currentTarget.rel == "last"){
                jQuery("#moonSelector").text(internalPartnerPromotion.remainCapsules);
                jQuery("#capsule_quantity_items").attr('value', internalPartnerPromotion.remainCapsules);
            }
            jQuery("#amountMoonSelectorList").css("visibility","hidden");


        },

        /**
         *
         * Set value in custom select for sun converter
         * @param event
         */
        onAmountSunConverter : function(event){

            jQuery("#sunSelector").text(event.currentTarget.innerHTML);
            jQuery("#capsule_quantity_partner").attr('value', event.currentTarget.innerHTML);

            if (event.currentTarget.rel == "last"){
                jQuery("#sunSelector").text(internalPartnerPromotion.remainCapsules);
                jQuery("#capsule_quantity_partner").attr('value', internalPartnerPromotion.remainCapsules);
            }
            jQuery("#amountSunSelectorList").css("visibility","hidden");


        },

        /**
         *
         * action for showing the custom layer
         */

        onBtnPrizeLayer : function (event) {

            var objectToAlign       = ('undefined' === typeof objectToAlign) ? jQuery("#prizeTemplateLayer") : objectToAlign,
                bodyOffsetWidth     = document.documentElement.offsetWidth,
                objectWidth         = objectToAlign.width(),
            // Take the banner (and it's margin) on the right hand side into account
                widthWithBanner     = objectWidth,
                objectLeft          = (bodyOffsetWidth / 2) - (widthWithBanner / 2),
                bodyOffsetHeight    = document.documentElement.offsetHeight,
                objectHeight        = objectToAlign.height(),
                objectTop           = (bodyOffsetHeight / 2) - (objectHeight / 2);

            jQuery("#prizeTemplateLayer").css({
                "top": 0 + "px"
            });


              Tools.Popup.showModalLayer();

            jQuery('#prizeTemplateLayer').fadeIn(500);




        },

        onBtnClosePrizeLayer: function(event){
            jQuery('#prizeTemplateLayer').fadeOut(500);
            Tools.Popup.hideModalLayer();
        }
    }

}

