function showInfoLayer(type, divToSend, text) {
    showBusyLayer();
    width_x = document.body.offsetWidth;
    container_x = jQuery("#infoLayer").width();

    jQuery("#infoLayer .question").addClass("icon_" + icon);
    if (type == 'confirm') {
        jQuery("#infoLayerInfo").hide();
        jQuery("#infoLayerConfirm").show();
        jQuery("#infoLayer .question").addClass("icon_question");
        jQuery("#infoLayer_link_confirm").click(function() {
            confirmInfoLayer(divToSend);
        });
    } else if (type == 'info') {
        jQuery("#infoLayerConfirm").hide();
        jQuery("#infoLayerInfo").show();
        text = infoText;
    } else if (type == 'maxDronesReached') {
        jQuery("#buy_button").hide();
        jQuery("#infoLayerConfirm").hide();
        jQuery("#infoLayerInfo").show();
        jQuery("#infoLayer .question").removeClass('icon_question').removeClass('icon_success').addClass("icon_error");
        text = textMaxDronesReached;
    }

    jQuery("#infoLayer .question").html(text);
    jQuery("#infoLayer").css('left', ((width_x/2) - (container_x/2))+"px");
    jQuery("#infoLayer").css('top', "200px");
    jQuery("#infoLayer").show();
}

function closeInfoLayer() {
    hideBusyLayer();
    jQuery("#infoLayer").hide();
}

submitted = 0;
function confirmInfoLayer(divToSend) {
    if(submitted == 0) {
        submitted = 1;
        jQuery("#"+divToSend).submit();
    }
}
