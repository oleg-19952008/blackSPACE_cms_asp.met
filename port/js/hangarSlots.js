function switchHangarView(selectedHangarId, slotId, activeState, hangarIsEmpty, template) {

    if (!hangarBarActive)  {
        return;
    }
    jQuery('.hangarSlot').removeClass('selected');
    if ('active' != activeState) {
        jQuery('#slot_'+slotId).addClass('selected');
        jQuery('#btnActivateHangarSlot').show();
        if (hangarIsEmpty) {
            jQuery('#btnActivateHangarSlot').hide();
        }
    } else {
        jQuery('#btnActivateHangarSlot').hide();
    }

    if (template == 'internalDock') {
        changeView('ship');
        xajax_switchHangar(selectedHangarId);
    } else {
        xajax_setHangarSelected(selectedHangarId);
        thisMovie("inventory").changeHangarSlot(slotId);
        xajax_changeHangarName(selectedHangarId);
    }

    setSelectedHangarId(selectedHangarId);
}

function showActivateButton() {
    jQuery('#btnActivateHangarSlot').show();
}

function setSelectedHangarId(selectedHangarId) {
    jQuery('#hangarView #hangarId').val(selectedHangarId);
    jQuery('#renameHangarForm #hangar_Id').val(selectedHangarId);
    jQuery('.shipDumpForm input[name="hangarId"]').val(selectedHangarId);
}

function setCurrentHangarName(name){
    if(jQuery('#renameHangarInputField')) {
        jQuery('#renameHangarInputField').val(name);
    }
}

function showHangarRenameForm() {
    jQuery('#renameHangarContainer').css('display', 'block');
    jQuery('#renameHangarPopup').css('display', 'block');
    jQuery('#renameHangarPopup').css('left', 220);
}

function hideHangarRenameForm() {
    jQuery('#renameHangarContainer').css('display', 'none');
}

function renameHangar() {
    jQuery('#renameHangarForm').submit();
}

function setNewHangerName(name, premium) {
    jQuery('#renameHangarContainer').css('display', 'none');
    if(premium) {
        jQuery('#showHangarNameInUpperRightCornerTextPremium').html('');
        jQuery('#showHangarNameInUpperRightCornerTextPremium').html(name);
    } else {
        jQuery('#showHangarNameInUpperRightCornerText').html('');
        jQuery('#showHangarNameInUpperRightCornerText').html(name);
    }

    if(jQuery('#renameHangarInputField')) {
        jQuery('#renameHangarInputField').val(name);
    }
}

var jsReadyForFlashEquipmentClient = false;
var isEventFired = false;
jQuery(document).ready(function(){
    jsReadyForFlashEquipmentClient = true;

    jQuery('#btnActivateHangarSlot').click(function() {

        if (!hangarBarActive || isEventFired)  {
            return;
        }
        isEventFired = true;

        if ('undefined' !== typeof Tools && 'undefined' !== Tools.Popup) {
            // Tools.Popup is present; show loading dialog
            Tools.Popup.showLoadingDialog();
        };
        jQuery('#hangarView').submit();
    });
})

function pageInit() {
    jsReadyForFlashEquipmentClient = true;
    document.forms["form1"].output.value += "\n" + "JavaScript is ready.\n";
}

function thisMovie(movieName) {
    if (navigator.appName.indexOf("Microsoft") != -1) {
        return window[movieName];
    } else {
        return document[movieName];
    }
}

function isReady() {
    return jsReadyForFlashEquipmentClient;
}

var hangarBarActive = true;
function setHangarBarActive(active) {
    hangarBarActive = active;
    if (true == hangarBarActive) {
        jQuery('#hangarSlotsDisable').hide();
    } else {
        jQuery('#hangarSlotsDisable').show();
    }
}
