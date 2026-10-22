var AjaxFormHandler = {

    callbackVariable: null,

    getCallback: function() {
        return (AjaxFormHandler.callbackVariable)
            ? AjaxFormHandler.callbackVariable
            : Payment;
    },

    setCallback: function(obj) {
        AjaxFormHandler.callbackVariable = obj;
    },

    getParameterFromForm: function(formObject) {
        var params = new Object();
        for (var i=0; i<formObject.elements.length; i++) {
            var element = formObject.elements[i];

            if (element.type == 'radio' && !element.checked) continue;
            if (element.type == 'checkbox' && !element.checked) continue;


            var pos1 = element.name.indexOf('[');
            var pos2 = element.name.indexOf(']');

            if (pos1 >= 0 && pos2 >= 0) {
                //new stuff for mobile payment, remove field description in gray
                if (
                    element.getProperty
                    && element.getProperty('alt') == element.value
                ) {
                    continue;
                }

                var mainname = element.name.substr(0,pos1);
                var subelement = element.name.substr(pos1+1, pos2-pos1-1);
                if (!params[mainname]) {
                    params[mainname] = new Object();
                }
                params[mainname][subelement] = element.value;
            } else {
                params[element.name] = element.value;
            }
        }

        return params;
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    reloadDirectOverlay: function(itemID, accountIDs, formObject) {
        // read parameters of form
        var params = new Object();
        for (var i=0; i<formObject.elements.length; i++) {
            var element = formObject.elements[i];
            params[element.name] = element.value;
        }
        AjaxFormHandler.getCallback().reloadDirectOverlay(itemID, accountIDs, params);
    },

    reloadHandlePayment: function(accountID, formObject) {
        // read parameters of form
        var params = AjaxFormHandler.getParameterFromForm(formObject);
        AjaxFormHandler.getCallback().reloadHandlePayment(accountID, params);
    },

    reloadHandlePaymentWithItems: function(accountID, formObject) {

        var cartIDs=[];
	    Payment.cartElements.each(
            function(item) {
                try {
                    cartIDs.push(item.itemID);
                } catch (err) {}
            }
        );

        // read parameters of form
        var params = AjaxFormHandler.getParameterFromForm(formObject);
        params['itemIDs'] = cartIDs;
        Payment.reloadHandlePayment(accountID, params);
    },

    showAdditionalOverlayWithItems: function(action, formObject, shoppingCart) {
        var cartIDs=[];
        if (!shoppingCart) {
	    Payment.cartElements.each(
            function(item) {
                try {
                    cartIDs.push(item.itemID);
                } catch (err) {}
            }
        );
        } else {
            shoppingCart.each(
                function(item) {
                    try {
                        cartIDs.push(item.getId());
                    } catch (err) {}
                }
            );
        }

        var params = AjaxFormHandler.getParameterFromForm(formObject);
        params['itemIDs'] = cartIDs;
        AjaxFormHandler.getCallback().showAdditionalOverlay(action, params);
    },

    showAdditionalOverlay: function(action, formObject) {
        var params = AjaxFormHandler.getParameterFromForm(formObject);
        AjaxFormHandler.getCallback().showAdditionalOverlay(action, params);
    }


}