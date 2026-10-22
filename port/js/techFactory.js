function updateConfirm(link) {
    jQuery('#deleteTechs').click(function(evt) {
        confirmationText = Tools.Text.get('message_confirm_deleteTechs');
        Tools.Popup.Presets.showQuestionDialog(confirmationText, {
            callback    : function() {
                redirect(link);
            }
        });
    })
}

