</head>
<body onLoad="" >
<!-- affiliateStartTag -->



<!.. user context info layer -->
<div id="userInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
<!-- hangar context info layer -->
<div id="hangarInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
<!-- clan info layer -->
<div id="clanInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
<!-- seitenabdecker -->



<div id="generalInfoPopup" class="fliess13px-grey">
    <div class="popup_headcontainer">
        <a id="general_popup_close" class="popup_close" href="#" ></a>
    </div>
    <div id="general_popup_question" class="question">
        <img src="do_img/global/popups/general/success_icon.png" id="general_popup_success" class="success" />
        <img src="do_img/global/popups/general/error_icon.png" id="general_popup_error" class="error" />
        <p id="general_popup_question_text">this text will be replace on xajax call</p>
    </div>
    <div class="popup_contentcontainer">
        <div class="popup_footcontainer">
            <div id="general_popup_close_button" class="popup_close_button">
                    <img src="./do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey" />
            </div>
        </div>
    </div>
</div>


<div id="busy_layer"></div>


<!-- seitenabdecker -->

<style type="text/css" media="screen">    @import "/css/cdn/includeInfoLayer.css";</style>
<script type="text/javascript">
infoText = '';
icon = '';
</script>
<script type="text/javascript" src="/js/infoLayer.js"></script>

<div id="infoLayer" class="confirmInfoLayer fliess13px-grey">
    <div class="popup_shop_headcontainer">
        <a class="popup_shop_close" href="javascript: void(0);" onclick="closeInfoLayer()"></a>
    </div>
    <div class="popup_shop_contentcontainer">
        <br>
        <div class="question"></div>
        <div class="popup_shop_footcontainer">
            <div id="infoLayerConfirm">
                <div class="popup_shop_confirm_button">
                    <div id="infoLayer_link_confirm"
                         class="popup_shop_confirm_text"
                         style="background-image: url(
                            './do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey'
                         );">
                    </div>
                </div>
                <div class="popup_shop_abort_button">
                    <div class="popup_shop_abort_text"
                         style="background-image: url(
                            './do_img/global/text_tf.esg?l=us&s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey'
                         );"
                         onclick="closeInfoLayer();">
                    </div>
                </div>
            </div>

            <div id="infoLayerInfo">
                <div class="popup_shop_close_button">
                    <div class="popup_shop_close_text"
                         style='background-image: url("./do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey");'
                         onclick="closeInfoLayer();"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
</script>
<?php require GLOBALS . 'internalHelpLayer.php'; require GLOBALS . 'internalNews.php'; ?>
<div class="backgroundImageContainer">
    <div class="overallContainer">
        
        <div class="outerContainer fliess11px-gelb">
            
                <?php require GLOBALS . 'internalHeaderIntern.php'; ?>


            <div class="bodyContainer">
                
<div class="content_frame_top">
    <div class="content_frame_top_left"></div>
    <div class="content_frame_top_right"></div>
</div>

<div class="content_frame_middle">

    <div id="domessaging">

            <div class="baseView hidden" id="folderView">
            <div class="header">
                <div class="button-checkbox" id="domsg_messages_checkboxAll">All</div>
                <div class="icon-trash" id="domsg_messages_deleteChecked"></div>

                <div id="domsg_messages_dropdown" class="button-dropdown">All</div>
                <div id="domsg_messages_dropdownLayer" class="hidden">
                </div>

                <div id="domsg_messages_pageNavigation" style="display: none">
                    <div id="domsg_messages_pageInfo"></div>

                    <div class="button-left button-left-disabled" id="domsg_messages_pageLeft"></div>
                    <div class="button-right button-right-disabled" id="domsg_messages_pageRight"></div>
                </div>

                <div class="button-biggreen" id="domsg_messages_new">New message</div>
            </div>

            <div class="gradient-top"></div>
            <div class="gradient-bottom"></div>

            <div class="entryList" id="folderViewEntrys">
            </div>
        </div>

                <div class="baseView hidden" id="messageWriteView">
            <div class="gradient-top"></div>
            <div class="gradient-bottom"></div>

            <div class="contactSearch">
                <div class="relative">
                    <input type="text" id="domsg_msgwrite_userSearch" />

                    <div class="icon-add icon-add-disabled" id="domsg_msgwrite_userSearchAddBtn"></div>

                    <div class="contactLabel">Contacts</div>
                </div>
            </div>

            <div class="contactList">
                <div id="messageWriteContacts">
                </div>

                <div class="bottom"></div>
            </div>

            <div class="recipients">
                <div class="relative">
                    <div class="label">To:</div>

                    <div id="domsg_recipientList">
                    </div>

                    <div class="help icon-info" id="domsg_msgwrite_help"></div>
                </div>
            </div>

            <div class="content">
                <div class="relative">
                    <div class="subjectLabel">Subject:</div>

                    <div class="subject"><input type="text" id="domsg_msgwrite_subject" maxlength="50" /></div>

                    <div class="body">
                        <textarea id="domsg_msgwrite_body" maxlength="5000"></textarea>

                        <div class="parent hidden" id="domsg_msgwrite_parent">
                            <div class="separator"></div>

                            <div class="dateUser" id="domsg_msgwrite_parentDateUser"></div>

                            <div class="text" id="domsg_msgwrite_parentText"></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- КАПЧА ОТКЛЮЧЕНА (закомментирован блок reCaptcha)
            <div id="reCaptcha" class="baseLayer errorLayer" style="z-index:10; display:none;">
                <div class="header">Recaptcha

                    <div id="cancelReCaptcha" class="closeCaptcha"></div>

                </div>
                <div class="content" style="width:359px;top:0;left:2px;position: relative;margin: auto">
                    <div class="text" style="text-align: left;padding: 0 18px">Please enter in the words displayed below. You are receiving this message because one or more recipients are either not from your contacts or in your clan.</div>
                    <div style="margin: 10px 0 0 18px;"><script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LfdSMgSAAAAAB447EsrEVUCOVs0_AreY_ZC2jjZ"></script>

	<noscript>
  		<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LfdSMgSAAAAAB447EsrEVUCOVs0_AreY_ZC2jjZ" height="300" width="500" frameborder="0"></iframe><br/>
  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
	</noscript></div>

                </div>
                <div class="footer" style="left: 2px;">
                    <div id="sendReCaptcha" class="button button-biggreen">OK</div>
                </div>
            </div>
            -->
            <div class="sendbar">
                <div class="button-cancel" id="domsg_msgwrite_cancelBtn">Cancel</div>
                <div id="domsg_msgwrite_txtCounter"></div>
                <div class="button-biggreen" id="domsg_msgwrite_sendMessageBtn">Send message</div>
            </div>
        </div>

                <div class="baseView hidden" id="contactsView">
            <div class="header">
                
                <div class="button-blacklist" id="domsg_contacts_blackListButton">Blacklist</div>
            </div>

            <div class="blackList hidden" id="blackListEntrys">
            </div>

            <div class="gradient-top"></div>
            <div class="gradient-bottom"></div>
            <div class="contactList" id="contactsViewEntrys">
            </div>
        </div>

                <div class="baseView hidden" id="notesView">
            <div class="header">
                <div class="button-biggreen" id="domsg_notes_new">New note</div>
            </div>

            <div class="gradient-top"></div>
            <div class="gradient-bottom"></div>

            <div class="entryList" id="notesViewEntrys">
            </div>
        </div>

        <div id="domsg_msgwrite_helpLayer" class="helpLayer hidden">
            <div class="title">Help</div>
            <div class="close-help button-close" id="domsg_msgwrite_helpLayerClose"></div>

            <div class="content">
                                    <font color="#7ecaff">Inbox</font><br /><br />
                    The inbox contains all messages that have been sent to you. Here you can read, answer or delete them. Use the dropdown menu to select the messages you would like to view. Click New Message to send a message to another player. 
<br /><br />Messages can be saved for a maximum of 14 days, after which they are automatically deleted by the system.  If you would like to save a message for more than 14 days, please save it as a note.<br /><br />
                                    <font color="#7ecaff">Create new message</font><br /><br />
                    To send another player a message, simply enter the player's nickname in the field to the upper left. If the player is on your server, you may add that player to the recipient list by using the plus button. If you have saved friends to your friend list, you can use the list to add them as a recipient. 
<br /><br />To prevent spamming, only 5 players may receive a message at the same time.  An exception to this is for clan messages, which can be sent to all clan members.<br /><br />
                                    <font color="#7ecaff">Sent messages</font><br /><br />
                    The outbox contains all the messages that you sent to other players. You may delete them here whenever you would like. If you would like to keep them, save the message as a note.<br /><br />
                                    <font color="#7ecaff">Contacts</font><br /><br />
                    In Contacts, you can save players and friends that you send frequent messages to. This saves you from having to search for them each time you would like to write them. Clan memebers are automatically added to the contact list.<br /><br />You may add as many contacts as you wish to the contact list. There are various options of doing this:<br /><br /><ol><li>View the profile page of a specific player and send them a friend request.</li>
<li>Enter the nickname in the seach field in the contact tab, and then click the plus symbol to add the player to your contact list.</li>
<li>When you click a player name, his or her pilot menu opens. Simply click the letter symbol to send the player a message.</li></ol><br /><br />
                                    <font color="#7ecaff">Notes</font><br /><br />
                    Hey you can make notes on other players or important events. Here you may also save messages that would like to retain. Messages in you inbox are automatically deleted after 14 days. If you save them as a note, you can keep those messages for as long as you wish.<br /><br />Note: You may only save a maximum of 10 notes. Premium players may save up to 50.<br /><br />
                
            </div>
        </div>

        <div id="loader">
        </div>
        <div id="subNav_container">
            <div class="tab tab1 tab-active" id="domsg_tab_inbox"><div>INBOX<span id="domsg_tab_inbox_info"></span></div></div>
            <div class="tab tab2" id="domsg_tab_outbox"><div>OUTBOX</div></div>
            <div class="tab tab3" id="domsg_tab_contacts"><div>CONTACTS</div></div>
            <div class="tab tab4" id="domsg_tab_notes"><div>NOTES</div></div>
        </div>
    </div>


    <script type="text/javascript" src="./js/jQuery/jquery.textarea-expander.js?__cv=48fae86cdd07438a75071aa0d793e900"></script>
    <script type="text/javascript">
    jQuery.fn.qtip.styles.domsg = {
        background: 'rgba(0, 0, 0, 0.9)',
        'font-size': '11px',
        width: 'auto',
        color: '#bcd3e3',
        border: {
            width: 1,
            radius: 1,
            color: 'rgba(124, 167, 202, 0.75)'
        },
        tip: 'topLeft',
        name: 'dark'
        };
    </script>

        <script type="text/javascript" src="./js/domsg.min.js"></script>
    
    <script type="text/javascript">
    //<![CDATA[
    var translations = new Object();
        translations['messaging_subNav_inbox'] = 'INBOX';
        translations['messaging_subNav_inbox_long'] = 'Inbox';
        translations['messaging_subNav_outbox'] = 'OUTBOX';
        translations['messaging_subNav_outbox_long'] = 'Outbox';
        translations['messaging_subNav_contacts'] = 'CONTACTS';
        translations['messaging_subNav_contacts_long'] = 'Contacts';
        translations['messaging_subNav_notes'] = 'NOTES';
        translations['messaging_subNav_notes_long'] = 'Notes';
        translations['messaging_common_sysMessageSender'] = 'DarkOrbit';
        translations['messaging_common_clan'] = 'Clan:';
        translations['messaging_common_selectAll'] = 'All';
        translations['messaging_common_newMessage'] = 'New message';
        translations['messaging_common_newMessage_long'] = 'Create new message';
        translations['messaging_common_okayBtn'] = 'OK';
        translations['messaging_common_confirmBtn'] = 'OK';
        translations['messaging_common_abortBtn'] = 'Cancel';
        translations['messaging_common_pageInfo'] = '%start%-%end% to %total%';
        translations['messaging_common_save'] = 'Save';
        translations['messaging_common_reply'] = 'Reply';
        translations['messaging_common_forward'] = 'Forward';
        translations['messaging_common_replyAll'] = 'Reply to all';
        translations['messaging_common_saveAsNote'] = 'Save as note';
        translations['messaging_common_blacklist'] = 'Blacklist';
        translations['messaging_common_blacklist_long'] = 'Open blacklist';
        translations['messaging_common_newNote'] = 'New note';
        translations['messaging_common_newNote_long'] = 'Create new note';
        translations['messaging_filter_all'] = 'All';
        translations['messaging_filter_unread'] = 'Unread';
        translations['messaging_filter_clan'] = 'Clan';
        translations['messaging_filter_system'] = 'System';
        translations['messaging_folderView_recipients'] = 'To:';
        translations['messaging_folderView_userWrote'] = '%username% wrote:';
        translations['messaging_contacts_sendAnInvite'] = 'sent you a request ...';
        translations['messaging_contacts_confirm'] = 'Accept';
        translations['messaging_contacts_decline'] = 'Decline';
        translations['messaging_tooltip_mailStatusAnswered'] = 'Answered messages';
        translations['messaging_tooltip_mailStatusRead'] = 'Read message';
        translations['messaging_tooltip_mailStatusUnread'] = 'Unread message';
        translations['messaging_tooltip_messageDelete'] = 'Delete message';
        translations['messaging_tooltip_addToBlacklist'] = 'Put send on blacklist';
        translations['messaging_tooltip_selectAll'] = 'Select all';
        translations['messaging_tooltip_deleteSelected'] = 'Delete selected';
        translations['messaging_tooltip_noteForward'] = 'Forward note';
        translations['messaging_tooltip_noteDelete'] = 'Delete note';
        translations['messaging_tooltip_friendCancel'] = 'Delete friend';
        translations['messaging_tooltip_sendMessage'] = 'Send message';
        translations['messaging_notes_premiumBlocked'] = 'Cannot be viewed. Note limit exceeded.';
        translations['messaging_msgWrite_replyAcronym'] = 'RE:';
        translations['messaging_msgWrite_search'] = 'Search';
        translations['messaging_msgWrite_contacts'] = 'Contacts';
        translations['messaging_msgWrite_recipients'] = 'To:';
        translations['messaging_msgWrite_subject'] = 'Subject:';
        translations['messaging_msgWrite_sendMessage'] = 'Send message';
        translations['messaging_msgWrite_cancel'] = 'Cancel';
        translations['messaging_msgWrite_messageToClan'] = 'Message to clan';
        translations['messaging_help_title'] = 'Help';
        translations['messaging_help_inbox_h'] = 'Inbox';
        translations['messaging_help_inbox_p'] = 'The inbox contains all messages that have been sent to you. Here you can read, answer or delete them. Use the dropdown menu to select the messages you would like to view. Click New Message to send a message to another player. \n\<br /\>\<br /\>Messages can be saved for a maximum of 14 days, after which they are automatically deleted by the system.  If you would like to save a message for more than 14 days, please save it as a note.';
        translations['messaging_help_compose_h'] = 'Create new message';
        translations['messaging_help_compose_p'] = 'To send another player a message, simply enter the player\'s nickname in the field to the upper left. If the player is on your server, you may add that player to the recipient list by using the plus button. If you have saved friends to your friend list, you can use the list to add them as a recipient. \n\<br /\>\<br /\>To prevent spamming, only 5 players may receive a message at the same time.  An exception to this is for clan messages, which can be sent to all clan members.';
        translations['messaging_help_sent_h'] = 'Sent messages';
        translations['messaging_help_sent_p'] = 'The outbox contains all the messages that you sent to other players. You may delete them here whenever you would like. If you would like to keep them, save the message as a note.';
        translations['messaging_help_contacts_h'] = 'Contacts';
        translations['messaging_help_contacts_p'] = 'In Contacts, you can save players and friends that you send frequent messages to. This saves you from having to search for them each time you would like to write them. Clan memebers are automatically added to the contact list.\<br /\>\<br /\>You may add as many contacts as you wish to the contact list. There are various options of doing this:\<br /\>\<br /\>\<ol\>\<li\>View the profile page of a specific player and send them a friend request.\</li\>\n\<li\>Enter the nickname in the seach field in the contact tab, and then click the plus symbol to add the player to your contact list.\</li\>\n\<li\>When you click a player name, his or her pilot menu opens. Simply click the letter symbol to send the player a message.\</li\>\</ol\>';
        translations['messaging_help_notes_h'] = 'Notes';
        translations['messaging_help_notes_p'] = 'Hey you can make notes on other players or important events. Here you may also save messages that would like to retain. Messages in you inbox are automatically deleted after 14 days. If you save them as a note, you can keep those messages for as long as you wish.\<br /\>\<br /\>Note: You may only save a maximum of 10 notes. Premium players may save up to 50.';
        translations['messaging_errorLayer_system_title'] = 'Unknown error';
        translations['messaging_errorLayer_system_text'] = 'An unknown error occurred. Click OK to restart the messaging system.';
        translations['messaging_errorLayer_blocked_title'] = 'Error';
        translations['messaging_errorLayer_blocked_text'] = 'The recipient does not wish to receive any messages.';
        translations['messaging_errorLayer_spam_title'] = 'Spam';
        translations['messaging_errorLayer_spam_text'] = 'Your messaging account has been blocked and therefore cannot send any more messages. To unblock your account, please contact support.';
        translations['messaging_errorLayer_blacklisted_title'] = 'Blacklist';
        translations['messaging_errorLayer_blacklisted_text'] = 'The recipient has blacklisted you, and therefore you cannot send him or her a message.';
        translations['messaging_errorLayer_subjectTooShort_title'] = 'Subject too short';
        translations['messaging_errorLayer_subjectTooShort_text'] = 'The subject entered is too short. It must contain at least 3 characters.';
        translations['messaging_errorLayer_subjectTooLong_title'] = 'Subject too long';
        translations['messaging_errorLayer_subjectTooLong_text'] = 'The subject entered is too long. It may not contain more than 50 characters.';
        translations['messaging_errorLayer_bodyTooShort_title'] = 'Message too short';
        translations['messaging_errorLayer_bodyTooShort_text'] = 'The message entered is too short. It must contain at least 5 characters.';
        translations['messaging_errorLayer_wrongCaptcha_title'] = 'Incorrect code';
        translations['messaging_errorLayer_wrongCaptcha_text'] = 'The Captcha code you entered was incorrect';
        translations['messaging_errorLayer_maxUnknownUser_title'] = 'Too many recipients';
        translations['messaging_errorLayer_maxUnknownUser_text'] = 'This message cannot be sent, as there are more than 10 recipients that are neither from your contacts nor members of your clan.';
        translations['messaging_errorLayer_bodyTooLong_title'] = 'Message too long';
        translations['messaging_errorLayer_bodyTooLong_text'] = 'The message entered is too long. The message limit is 5,000 characters.';
        translations['messaging_errorLayer_noRecipient_title'] = 'No recipient';
        translations['messaging_errorLayer_noRecipient_text'] = 'No recipient was added.';
        translations['messaging_errorLayer_tooManyRecipients_title'] = 'Too many recipients';
        translations['messaging_errorLayer_tooManyRecipients_text'] = 'The maximum number of recipients allowed is five.';
        translations['messaging_errorLayer_addOfClanWhileRecipients_title'] = 'Add recipient';
        translations['messaging_errorLayer_addOfClanWhileRecipients_text'] = 'You have reached the maximum number of recipients allowed. You may only send a message to 5 players OR to the entire clan.';
        translations['messaging_errorLayer_replyNoRecipientSwitch_title'] = 'You may not edit the recipients.';
        translations['messaging_errorLayer_replyNoRecipientSwitch_text'] = 'You may not edit the recipient when replying to a message.';
        translations['messaging_errorLayer_notesLimitReached_title'] = 'Note limit reached';
        translations['messaging_errorLayer_notesLimitReached_text'] = 'You\'ve reached the maximum number of notes allowed (%notesLimit%). Please delete one first before creating a new one.';
        translations['messaging_errorLayer_restrictionUnknownUser_title'] = 'Error';
        translations['messaging_errorLayer_restrictionUnknownUser_text'] = 'This message was not sent! Level %userlevel% players may only send %maxMessages% messages to users that are not in their contacts or clan for a span of 24 hours.';
        translations['messaging_confirmLayer_contactRequestDecline_title'] = 'Decline friend request';
        translations['messaging_confirmLayer_contactRequestDecline_text'] = 'Do you really want to decline the friend request?';
        translations['messaging_confirmLayer_contactDelete_title'] = 'Delete friend';
        translations['messaging_confirmLayer_contactDelete_text'] = 'Do you really want to remove this player from your friend list?';
        translations['messaging_confirmLayer_noteDelete_title'] = 'Delete note';
        translations['messaging_confirmLayer_noteDelete_text'] = 'Do you really want to delete the note?';
        translations['messaging_confirmLayer_messageDelete_title'] = 'Delete message';
        translations['messaging_confirmLayer_messageDelete_text'] = 'Do you really want to delete the message?';
        translations['messaging_confirmLayer_addToBlacklist_title'] = 'Add to blacklist';
        translations['messaging_confirmLayer_addToBlacklist_text'] = 'Do you really wan to add %username% to your blacklist? He/she won\'t be able to send you any messages anymore.';
        translations['messaging_confirmLayer_blackListDelete_title'] = 'Remove from blacklist';
        translations['messaging_confirmLayer_blackListDelete_text'] = 'Do you really want to remove %username% from your blacklist? He/she will be able to send you messages again.';
        translations['messaging_confirmLayer_messageMultiDelete_title'] = 'Delete message';
        translations['messaging_confirmLayer_messageMultiDelete_text'] = 'Do you really want to delete the selected messages?';
        translations['messaging_successLayer_contactRequestAccepted_title'] = 'Friend request accepted';
        translations['messaging_successLayer_contactRequestAccepted_text'] = 'Your request to become friends has been accepted.';
        translations['messaging_successLayer_noteSaved_title'] = 'Save note';
        translations['messaging_successLayer_noteSaved_text'] = 'The note was successfully saved!';
        translations['messaging_successLayer_messageSavedAsNote_title'] = 'Save as note';
        translations['messaging_successLayer_messageSavedAsNote_text'] = 'The messages was successfully saved as a note!';
        translations['messaging_successLayer_messageSent_title'] = 'Message sent';
        translations['messaging_successLayer_messageSent_text'] = 'The message was successfully sent!';
        translations['messaging_follow_us'] = 'FOLLOW US:';
        translations['messaging_informationtag_frauprotection'] = 'DarkOrbit employees will never ask for your password or user data. Nor will they ask that you register on another site.';
        translations['messaging_clanMessage_acceptApply_subject'] = 'Your application for %%CLANTAG%% has been accepted';
        translations['messaging_clanMessage_acceptApply_body'] = 'Hello %%USERNAME%%,\n\<br /\>\<br /\>\nYour application to the %%CLANNAME%% Clan has been accepted.\n\<br /\>\<br /\>\nHere\'s to working together, Pilot!';
        translations['messaging_clanMessage_declineApply_subject'] = 'Your application for %%CLANTAG%% was declined';
        translations['messaging_clanMessage_declineApply_body'] = 'Hello %%USERNAME%%,\n\<br /\>\<br /\>\nYour application for the %%CLANNAME%% clan has been declined.\n\<br /\>\<br /\>\nWe wish you continued success, Pilot!';
        translations['messaging_reCaptcha_msg_headline'] = 'Recaptcha';
        translations['messaging_reCaptcha_msg_infotext'] = 'Please enter in the words displayed below. You are receiving this message because one or more recipients are either not from your contacts or in your clan.';
        translations['messaging_reCaptcha_msg_button_send'] = 'Send';
        translations['messaging_reCaptcha_msg_button_cancel'] = 'Cancel';
        jQuery(document).ready(function() {
        DoMessaging.getInstance().setTranslations(translations);
        DoMessaging.getInstance().init();
        
                                        
    });
    jQuery('#domsg_msgwrite_body').bind('mousedown keyup', function(){
        jQuery('#domsg_msgwrite_txtCounter').php(jQuery(this).val().length+'/'+5000);
    });
    jQuery('textarea[id$="_open-body"]').live('mousedown keyup', function(){
        jQuery('#'+jQuery(this).attr('id')+'_counter').php(jQuery(this).val().length+'/'+5000);
    });
    jQuery('.open-closebtn, .closed-clickarea, #domsg_notes_new').live('click', function(){
        if(jQuery(this).attr('id') == 'domsg_notes_new' || !jQuery('#domsg_notes_new').hasClass('button-biggreen-disabled')) {
               jQuery('.domsg_notes_txtCounter').php('');
        }
    });
    jQuery('.tab1, .tab2, .tab3, .tab4').click(function() {
        jQuery('.tab1, .tab2, .tab3, .tab4').removeClass('tab-active');
        jQuery(this).addClass('tab-active');
    });
    //]]>
    </script>

</div>

<div class="content_frame_bottom">
    <div class="content_frame_bottom_left"></div>
    <div class="content_frame_bottom_right"></div>
</div>


<div class="footerContainer">

<div id="alertBox" class="fliesstext"></div>
<div id="imprint" style="width:523px;height:600px;" class="fliesstext">
    <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="./do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt="" /></a></div>
    <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>Building Vertigo - Polaris<br>2-4 rue Eugène Ruppert<br>L-2453 Luxemburg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jeronimo Folgueira<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 25331016<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 261 911 3515<br>Fax: +352 49 48 48 6606<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
</div>
<?php require GLOBALS . 'credits.php';?>

<script type="text/javascript" id="sourcecode">

    jQuery(function()
    {
        jQuery('#teamCredits_text').jScrollPane({autoReinitialise: true, showArrows: true});
    });

</script>

    <div id="imprint_ingame" class="fliesstext">
        <a href="javascript:void(0);" onclick="showFooterLayer('imprint');">
           
                <a href="javascript:void(0);" onclick="showFooterLayer('teamCreditsBox')">Credits</a> |
        <a href="/GameAPI.php?action=portal.redirectToBoard" target="_blank">Forum</a>
    </div>





   </div><!-- End footerContainer -->
</div><!-- End bodyContainer -->
</div><!-- End outerContainer -->
</div><!-- End overallContainer -->
</div>




<script type="text/javascript">
    
    if (jQuery('#toolbar').length > 0) {
        jQuery('#toolbar').css('float', 'none');
        jQuery('body').css('background-position', 'center 30px');
    }
    
</script>
<link rel="stylesheet" type="text/css" href="./resources/css/popup.css?__cv=4e58da2dec4df33ee5f4c239848dda00" />
<div id="popup">
    <div class="header">
        <div class="button-close"></div>
    </div>
    <div class="body">
        <div class="icon icon-question"></div>
        <div class="icon icon-error"></div>
        <div class="icon icon-success"></div>
        <div class="content fliess13px-grey"></div>
    </div>
    <div class="footer single-button">
        <div class="button button-green">
            <div class="text" style="background-image: url(/do_img/global/text_tf.esg?s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
        </div>
        <div class="button button-blue">
            <div class="text" style="background-image: url(/do_img/global/text_tf.esg?s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
        </div>
    </div>
</div>
<div id="popup-modalBackground"></div>
<img id="popup-loading" alt="Loading..." src="./do_img/global/pilotSheet/profilePage/loadingAnimation.gif" />

<!-- LayertoolService JavaScript Injection start -->
<script type="text/javascript">
    //<![CDATA[
    // add fancybox css to the head
    var cssLink  = document.createElement('link');
    cssLink.type = 'text/css';
    cssLink.rel  = 'stylesheet';
    cssLink.href = './application/fancybox/jquery.fancybox-1.3.4.css';
    document.getElementsByTagName('head')[0].appendChild(cssLink);
    //]]>
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="./application/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="./application/client/client.js"></script>
<script type="text/javascript" src="./application/cookie/jquery.cookie.js"></script>
<script type="text/javascript">var jQueryLts = jQuery.noConflict(true);</script>

<!-- LayertoolService JavaScript Injection end -->


</body>
</html>