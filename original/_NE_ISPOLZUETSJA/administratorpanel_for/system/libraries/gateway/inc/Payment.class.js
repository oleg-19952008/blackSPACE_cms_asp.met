var Payment = {

    priceEventListener: new ActionListenerList(),


    restoreCurrencyString: function(currency) {
        if (currency == '€') return 'EUR';
        if (currency == '$') return 'USD';
        if (currency == '£') return 'GBP';
        if (currency == 'TL') return 'TRY';
        return currency;
    },

    currentStep: 0,
    paymentAccounts: false,
    fastPayData: false,
    fastPayStatus: false,
    preselectedItems: [],
    onlySecureMethods: false,
    selectedFastPayMethod: false,

    updateStep: function(step) {
        if(step==Payment.currentStep) return;

        if(step > Payment.currentStep) {
            for (var i = 0; i <= step; i++) {
                $('bar_'+i).style.backgroundImage = 'url('+Payment.img.get('progressBar_'+i)+')';
                $('description_'+i).className = 'progressText_activ';
            }
        } else {
            for(var i = 4; i > step; i--) {
                $('bar_'+i).style.backgroundImage = 'url('+Payment.img.get('progressBar_'+i+'_grey')+')';
                if (i != 4) $('description_'+i).className = 'progressText_inactiv';
            }
        }
        Payment.currentStep = step;
    },

    /* Status of the lightbox-overlay */
    overlayOpen: false,


    /* Flag that prevents animations from bugging due to dual execution */
    moving: false,

    img: null,
    lang: null,

    windowSize: [],
    /* Main function called on window load */
    init:function() {
        Payment.windowSize = Util.getBetterWindowSize();
        window.onresize = function() {
            if (Payment.overlayOpen) {
                $('overlayer').style.height = 0;
                $('overlayer').style.width = 0;
            }
            Payment.windowSize = Util.getBetterWindowSize();
            if (Payment.overlayOpen) {
                $('overlayer').style.height = Payment.windowSize[5]+"px";
                $('overlayer').style.width = Payment.windowSize[4]+"px";
            }
        }

        itemlistElements = new Hash({});

        Payment.initMoreOffers();
        Payment.initMoreMethods();
        Payment.img = new ImageResourceHandler('image_resources', 'image_');
        Payment.lang = new ResourceHandler('language_resources', 'lang_');
        /*
        LangRes.init('language_resources','lang_');
        ImgRes.init('image_resources','image_');*/

        if (document.addEventListener){
            document.addEventListener('keypress', Payment.handleKey, false);
        } else if (document.attachEvent){
            document.attachEvent('onkeypress', Payment.handleKey);
        }

        Payment.preselectedItems = getPreselectedItems();

        Payment.updateItemGroup(getDefaultItemGroup());
        if(Util.trim($('overlay_content').innerHTML) != '') {
            var overlayclass = 'middleOverlay';
            //if($('overlay_content').innerHTML.indexOf('overlay_success')) overlayclass = 'smallOverlay';
            Payment.enableOverlay(false,overlayclass);
        }

        var offerItems = $('offerItems').getChildren();
        for(var i=0; i<offerItems.length; i++) {
            if(Util.trim(offerItems[i].id) != '') {
                Util.addMovingText(offerItems[i].id + "_reflection", offerItems[i].id+"_text");
            }
        }
    },

    handleKey: function(e) {
        if(e.keyCode == 27) {
            Payment.disableOverlay();
        }

    },

    maxRows: 9,

    //new test comment

    updateItemGroup: function(itemGroup) {
        Payment.setWaitingScreen($('topItemsPrices'));
        if ($('topItemsTable')) {
            $('topItemsTable').dispose();
        }
        $('offerItems').getChildren().each(
            function(item) {
                if($(item) !== null) {
                    $(item).removeClass('offerItemGlow');
                    $(item).addClass('pointer');
                }
            }
        );
        if($('offerItem_'+itemGroup) !== null) {
            $('offerItem_'+itemGroup).addClass('offerItemGlow');
            $('offerItem_'+itemGroup).removeClass('pointer');
        }


        var items = getItems(itemGroup);

        if (items) {
            Payment.updateItemSelection(items);
        } else {
            Util.apiRequest(
                'gameapi.jsonItemSelection',
                {'itemGroup':itemGroup},
                Payment.updateItemSelection
            );
        }
    },

    updateItemSelection: function(o) {
        if(!o) return;

        if (o.items == false) {
            if (isHiddenGroupActive() && !isInitialPage()) {
                Util.apiRequest(
                    'gameapi.jsonResetPreselectedItems',
                    {'resetPreselectedItems':true},
                    function(o) {
                        window.location = getRootURL() + '?' + getSession();
                    }
                );
            } else {
                Payment.showAdditionalOverlay('error', 'noItemsFound');
            }
            return;
        }

        if ($('topItemsTable')) {
            $('topItemsTable').dispose();
        }
        var table = new Element('table', {'id':'topItemsTable'});

        $('topItemsTitle').innerHTML = o.config.headline;
        $('topItemsHeaderIcon').style.backgroundImage = 'url('+o.config.imagePath+')';

        var itemids = new Array();

        var firstDirectRow          = true;
        var usedShoppingCartTypes   = 0;
        var shoppingCartTypeSms     = 1;
        var shoppingCartTypePhone   = 2;
        var shoppingCartTypeTerminal = 3;
        var firstDirectRowElement   = null;

        var preselectedItemList = new Array();
        var max = Payment.maxRows;

        o.items.each(
            function(item, index) {
                --max;
                if (max < 0) return;

                //check if only secure methods are accepted and if item is a
                //direct overlay with an non secore method
                if (Payment.onlySecureMethods === true && item.nonSecOverlayItem === true) {
                    return;
                }

                // fill line between normal items and sms/phone items
                // with a headline
                if (item.showDirectOverlay && firstDirectRow) {
                    if (index != 0) {

                        if (o.items.length >= Payment.maxRows) {
                            var row = table.insertRow(table.rows.length);
                            var desc = row.insertCell(0);
                            desc.colSpan = 4;
                            desc.id = 'slimItemSelectionSubheadline';
                            desc.className = 'slimTopItemsDirectOverlaySeparator';
                        } else {
                            var row = table.insertRow(table.rows.length);
                            var desc = row.insertCell(0);
                            desc.colSpan = 4;
                            desc.id = 'itemSelectionSubheadline';
                            desc.className = 'topItemsDirectOverlaySeparator';
                        }
                    }

                    firstDirectRow = false;
                }

                if(item.shoppingCartIcon == false) item.shoppingCartIcon = '';
                var row = table.insertRow(table.rows.length);
                var desc = row.insertCell(0);
                if (item.shoppingCartType == 'sms' || item.shoppingCartType == 'smssub') {
                    row.id = 'sms_' + index;
                } else if (item.shoppingCartType == 'phone') {
                    row.id = 'phone_' + index;
                } else if (item.shoppingCartType == 'terminal') {
                    row.id = 'terminal_' + index;
                }

                var shoppingCartEvent = "Payment.addToCart('"+item.id+"_"+item.itemID+"')";
                if (item.showDirectOverlay) {
                    if (item.countById <= 1) {
                        shoppingCartEvent = "Payment.showDirectOverlay('"+
                        item.id+"', '"+item.accountIDs+"', "+item.openPrePopup+")";
                    } else {
                        shoppingCartEvent = "Payment.showDirectOverlaySelection('"+
                        item.id+"', '"+item.shoppingCartType+"')";
                    }
                }

                desc.innerHTML = '<div class="btn" onclick="'+shoppingCartEvent+'">'+item.title+'</div>';
                //desc.setProperty('id', 'itemdesc' + index);
                desc.id = 'itemdesc' + index;
                desc.noWrap = 1;
                itemids.push(item);

                var disc = row.insertCell(1);
                disc.innerHTML =
                        '<div id="itemSelectionSavePercentage'+index+'_container" class="savepercentprice">'
                        + '<div id="itemSelectionSavePercentage'+index+'_text" class="nowrap btn" onclick="'+shoppingCartEvent+'">'
                        + item.savePercentage
                        + '</div>'
                        + '</div>';
                disc.id        = 'itemSelectionSavePercentage'+index+'';

                var price = row.insertCell(2);
                //price.innerHTML = item.actualPrice;
                price.innerHTML = '<div class="btn" onclick="'+shoppingCartEvent+'">'+item.selectionPrice+'</div>';  // maybe text (e.g. monthly xx EUR)
                price.className = 'newprice';
                price.noWrap    = 1;
                price.id        = 'itemSelectionPrice'+index;
                var btntd = row.insertCell(3);

                var shoppingCartClass = 'addToCartBtn';
                if (item.shoppingCartType == 'sms') {
                    shoppingCartClass = 'addToCartMobileBtn';
                } else if (item.shoppingCartType == 'phone') {
                    shoppingCartClass = 'addToCartPhoneBtn';
                } else if (item.shoppingCartType == 'smssub') {
                    shoppingCartClass = 'addToCartMobileBtn';
                } else if (item.shoppingCartType == 'terminal') {
                    shoppingCartClass = 'addToCartTerminalBtn';
                }
                var btn = '<div id="itemaddtocart'+index+'" class="'+shoppingCartClass+' btn" onclick="'+shoppingCartEvent+'"></div>';

                btntd.innerHTML= btn;

                itemlistElements.set(item.id+"_"+item.itemID,
                    //new Payment.CartElement(descriptVal, priceVal, discountVal, itemID, cartIcon)
                    new Payment.Item(item)
                );

                // check if item is preselected
                for (var i=0; i<Payment.preselectedItems.length; i++) {
                    if (
                        (
                            Payment.preselectedItems[i] == item.id
                            || Payment.preselectedItems[i] == item.itemID
                        )
                        && !item.showDirectOverlay
                    ) {
                        preselectedItemList.push(item.id+"_"+item.itemID);
                    }
                }

            }
        );
        $('topItemsPrices').adopt(table);

        if (Payment.allowedAccounts.length > 0 || Payment.restrictedAccounts.length > 0) {
           Payment.checkVoucherSmsPhone();
        }

        // calculation for with of discount
        var minWidthDisc = -1;
        var allEmpty = true;
        itemids.each(function(item, index) {
            var totalSize = $('itemdesc'+index).getParent().getSize().x - 10;
            totalSize -= $('itemdesc'+index).getSize().x;
            totalSize -= $('itemSelectionPrice'+index).getSize().x;
            totalSize -= $('itemaddtocart'+index).getSize().x;
            if (minWidthDisc < 0 || minWidthDisc > totalSize) {
                minWidthDisc = totalSize;
            }
            if ($('itemSelectionSavePercentage'+index+'_text').innerHTML != '') {
                allEmpty = false;
            }
        });

        // set tooltips for items
        itemids.each(function(item, index) {
            new ToolTipper('itemdesc'+index, getOverlayInfoForToolTipper, item);
            new SmallToolTipper('itemaddtocart'+index, item.addToCartTooltip);
            new SmallToolTipper('itemSelectionPrice'+index, item.localPrice);

            if (allEmpty) {
                $('itemSelectionPrice'+index).setStyle('width', ($('itemSelectionPrice'+index).getSize().x+minWidthDisc-25)+"px");
                minWidthDisc = 0;
            }

            $('itemSelectionSavePercentage'+index).setStyle('width', minWidthDisc+"px");
            $('itemSelectionSavePercentage'+index+'_container').setStyle('width', minWidthDisc+"px");
            Util.addMovingText('itemSelectionSavePercentage'+index+'_container', 'itemSelectionSavePercentage'+index+'_text');
        });

        // preselect for items
        if (preselectedItemList.length == 1) {
            Payment.addToCart(preselectedItemList.shift());
            Payment.requestMethods();
        }
        Payment.preselectedItems = new Array();

        Payment.unsetWaitingScreen();
    },


    /* Used for the offers / methods content sliders */
    offersOpen: false,
    offerPages: 0,
    offerPage: 0,
    methodOpen: false,
    methodPages: 1,
    methodPage: 0,

    /* Array of payment methods */
    paymentMethods: [],

    /* Opens/closes offers */
    toggleMoreOffers: function() {
        if(Payment.moving) return;
        Payment.moving = true;
        if(!Payment.offersOpen) {
            $('moreOffers').get('morph').removeEvents('complete');
            $('moreOffers').set('morph', {duration: 500,
                onComplete: function() {
                    $('offersExpanded').get('morph').removeEvents('complete');
                    $('offersExpanded').set('morph', {duration: 250,
                        onComplete: function() {
                            Payment.offersOpen = true;
                            Payment.moving = false;
                        }
                    });
                    $('offersExpanded').morph({opacity:[0,1]});
                }
            });

            $('moreOffers').morph({height:130});
        } else {
            $('offersExpanded').get('morph').removeEvents('complete');
            $('offersExpanded').set('morph', {duration: 250,
                onComplete: function() {
                    $('moreOffers').get('morph').removeEvents('complete');
                    $('moreOffers').set('morph', {duration: 500,
                        onComplete: function() {
                            Payment.offersOpen = false;
                            Payment.moving = false;
                        }
                    });
                    $('moreOffers').morph({height:36});
                }
            });
            $('offersExpanded').morph({opacity:[1,0]});
        }
    },

    /* Called from init: Initializes pages for offers */
    initMoreOffers: function() {
        //$$('.offerItem').each(
        $('moreOffers').getElements('.offerItem').each(
            function(item, index) {
                if(
                    index != 0
                    && index != $$('.offerItem').length
                    && index % 4 == 0
                    && $(item.id+'_tooltip')
                ) {
                    Payment.offerPages++;
                }
                if ($(item.id+'_tooltip')) {
                    new SmallToolTipper(item.id, $(item.id+'_tooltip').value );
                }
            }
        );
    },

    /* Called from init: Initializes pages for payment methods */
    initMoreMethods: function() {
        var childElements = $('paymentMethods').getChildren();
        for(var i=1; i< childElements.length; i++) {
            if(childElements[i].id.match(/methodItems_page_/)) {
                Payment.methodPages++;
            }
        }
    },

    /* Shows the lightbox overlay */
    enableOverlay: function(content, overlayClass) {
        var fading = true;

        if(Payment.overlayOpen === true) {
            $('overlay').set('class', overlayClass);
            if (content) {
                $('overlay_content').innerHTML = content;
            }
            fading = false;
            //return;
        }
        Payment.overlayOpen = true;

        if (fading) $('overlayer').set('opacity','.0');
        $('overlayer').style.height = Payment.windowSize[5]+"px";
        $('overlayer').style.width = Payment.windowSize[4]+"px";

        //alert(Payment.windowSize[5] + " " + Payment.windowSize[4]);

        if (fading) Util.fadeIn('overlayer',0.0,0.7,500);
        if (fading) $('overlay').set('opacity','.0');
        $('overlay').style.display='block';
        $('overlay').setStyle('visibility', '');
        $('overlay').set('class', overlayClass);

        // falls content schon vorgesetzt beim seitenladen,
        //dann nicht den content neu setzen
        if (typeof(content) !== 'undefined') {
            if (content !== false) {
                $('overlay_content').innerHTML = content; //o.overlayHTML;
            }
        }

        var overlay = new Overlay(content);
        overlay.execPostActions();

        $('toolTipLayer').style.display = 'none';

        if (fading) Util.fadeIn('overlay',0.0,1.0,500);
    },

    /* Hides the lightbox overlay */
    disableOverlay: function(reloadCart) {
        if(Payment.overlayOpen === false) return;
        Payment.overlayOpen = false;
        Util.fadeOut('overlayer', 0.7, 0.0, 500);
        Util.fadeOut('overlay', 1.0, 0.0, 500);
        $('overlay').setStyle('visibility', 'hidden');
        Payment.updateStep(1);
        if(reloadCart && !Payment.cartElements.length) {
            Payment.reloadCart();
        }
    },

    /*
     * search for a non showDirectOverlay item(not sms, phone,...) with
     * same itemID and return fullItemID
     */
    getFullItemId: function(items, itemID) {
        found = false;
        for (var itemGroup in items) {
            for (var item in items[itemGroup].items) {
                if ( items[itemGroup].items[item] &&
                    !items[itemGroup].items[item].showDirectOverlay &&
                     items[itemGroup].items[item].id == itemID
                ) {
                    found = itemID + "_" +
                        items[itemGroup].items[item].itemID;
                    if (!itemlistElements.has(itemID)) {
                        Payment.updateItemGroup(itemGroup);
                    }
                    break;
                }
            }
            if (found) {
                break;
            }
        }
        return found;
    },


    reloadCart: function() {
        var items = getItems();
        Util.apiRequest('gameapi.jsonCatchShoppingCart',{'result': 'OK'},
            function(o) {
                if (o && o.result == 'OK' && o.items && o.items.length) {
                    for (i=0; i< o.items.length; i++) {
                        var fullItemId = Payment.getFullItemId(items, o.items[i]);
                        Payment.addToCart(fullItemId);
                    }
                }
            }
        );
    },

    /* Slides the offers to the left / right */
    moveOffers: function(direction) {
        if(Payment.moving) return;
        Payment.moving = true;

        /* arabian payment */
        if (getCssDir() == "_rtl") {
           if (direction == "next") {
              direction = "prev";
           } else if (direction == "prev") {
              direction = "next";
           }
        }


        if (getCssDir() == "_rtl") {
            var left = parseInt($('offerItems').style.marginRight);
        } else {
            var left = parseInt($('offerItems').style.marginLeft);
        }
        if(!left) left = 0;
        $('offerItems').get('morph').removeEvents('complete');
        $('offerItems').set('morph', {onComplete: function() {Payment.moving = false;}});
        switch(direction) {
            case 'next':
                if (Payment.offerPage + 1 > Payment.offerPages) {
                    Payment.moving = false;
                    return;
                }
                if (getCssDir() == "_rtl") {
                    $('offerItems').morph({marginRight: parseInt(left - 348)});
                } else {
                    $('offerItems').morph({marginLeft: (left - 348)});
                }
                Payment.offerPage++;
            break;

            case 'prev':
                if(Payment.offerPage - 1 < 0) {
                    Payment.moving = false;
                    return;
                }
                if (getCssDir() == "_rtl") {
                    $('offerItems').morph({marginRight: parseInt(left + 348)});
                } else {
                    $('offerItems').morph({marginLeft: (left + 348)});
                }
                Payment.offerPage--;
            break;
        }
    },

    /* Slides the payment methods up / down */
    moveMethods: function(direction) {
        if(Payment.moving) return;
        Payment.moving = true;
        var top = parseInt($('paymentMethods').style.marginTop);
        if(!top) top = 0;

        $('paymentMethods').get('morph').removeEvents('complete');
        $('paymentMethods').set('morph', {onComplete: function() {Payment.moving = false;}});
        switch(direction) {
            case 'next':
                if (Payment.methodPage + 1 > Payment.methodPages) {
                    Payment.moving = false;
                    return;
                }
                $('paymentMethods').morph({marginTop: (top - 140)});
                Payment.methodPage++;
            break;

            case 'prev':
                if(Payment.methodPage - 1 < 0) {
                    Payment.moving = false;
                    return;
                }
                $('paymentMethods').morph({marginTop: (top + 140)});
                Payment.methodPage--;
            break;
        }
    },

    /* Array of CartElement objects for use with the cart-total calculation */
    cartElements: [],

    /* Array of CartElement objects for use group list */
    itemlistElements: null,

    /* Cart element counter for use with the cart-total calculation */
    counter: 0,

    /* Adds a new cart element, shows payment methods automatically when cart is full */
    addToCart: function(itemID) {
        if (Payment.counter >= getShoppingCartSize()) {
            Payment.showAdditionalOverlay('error', 'ShoppingCartSize');
            Tracking.fullShoppingCart(itemID);
            return; //+ maybe a scrollbar would be more sufficient than a full cart?
        }
//        if (Payment.counter >= (getShoppingCartSize()-1)) {
//            Payment.requestMethods();
//        }

        // search cartElement
        if (itemlistElements.has(itemID)) {
            var cartElement = itemlistElements.get(itemID);

            var pushIt = true;
            if (cartElement.limitByUser > 0) {

                filteredItem = Payment.cartElements.filter(function(item, index){
                    return (item.itemID == this.id);
                }, cartElement);

                if (filteredItem.length >= cartElement.limitByUser) {
                    pushIt = false;
                }
            }

            if (pushIt) {
                Payment.cartElements.push(
                    new Payment.CartElement(
                        cartElement
                    )
                );
                /*
                 * the first time an item is added to the cart we must build the
                 * paymentMethods so to be able to call sort method correctly
                 */
                if (!Payment.paymentMethods.length) {
                    Payment.fastPayData = getAccounts().fastPayData;
                    Payment.buildPaymentMethods(Payment.paymentAccounts, Payment.fastPayData, false);
                }
                this.calcSums('add');
                Tracking.addItemToShoppingCart(itemID)
            }
        }

        if (Payment.counter >= (getShoppingCartSize())) {
            Payment.requestMethods();
        }

        if (Payment.methodOpen === true) {
            Payment.checkFastPay();
        } else {
            //set another onClick action and text if direct purchase
            if (Payment.paymentAccounts.length == 1) {
                $('checkoutButton').removeEvents('click');
                $('checkoutButton').addEvent('click', function(){ Payment.handlePayment(Payment.paymentAccounts[0]['id']); });
                $('checkoutButtonCheckout').style.display = 'none';
                $('checkoutButtonPurchase').style.display = 'block';
            }
            if ($('checkoutButton').style.display != 'block') {
                Util.fadeIn('checkoutButton', 0.0, 1.0, 500);
            }
        }
    },

    /* CartElement object, containing price and discount of a cart element */
    CartElement: function(selectedItem) {
        var self = this;
        this.id = Payment.cartElements.length;
        this.itemID = selectedItem.id;
        this.price = Util.parseFloat(selectedItem.actualPrice);
        this.discount = Util.parseFloat(selectedItem.fullPrice) - this.actualPrice;
        this.shoppingCartPrice = selectedItem.shoppingCartPrice;
        this.shoppingCartFullPrice = selectedItem.shoppingCartFullPrice;
        this.selectedItem = item;
        var icon = new Element('div', {'class':'cartItemSmallIcon','style':'background-image:url('+selectedItem.shoppingCartIcon+')'});
        var description = new Element('div',{'class':'cartItemDescription','html':selectedItem.description});
        var deleteBtn = new Element('div',{'class':'cartItemDeleteButton','events': {'click':function(){Payment.removeFromCart(self.id)}}});
        var price = new Element('div',{'class':'cartItemPrice','html':selectedItem.actualPrice});
        var discount = new Element('div',{'class':'cartItemDiscount','html':selectedItem.fullPrice});
        var clear = new Element('div',{'class':'clear'});
        var item = new Element('div',{'id':'cartElement_'+this.id,'class':'shoppingCartItem','style':'opacity:0;'});
        item.adopt(icon,description,deleteBtn,price,discount,clear);
        this.item = item;
        //item.setStyle('visibility', 'hidden');
        $('shoppingCartItems').adopt(item);

        // IE 6 & 7 somehow mess up the opacity set in the new Element code, so here you go
        item.setStyle('opacity', '0');

        Util.fadeIn(item.id, 0.0, 1.0, 500);

        this.remove = function() {
            Util.fadeOut(this.item.id, 1.0, 0.0, 500, function() { self.item.destroy(); Payment.moving = false; });
        }
    },

    Item: function(item) {
        var self = this;
        this.item = item;
        this.id = item.id;
        this.description = item.title;
        this.fullPrice = item.fullPrice;
        this.actualPrice = item.actualPrice;
        this.shoppingCartIcon = item.shoppingCartIcon;
        this.shoppingCartPrice = item.shoppingCartPrice;
        this.shoppingCartFullPrice = item.shoppingCartFullPrice;
        this.limitByUser = item.limitByUser;
    },

    handlePayment: function(accountID, cartFromSession) {
        //if($('paymentMethods').innerHTML !== '') return;
        var cartIDs=[];
        Payment.cartElements.each(
            function(item) {
                try {
                    cartIDs.push(item.itemID);
                } catch (err) {}
            }
        );
        // fix against popup blocker
        if (Payment.paymentAccounts) {
            Payment.paymentAccounts.each(
                function(account) {
                    if (account.id == accountID) {
                        if (account.popup && !account.recurring) {
                            HandlePayment.preOpenExternalWindow();
                        }
                    }
                }
            );
        }

        Util.apiRequest('gameapi.jsonHandlePayment',{'accountID': accountID, 'itemIDs': cartIDs, 'cartFromSession': cartFromSession},
            function(o) {
                if (o.result != 'OK') {
                    Payment.showAdditionalOverlay('error', o.result);
                    return;
                }
                if (o.popup && !o.recurring) {
                    HandlePayment.preOpenExternalWindow();
                }
                if (o.overlayHTML) {
                    var overlay = new Overlay(o.overlayHTML);
                    var overlayClass = overlay.getCssClass();
                    overlay.execActions();

                    Payment.updateStep(2);
                    Payment.enableOverlay(o.overlayHTML, overlayClass);
                }
                if (o.callback && o.callback.object && o.callback.method && o.callback.parameter) {
                    var objectname = o.callback.object;
                    var methodname = o.callback.method;
                    var parameters = o.callback.parameter;

                    // ausnutzen, dass alle alle methoden zum
                    // window-object gehoeren!
                    window[objectname][methodname](parameters);
                }
            }
        );

    },

    reloadHandlePayment: function(accountID, params) {
        params['accountID'] = accountID;
        Util.apiRequest('gameapi.jsonHandlePayment', params,
            function(o) {
                if (o.result != 'OK') {
                    Payment.showAdditionalOverlay('error', o.result);
                    return;
                }
                if (o.overlayHTML) {
                    var overlay = new Overlay(o.overlayHTML);
                    var overlayClass = overlay.getCssClass();
                    overlay.execActions();
                    Payment.enableOverlay(o.overlayHTML, overlayClass);
                    Payment.unsetWaitingScreen();
                }
                if (o.callback && o.callback.object && o.callback.method && o.callback.parameter) {
                    var objectname = o.callback.object;
                    var methodname = o.callback.method;
                    var parameters = o.callback.parameter;

                    // ausnutzen, dass alle alle methoden zum
                    // window-object gehoeren!
                    window[objectname][methodname](parameters);
                }
            }
        );
    },

    /* Array of Accounts during special account handling */
    allowedAccounts: [],
    restrictedAccounts: [],

    InArray: function (array, search) {

        var rtrn = false;
        var zaehler = 0;

        if (array != '' && search != '')
        {
            for(zaehler = 0; zaehler < array.length; zaehler++)
            {
                if(array[zaehler] == search)
                {
                    rtrn = true;
                    return rtrn;
                } else
                {
                    rtrn = false;
                }
            }
        } else
        {
            rtrn = false;
        }
        return rtrn;
    },

    /* PaymentOption object, containing min and max price value available for a certain method */
    PaymentOption: function(accountID, element, min, max, fix, enabledPicture, disabledPicture, order) {
        this.accountID = accountID;
        this.element = $(element);
        this.min = min;
        this.max = max;
        this.fix = fix;
        this.order = order;
        this.onclickBackup = this.element.onclick;

        this.check = function(price, currency) {
            var enable = false;
            currency = Payment.restoreCurrencyString(currency);

            if (this.fix && this.fix.length > 0) {
                for(var i=0; i<this.fix.length; i++) {
                    if (this.fix[i].price == price &&  this.fix[i].currency == currency) {
                        enable = true;
                        break;
                    }
                }

            } else if(price < this.min || (price > this.max && this.max !== -1)) {
                enable = false;
            } else {
                enable = true;
            }

            if (Payment.restrictedAccounts.length > 0 && Payment.InArray(Payment.restrictedAccounts, this.accountID)) {
                enable = false;
            }

            if (enable) {
                this.element.style.cursor = 'pointer';
                this.element.removeClass('methodItemInactive');
                this.element.addClass('methodItem');
                this.element.onclick = this.onclickBackup;
                $('paymentMethodIcon_'+this.accountID).setStyle(
                    'background-image', 'url('+enabledPicture+')');

                //for FastPay
                if ($('FastPay_'+this.accountID)) {
                    if ($('FastPay_'+this.accountID).disabled !== false) {
                        $('FastPay_'+this.accountID).disabled = false;
                        Payment.checkFastPayOrder();
                    }
                }
            } else {
                this.element.style.cursor = 'default';
                this.element.removeClass('methodItem');
                this.element.addClass('methodItemInactive');
                this.element.onclick = null;
                $('paymentMethodIcon_'+this.accountID).setStyle(
                    'background-image', 'url('+disabledPicture+')');

                //for FastPay
                if ($('FastPay_'+this.accountID)) {
                    if ($('FastPay_'+this.accountID).disabled !== true) {
                        $('FastPay_'+this.accountID).disabled = true;
                        if (Payment.selectedFastPayMethod == 'FastPay_'+this.accountID) {
                            Payment.selectedFastPayMethod = false;
                        }
                        Payment.checkFastPayOrder();
                    }
                }
            }
            return enable;
        }
    },

    checkFastPayOrder: function() {
        var radio = document.getElementsByName("transactionId");
        for (var i=0;radio[i];i++) {
            if (
                radio[i].disabled != true
                && (
                    (Payment.selectedFastPayMethod != false && Payment.selectedFastPayMethod == radio[i].id)
                    || (Payment.selectedFastPayMethod == false && radio[i].checked)
                )
            ) {
                Payment.selectedFastPayMethod = radio[i].id;
                radio[i].checked = true;
            } else {
                radio[i].checked = false;
            }
        }

    },

    setCloseIe6Info: function(nr) {

        Util.apiRequest('gameapi.jsonCloseIe6Info', nr,
            function(o) {}
        );
    },

    setCloseMinorUserInfo: function(nr) {

        Util.apiRequest('gameapi.jsonCloseMinorUserInfo', nr,
            function(o) {}
        );
    },

    setCloseAbortsInfo: function(nr) {

        Util.apiRequest('gameapi.jsonCloseAbortsInfo', nr,
            function(o) {}
        );
    },

    /* Removes item nr. (nr) from the cart */
    checkFastPay: function() {

        if (Payment.fastPayData) {

            var radio = document.getElementsByName("transactionId");
            var count = 0;

            if (radio.length > 0) {

                for(var i=0;radio[i];i++) {
                    count = count + 1;
                }

               if (Payment.fastPayStatus) {
                    if (count == 0) {
                        Payment.buildPaymentMethods(Payment.paymentAccounts, Payment.fastPayData, false);
                        Payment.checkPayments();
                    }
                } else {
                    Payment.buildPaymentMethods(Payment.paymentAccounts, Payment.fastPayData, true);
                    Payment.checkPayments();
                }
            }
        }
    },

    /* Removes item nr. (nr) from the cart */
    removeFromCart: function(nr) {
        if(Payment.moving) return;
        Payment.moving = true;
        Payment.cartElements[nr].remove();
        delete Payment.cartElements[nr];
        this.calcSums('remove');
        Tracking.deleteItemFromShoppingCart(nr);

        if (Payment.methodOpen === true) {
            Payment.checkFastPay();
            Util.fadeOut('checkoutButton', 1.0, 0.0, 500);
        } else {
            if (Payment.counter == 0) {
                Util.fadeOut('checkoutButton', 1.0, 0.0, 500);
            }
        }
    },

    checkPayments: function() {
        var priceOverall = 0;
        var discountOverall = 0;

        Payment.cartElements.each(function(item, index){
            try {
                if(item.shoppingCartPrice) priceOverall += item.shoppingCartPrice; //item.price;
                if(item.shoppingCartFullPrice) discountOverall += (item.shoppingCartFullPrice); // - item.shoppingCartPrice
            } catch (err) {}
        });

        priceOverall = priceOverall.toFixed(2);

        for(var i=0; i<Payment.paymentMethods.length; i++) {
            Payment.paymentMethods[i].check(priceOverall, getShoppingCartCurrency());
        }

        Payment.afterCheck($('paymentMethods').getChildren('div'));
    },

    checkVoucherSmsPhone: function() {
       if (Payment.allowedAccounts.length > 0 || Payment.restrictedAccounts.length > 0) {
           for(var i = 0; i < Payment.maxRows; i++) {
               if ((Payment.allowedAccounts.length > 0 && !Payment.InArray(Payment.allowedAccounts, "sms")) || Payment.InArray(Payment.restrictedAccounts, "sms")) {
                   if ($('sms_'+i)) $('sms_'+i).setStyle('display', 'none');
                  }
               if ((Payment.allowedAccounts.length > 0 && !Payment.InArray(Payment.allowedAccounts, "phone")) || Payment.InArray(Payment.restrictedAccounts, "phone")) {
                   if ($('phone_'+i)) $('phone_'+i).setStyle('display', 'none');
                  }
           }
        }
    },

    showVoucherSmsPhone: function() {
       for(var i = 0; i < Payment.maxRows; i++) {
           if ($('sms_'+i)) $('sms_'+i).removeProperties('style');
           if ($('phone_'+i)) $('phone_'+i).removeProperties('style');
       }
    },

    /* Calculates cart total and cart total discounts */
    calcSums: function(action) {
        var priceOverall = 0;
        var discountOverall = 0;

        if(action == 'add') Payment.counter += 1;
        if(action == 'remove') Payment.counter -= 1;



        Payment.cartElements.each(function(item, index){
            try {
                if(item.shoppingCartPrice) {
                    priceOverall += item.shoppingCartPrice; //item.price;
                }
                if(item.shoppingCartFullPrice) {
                    discountOverall += (item.shoppingCartFullPrice) ;// - item.shoppingCartPrice);
                } else {
                    discountOverall += item.shoppingCartPrice;
                }
            } catch (err) {}
        });

        if(Payment.counter <= 0) {
            if(Payment.methodOpen === true) {
                Payment.methodOpen = false;
                Payment.hideMethods();
            }
        }

        setPriceInElement(priceOverall, getShoppingCartCurrency(), $('cartTotal'));
        $('cartTotalPay').value=priceOverall;
        if (discountOverall > 0 && priceOverall != discountOverall) {
            $('cartSaved').setStyle('display', 'inline');
            setPriceInElement(discountOverall, getShoppingCartCurrency(), $('cartSaved'));
        } else {
            $('cartSaved').setStyle('display', 'none');
        }
        for(var i=0; i<Payment.paymentMethods.length; i++) {
            Payment.paymentMethods[i].check(priceOverall, getShoppingCartCurrency());
        }

        Payment.priceEventListener.throwEvent(new EventPriceChange(getShoppingCartCurrency(), priceOverall));

        Payment.sortMethods(Payment.paymentMethods, priceOverall, getShoppingCartCurrency());
    },


    /* Fades in payment methods */
    requestMethods: function() {
        if(Payment.counter >= 0 && Payment.paymentAccounts.length > 1) {
            if(Payment.methodOpen === true) return;

            Payment.methodOpen = true;
            Payment.checkFastPay();
            if($('paymentMethods').innerHTML != '') {
                Payment.displayMethods();
            } else {
                // get all itemids for tracking
                var itemids = new Array();
                for (var i=0; i<Payment.cartElements.length; i++) {
                    if (Payment.cartElements[i]) {
                        itemids.push(Payment.cartElements[i]['itemID']);
                    }
                }

                Payment.setWaitingScreen($('paymentMethodsContent'));
                Util.apiRequest('gameapi.jsonShoppingCartEval',{'items':itemids},
                    function(o)    {
                        Payment.handleMethodObject(o);
                        Payment.displayMethods();
                        Payment.calcSums();
                        Payment.unsetWaitingScreen();
                    }
                );
            }
        }
    },

    handleMethodObject: function(o) {
        Payment.paymentAccounts = o.accounts;
        Payment.fastPayData = o.fastPayData;
        Payment.buildPaymentMethods(o.accounts, o.fastPayData, false);
    },

    buildPaymentMethods: function(accounts, fastPayData, fastPayOn) {

        function downBtn() {
            var elem = new Element('div',{
                'class':'methodItem'
            }).adopt( new Element('span', {
                'class':'methodItemMoveNextText',
                'html':Payment.lang.get('moreMethods')
            }));
            elem.addClass('methodItemButtonDown');
            elem.onclick = function() {
                Payment.moveMethods('next');
            }
            return elem;
        }
        function upBtn() {
            var elem = new Element('div',{
                'class':'methodItem'
            }).adopt( new Element('span', {
                'class':'methodItemMovePrevText',
                'html':Payment.lang.get('prevMethods')
            }));
            elem.addClass('methodItemButtonUp');

            elem.onclick = function() {
                Payment.moveMethods('prev');
            }
            return elem;
        }
        /*function easyClick() {
            var elem = new Element('div',{
                'id':'paymentMethodIcon_easyClick',
                'class':'methodItem'
            }).adopt( new Element('span', {
                'class':'methodItemBottomText',
                'html':Payment.lang.get('easyClick')
            })).adopt( new Element('div', {
                'class':'methodItemIcon methodItemEasyClick',
            }));

            elem.onclick = function() {
                //Payment.showAdditionalOverlay('easyclickRegister');
                Payment.showAdditionalOverlay('easyclickBuy');
            }

            //new ToolTipper('paymentMethodIcon_easyClick', Payment.lang.get('easyClickDesc'));

            return elem;
        }*/
        function fastPay() {
            var elem = new Element('div',{
                'id':'paymentMethodIcon_fastPay',
                'class':'methodItemFastPayBox'
            });
            return elem;
        }
        function downBtnExtra() {
            var elem = new Element('div',{
                'id':'paymentBtn_fastPay',
                'class':'methodItemExtra'
            }).adopt( new Element('span', {
                'class':'methodItemMoveNextText',
                'html':Payment.lang.get('moreMethods')
            }));
            elem.addClass('methodItemButtonDown');
            elem.onclick = function() {
                Payment.moveMethods('next');
            }
            return elem;
        }

        var fastpay = (((Payment.fastPayData)) ? true : false);
        var cnt = 1;
        var iterate = getMethodBoxSize();
        Payment.paymentMethods = [];
        $('paymentMethods').innerHTML = "";

        if (fastpay && !fastPayOn) {
            if ($('paymentMethodIcon_fastPay')) {
                $('fastPayStorer').innerHTML = $('paymentMethodIcon_fastPay').innerHTML;
            } else {
                Util.apiRequest('gameapi.jsonAdditionalAction',{'action': 'fastPay', 'parameters': fastPayData},
                    function(o) {
                        if (o.overlayHTML) {
                            $('fastPayStorer').innerHTML = o.overlayHTML;
                            Payment.checkPayments();
                            Payment.checkFastPay();
                            Payment.checkFastPayOrder();
                        }
                    }
                );

            }

            Payment.fastPayStatus = false;
        } else {
            var priceOverall = 0;
            var discountOverall = 0;
            var increasePage = false;
            Payment.cartElements.each(function(item, index){
                try {
                    if(item.shoppingCartPrice) priceOverall += item.shoppingCartPrice; //item.price;
                    if(item.shoppingCartFullPrice) discountOverall += (item.shoppingCartFullPrice); // - item.shoppingCartPrice
                } catch (err) {}
            });

            priceOverall = priceOverall.toFixed(2);
            Payment.methodPages = 1;
            accounts.each(
                function(item, index) {

                    var pMethod = new Element('div',{
                        'class':'methodItem',
                        'id':'paymentMethod_'+item.id
                    });

                    pMethod.onclick = function() {
                        /*if (item.popup) {
                            HandlePayment.preOpenExternalWindow();
                        }*/
                        Payment.handlePayment(item.id);
                    }

                    var pText  = new Element('span',{'class':'methodItemBottomText','html':item.label});
                    var pIcon  = new Element('div',{'id':'paymentMethodIcon_'+item.id, 'class':'methodItemIcon', 'style':'background-image:url('+item.icon+')'});
                    var pBonus = null;

                    if (item.bonusRate && item.bonusRate != '') {
                        pBonus = new Element('div',{'id':'paymentMethodBonus_'+item.id, 'class':'paymentMethodBonus', 'style':'background-image: url('+item.imageUrl+');', 'html':''});
                    }

                    pIcon.adopt(pText);
                    if (pBonus) {
                        pIcon.adopt(pBonus);
                    }
                    pMethod.adopt(pIcon);
                    /*if(easy == true && o.isEasyClick) {
                        $('paymentMethods').adopt(easyClick());
                        easy = false;
                        cnt++;
                        new ToolTipper('paymentMethodIcon_easyClick', Payment.lang.get('easyClickDesc'));
                    } else*/

                    if (fastpay && fastPayData != false) {
                        if (getMethodBoxSize() < 8) {
                            $('paymentMethods').adopt(fastPay(), upBtn());
                        } else {
                            $('paymentMethods').adopt(fastPay(), downBtnExtra(), upBtn());
                        }

                        if ($('fastPayStorer').innerHTML == "") {
                            Util.apiRequest('gameapi.jsonAdditionalAction',{'action': 'fastPay', 'parameters': fastPayData},
                                function(o) {
                                    if (o.overlayHTML) {
                                        $('paymentMethodIcon_fastPay').innerHTML = o.overlayHTML;
                                        Payment.checkPayments();
                                        Payment.checkFastPay();
                                        Payment.checkFastPayOrder();
                                    }
                                }
                            );
                        } else {
                            $('paymentMethodIcon_fastPay').innerHTML = $('fastPayStorer').innerHTML;
                        }

                        new ToolTipper('paymentMethodIcon_fastPay', $('fastPayHelpText').value);
                        new ToolTipper('fastPayBonusText', $('fastPayInfoToolTipText').value);

                        fastpay = false;
                        Payment.fastPayStatus = true;
                        cnt++;
                        increasePage = false;
                        //iterate=8;
                    } else if(cnt % iterate == 0) {
                        $('paymentMethods').adopt(downBtn(), upBtn());
                        increasePage = true;
                        cnt = 0;
                        iterate = getMethodBoxSize()-2;
                    }
                    $('paymentMethods').adopt(pMethod);
                    var paymentOption = new Payment.PaymentOption(item.id, pMethod.id,item.priceStart, item.priceEnd, item.priceFix, item.icon, item.iconDisabled, item.order);
                    if (paymentOption.check(priceOverall, getShoppingCartCurrency())) {
                        cnt++;
                        if (increasePage) {
                            Payment.methodPages++;
                            increasePage = false;
                        }
                    }
                    Payment.paymentMethods.push(paymentOption);
                    new ToolTipper(pMethod.id, item.description);
                }
            );
            if (Payment.methodPages > 1 && Payment.methodPage > Payment.methodPages) {
                Payment.moving = false;
                Payment.moveMethods('prev');
            }
        }
    },

    displayMethods: function() {
        if (Payment.paymentAccounts.length > 1 ) {
            Payment.updateStep(1);
            Util.fadeIn('paymentMethodsBox', 0.0, 1.0, 500);
            Util.fadeOut('checkoutButton', 1.0, 0.0, 500);
            Tracking.showPaymentmethodList();
        }
    },

    hideMethods: function() {
        Payment.updateStep(0);
        Util.fadeOut('paymentMethodsBox', 1.0, 0.0, 500);
    },

    sortAccounts: function(accounts, helper) {
        for (var j=0; j<accounts.length-1; j++) {
            var ordered = true;
            for(var i=0; i<accounts.length-1; i++) {
                if (helper(accounts[i], accounts[i+1])== 1) {
                    app = accounts[i];
                    accounts[i] = accounts[i+1];
                    accounts[i+1] = app;
                    ordered = false;
                }
            }
            if (ordered) {
                j = accounts.length;
            }
        }
    },

    sortMethods: function(methods, priceOverall, getShoppingCartCurrency) {
        if (Payment.paymentAccounts) {
            Payment.sortAccounts(
                Payment.paymentAccounts, Payment.sortMethodsHelper
            );
            Payment.fastPayData = getAccounts().fastPayData;
            Payment.buildPaymentMethods(Payment.paymentAccounts, Payment.fastPayData, false);

            for(var i=0; i<Payment.paymentMethods.length; i++) {
                Payment.paymentMethods[i].check(priceOverall, getShoppingCartCurrency);
            }

            Payment.afterCheck($('paymentMethods').getChildren('div'));
        }
    },

    //after check, remove eventual ending up/down arrows
    afterCheck: function(paymentMethods) {
        var index = paymentMethods.length-1;
        while (
            paymentMethods[index] && (
                paymentMethods[index].hasClass('methodItemInactive') ||
                paymentMethods[index].hasClass('methodItemButtonUp') ||
                paymentMethods[index].hasClass('methodItemButtonDown')
            )
        ) {
            paymentMethods[index].set('class', 'methodItemInactive');
            index--;
        }
    },

    // check if class is  enabled and check order of account
    sortMethodsHelper: function(a, b) {

        var aId = 'paymentMethod_'+a.id;
        var bId = 'paymentMethod_'+b.id;
        var aEnabled = Payment.isMethodElementEnabled(aId);
        var bEnabled = Payment.isMethodElementEnabled(bId);

        if (aEnabled && !bEnabled) {
            return -1;
        } else if (!aEnabled && bEnabled) {
            return 1;
        } else {
            if (a.order == b.order) return 0;
            return (parseInt(a.order) > parseInt(b.order)) ? 1 : 0;
        }
    },

    isMethodElementEnabled: function(elementId) {
        if ($(elementId)) {
            return (!$(elementId).hasClass('methodItemInactive'));
        } else {
            return false;
        }
    },

    showDirectOverlay: function(itemID, accountIDs, preopenPopup) {
        if (preopenPopup) {
            HandlePayment.preOpenExternalWindow();
        }

        Util.apiRequest('gameapi.jsonDirectOverlay',{'itemID':itemID, 'accountIDs':accountIDs},
                function(o)    {
                    var overlay = new Overlay(o.overlayHTML);
                    var overlayClass = overlay.getCssClass();
                    overlay.execActions();
                    Payment.enableOverlay(o.overlayHTML, overlayClass);


                    if (o.callback && o.callback.object && o.callback.method && o.callback.parameter) {
                        var objectname = o.callback.object;
                        var methodname = o.callback.method;
                        var parameters = o.callback.parameter;

                        // ausnutzen, dass alle alle methoden zum
                        // window-object gehoeren!
                        window[objectname][methodname](parameters);
                    }
                }
            );
    },

    reloadDirectOverlay: function(itemID, accountIDs, params) {
        //Payment.disableOverlay();
        params['itemID'] = itemID;
        params['accountIDs'] = accountIDs;
        Util.apiRequest('gameapi.jsonDirectOverlay',params,
                function(o) {
                    var overlay = new Overlay(o.overlayHTML);
                    var overlayClass = overlay.getCssClass();
                    overlay.execActions();
                    Payment.enableOverlay(o.overlayHTML, overlayClass);

                    if (o.callback && o.callback.object && o.callback.method && o.callback.parameter) {
                        var objectname = o.callback.object;
                        var methodname = o.callback.method;
                        var parameters = o.callback.parameter;

                        // ausnutzen, dass alle alle methoden zum
                        // window-object gehoeren!
                        window[objectname][methodname](parameters);
                    }
                }
            );
    },

    showDirectOverlaySelection: function(itemID, methodType) {
        var params = new Object();
        params['itemID'] = itemID;
        params['shoppingCartType'] = methodType;
        Util.apiRequest('gameapi.jsonDirectOverlaySelection',params,
            function(o) {
                var overlay = new Overlay(o.overlayHTML);
                var overlayClass = overlay.getCssClass();
                overlay.execActions();
                Payment.enableOverlay(o.overlayHTML, overlayClass);
                if (o.callback && o.callback.object && o.callback.method && o.callback.parameter) {
                    var objectname = o.callback.object;
                    var methodname = o.callback.method;
                    var parameters = o.callback.parameter;
                    // ausnutzen, dass alle alle methoden zum
                    // window-object gehoeren!
                    window[objectname][methodname](parameters);
                }
            }
        );
    },

    setFastpayPercentage: function(percentage) {
        if (percentage > 0) {
            var text = $('fastPayInfoText').innerHTML;
            $('fastPayHelpText').value = $('fastPayHelpTextBackup').value;
            $('fastPayInfoToolTipText').value = $('fastPayHelpTextBackup').value;

            $('fastPayBonusText').style.visibility="";
            $('fastPayInfoText').innerHTML = text.substring(0, text.indexOf(" ") + 1)
                + percentage + text.substring(text.indexOf("%"));
        } else {
            $('fastPayHelpText').value='';
            $('fastPayInfoToolTipText').value ='';
            $('fastPayBonusText').style.visibility="hidden";
        }

        new ToolTipper('fastPayBonusText', $('fastPayInfoToolTipText').value);
        new ToolTipper('paymentMethodIcon_fastPay', $('fastPayHelpText').value);
        $('toolTipLayer').style.display = 'none';
    },

    setSelectedFastPayMethod: function(accountId) {
         Payment.selectedFastPayMethod = 'FastPay_' + accountId;
    },

    submitFastpay: function() {
        if (Payment.selectedFastPayMethod != false && $(Payment.selectedFastPayMethod).disabled != true) {
            Payment.setWaitingScreen($('paymentMethodIcon_fastPay'), true);
            $('accountID').value = HandlePayment.fastPayGetAccount();
            AjaxFormHandler.showAdditionalOverlayWithItems('fastPay', $('frm_fastpay'));
        }
    },

    doCallBack: function(callback) {
        var objectname = callback.object;
        var methodname = callback.method;
        var parameters = callback.parameter;

        // ausnutzen, dass alle alle methoden zum
        // window-object gehoeren!
        window[objectname][methodname](parameters);
    },

    showAdditionalOverlay: function(action, params) {
        Util.apiRequest('gameapi.jsonAdditionalAction',{'action': action, 'parameters': params},
            function(o) {
                if (o.overlayHTML) {

                    var overlay = new Overlay(o.overlayHTML);
                    var overlayClass = overlay.getCssClass();
                    overlay.execActions();

                    Payment.enableOverlay(o.overlayHTML, overlayClass);
                    Payment.unsetWaitingScreen();
                }
                if (o.callback && ((o.callback.object && o.callback.method && o.callback.parameter) || o.callback.more)) {
                    //special for more than one fallback action
                    if (o.callback.more) {
                        for(var i=0; i<o.callback.more.length; i++) {
                            Payment.doCallBack(o.callback.more[i]);
                        }
                    } else {
                        Payment.doCallBack(o.callback);
                    }

                }
            }
        );
    },

    /*+ Quick'n'Dirtily advances one page  */
    advanceStep: function() {
        $('overlay_page_0').get('morph').removeEvents('complete');
        $('overlay_page_0').set('morph', {onComplete: function() { $('overlay_page_0').style.display="none"; $('overlay_page_1').style.display="block"; $('overlay_page_1').morph({opacity:[0,1]}) }});
        $('overlay_page_0').morph({opacity:[1,0]});
        $('overlay').morph({height:[438,337]});
    },

    closeOverlayEmbedded: function() {
        $('overlay_wait_embedded').style.display="none";
    },

    /*if enable = true => im div kann nichts mehr geklickt werden  */
    setWaitingScreen: function(element, enable, overlay) {
        var pos = element.getPosition();
        var size = element.getSize();

        if (overlay) {
            $('ajaxWaitingLayer').set('class', 'ajaxwaitingOverlay');
        } else {
            $('ajaxWaitingLayer').set('class', 'ajaxwaiting');
        }

        if (enable) {
            $('ajaxWaitingLayer').setStyle('width', size.x);
            $('ajaxWaitingLayer').setStyle('height', size.y);
        } else {
            $('ajaxWaitingLayer').setStyle('width', "");
            $('ajaxWaitingLayer').setStyle('height', "");
        }

        $('ajaxWaitingLayer').setStyle('display', 'block');

        var size2 = $('ajaxWaitingLayer').getSize();
        $('ajaxWaitingLayer').setPosition({
            x: pos.x + (size.x / 2) - (size2.x / 2),
            y: pos.y + (size.y / 2) - (size2.y / 2)
        });

    },

    unsetWaitingScreen: function() {
        $('ajaxWaitingLayer').setStyle('display', 'none');
    }

}

//window.onload = function(){
//    Payment.init();
//}

window.addEvent('domready', function() {
    Payment.init();
});