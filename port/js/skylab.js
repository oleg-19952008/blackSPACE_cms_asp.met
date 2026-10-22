/**
 * Created with JetBrains PhpStorm.
 * User: rgericke
 * Date: 11.10.13
 * Time: 14:57
 * all of the skylab magic
 */

var Skylab =
{
    listenerInit: false,

    init: function()
    {
        jQuery('.skylab_module_close').click(function() {
            Skylab.closeAllModules();
        });
    },

    showModule: function(moduleName)
    {
        this.closeAllModules();
        jQuery('#module_' + moduleName + '_large').show();

        if (false === this.listenerInit && 'transportModule' == moduleName) {
            this.addTransportListener();
            this.listenerInit = true;
        }

        this.showShadow();
    },

    showShadow: function()
    {
        jQuery('#skylab_shadow').show();
    },

    hideShadow: function()
    {
        jQuery('#skylab_shadow').hide();
    },

    closeAllModules: function()
    {
        jQuery('.module_large').hide();
        this.hideShadow();
    },

    addTransportListener: function()
    {
        jQuery('input[type="text"].skylab_standard').focus(function() {
            if (0 == jQuery(this).val()) {
                jQuery(this).val('');
            }
        });

        jQuery('input[type="text"].skylab_standard').blur(function() {
            if ('' == jQuery(this).val()) {
                jQuery(this).val(0);
            }
        });
    },

    changeToTab: function(tabID, container)
    {
        var containerId = '#module_infobox_' + container;
        var contentId = containerId;

        if (jQuery(containerId + ' .tab_' + tabID).hasClass('tab_active')) {
            return null;
        }

        switch(tabID)
        {
            case 'first':
                contentId += '_overview_large';
                break;
            case 'second':
                contentId += '_upgrade_large';
                break;
            case 'third':
                contentId += '_productivity_large';
                break;

            default:
                return null;
        }

        jQuery(containerId + ' .skylab_module_tab').removeClass('tab_active');
        jQuery(containerId + ' .tab_' + tabID).addClass('tab_active');

        jQuery(containerId + ' .tabContent').hide();
        jQuery(contentId).show();
    },

    sendTransport: function(mode, text, okLabel, cancelLabel) {
        jQuery('#mode').val(mode);

        if(mode == 'fast') {
            Dialog.confirm(text,
                {
                    height: 100,
                    width:300,
                    okLabel: okLabel,
                    cancelLabel: cancelLabel,
                    //className: "alphacube",
                    ok:function(win) {
                        jQuery('#sendTransport').submit();
                        return true;
                    }
                });
        } else if ('instantFinish' == mode) {
            Dialog.confirm(text,{
                height: 100,
                width: 300,
                ok: function() {
                    jQuery('#sendTransport').submit();
                    return true;
                }
            });
        } else {
            jQuery('#sendTransport').submit()
        }
    },

    isVideoAvailable: function()
    {
        return ('1' == jQuery('#videoAvailable').val())
    },

    chooseUpgradeOption: function(option, containerKey)
    {
        var showAcceptButton = true;

        // set visual active state to the currently clicked container
        jQuery('#module_infobox_' + containerKey + ' .option_state').removeClass('upgrade_option_active');
        jQuery('#module_infobox_' + containerKey + ' .upgrade_option_' + option + ' .option_state').addClass(
            'upgrade_option_active'
        );

        // hide the ok button
        jQuery('#module_infobox_' + containerKey + ' .upgrade_option_confirm').hide();

        var textId = '#upgrade_text_' + option;

        // check if we have a video available
        if ('cinema' == option && !this.isVideoAvailable()) {
            textId += '_noVideo';
            showAcceptButton = false;
        }

        // show the fitting hint text
        jQuery('#module_infobox_' + containerKey + ' .upgrade_options_text').hide();
        jQuery(textId + '_' + containerKey).show();
        // set the clicked option as chosen
        jQuery('#upgrade_option_' + containerKey).val(option);

        // unbind the click event from the ok button to avoid duplication and/or exploits
        jQuery('#module_infobox_' + containerKey + ' .upgrade_option_confirm').unbind('click');

        // show ok button and bind the click event
        if (true === showAcceptButton) {
            jQuery('#module_infobox_' + containerKey + ' .upgrade_option_confirm').show().bind('click', function() {
                switch (option)
                {
                    case 'instant':
                        Skylab.instantUpgrade(containerKey);
                        break;
                    case 'cancel':
                        Skylab.cancelUpgrade(containerKey);
                        break;
                    case 'cinema':
                        Skylab.showVideo(containerKey);
                        break;
                }
            });
        }
    },

    instantUpgrade: function(containerKey)
    {
        do_redirect(
            '/indexInternal.es?action=internalSkylab&subaction=instantFinishUpgrade&construction='
            + containerKey
            + '&reloadToken=' + rid
        )
    },

    cancelUpgrade: function(containerKey)
    {
        do_redirect(
            'indexInternal.es?action=internalSkylab&subaction=abortUpgrade&construction='
            + containerKey
            + '&reloadToken=' + rid
        );
    },

    showVideo: function(containerKey)
    {
        // double check if there is a video
        if (!this.isVideoAvailable()) {
            return false;
        }

        var incentiveKey = 'skylab_';

        if ('transport' == containerKey) {
            incentiveKey += 'transport';
        } else {
            incentiveKey += 'upgrade_' + containerKey;
        }

        // get video properties
        var iFrameURL = jQuery('#videoURL').val();
        var tmpSize = jQuery('#videoSize').val().split('x');

        var iFrameWidth = tmpSize[0];
        var iFrameHeight = tmpSize[1];

        this.closeAllModules();

        Tools.Popup.Initialize();

        // do some magic
        jQuery.ajax({
            type        : 'POST',
            url         : '/ajax/cinema.php',
            dataType    : 'json',
            data        : {
                action          : 'videoRequested',
                category        : incentiveKey
            },
            beforeSend  : function() {
                Tools.Popup.showLoadingDialog();
            },
            success     : function (data, status, jqXHR) {
                Tools.Popup.hideLoadingDialog();

                if (1 == data.isError) {
                    Tools.Popup.Presets.showErrorDialog(data.message);
                } else {
                    BrandCinema.iFrameWidth = iFrameWidth;
                    BrandCinema.iFrameHeight = iFrameHeight;
                    BrandCinema.iFrameUrl = iFrameURL;

                    BrandCinema.openVideoLayer();
                }
            },
            error       : function() {
                Tools.Popup.hideLoadingDialog();
            }
        });

        this.resetCurrentVideo();
    },

    resetCurrentVideo: function()
    {
        jQuery('#videoAvailable').val('0');
        jQuery('#videoURL').val('');
    }
};

var currentTime = 0;

var SkylabTimer = function() {};

SkylabTimer.prototype = {

    startTime       : 0,
    endTime         : 0,
    targetDivId     : '',
    targetDiv       : null,
    timeDiv         : null,
    barContainerDiv : null,
    barDiv          : null,
    interval        : null,
    now             : null,
    finished        : 0,
    barMinWidth:    20,
    barMaxWidth:    272,

    init : function(divId, start, end)
    {
        this.now = currentTime;
        this.startTime = start;
        this.endTime = end;
        this.targetDivId = 'progressBG_module_' + divId;
        var wrapperDivId = this.targetDivId;

        this.targetDiv = document.getElementById(wrapperDivId);
        this.targetDiv.skylabTimer = this;

        this.barContainerDiv = document.getElementById('module_progressBarWrapper_' + divId);
        this.timeDiv = document.getElementById('progress_timer_' + divId);

        // draw timer...
        this.render();

            // start loop...
        this.interval = window.setInterval("document.getElementById('" + wrapperDivId + "').skylabTimer.render();", 1000);
    },

    render : function()
    {
        var timeLeft = this.endTime - this.now;

        if(timeLeft <= 0) {
            this.finish();
            return;
        }

        h = Math.floor(timeLeft / 3600);
        m = Math.floor((timeLeft - (h * 3600)) / 60);
        s = Math.floor(timeLeft - h * 3600 - m * 60);

        if (h < 10) h = '0' + String(h);
        if (m < 10) m = '0' + String(m);
        if (s < 10) s = '0' + String(s);

        this.timeDiv.innerHTML = String(h) + ':' + String(m) + ':' + String(s);

        var barWidth = 0;
        var perc = Math.round((this.now - this.startTime) / (this.endTime - this.startTime) * 100);
        barWidth = Math.round((this.barMaxWidth / 100) * perc);

        if (this.barMinWidth > barWidth) {
            barWidth = this.barMinWidth;
        }
        if (this.barMaxWidth < barWidth) {
            barWidth = this.barMaxWidth;
        }

        this.barContainerDiv.style.width = String(barWidth) + 'px';

        this.now++;
    },

    finish : function()
    {
        // end loop...
        var str = '0:00:00';

        if(this.timeDiv.innerHTML == str) {
            this.timeDiv.innerHTML = '';
        } else {
            this.timeDiv.innerHTML = str;
        }

        if (this.finished == 5) {
            window.clearInterval(this.interval);
            do_redirect('indexInternal.es?action=internalSkylab');
        }

        this.finished++;
    }
};

jQuery(document).ready(function() {
    Skylab.init();
});