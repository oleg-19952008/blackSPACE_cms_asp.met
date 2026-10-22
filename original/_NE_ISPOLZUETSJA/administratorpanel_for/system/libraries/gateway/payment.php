<?php ?>

<html>
    <head>
        <title>Medianet Payment Gateway</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <link rel="stylesheet" type="text/css" href="includes/styles.css">
        <link rel="stylesheet" type="text/css" href="includes/embedded.css">



        <link rel="stylesheet" type="text/css" href="https://ssl.bpsecure.com/billing/images/embedded/22/styles.css?__cv=842cc827a6d2b1e5ca14ef7db4440300">



        <script src="./inc/mootools-core-1.4.5-full-compat.js?__cv=cc6d0a32fb1a4eb7327eca35e563a900" type="text/javascript"></script>
        <script src="./inc/mootools-more-1.4.0.1.js?__cv=7042abe9a50e685cea196b483c619e00" type="text/javascript"></script>

        <script src="./inc/script.js?__cv=bc78bd9dd19c649b9a72b88d62e94f00" type="text/javascript"></script>
        <script src="./inc/ActionListenerList.class.js?__cv=999ec27d869da1e83a0df30983868300" type="text/javascript"></script>
        <script src="./inc/EventPriceChange.class.js?__cv=af7ba96164db4eb436e1a2ca310fde00" type="text/javascript"></script>
        <script src="./inc/Payment.class.js?__cv=e2dd2cf9960b17be141392363e501200" type="text/javascript"></script>
        <script src="./inc/AfterPayment.class.js?__cv=d825e8549231285ebda5a3c687a1f600" type="text/javascript"></script>
        <script src="./inc/HandlePayment.class.js?__cv=3f256b0f0a6e88a78e4cf6586a196300" type="text/javascript"></script>
        <script src="./inc/AjaxFormHandler.class.js?__cv=579f1f66a8fc639656b223cf52e45100" type="text/javascript"></script>
        <script src="./inc/util.js?__cv=26dbdd01750770503eb3aa11b7ab4f00" type="text/javascript"></script>
        <script src="./inc/Resources.class.js?__cv=f6af19888af0d82d099cde8d8a480500" type="text/javascript"></script>
        <script src="./inc/Overlay.class.js?__cv=6efba5a329962674624669787367bd00" type="text/javascript"></script>
        <script src="./inc/ToolTipper.class.js?__cv=6b439f6a64d91bfa4f6f06a3780a1800" type="text/javascript"></script>
        <script src="./inc/NumberFormat.class.js?__cv=19a09624cad981bb2b2e03ed9438fa00" type="text/javascript"></script>
        <script src="./inc/Tracking.class.js?__cv=ac18891e566a876c54db13f10be43900" type="text/javascript"></script>

        <script type="text/javascript">

            function getLanguage() {
                return 'en';
            }

            function getCssDir() {
                return '';
            }

            function getSession() {
                return '';
            }

            function getRootURL() {
                return 'https://www.medianet.us/payment/';
            }

            function getShoppingCartCurrency() {
                return '€';
            }

            function getShoppingCartSize() {
                return 4;
            }

            function getMethodBoxSize() {
                return 8;
            }

            function getDefaultItemGroup() {
                return 2;
            }

            function isNotooltiphide() {
                return '';
            }

            function getPreselectedItems() {
                var result = new Array();
                Payment.paymentAccounts = getAccounts().accounts;


                return result;
            }

            function isDeeplinkPayment() {
                return 1;
            }

            function isHiddenGroupActive() {
                return '';
            }

            function isInitialPage() {
                return true;
            }

            function setPriceInElement(price, currency, element) {


                var decimals = 2;
                var base = "[currency][price]";
                var thousandSep = ",";
                var decimalSep = ".";


                //var price = price.toFixed(decimals);

                var num = new NumberFormat();
                num.setInputDecimal('.');
                num.setNumber(price); // obj.value is '-1000.247'
                num.setPlaces(decimals, false);
                num.setCurrencyValue('$');
                num.setCurrency(false);
                num.setCurrencyPosition(num.LEFT_OUTSIDE);
                num.setNegativeFormat(num.LEFT_DASH);
                num.setNegativeRed(false);
                num.setSeparators(true, thousandSep, decimalSep);
                price = num.toFormatted();

                element.innerHTML = base.replace(/\[price\]/g, price).replace(/\[currency\]/g, currency);
            }

            function getItems(itemgroup) {
                var items = JSON.decode('{"1":{"config":{"headline":"Uridium","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_1.gif?__cv=f3c986f35981b6b6bd4d5745ff964d00","order":19},"items":[{"id":"1_realCurrency_5000.0000_0_NONE","itemID":"5649","projectID":"168","title":"5,000 Uridium","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac1.99","selectionPrice":"\u20ac1.99","shoppingCartPrice":1.99,"shoppingCartFullPrice":"","price":"1.9900","currency":"EUR","type":"realCurrency","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"5000","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a31.63","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":1.99},{"id":"1_realCurrency_15000.0000_0_NONE","itemID":"1237","projectID":"168","title":"15,000 Uridium","fullPrice":"\u20ac5.97","savePercentage":"Save&nbsp;16%!","percentage":"Save 16%!","addToCartTooltip":"Add to cart","actualPrice":"\u20ac5.00","selectionPrice":"\u20ac5.00","shoppingCartPrice":5,"shoppingCartFullPrice":5.97,"price":"5.0000","currency":"EUR","type":"realCurrency","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"15000","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a34.11","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":5},{"id":"1_realCurrency_30000.0000_0_NONE","itemID":"256","projectID":"168","title":"30,000 Uridium","fullPrice":"\u20ac11.94","savePercentage":"Save&nbsp;16%!","percentage":"Save 16%!","addToCartTooltip":"Add to cart","actualPrice":"\u20ac10.00","selectionPrice":"\u20ac10.00","shoppingCartPrice":10,"shoppingCartFullPrice":11.94,"price":"10.0000","currency":"EUR","type":"realCurrency","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"30000","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a38.21","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":10},{"id":"1_realCurrency_75000.0000_0_NONE","itemID":"257","projectID":"168","title":"75,000 Uridium","fullPrice":"\u20ac29.85","savePercentage":"Save&nbsp;16%!","percentage":"Save 16%!","addToCartTooltip":"Add to cart","actualPrice":"\u20ac25.00","selectionPrice":"\u20ac25.00","shoppingCartPrice":25,"shoppingCartFullPrice":29.85,"price":"25.0000","currency":"EUR","type":"realCurrency","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"75000","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a320.54","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":25},{"id":"1_realCurrency_150000.0000_0_NONE","itemID":"258","projectID":"168","title":"150,000 Uridium","fullPrice":"\u20ac59.70","savePercentage":"Save&nbsp;18%!","percentage":"Save 18%!","addToCartTooltip":"Add to cart","actualPrice":"\u20ac49.00","selectionPrice":"\u20ac49.00","shoppingCartPrice":49,"shoppingCartFullPrice":59.7,"price":"49.0000","currency":"EUR","type":"realCurrency","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"150000","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a340.25","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":49},{"id":"1_realCurrency_330000.0000_0_NONE","itemID":"259","projectID":"168","title":"330,000 Uridium","fullPrice":"\u20ac131.34","savePercentage":"Save&nbsp;25%!","percentage":"Save 25%!","addToCartTooltip":"Add to cart","actualPrice":"\u20ac99.00","selectionPrice":"\u20ac99.00","shoppingCartPrice":99,"shoppingCartFullPrice":131.34,"price":"99.0000","currency":"EUR","type":"realCurrency","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"330000","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a381.32","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":99},{"id":"1_realCurrency_8500.0000_0_NONE","itemID":"8318","projectID":"168","title":"8,500 Uridium","fullPrice":"25.25 DKK","savePercentage":"Pay&nbsp;via&nbsp;cell&nbsp;phone","percentage":"","addToCartTooltip":"Pay via cell phone","actualPrice":"25.00 DKK","selectionPrice":"25.00 DKK","shoppingCartPrice":3.35,"shoppingCartFullPrice":3.38,"price":25,"currency":"DKK","type":"realCurrency","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"8500","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"sms","showDirectOverlay":true,"openPrePopup":false,"accountIDs":"3827","countById":1,"limitByUser":"0","nonSecOverlayItem":true,"localPrice":"\u00a32.75","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":3.35}]},"2":{"config":{"headline":"Premiums & Subscriptions","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_2.gif?__cv=685b71fce1fce5f5a503f97bd2e50900","order":29},"items":[{"id":"2_premium_1.0000_1_MONTHS","itemID":"26401","projectID":"168","title":"1 Month Premium","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20AC2.00","selectionPrice":"\u20AC2.00","shoppingCartPrice":2,"shoppingCartFullPrice":"","price":"2.0000","currency":"EUR","type":"premium","premiumType":"basic","interval":"1","intervalType":"MONTHS","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u20AC2.00","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":2}]},"17":{"config":{"headline":"Specials","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_17.gif?__cv=40cdb718515e8e654bda5dbd56320400","order":30},"items":[]},"3":{"config":{"headline":"Advantage Packs","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_3.gif?__cv=daa9ec248b0e57eae9ec5070df22aa00","order":39},"items":[]},"8":{"config":{"headline":"Ships","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_8.gif?__cv=4d1d4e318cc14437d69377cdaf4a6b00","order":40},"items":[{"id":"8_ship_goliath_1.0000_0_NONE","itemID":"56031","projectID":"168","title":"Goliath","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac14.99","selectionPrice":"\u20ac14.99","shoppingCartPrice":14.99,"shoppingCartFullPrice":"","price":"14.9900","currency":"EUR","type":"ship_goliath","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a312.31","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":14.99},{"id":"8_ship_vengeance_1.0000_0_NONE","itemID":"56044","projectID":"168","title":"Vengeance","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac5.99","selectionPrice":"\u20ac5.99","shoppingCartPrice":5.99,"shoppingCartFullPrice":"","price":"5.9900","currency":"EUR","type":"ship_vengeance","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"2","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a34.92","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":5.99},{"id":"8_ship_citadel_1.0000_0_NONE","itemID":"56057","projectID":"168","title":"Citadel","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac49.99","selectionPrice":"\u20ac49.99","shoppingCartPrice":49.99,"shoppingCartFullPrice":"","price":"49.9900","currency":"EUR","type":"ship_citadel","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"3","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a341.06","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":49.99},{"id":"8_ship_aegis_1.0000_0_NONE","itemID":"56070","projectID":"168","title":"Aegis","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac39.99","selectionPrice":"\u20ac39.99","shoppingCartPrice":39.99,"shoppingCartFullPrice":"","price":"39.9900","currency":"EUR","type":"ship_aegis","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"4","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a332.85","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":39.99},{"id":"8_ship_spearhead_1.0000_0_NONE","itemID":"56083","projectID":"168","title":"Spearhead","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac9.99","selectionPrice":"\u20ac9.99","shoppingCartPrice":9.99,"shoppingCartFullPrice":"","price":"9.9900","currency":"EUR","type":"ship_spearhead","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"5","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a38.21","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":9.99},{"id":"8_package_trinity_1.0000_0_NONE","itemID":"52089","projectID":"168","title":"\\"Trinity\\" Ship Pack","fullPrice":"","savePercentage":"Save&nbsp;60%!","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac89.00","selectionPrice":"\u20ac89.00","shoppingCartPrice":89,"shoppingCartFullPrice":"","price":"89.0000","currency":"EUR","type":"package_trinity","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"7","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a373.10","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":89}]},"4":{"config":{"headline":"Starter Kits","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_4.gif?__cv=75fdf3adf02b9a0540491db24fbde300","order":49},"items":[]},"5":{"config":{"headline":"Savings & Starter Kits","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_5.gif?__cv=c1d4596376f308a0805ee9fed0c69e00","order":50},"items":[{"id":"5_challenger_discount_kit_1.0000_0_NONE","itemID":"67781","projectID":"168","title":"Challenger Savings Pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac1.99","selectionPrice":"\u20ac1.99","shoppingCartPrice":1.99,"shoppingCartFullPrice":"","price":"1.9900","currency":"EUR","type":"challenger_discount_kit","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a31.63","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":1.99},{"id":"5_elite_discount_kit_1.0000_0_NONE","itemID":"67809","projectID":"168","title":"Elite Savings Pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac4.99","selectionPrice":"\u20ac4.99","shoppingCartPrice":4.99,"shoppingCartFullPrice":"","price":"4.9900","currency":"EUR","type":"elite_discount_kit","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"2","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a34.10","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":4.99},{"id":"5_pro_discount_kit_1.0000_0_NONE","itemID":"67837","projectID":"168","title":"Pro Savings Pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac9.99","selectionPrice":"\u20ac9.99","shoppingCartPrice":9.99,"shoppingCartFullPrice":"","price":"9.9900","currency":"EUR","type":"pro_discount_kit","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"3","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a38.21","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":9.99},{"id":"5_vengeance-start-kit_1.0000_0_NONE","itemID":"67865","projectID":"168","title":"Vengeance Starter Kit","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac9.99","selectionPrice":"\u20ac9.99","shoppingCartPrice":9.99,"shoppingCartFullPrice":"","price":"9.9900","currency":"EUR","type":"vengeance-start-kit","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"4","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a38.21","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":9.99},{"id":"5_leonov-start-kit_1.0000_0_NONE","itemID":"67893","projectID":"168","title":"Leonov Starter Kit","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac14.99","selectionPrice":"\u20ac14.99","shoppingCartPrice":14.99,"shoppingCartFullPrice":"","price":"14.9900","currency":"EUR","type":"leonov-start-kit","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"5","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a312.31","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":14.99},{"id":"5_goliath-start-kit_1.0000_0_NONE","itemID":"67921","projectID":"168","title":"Goliath Starter Kit","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac24.99","selectionPrice":"\u20ac24.99","shoppingCartPrice":24.99,"shoppingCartFullPrice":"","price":"24.9900","currency":"EUR","type":"goliath-start-kit","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"6","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a320.53","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":24.99}]},"15":{"config":{"headline":"Ship Designs","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_15.gif?__cv=716beafe03f53f39ae56682ba48fac00","order":60},"items":[{"id":"15_shipdesign_solace_1.0000_0_NONE","itemID":"17600","projectID":"168","title":"Solace design","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac35.00","selectionPrice":"\u20ac35.00","shoppingCartPrice":35,"shoppingCartFullPrice":"","price":"35.0000","currency":"EUR","type":"shipdesign_solace","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a328.75","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":35},{"id":"15_shipdesign_spectrum_1.0000_0_NONE","itemID":"17609","projectID":"168","title":"Spectrum design","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac35.00","selectionPrice":"\u20ac35.00","shoppingCartPrice":35,"shoppingCartFullPrice":"","price":"35.0000","currency":"EUR","type":"shipdesign_spectrum","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"2","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a328.75","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":35},{"id":"15_shipdesign_diminisher_1.0000_0_NONE","itemID":"17618","projectID":"168","title":"Diminisher design","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac35.00","selectionPrice":"\u20ac35.00","shoppingCartPrice":35,"shoppingCartFullPrice":"","price":"35.0000","currency":"EUR","type":"shipdesign_diminisher","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"3","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a328.75","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":35},{"id":"15_shipdesign_sentinel_1.0000_0_NONE","itemID":"17627","projectID":"168","title":"Sentinel design","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac35.00","selectionPrice":"\u20ac35.00","shoppingCartPrice":35,"shoppingCartFullPrice":"","price":"35.0000","currency":"EUR","type":"shipdesign_sentinel","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"4","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a328.75","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":35},{"id":"15_shipdesign_scorpion_1.0000_0_NONE","itemID":"17636","projectID":"168","title":"Venom design","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac35.00","selectionPrice":"\u20ac35.00","shoppingCartPrice":35,"shoppingCartFullPrice":"","price":"35.0000","currency":"EUR","type":"shipdesign_scorpion","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"5","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a328.75","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":35},{"id":"15_shipdesign_package1_1.0000_0_NONE","itemID":"17645","projectID":"168","title":"Special Design Pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac120.00","selectionPrice":"\u20ac120.00","shoppingCartPrice":120,"shoppingCartFullPrice":"","price":"120.0000","currency":"EUR","type":"shipdesign_package1","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"6","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a398.57","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":120},{"id":"15_skill-design-lightning_1.0000_0_NONE","itemID":"21136","projectID":"168","title":"Lightning Design","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac35.00","selectionPrice":"\u20ac35.00","shoppingCartPrice":35,"shoppingCartFullPrice":"","price":"35.0000","currency":"EUR","type":"skill-design-lightning","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"7","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a328.75","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":35},{"id":"15_design-package-harvest_1.0000_0_NONE","itemID":"21135","projectID":"168","title":"Harvest Design Pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac30.00","selectionPrice":"\u20ac30.00","shoppingCartPrice":30,"shoppingCartFullPrice":"","price":"30.0000","currency":"EUR","type":"design-package-harvest","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"8","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"1","nonSecOverlayItem":false,"localPrice":"\u00a324.64","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":30},{"id":"15_addon3_1.0000_0_NONE","itemID":"17497","projectID":"168","title":"Rising Star Pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac30.00","selectionPrice":"\u20ac30.00","shoppingCartPrice":30,"shoppingCartFullPrice":"","price":"30.0000","currency":"EUR","type":"addon3","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"9","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a324.64","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":30}]},"6":{"config":{"headline":"Magic Bag","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":69},"items":[]},"9":{"config":{"headline":"Equipment","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_9.gif?__cv=3805c061d159dd553f78131e22da3600","order":70},"items":[{"id":"9_item_laserpack1_1.0000_0_NONE","itemID":"56096","projectID":"168","title":"Laser pack 1","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac14.99","selectionPrice":"\u20ac14.99","shoppingCartPrice":14.99,"shoppingCartFullPrice":"","price":"14.9900","currency":"EUR","type":"item_laserpack1","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a312.31","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":14.99},{"id":"9_item_schildpaket1_1.0000_0_NONE","itemID":"56135","projectID":"168","title":"Shield pack 1","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac14.99","selectionPrice":"\u20ac14.99","shoppingCartPrice":14.99,"shoppingCartFullPrice":"","price":"14.9900","currency":"EUR","type":"item_schildpaket1","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a312.31","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":14.99},{"id":"9_item_starthilfepaket_1.0000_0_NONE","itemID":"56174","projectID":"168","title":"Start-up pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac14.99","selectionPrice":"\u20ac14.99","shoppingCartPrice":14.99,"shoppingCartFullPrice":"","price":"14.9900","currency":"EUR","type":"item_starthilfepaket","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a312.31","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":14.99},{"id":"9_item_battlepaket_1.0000_0_NONE","itemID":"56187","projectID":"168","title":"Battle pack","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac24.99","selectionPrice":"\u20ac24.99","shoppingCartPrice":24.99,"shoppingCartFullPrice":"","price":"24.9900","currency":"EUR","type":"item_battlepaket","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a320.53","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":24.99},{"id":"9_item_laserpack2_1.0000_0_NONE","itemID":"56109","projectID":"168","title":"Laser pack 2","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac29.99","selectionPrice":"\u20ac29.99","shoppingCartPrice":29.99,"shoppingCartFullPrice":"","price":"29.9900","currency":"EUR","type":"item_laserpack2","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a324.63","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":29.99},{"id":"9_item_laserpackxl_1.0000_0_NONE","itemID":"56122","projectID":"168","title":"Laser pack XL","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac29.99","selectionPrice":"\u20ac29.99","shoppingCartPrice":29.99,"shoppingCartFullPrice":"","price":"29.9900","currency":"EUR","type":"item_laserpackxl","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a324.63","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":29.99},{"id":"9_item_schildpaket2_1.0000_0_NONE","itemID":"56148","projectID":"168","title":"Shield pack 2","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac29.99","selectionPrice":"\u20ac29.99","shoppingCartPrice":29.99,"shoppingCartFullPrice":"","price":"29.9900","currency":"EUR","type":"item_schildpaket2","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a324.63","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":29.99},{"id":"9_item_schildpaketxl_1.0000_0_NONE","itemID":"56161","projectID":"168","title":"Shield pack XL","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac29.99","selectionPrice":"\u20ac29.99","shoppingCartPrice":29.99,"shoppingCartFullPrice":"","price":"29.9900","currency":"EUR","type":"item_schildpaketxl","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a324.63","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":29.99},{"id":"9_item_slot4cpu_1.0000_0_NONE","itemID":"56200","projectID":"168","title":"Slot 4 CPU","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac49.99","selectionPrice":"\u20ac49.99","shoppingCartPrice":49.99,"shoppingCartFullPrice":"","price":"49.9900","currency":"EUR","type":"item_slot4cpu","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"0","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a341.06","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":49.99}]},"14":{"config":{"headline":"Class Designs","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":70},"items":[{"id":"14_class-design-aegis-veteran_1.0000_0_NONE","itemID":"79636","projectID":"168","title":"Aegis Veteran","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac9.99","selectionPrice":"\u20ac9.99","shoppingCartPrice":9.99,"shoppingCartFullPrice":"","price":"9.9900","currency":"EUR","type":"class-design-aegis-veteran","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a38.21","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":9.99},{"id":"14_class-design-citadel-veteran_1.0000_0_NONE","itemID":"79666","projectID":"168","title":"Citadel Veteran","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac9.99","selectionPrice":"\u20ac9.99","shoppingCartPrice":9.99,"shoppingCartFullPrice":"","price":"9.9900","currency":"EUR","type":"class-design-citadel-veteran","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a38.21","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":9.99},{"id":"14_class-design-spearhead-veteran_1.0000_0_NONE","itemID":"79606","projectID":"168","title":"Spearhead Veteran","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac9.99","selectionPrice":"\u20ac9.99","shoppingCartPrice":9.99,"shoppingCartFullPrice":"","price":"9.9900","currency":"EUR","type":"class-design-spearhead-veteran","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a38.21","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":9.99},{"id":"14_class-design-spearhead-elite_1.0000_0_NONE","itemID":"85869","projectID":"168","title":"Spearhead Elite","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac19.99","selectionPrice":"\u20ac19.99","shoppingCartPrice":19.99,"shoppingCartFullPrice":"","price":"19.9900","currency":"EUR","type":"class-design-spearhead-elite","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a316.42","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":19.99},{"id":"14_design-package-class-design_1.0000_0_NONE","itemID":"79696","projectID":"168","title":"All-in-One","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac24.99","selectionPrice":"\u20ac24.99","shoppingCartPrice":24.99,"shoppingCartFullPrice":"","price":"24.9900","currency":"EUR","type":"design-package-class-design","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"1","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a320.53","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":24.99},{"id":"14_class-design-aegis-elite_1.0000_0_NONE","itemID":"85907","projectID":"168","title":"Aegis Elite","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac19.99","selectionPrice":"\u20ac19.99","shoppingCartPrice":19.99,"shoppingCartFullPrice":"","price":"19.9900","currency":"EUR","type":"class-design-aegis-elite","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"2","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a316.42","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":19.99},{"id":"14_class-design-citadel-elite_1.0000_0_NONE","itemID":"85945","projectID":"168","title":"Citadel Elite","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac19.99","selectionPrice":"\u20ac19.99","shoppingCartPrice":19.99,"shoppingCartFullPrice":"","price":"19.9900","currency":"EUR","type":"class-design-citadel-elite","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"3","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a316.42","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":19.99},{"id":"14_design-package-class-designelite_1.0000_0_NONE","itemID":"85983","projectID":"168","title":"All-in-One Elite","fullPrice":"","savePercentage":"","percentage":"","addToCartTooltip":"Add to cart","actualPrice":"\u20ac44.99","selectionPrice":"\u20ac44.99","shoppingCartPrice":44.99,"shoppingCartFullPrice":"","price":"44.9900","currency":"EUR","type":"design-package-class-designelite","premiumType":"","interval":"0","intervalType":"NONE","description":"","order":"4","shoppingCartIcon":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","shoppingCartType":"","showDirectOverlay":false,"openPrePopup":false,"accountIDs":"","countById":1,"limitByUser":"0","nonSecOverlayItem":false,"localPrice":"\u00a336.95","iconSmall":"","iconMedium":"","iconBig":"","badgeButton":"","activeSubscription":false,"voucherPrice":44.99}]},"7":{"config":{"headline":"Deals","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/22\/itemcategory_selection_7.gif?__cv=c9022d9854b865971ce1968b05e35200","order":79},"items":[]},"11":{"config":{"headline":"Text tip","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":119},"items":[]},"13":{"config":{"headline":"Bigpoints","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":139},"items":[]},"16":{"config":{"headline":"","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":169},"items":[]},"18":{"config":{"headline":"","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":189},"items":[]},"19":{"config":{"headline":"","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":199},"items":[]},"20":{"config":{"headline":"","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":209},"items":[]},"21":{"config":{"headline":"","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":219},"items":[]},"100":{"config":{"headline":"","imagePath":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","order":1009},"items":[]}}', true);
                if (itemgroup) {
                    items = items[itemgroup];
                }
                return items;
            }

            function getAccounts() {
                var accounts = JSON.decode('{"result":"OK","accounts":[{"id":"4214","label":"PayPal","icon":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/button_pm_paypal.png?__cv=3faf4d707fed975cacf04089bfe5e800","iconDisabled":"https:\/\/ssl.bpsecure.com\/billing\/images\/embedded\/button_pm_paypal_grey.png","priceStart":0.5,"priceEnd":1000,"priceFix":[],"description":"With a free PayPal account you can instantly pay for online purchases. It\'s easy, fast and secure.<br><br>1. <b>Easy<\/b>: In <b>just two clicks<\/b> you can pay without having to enter your bank or credit card details.<br>2. <b>Fast<\/b>: The seller receives the money within seconds.<br>3. <b>Secure<\/b>: Your bank and credit card information will not be given to third parties.","popup":false,"order":0,"bonusRate":"","imageUrl":"https:\/\/ssl.bpsecure.com\/billing\/images\/ghostimage.gif?__cv=ad480fd0732d0f6f1a8b06359e3a4200","secureMethod":false,"typeCategory":"","displayOutOfPriceRange":false}],"fastPayData":false}', true);
                return accounts;
            }
            window.addEvent('domready', function() {
                resizeBrowserSize(true);
            });




            window.addEvent('domready', function() {


                if (!Payment.paymentAccounts) {
                    Payment.paymentAccounts = getAccounts().accounts;
                }
                Payment.fastPayData = getAccounts().fastPayData;
            });









            function updateGameCur() {
                var gamecurrency;
                gamecurrency = $('realcurrency').value * getSwapExchangeRate();
                if (gamecurrency < 0) {
                    gamecurrency = 'NaN';
                }
                $('gamecurrency').value = gamecurrency;
                $('realcurrency').style.color = (isMaxSwapReached())
                        ? '#ff0000'
                        : '#000000';
            }

            function submitCurrencySwap() {
                if ($('realcurrency').value > 0) {
                    $('swapAction').value = (getCurrencySwapWallet())
                            ? 'walletSwap'
                            : 'currencySwap';
                    // $('frmCurrencySwap').submit();
                    AjaxFormHandler.showAdditionalOverlay($('swapAction').value, $('frmCurrencySwap'));
                }
            }

            var currencySwapWallet = false;

            function setCurrencySwapWallet(b)
            {
                currencySwapWallet = b;
            }

            function getCurrencySwapWallet()
            {
                return currencySwapWallet;
            }

            function getSwapTextHeadline()
            {
                return (!getCurrencySwapWallet())
                        ? 'Exchange Uridium for credits'
                        : ' for Uridium';
            }

            function getSwapTextSwitchline()
            {
                return (!getCurrencySwapWallet())
                        ? 'Exchange '
                        : 'Exchange Uridium';
            }

            function getSwapExchangeRate()
            {
                return (!getCurrencySwapWallet())
                        ? 0
                        : 0;
            }

            function getMaxSwapValue()
            {
                return (getCurrencySwapWallet())
                        ? 0
                        : -1;
            }

            function isMaxSwapReached()
            {
                return (getMaxSwapValue() >= 0) && ($('realcurrency').value > getMaxSwapValue());
            }

            function initSwapTexts()
            {
                if ($('swapCurrencyHeadline')) {
                    $('swapCurrencyHeadline').innerHTML = getSwapTextHeadline();
                }
                if ($('swapCurrencySwitchline')) {
                    $('swapCurrencySwitchline').innerHTML = getSwapTextSwitchline();
                }
            }

            function onClickSwapHeader()
            {
                var textSlide = new Fx.Slide('swapCurrencyHeadlineBox', {mode: 'horizontal'});
                textSlide.slideOut().chain(function() {

                    setCurrencySwapWallet(!getCurrencySwapWallet());
                    initSwapTexts();

                    var textSlide = new Fx.Slide('swapCurrencyHeadlineBox', {mode: 'horizontal'});
                    textSlide.slideIn();

                    if ($('realcurrency').value.length > 0) {
                        updateGameCur();
                    }
                });
            }

        </script>

        <!-- EventStream ServerAdapter getJavascriptPageTag --><script language="javascript">window.BpEventStream = window.BpEventStream || {"time": new Date().getTime(), "context": {"pid": 168, "uid": 101190755, "tid": "467288f55f903682f7011c58b98348b8", "iid": "1c9bd003067a1fef79c3b1c053c19074", "sid": "94a23dd09e47f278542c657f4715bc07", "ctime": 1394090859586}};</script><script language="javascript" src="//assets.bpsecure.com/eventstream/eventstream.js?ts=4646969"></script>

    </head>
    <body ">  
        <div id="overall">

            <div id="overlay_info" class="overlay_info_message" style="display:none;">





                <div id="closeOverlayBtn" onclick="document.getElementById('overlay_info').style.display = 'none';"></div>
                <div class="clear"></div>

                <div id="overlay_info_content_box">
                    <div style="text-align: center;"><strong>One moment please ...</strong></div>
                </div>

            </div>
            <div id="overlay_wait"></div>
            <div id="overlaybackground_wait"></div>
            <div id="toolTipLayer" class="tooltip" style="left: 624px; top: 251px; display: block;">Add to cart</div>
            <div id="ajaxWaitingLayer" class="ajaxwaiting" style="display: none; left: 395px; top: 281px;"></div>
            <div id="overlayer"></div>
            <div id="overlay" class="bigOverlay">
                <div id="closeOverlayBtn" onclick="Payment.disableOverlay();"></div>
                <div class="clear"></div>
                <div id="overlay_content">


                </div>
            </div>

            <div id="language_resources">
                <input type="hidden" id="lang_voucherButtonText" value="Voucher">
                <input type="hidden" id="lang_moreMethods" value="Other payment methods">
                <input type="hidden" id="lang_prevMethods" value="Previous payment methods">
                <input type="hidden" id="lang_itemselectionSubheadlineAll" value="Payable via cell phone or landline:">
                <input type="hidden" id="lang_itemselectionSubheadlineSms" value="Payable via cell phone:">
                <input type="hidden" id="lang_itemselectionSubheadlinePhone" value="Payable via landline:">
                <input type="hidden" id="lang_easyClick" value="EasyClick">
                <input type="hidden" id="lang_easyClickDesc" value="
                       If you regularly make purchases here or regularly fill up your virtual account,
                       &lt;p&gt;you might find EasyClick a quick and easy alternative for making your purchases:
                       Choose how you want to pay - by bank transfer or credit card.&lt;/p&gt;
                       Then enter the data for the chosen payment method along with your personal details.
                       After you have confirmed these, you can use the convenient quick-buy buttons.">
                <input type="hidden" id="lang_total" value="Total:">
            </div>


            <div id="image_resources">
                <input type="hidden" id="image_progressBar_0" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_1.gif?__cv=94947d40408f70c3d774534f8d378500">
                <input type="hidden" id="image_progressBar_1" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_2.gif?__cv=28e541db7ae2c2920b33027f6f7ad500">
                <input type="hidden" id="image_progressBar_2" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_3.gif?__cv=a29747e502ffb3e7abe7b538427e3b00">
                <input type="hidden" id="image_progressBar_3" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_4.gif?__cv=2137d07580c85cebb58ed3f6b4c48a00">
                <input type="hidden" id="image_progressBar_4" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_5.gif?__cv=24e4fd67252dec67bbdb1ba27d854500">
                <input type="hidden" id="image_progressBar_0_grey" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_1_grey.gif?__cv=ff0a4964dab37dd6be2200c15a013d00">
                <input type="hidden" id="image_progressBar_1_grey" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_2_grey.gif?__cv=979ad240550a1eccfe4c28dd6a91e200">
                <input type="hidden" id="image_progressBar_2_grey" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_3_grey.gif?__cv=d9973aaf63383a5b1f524f2575dc6100">
                <input type="hidden" id="image_progressBar_3_grey" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_4_grey.gif?__cv=eacaf08722496465b2efa715f4f12f00">
                <input type="hidden" id="image_progressBar_4_grey" value="https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_5_grey.gif?__cv=26192365785ec56d8d8e8b345d8be700">
            </div>
            <div id="bodyCenter">
                <div id="paymentBoxCenter">

                    <div id="content">
                        <div id="progressBarWrapper">
                            <div id="progressCart"></div>
                            <div id="progressBars">
                                <div id="bar_0" class="progressBar" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_1.gif?__cv=94947d40408f70c3d774534f8d378500)"></div>
                                <div id="bar_1" class="progressBar" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_2_grey.gif?__cv=979ad240550a1eccfe4c28dd6a91e200)"></div>
                                <div id="bar_2" class="progressBar" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_3_grey.gif?__cv=d9973aaf63383a5b1f524f2575dc6100)"></div>
                                <div id="bar_3" class="progressBar" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_4_grey.gif?__cv=eacaf08722496465b2efa715f4f12f00)"></div>
                                <div id="bar_4" class="progressBar" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/progressBar_5_grey.gif?__cv=26192365785ec56d8d8e8b345d8be700)"></div>
                            </div>
                            <div class="clear"></div>
                            <div id="progressDescriptions">
                                <div id="description_0" class="progressText_activ">1. Choose item</div>
                                <div id="description_1" class="progressText_inactiv">2. Payment method</div>
                                <div id="description_2" class="progressText_inactiv">3. Enter details</div>
                                <div id="description_3" class="progressText_inactiv">4. Confirm</div>
                                <div class="clear"></div>
                            </div>
                        </div>

                        <!-- main information -->


                        <div id="contentLeft">
                            <div id="topItems">
                                <div class="left">
                                    <div id="topItemsHeaderL" class="left" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/topItemsHeader_0.png?__cv=03046b6d1248c6b046a05a4a85d95300)"></div>
                                    <div id="topItemsHeaderM" class="left" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/topItemsHeader_1.png?__cv=1e88d452bd7c21c23c0add75d9d53400)">
                                        <div id="topItemsHeaderIcon" class="left" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_selection_1.gif?__cv=f3c986f35981b6b6bd4d5745ff964d00);"></div>
                                        <div id="topItemsTitle" class="left">Uridium</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div id="topItemsHeaderR" class="left" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/topItemsHeader_2.png?__cv=0ffd1ffdc0b9b282e1307ed4e9178600)"></div>
                                    <div class="clear"></div>
                                    <div id="topItemsPrices">

                                        <table id="topItemsTable"><tbody><tr><td id="itemdesc0" nowrap=""><div class="btn" onclick="Payment.addToCart('1_realCurrency_5000.0000_0_NONE_5649')">5,000 Uridium</div></td><td id="itemSelectionSavePercentage0" style="width: 119px;"><div id="itemSelectionSavePercentage0_container" class="savepercentprice" style="width: 119px;"><div id="itemSelectionSavePercentage0_text" class="nowrap btn" onclick="Payment.addToCart('1_realCurrency_5000.0000_0_NONE_5649')"></div></div></td><td class="newprice" nowrap="" id="itemSelectionPrice0"><div class="btn" onclick="Payment.addToCart('1_realCurrency_5000.0000_0_NONE_5649')">€1.99</div></td><td><div id="itemaddtocart0" class="addToCartBtn btn" onclick="Payment.addToCart('1_realCurrency_5000.0000_0_NONE_5649')"></div></td></tr><tr><td id="itemdesc1" nowrap=""><div class="btn" onclick="Payment.addToCart('1_realCurrency_15000.0000_0_NONE_1237')">15,000 Uridium</div></td><td id="itemSelectionSavePercentage1" style="width: 119px;"><div id="itemSelectionSavePercentage1_container" class="savepercentprice" style="width: 119px;"><div id="itemSelectionSavePercentage1_text" class="nowrap btn" onclick="Payment.addToCart('1_realCurrency_15000.0000_0_NONE_1237')">Save&nbsp;16%!</div></div></td><td class="newprice" nowrap="" id="itemSelectionPrice1"><div class="btn" onclick="Payment.addToCart('1_realCurrency_15000.0000_0_NONE_1237')">€5.00</div></td><td><div id="itemaddtocart1" class="addToCartBtn btn" onclick="Payment.addToCart('1_realCurrency_15000.0000_0_NONE_1237')"></div></td></tr><tr><td id="itemdesc2" nowrap=""><div class="btn" onclick="Payment.addToCart('1_realCurrency_30000.0000_0_NONE_256')">30,000 Uridium</div></td><td id="itemSelectionSavePercentage2" style="width: 119px;"><div id="itemSelectionSavePercentage2_container" class="savepercentprice" style="width: 119px;"><div id="itemSelectionSavePercentage2_text" class="nowrap btn" onclick="Payment.addToCart('1_realCurrency_30000.0000_0_NONE_256')">Save&nbsp;16%!</div></div></td><td class="newprice" nowrap="" id="itemSelectionPrice2"><div class="btn" onclick="Payment.addToCart('1_realCurrency_30000.0000_0_NONE_256')">€10.00</div></td><td><div id="itemaddtocart2" class="addToCartBtn btn" onclick="Payment.addToCart('1_realCurrency_30000.0000_0_NONE_256')"></div></td></tr><tr><td id="itemdesc3" nowrap=""><div class="btn" onclick="Payment.addToCart('1_realCurrency_75000.0000_0_NONE_257')">75,000 Uridium</div></td><td id="itemSelectionSavePercentage3" style="width: 119px;"><div id="itemSelectionSavePercentage3_container" class="savepercentprice" style="width: 119px;"><div id="itemSelectionSavePercentage3_text" class="nowrap btn" onclick="Payment.addToCart('1_realCurrency_75000.0000_0_NONE_257')">Save&nbsp;16%!</div></div></td><td class="newprice" nowrap="" id="itemSelectionPrice3"><div class="btn" onclick="Payment.addToCart('1_realCurrency_75000.0000_0_NONE_257')">€25.00</div></td><td><div id="itemaddtocart3" class="addToCartBtn btn" onclick="Payment.addToCart('1_realCurrency_75000.0000_0_NONE_257')"></div></td></tr><tr><td id="itemdesc4" nowrap=""><div class="btn" onclick="Payment.addToCart('1_realCurrency_150000.0000_0_NONE_258')">150,000 Uridium</div></td><td id="itemSelectionSavePercentage4" style="width: 119px;"><div id="itemSelectionSavePercentage4_container" class="savepercentprice" style="width: 119px;"><div id="itemSelectionSavePercentage4_text" class="nowrap btn" onclick="Payment.addToCart('1_realCurrency_150000.0000_0_NONE_258')">Save&nbsp;18%!</div></div></td><td class="newprice" nowrap="" id="itemSelectionPrice4"><div class="btn" onclick="Payment.addToCart('1_realCurrency_150000.0000_0_NONE_258')">€49.00</div></td><td><div id="itemaddtocart4" class="addToCartBtn btn" onclick="Payment.addToCart('1_realCurrency_150000.0000_0_NONE_258')"></div></td></tr><tr><td id="itemdesc5" nowrap=""><div class="btn" onclick="Payment.addToCart('1_realCurrency_330000.0000_0_NONE_259')">330,000 Uridium</div></td><td id="itemSelectionSavePercentage5" style="width: 119px;"><div id="itemSelectionSavePercentage5_container" class="savepercentprice" style="width: 119px;"><div id="itemSelectionSavePercentage5_text" class="nowrap btn" onclick="Payment.addToCart('1_realCurrency_330000.0000_0_NONE_259')">Save&nbsp;25%!</div></div></td><td class="newprice" nowrap="" id="itemSelectionPrice5"><div class="btn" onclick="Payment.addToCart('1_realCurrency_330000.0000_0_NONE_259')">€99.00</div></td><td><div id="itemaddtocart5" class="addToCartBtn btn" onclick="Payment.addToCart('1_realCurrency_330000.0000_0_NONE_259')"></div></td></tr><tr><td colspan="4" id="itemSelectionSubheadline" class="topItemsDirectOverlaySeparator"></td></tr><tr id="sms_6"><td id="itemdesc6" nowrap=""><div class="btn" onclick="Payment.showDirectOverlay('1_realCurrency_8500.0000_0_NONE', '3827', false)">8,500 Uridium</div></td><td id="itemSelectionSavePercentage6" style="width: 119px;"><div id="itemSelectionSavePercentage6_container" class="savepercentprice" style="width: 119px;"><div id="itemSelectionSavePercentage6_text" class="nowrap btn" onclick="Payment.showDirectOverlay('1_realCurrency_8500.0000_0_NONE', '3827', false)">Pay&nbsp;via&nbsp;cell&nbsp;phone</div></div></td><td class="newprice" nowrap="" id="itemSelectionPrice6"><div class="btn" onclick="Payment.showDirectOverlay('1_realCurrency_8500.0000_0_NONE', '3827', false)">25.00 DKK</div></td><td><div id="itemaddtocart6" class="addToCartMobileBtn btn" onclick="Payment.showDirectOverlay('1_realCurrency_8500.0000_0_NONE', '3827', false)"></div></td></tr></tbody></table></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div id="moreOffers" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/offers_bg.gif?__cv=73f3b701e53e17bffb6d28f98041c600); ">
                                <div id="offersHeaderL" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/standardheader_0.png?__cv=3c8ed5c45d3b742c1ede2840b8d76c00)"></div>
                                <div id="offersHeaderM" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/standardheader_1.png?__cv=28dd649a18c069bd749a19b25f563100)">Available offers</div>
                                <div id="offersHeaderR" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/standardheader_2.png?__cv=2fffac1afe389f2b44f016d146b57b00)"></div>
                                <div class="clear"></div>
                                <div id="offersExpanded" class="">
                                    <div id="offersArrowLeft" onclick="Payment.moveOffers('prev')"></div>
                                    <div id="offersContent" class="left">
                                        <div id="offerItems">

                                            <div class="offerItem offerItemGlow" id="offerItem_1" >
                                                <div class="innerOfferItem">
                                                    <div class="offerItemImage" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_1.gif?__cv=a7ab46b56af2eaf98030595a58747600);">
                                                        <div id="offerItem_1_glow"></div>
                                                    </div>
                                                    <div class="offerItemReflection" id="offerItem_1_reflection">
                                                        <div id="offerItem_1_text">Uridium</div>
                                                    </div>
                                                    <input type="hidden" id="offerItem_1_tooltip" value="Uridium">
                                                </div>
                                            </div>
                                            <div class="offerItem pointer" id="offerItem_2" onclick="Payment.updateItemGroup(2)">
                                                <div class="innerOfferItem">
                                                    <div class="offerItemImage" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_2.gif?__cv=5583871712b96ff31d945ec22f391800);">
                                                        <div id="offerItem_2_glow"></div>
                                                    </div>
                                                    <div class="offerItemReflection" id="offerItem_2_reflection">
                                                        <div id="offerItem_2_text" style="margin-left: -48px;">Premiums&nbsp;&amp;&nbsp;Subscriptions</div>
                                                    </div>
                                                    <input type="hidden" id="offerItem_2_tooltip" value="Premiums &amp; Subscriptions">
                                                </div>
                                            </div>
                                            <div class="offerItem pointer" id="offerItem_8">
                                                <div class="innerOfferItem">
                                                    <div class="offerItemImage" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_8.gif?__cv=93a66566e01b525d2b41268e64535d00);">
                                                        <div id="offerItem_8_glow"></div>
                                                    </div>
                                                    <div class="offerItemReflection" id="offerItem_8_reflection">
                                                        <div id="offerItem_8_text">Ships</div>
                                                    </div>
                                                    <input type="hidden" id="offerItem_8_tooltip" value="Ships">
                                                </div>
                                            </div>
                                            <div class="offerItem pointer" id="offerItem_5" >
                                                <div class="innerOfferItem">
                                                    <div class="offerItemImage" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_5.gif?__cv=dbd23c4702de8883417885ba198c6600);">
                                                        <div id="offerItem_5_glow"></div>
                                                    </div>
                                                    <div class="offerItemReflection" id="offerItem_5_reflection">
                                                        <div id="offerItem_5_text" style="margin-left: -27px;">Savings&nbsp;&amp;&nbsp;Starter&nbsp;Kits</div>
                                                    </div>
                                                    <input type="hidden" id="offerItem_5_tooltip" value="Savings &amp; Starter Kits">
                                                </div>
                                            </div>
                                            <div class="offerItem pointer" id="offerItem_15">
                                                <div class="innerOfferItem">
                                                    <div class="offerItemImage" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_15.gif?__cv=d06463e549eecdfe55247d7b2f825800);">
                                                        <div id="offerItem_15_glow"></div>
                                                    </div>
                                                    <div class="offerItemReflection" id="offerItem_15_reflection">
                                                        <div id="offerItem_15_text">Ship&nbsp;Designs</div>
                                                    </div>
                                                    <input type="hidden" id="offerItem_15_tooltip" value="Ship Designs">
                                                </div>
                                            </div>
                                            <div class="offerItem pointer" id="offerItem_9">
                                                <div class="innerOfferItem">
                                                    <div class="offerItemImage" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_9.gif?__cv=36363ca2ad6263a687f2bc8c4fd15500);">
                                                        <div id="offerItem_9_glow"></div>
                                                    </div>
                                                    <div class="offerItemReflection" id="offerItem_9_reflection">
                                                        <div id="offerItem_9_text">Equipment</div>
                                                    </div>
                                                    <input type="hidden" id="offerItem_9_tooltip" value="Equipment">
                                                </div>
                                            </div>
                                            <div class="offerItem pointer" id="offerItem_14">
                                                <div class="innerOfferItem">
                                                    <div class="offerItemImage" style="background-image: url(https://ssl.bpsecure.com/billing/images/embedded/22/itemcategory_14.gif?__cv=793a5605ace1a718b244197666332400);">
                                                        <div id="offerItem_14_glow"></div>
                                                    </div>
                                                    <div class="offerItemReflection" id="offerItem_14_reflection">
                                                        <div id="offerItem_14_text">Class&nbsp;Designs</div>
                                                    </div>
                                                    <input type="hidden" id="offerItem_14_tooltip" value="Class Designs">
                                                </div>
                                            </div>
                                            <div class="clear pointer"></div>
                                        </div>
                                    </div>
                                    <div id="offersArrowRight" onclick="Payment.moveOffers('next')"></div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>        <div id="contentRight">
                            <div id="shoppingCartListContainer">
                                <div id="shoppingCartItems"></div>
                                <div id="shoppingCartTotal">
                                    <div id="cartTotalText">Total:</div>
                                    <div id="cartTotal"><span id="priceOverall"></span> <span id="priceOverallCurrency"></span></div>
                                    <div id="cartSaved">(You save: <span id="discountOverall"></span> <span id="discountOverallCurrency"></span>)</div>
                                </div>
                            </div>
                            <div class="checkoutButtonDiv">
                                <div id="checkoutButton" style="display: none; opacity: 0; filter: alpha(opacity=0);" onclick="Payment.requestMethods()">
                                    <span id="checkoutButtonCheckout">Proceed to checkout</span>
                                    <form method="post" action="process.php">
                                        <input type="hidden" id="cartTotalPay" name="amount" value="">
                                        <input type="hidden" name="item_name" value="Premium Pack#">
                                        <input type="hidden" name="user_id" value="1">
                                        <span id="checkoutButtonPurchase" style="display: none;"><input type="submit" value=" Buy "></span>
                                    </form>
                                </div>
                            </div>
                            <div class="clear"></div>

                            <div id="paymentMethodsBox" class="methodBox" style="display: none; opacity: 0;">
                                <div id="methodsHeaderL" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/standardheader_0.png?__cv=3c8ed5c45d3b742c1ede2840b8d76c00)"></div>
                                <div id="methodsHeaderM" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/standardheader_1.png?__cv=28dd649a18c069bd749a19b25f563100)">Choose payment method</div>
                                <div id="methodsHeaderR" style="background-image:url(https://ssl.bpsecure.com/billing/images/embedded/22/standardheader_2.png?__cv=2fffac1afe389f2b44f016d146b57b00)"></div>
                                <div class="clear"></div>
                                <div id="paymentMethodsContent">
                                    <div id="paymentMethods"></div>
                                </div>
                            </div>
                            <div id="fastPayStorer" class="hidden"></div>
                        </div>    	<div class="clear"></div>

                        <!-- includes the footer -->

                    </div>

                    <div id="footer">
                        <div id="trackingPixelDiv" style="visibility:hidden;position:absolute">

                        </div>
                        <span class="footerlink">© 2014 Medianet</span>
                        | <a class="footerlink" href="#" onclick="Payment.showAdditionalOverlay('imprint')">Legal information</a>
                        | <a class="footerlink" href="index.es?action=info&amp;subAction=termsOfUse&amp;sid=a942f084d5cc8a488ee4af22f7002812" target="_blank">Terms &amp; Conditions</a>
                        | Language: <img src="https://ssl.bpsecure.com/billing/images/embedded/flags/us.png?__cv=0ea7941d8af02476a66e26a503ff7b00" width="16" height="26" alt="DK" align="middle" class="footerCountryFlag">
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>