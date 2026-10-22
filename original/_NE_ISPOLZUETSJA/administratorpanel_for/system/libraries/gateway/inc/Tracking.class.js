var Tracking = {




    loadItemDescription: function(item) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.item.description.load', {'item':item});
        }
    },

    showItemDescription: function(item) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.item.description.show', {'item':item});
        }
    },

    hideItemDescription: function(item) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.item.description.hide', {'item':item});
        }
    },

    loadAccountDescription: function(account) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.account.description.load', {'account':account});
        }
    },

    showAccountDescription: function(account) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.account.description.show', {'account':account});
        }
    },

    hideAccountDescription: function(account) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.account.description.hide', {'account':account});
        }
    },

    addItemToShoppingCart: function(item) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.payment.shoppingcart.add', {'item':item});
        }
    },

    deleteItemFromShoppingCart: function(item) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.payment.shoppingcart.remove', {'item':item});
        }
    },

    fullShoppingCart: function(item) {
        if (BpEventStream.track) {
            BpEventStream.track('payment.shoppingcart.full', {'item':item});
        }
    },

    showPaymentmethodList: function() {
        if (BpEventStream.track) {
            BpEventStream.track('payment.payment.method.list', {});
        }
    }



}