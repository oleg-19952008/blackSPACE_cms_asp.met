jQuery('document').ready(function(){
    jQuery('ul.clan_items').eq(0).find('li:even').addClass('even');
    jQuery('.js-scroll-pane').jScrollPane({autoReinitialise: false, showArrows: true});

    // clan details handlings

    jQuery('#clanApplicationForm').unbind('submit');
    jQuery('#clanApplicationForm').bind('submit', function(evt){
        evt.preventDefault();

        var form     = jQuery(this);
        var action   = form.attr('action');
        var postData = form.serialize();
        var language = form.find('[name=language]').val();
        var message_success = form.find('.message_success').html();
        var message_error   = form.find('.message_error').html();
        var message_afterSuccess = jQuery('#clanApplicationOk').val();

        form.find('textarea, button').attr('disabled', 'disabled');

        // var textarea = form.find('textarea');

        // cleanup default text
        // if (textarea.val() === textarea.attr('title')) {
        //     textarea.val('');
        // };

        User.set('language', language);
        Tools.ErrorHandler.Initialize();
        Tools.Popup.Initialize();

        jQuery.ajax({
            async : false,
            cache : false,
            data  : postData,
            url   : action,
            type  : 'POST',
            success : function(){
                Tools.Popup.Presets.showSuccessDialog(message_success, {
                    textIdentifier  : 'clan_popup_close'
                });
                form.find('textarea').val(message_afterSuccess);
                form.find('button').removeClass('clanSubmit');
                form.find('button').addClass('clanInactive');
            },
            error : function(){
                Tools.Popup.Presets.showErrorDialog(message_error, {
                    textIdentifier  : 'clan_popup_close'
                });
                form.find('textarea, button').removeAttr('disabled');
            }
        });
    });

    jQuery('#clanApplicationForm').fadeIn();

    // input field replacement
    jQuery('input[type="text"], textarea').each(function() {
        var inpValue = jQuery(this).val();
        var inpTitle = jQuery(this).attr('title');

        if (inpValue == '') {
            jQuery(this).val(inpTitle);
        }
    });
    jQuery('input[type="text"], textarea').focus(function() {
        if (jQuery(this).val() == jQuery(this).attr('title')) {
            jQuery(this).val('');
        }
    });
    jQuery('input[type="text"], textarea').blur(function() {
        if ('' == jQuery(this).val()) {
            jQuery(this).val(jQuery(this).attr('title'));
        }
    });


    //limit applicationText Clan to 300 characters
    jQuery("#applicationText").keyup(function(){

        if(jQuery(this).val().length > 300){
            jQuery(this).val(jQuery(this).val().substr(0, 300));
        }
    });

});