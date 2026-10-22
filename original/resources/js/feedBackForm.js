/**
 * Created by JetBrains PhpStorm.
 * User: vfayos
 * Date: 24.04.12
 * Time: 15:38
 * To change this template use File | Settings | File Templates.
 */


/**
 * JavaScript for Feedback Form.
 *
 */

var FeedBackForm = {
    library : null,

    Initialize : function () {
        // Get new library object for storing elements
        this.library = new Storage();

        this.fetchElements();
        this.initializeEventListeners();


    },

    fetchElements : function () {

        var feedbackLayer = jQuery('#feedbackLayer'),
            closeFeedback  = jQuery('#closeFeedback'),
            buttonFeedback  = jQuery('#buttonFeedback'),
            buttonPopupClose  = jQuery('#general_popup_close'),
            buttonPopupCloseButton  = jQuery('#general_popup_close_button'),
            descriptionFeedback  = jQuery('#descriptionFeedback');

        this.library.set('feedbackLayer', feedbackLayer);
        this.library.set('closeFeedback', closeFeedback);
        this.library.set('buttonFeedback', buttonFeedback);
        this.library.set('buttonPopupClose', buttonPopupClose);
        this.library.set('buttonPopupCloseButton', buttonPopupCloseButton);
        this.library.set('descriptionFeedback', descriptionFeedback);
    },

    initializeEventListeners : function () {

        var feedbackLayer = this.library.get('feedbackLayer'),
            closeFeedback  = this.library.get('closeFeedback'),
            buttonFeedback  = this.library.get('buttonFeedback'),
            buttonPopupClose  = this.library.get('buttonPopupClose'),
            buttonPopupCloseButton  = this.library.get('buttonPopupCloseButton'),
            descriptionFeedback  = this.library.get('descriptionFeedback');

        //feedbackLayer
        Tools.addDefaultMouseEventBehaviour(feedbackLayer);
        feedbackLayer.live('click',     this.Events.onFeedBackLayerClick);

        //closebutton
        Tools.addDefaultMouseEventBehaviour(closeFeedback);

        closeFeedback.live('click',     this.Events.onCloseButtonClick);

        //descriptionFeedback
        descriptionFeedback.live('keydown',    this.Events.onDescriptionKeydown);
        descriptionFeedback.live('keyup',     this.Events.onDescriptionKeyup);

        //buttonFeedback
        Tools.addDefaultMouseEventBehaviour(buttonFeedback);
        buttonFeedback.live('click',     this.Events.onButtonSendClick);

        buttonPopupClose.live('click', this.Events.onPopupCloseButtonClick);
        buttonPopupClose.live('mouseover', this.Events.onPopupCloseMouseOver);
        buttonPopupClose.live('mouseout', this.Events.onPopupCloseMouseOut);
        buttonPopupCloseButton.live('click', this.Events.onPopupCloseButtonClick);
        buttonPopupCloseButton.live('mouseover', this.Events.onPopupCloseButtonMouseOver);
        buttonPopupCloseButton.live('mouseout', this.Events.onPopupCloseButtonMouseOut);

    },

    showTooltipForSlotId : function (slotId) {
        console.log('Show tooltip for slot #' + slotId);
    },

    Events : {


        onPopupCloseMouseOver: function(){
            jQuery("#general_popup_close").css("background-position","0px -24px");
        },

        onPopupCloseMouseOut: function(){
            jQuery("#general_popup_close").css("background-position","0px -0px");
        },

        onPopupCloseButtonMouseOver: function(){
            jQuery("#general_popup_close_button").css("background-position","0px -128px");
        },

        onPopupCloseButtonMouseOut: function(){
            jQuery("#general_popup_close_button").css("background-position","0px -96px");
        },


        /**
         * on popup close cross arrow
         *
         * @param event
         */

        onPopupCloseButtonClick: function(e){

            Tools.Popup.hideModalLayer();
            jQuery("#feedbackLayer").animate({width: 'show'});
            jQuery('#generalInfoPopup').fadeOut(500);
        },
        /**
         * on description keydown
         */
        onDescriptionKeydown : function (event) {
            misc.limitTextSize(this,255);
        },

        /**
         * on description keyup
         */
        onDescriptionKeyup : function (event) {
            misc.limitTextSize(this,255);
        },


        /**
         * on Button send ckick
         */
        onButtonSendClick : function (event) {

            //if the form was answered.
            if(FeedBackForm.library.get("question1") != undefined &&
                FeedBackForm.library.get("question2") != undefined &&
                FeedBackForm.library.get("question3") != undefined){

                var aFlashVersion = flashembed.getVersion();

                var question1 = FeedBackForm.library.get("question1");
                var question2 = FeedBackForm.library.get("question2");
                var question3 = FeedBackForm.library.get("question3");
                var question4 = jQuery("#descriptionFeedback").val();
                var flashVersion = "Shockwave Flash " + aFlashVersion[0] + "r"+aFlashVersion[1];
                var appVersion = navigator.appVersion;
                var action = location.href.split('/')[3];

                //set values to 0
                jQuery("#descriptionFeedback").val("");
                jQuery("#selectorFeedBack").val("1");

                xajax_setFeedBackForm(
                    question1,
                    question2,
                    question3,
                    question4,
                    action,
                    flashVersion,
                    appVersion);
            }
        },

        /**
         * oon close button mouseover
         */
        onCloseButtonClick : function (event) {

            jQuery('#feedBackInfoBox').fadeOut(500, function() {

                Tools.Popup.hideModalLayer();
                //set values to 0
                jQuery("#descriptionFeedback").val("");
                jQuery("#selectorFeedBack").val("1");
                //show layer
                jQuery("#feedbackLayer").animate({width: 'show'});
            });

        },

        /**
         * Example call event
         */
        onFeedBackLayerClick : function (event) {

            window.focus();
            _screen_width = jQuery(window).width();
            _screen_height = jQuery(window).height();

            var _left = (_screen_width / 2) - (jQuery("#feedBackInfoBox").width() / 2);
            var _top = jQuery(document).scrollTop() + (_screen_height / 2) - (jQuery("#feedBackInfoBox").height() / 2);

            jQuery("#feedBackInfoBox").css({
                "left": _left,
                "top": "150px"
            });

            //reset the survey
            for(var j=3;j>0;j--){
                for (var i=6; i>0; i--){
                    var el = "#q-" + j + "_p-" + i;
                    jQuery(el).removeClass("feedback_star_filled");
                    jQuery(el).addClass("feedback_star_empty");
                }
            }

            FeedBackForm.library.set("question1",undefined);
            FeedBackForm.library.set("question2",undefined);
            FeedBackForm.library.set("question3",undefined);
            jQuery("#descriptionFeedback").text("");

            jQuery("#buttonFeedback").css("background-position","0px -193px");
            jQuery("#buttonFeedback").css("color","#5d5d5d");
            /* end reset the survey */


            Tools.Popup.showModalLayer();

            jQuery('#feedBackInfoBox').fadeIn(500);
            jQuery("#selectBackground").html(jQuery("#selectorFeedBack option:selected").text());

            jQuery("#feedbackLayer").delay(100).animate({width: 'hide'});

        }
    },

    /**
     *
     *
     *
     * @param event
     */

    setQuestion: function(question, star){

        //remove the filled
        for (var i=6; i>0; i--){
            var el = "#q-" + question + "_p-" + i;
            jQuery(el).removeClass("feedback_star_filled");
            jQuery(el).addClass("feedback_star_empty");
        }

        //add the current ones
        for (var i=star; i>0; i--){
            var el = "#q-" + question + "_p-" + i;
            jQuery(el).addClass("feedback_star_filled");
            jQuery(el).removeClass("feedback_star_empty");
        }

        //set new values
        if (question == 1){
            this.library.set("question1",star);
        }
        if (question == 2){
            this.library.set("question2",star);
        }
        if (question == 3){
            this.library.set("question3",star);
        }

        //enable button for send values
        if(this.library.get("question1") != undefined && this.library.get("question2") != undefined && this.library.get("question3") != undefined){
            jQuery("#buttonFeedback").css("background-position","0px 0px");
            jQuery("#buttonFeedback").css("color","#fff");

        }
    },

        /**
         *
         * function callback from xajax feedback request when the user send a message
         * the form intended from.
         *
         * center info general Popup
         *
         */
    callBackFeedBackForm: function(){

        //hide form
        jQuery('#feedBackInfoBox').fadeOut(500);

        //show layer success / error
        //TODO encapsulate javascript in api

        var _screen_width = jQuery(window).width();
        var _screen_height = jQuery(window).height();

        var _left = (_screen_width / 2) - (jQuery("#generalInfoPopup").width() / 2);
        var _top = jQuery(document).scrollTop() + (_screen_height / 2) - (jQuery("#generalInfoPopup").height() / 2);

        jQuery("#generalInfoPopup").css({

            "top": "150px",
            "z-index": 100
        });

        jQuery('#generalInfoPopup').fadeIn(500);

    }

};
