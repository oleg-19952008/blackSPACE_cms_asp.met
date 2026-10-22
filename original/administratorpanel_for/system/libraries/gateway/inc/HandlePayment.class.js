var HandlePayment = {

    popup: null,
    gameCardIdentifierLength: 2,
    gameCardMaxPerField: 4,


    preOpenExternalWindow: function() {

		HandlePayment.windowReference = window.open('', "externalpayment", "width=800,height=600,left=100,top=200,scrollbars=yes");
    },

    openExternalWindow: function(params) {
        var external = window.open(params.url, "externalpayment", "width=800,height=600,left=100,top=200,scrollbars=yes");
        try {
        external.focus();
        } catch (e) {}
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    setScreenResolution: function(elementId) {
        $(elementId).value = screen.width + 'x' + screen.height;
    },


    // -------------------------------------------------------------------------
    //                              method / account specific javascript methods

    debitLoadBankName: function(type, value, elem)
    {
        value = value.trim();
        elem.value = value;

        /* get bank info by API and show results */
        if (value.length > 3) {
            Util.apiRequest(
                'gameapi.jsonPaymentInfo', {
                    'module': 'sepa',
                    'action': 'info',
                    'data': {'type': type, 'value': value}
                },
                function(res) {HandlePayment.debitLoadBankNameCallback(res)}
            );
        }
    },

    debitLoadBankNameCallback: function(result)
    {
        if (result.result == 'OK') {
            if (result.res.status == 'error' || !result.res.bankName) {
                if ($('sepaBankName')) {
                    $('sepaBankName').innerHTML = '';
                }

                if (result.res.status == 'error') {
                    Array.each(result.res.invalid, function(yoooo, index){
                        $(yoooo).addClass('sepaError');
                    });
                }
            } else {
                if ($('sepaBankName') && $('sepaBankNameHidden')) {
                    $('sepaBankName').innerHTML = result.res.bankName;
                    $('sepaBankNameHidden').value = result.res.bankName;
                }
            }
        }
    },

    // -------------------------------------------------------------------------

    buildpayEpinOnInputchange: function(element) {
        element = document.id(element);
        var parent = element.getParent('div');
        var actaulEpinParts = parent.getChildren('input');
        var actualPartNr = element.id.substr(3,1)

        //get prev and next input field if exists
        var prev = false;
        var next = false;
        Array.each(actaulEpinParts, function(part, index){
            if ((parseInt(actualPartNr) - 1) == index) {
                prev = part;
            }
            if ((parseInt(actualPartNr) + 1) == index) {
                next = part;
            }
        });

        element.value = element.value.toUpperCase();
        if (element.value.length > 4 && next) {
            var t = new String(element.value);
            element.value = t.substr(0,4);
            next.focus();
            next.value = t.substr(4, t.length - 4);
            next.onchange();
        } else if (element.value.length == 0 && prev) {
            prev.focus();
        }
    },

    buildpayEpinCheckEpinCode: function(cur) {
        //check if all epin numbers are used
        cur = document.id(cur);
        var actualEpinContainer = cur.getParent('div');
        var actaulEpinParts = actualEpinContainer.getChildren('input');
        var count = 0;
        Array.each(actaulEpinParts, function(part, index){
            count += part.value.length;
        });

        if (count == 20) {
            //get epin codes
            var container = $('epinContainer');
            var epinCodeContainer = container.getChildren('div');
            var epinCodes = [];
            Array.each(epinCodeContainer, function(inputFields, indexC){
                var epinParts = inputFields.getChildren('input');
                var epinCode = '';
                Array.each(epinParts, function(part, indexI){
                    epinCode += part.value;
                });
                var actualEpin = [];
                actualEpin[indexC] = epinCode;
                if (actualEpin[indexC].length == 20) {
                    var noMerge = false;
                    var index = 0;
                    Array.each(epinCodes, function(code, key) {
                        if (code == actualEpin[indexC]) {
                            inputFields.dispose();
                            noMerge = true;
                        }
                        index = parseInt(key) + 1;
                    });
                    if (!noMerge) {
                        epinCodes[index] = actualEpin[indexC];
                    }

                } else {
                    //delete incomplete input blocks
                    inputFields.dispose();
                }
            });

            /* get epin info by API and show results */
            Util.apiRequest(
                'gameapi.jsonPaymentInfo', {
                    'module': 'buildpay_epin',
                    'action': 'getEpinInfo',
                    'data': {'epins': epinCodes}
                },
                function(res) {HandlePayment.buildpayEpinCheckEpinCodeCallback(res)}
            );
        } else {
            var msgBox = actualEpinContainer.getElement('span[id=epinResultMsg]');
            HandlePayment.buildpayEpinSetResultMsg(
                $('epinResultMsgNotEnough'), msgBox
            );
        }
    },

    buildpayEpinCheckEpinCodeCallback: function(result) {
        //show blacklist and unknown error message
        if (result.res.status == 'error') {
            HandlePayment.buildpayEpinSetResultMsg($('epinResultMsgUnkown'));
        }
        if (result.res.status == 'blacklist') {
            HandlePayment.buildpayEpinSetResultMsg($('epinResultMsgBlacklist'));
        }
        if (result.res.status == 'multipleProvider') {
            HandlePayment.buildpayEpinSetResultMsg(
                $('epinResultMsgMultipleProvider')
            );
        }
        if (result.res.status == 'expired') {
            HandlePayment.buildpayEpinSetResultMsg(
                $('epinResultMsgExpired')
            );
        }

        var objectKeys = [];
        for (var key in result.res.epinData) {
            if (result.res.epinData.hasOwnProperty(key)) {
                objectKeys.push(key);
            }
        }

        //set epin result data
        var allEpinsValid = true;
        var count = 0;
        Array.each(objectKeys, function(epinCode, index) {
            var epinData = result.res.epinData[epinCode];

            //get epinContainer by code
            var inputDiv = HandlePayment.buildpayEpinGetInputFieldsByEpin(epinCode);
            var msgBox = inputDiv.getElement('span[id=epinResultMsg]');
            if (epinData.status == 'valid') {
                var htmlPrice = '';
                if (epinData.formattedItemPrice) {
                    htmlPrice = epinData.formattedPrice + ' ('
                              + epinData.formattedItemPrice + ')';
                } else {
                    htmlPrice = epinData.formattedPrice;
                }
                msgBox.set('html', htmlPrice);
                var priceClass = '';
                if (result.res.epinAmountEnough) {
                   priceClass = 'fontColor_success';
                }
                msgBox.set('class', priceClass);
            }
            if (epinData.status == 'unknown') {
                allEpinsValid = false;
                HandlePayment.buildpayEpinSetResultMsg($('epinResultMsgUnkown'), msgBox);
            }
            if (epinData.status == 'used') {
                allEpinsValid = false;
                HandlePayment.buildpayEpinSetResultMsg($('epinResultMsgUsed'), msgBox);
            }
            if (epinData.status == 'expired') {
                allEpinsValid = false;
                HandlePayment.buildpayEpinSetResultMsg(
                    $('epinResultMsgExpired'), msgBox
                );
            }
        });

        //add one more epin input field if neccessary
        if (
            allEpinsValid && !result.res.epinAmountEnough && !result.res.status
        ) {
            HandlePayment.buildpayEpinCloneInputElement();
        }
    },

    buildpayEpinSetResultMsg: function(msgSource, msgBox) {
        if (!msgBox) {
            var allMsgBoxes
                = $('epinContainer').getElements('span[id=epinResultMsg]');
            Array.each(allMsgBoxes, function(msgBox, index){
                msgBox.set('html', msgSource.innerHTML);
                msgBox.set('class', msgSource.get('class'));
            });
        } else {
            msgBox.set('html', msgSource.innerHTML);
            msgBox.set('class', msgSource.get('class'));
        }
    },

    buildpayEpinCloneInputElement: function() {
        //get all input fields and clone last epinInputFields block
        var container = $('epinContainer');
        var allInput = container.getElements('div[id=epinInputFields]');
        var blockCount = allInput.length;

        //just clone if not more as 6 code fields exists, 6 is tpl based end.
        if (blockCount < 6) {
            var inputFields = allInput.getLast();
            var clone = inputFields.clone(true, true);
            var epinParts = clone.getChildren('input');
            clone.inject(inputFields, 'after');

            //clean fields
            Array.each(epinParts, function(part, index){
                part.value = '';
                part.name = 'pin' + (blockCount) + '[' + index  + ']';
            });
            clone.getElement('span[id=epinResultMsg]').set('html', '');
        }
    },

    buildpayEpinGetInputFieldsByEpin: function(epin) {
        var res = false;
        var container = $('epinContainer');
        var allInput = container.getElements('div[id=epinInputFields]');
        Array.each(allInput, function(inputDiv, indexInput){
            var epinParts = inputDiv.getChildren('input');
            var epinCode = '';
            Array.each(epinParts, function(part, indexParts){
                epinCode += part.value;
            });
            if (epinCode == epin) {
                res = inputDiv;
            }
        });

        return res;
    },

    ////////////////////////////////////////////////////////////////////////////
    // Bigpoint GameCard stuff
    ////////////////////////////////////////////////////////////////////////////

    BigPointGameCardOnInputchange: function(element) {
        element = document.id(element);
        var parent = element.getParent('.pinInputFieldDiv');
        var actaulPinParts = parent.getElements(
            '.gamecard_inputField'
        );
        var actualPartNr = element.id.substr(3, 1);

        if (actualPartNr == 0) {
            if (
                element.value.length >= this.gameCardIdentifierLength
                    && (
                    element.getParent('.bigInputDivWrap').get('alt')
                        != element.value.substr(
                        0, this.gameCardIdentifierLength
                    )
                    )
                ) {
                element.getParent('.bigInputDivWrap').set(
                    'alt',
                    element.value.substr(0, this.gameCardIdentifierLength)
                );
                parent.getElement('.pinlength').value = '';
                this.BigPointGameCardCheckLength(element);
            }
        }

        //get prev and next input field if exists
        var prev = false;
        var next = false;
        Array.each(actaulPinParts, function(part, index){
            if ((parseInt(actualPartNr) - 1) == index) {
                prev = part;
            }
            if ((parseInt(actualPartNr) + 1) == index) {
                next = part;
            }
        });

        element.value = element.value.toUpperCase();
        if (element.value.length > this.gameCardMaxPerField && next) {
            var t = new String(element.value);
            element.value = t.substr(0, this.gameCardMaxPerField);
            next.focus();
            next.value = t.substr(
                this.gameCardMaxPerField, t.length - this.gameCardMaxPerField
            );
            next.onchange();
        } else if (element.value.length == 0 && prev) {
            prev.focus();
        }
    },

    BigPointGameCardCheckLength: function(elem)
    {
        if (
            elem.getParent('.pinInputFieldDiv').getElement('.pinlength').value
                == ''
        ) {
            var pinCode = '';

            actaulPinParts = elem.getParent('.pinInputFieldDiv').getElements(
                '.gamecard_inputField'
            );

            Array.each(actaulPinParts, function(part, index) {
                if (index == 0) {
                    firstpart = part.value.substr(
                        0, HandlePayment.gameCardIdentifierLength
                    );
                }
                pinCode += part.value;
            });

            Util.apiRequest(
                'gameapi.jsonPaymentInfo', {
                    'module': 'buildpay_bigpointGameCard',
                    'action': 'getPinLength',
                    'data': {'firstpart': firstpart, 'pinCode': pinCode}
                },
                function(result) {
                    HandlePayment.BigPointGameCardCheckLengthCallback(result)
                }
            );
        }
    },

    BigPointGameCardCheckLengthCallback: function(result)
    {
        code = result.res.pinCode;
        var inputDiv = HandlePayment.BigPointGameCardGetInputFieldsByPin(code);
        if (inputDiv) {
            inputDiv.getElement('.pinlength').value = result.res.length;
            this.BigPointGameCardShowFields(inputDiv, result.res.length);
        }
    },

    BigPointGameCardShowFields: function(inputDiv, length)
    {
        count = length / this.gameCardMaxPerField;

        actualPinParts = inputDiv.getElements('.gamecard_inputField');

        Array.each(actualPinParts, function(part, index) {
            if (index <= count) {
                part.getParent('.bigInputDivWrap').removeClass('transBig');
            } else {
                part.getParent('.bigInputDivWrap').addClass('transBig');
            }
        });
    },

    BigPointGameCardPinLength: function(firstpart, pinCode, cur)
    {
        result = null;

        //already loaded at entry of the first two signs
        if (
            cur.getParent('.pinInputFieldDiv').getElement('.pinlength').value
                == ''
            ) {
            Util.apiRequest(
                'gameapi.jsonPaymentInfo', {
                    'module': 'buildpay_bigpointGameCard',
                    'action': 'getPinLength',
                    'data': {'firstpart': firstpart, 'pinCode': pinCode}
                },
                function(result) {
                    HandlePayment.BigPointGameCardPinLengthCallback(result)
                }
            );
        } else {
            result = cur.getParent('.pinInputFieldDiv').getElement(
                '.pinlength'
            ).value;
        }

        return result;
    },

    BigPointGameCardPinLengthCallback: function(result)
    {
        inputDiv = HandlePayment.BigPointGameCardGetInputFieldsByPin(
            result.res.pinCode
        );
        inputDiv.getElement('.pinlength').value = result.res.length;

        HandlePayment.BigPointGameCardShowFields(inputDiv, result.res.length);
        HandlePayment.BigPointGameCardCheckPinCode(
            inputDiv.getElement('.pinSubmitCheckButton')
        );
    },

    BigPointGameCardCheckPinCode: function(cur) {
        cur = document.id(cur);
        //check if all pin numbers are used
        var actualPinContainer = cur.getParent('.pinInputFieldDiv');
        var actaulPinParts = actualPinContainer.getElements(
            '.gamecard_inputField'
        );
        var count = 0;
        var pinCode = '';

        Array.each(actaulPinParts, function(part, index) {
            if (index == 0) {
                firstpart = part.value.substr(
                    0, HandlePayment.gameCardIdentifierLength
                );
            }
            count += part.value.length;
            pinCode += part.value;
        });
        pinlength = this.BigPointGameCardPinLength(firstpart, pinCode, cur);

        if (pinlength == null) {
            //do nothing and wait for the callback who calls me again
        } else if (count == pinlength) {
            //get pin codes
            var container = $('pinContainer');
            var pinCodeContainer = container.getElements('.pinInputFieldDiv');
            var pinCodes = {};
            Array.each(pinCodeContainer, function(inputFields, indexC){
                var pinParts = inputFields.getElements('.gamecard_inputField');
                var pinCode = '';
                Array.each(pinParts, function(part, indexI){
                    pinCode += part.value;
                });
                var actualPin = {};
                actualPin[indexC] = pinCode;

                if (Object.contains(pinCodes, actualPin[indexC])) {
                    inputFields.dispose();
                    var noMerge = true;
                }
                if (!noMerge) {
                    Object.merge(pinCodes, actualPin);
                }
            });

            /* get pin info by API and show results */
            Util.apiRequest(
                'gameapi.jsonPaymentInfo', {
                    'module': 'buildpay_bigpointGameCard',
                    'action': 'getInfo',
                    'data': {'pins': pinCodes}
                },
                function(res) {
                    HandlePayment.BigPointGameCardCheckPinCodeCallback(res)
                }
            );
        } else {
            //clearOldStuff
            HandlePayment.BigPointGameCardSetResultMsg($('pinResultMsgEmpty'));
            actualPinContainer.getElement('.pinPriceMsg').set('html', '');

            var msgBox = actualPinContainer.getElement('.pinResultMsg');
            HandlePayment.BigPointGameCardSetResultMsg(
                $('pinResultMsgNotEnough'), msgBox
            );
        }
    },

    BigPointGameCardCheckPinCodeCallback: function(result) {
        //clearOldStuff
        HandlePayment.BigPointGameCardSetResultMsg($('pinResultMsgEmpty'));
        //show blacklist and unknown error message
        if (result.res.status == 'error') {
            HandlePayment.BigPointGameCardSetResultMsg($('pinResultMsgUnkown'));
        }
        if (result.res.status == 'blacklist') {
            HandlePayment.BigPointGameCardSetResultMsg(
                $('pinResultMsgBlacklist')
            );
        }
        if (result.res.status == 'multipleProvider') {
            HandlePayment.BigPointGameCardSetResultMsg(
                $('pinResultMsgMultipleProvider')
            );
        }

        //set pin result messages
        var allPinsValid = true;
        Object.each(result.res.pinData, function(pinData, pinCode) {
            //get pinContainer by code
            var inputDiv = HandlePayment.BigPointGameCardGetInputFieldsByPin(
                pinCode
            );
            var msgBox = inputDiv.getElement('.pinPriceMsg');
            if (pinData.status == 'valid') {
                var htmlPrice = '';
                if (pinData.formattedItemPrice) {
                    htmlPrice = pinData.formattedPrice + ' ('
                        + pinData.formattedItemPrice + ')';
                } else {
                    htmlPrice = pinData.formattedPrice;
                }
                msgBox.set('html', htmlPrice);
                var priceClass = 'pinPriceMsg';
                if (result.res.pinAmountEnough) {
                    priceClass = 'pinPriceMsg fontColor_success';
                }
                msgBox.set('class', priceClass);
            } else {
                msgBox.set('html', '');
            }

            var msgBox = inputDiv.getElement('.pinResultMsg');
            msgBox.set('html', '');

            if (
                pinData.status == 'unknown'
                || pinData.status == 'pinerror'
                || pinData.status == 'insufficient'
            ) {
                allPinsValid = false;
                HandlePayment.BigPointGameCardSetResultMsg(
                    $('pinResultMsgUnkown'), msgBox
                );
            }
            if (pinData.status == 'used') {
                allPinsValid = false;
                HandlePayment.BigPointGameCardSetResultMsg(
                    $('pinResultMsgUsed'), msgBox
                );
            }
            if (pinData.status == 'expired') {
                allPinsValid = false;
                HandlePayment.BigPointGameCardSetResultMsg(
                    $('pinResultMsgExpired'), msgBox
                );
            }
        });

        //add one more pin input field if neccessary
        if (allPinsValid && !result.res.pinAmountEnough && !result.res.status) {
            HandlePayment.BigPointGameCardCloneInputElement();
        }
    },

    BigPointGameCardSetResultMsg: function(msgSource, msgBox) {
        if (!msgBox) {
            var allMsgBoxes
                = $('pinContainer').getElements('.pinResultMsg');
            Array.each(allMsgBoxes, function(msgBox, index){
                msgBox.set('html', msgSource.innerHTML);
                msgBox.set(
                    'class', msgSource.get('class') + ' pinResultMsg'
                );
            });
        } else {
            msgBox.set('html', msgSource.innerHTML);
            msgBox.set('class', msgSource.get('class') + ' pinResultMsg');
        }
    },

    BigPointGameCardCloneInputElement: function() {
        //get all input fields and clone last pinInputFields block
        var allInput = $('pinContainer').getElements('.pinInputFieldDiv');
        var blockCount = allInput.length;
        var inputFields = allInput.getLast();
        var clone = inputFields.clone(true, true);
        var pinParts = clone.getElements('.gamecard_inputField');
        clone.inject(inputFields, 'after');

        //clean fields
        Array.each(pinParts, function(part, index){
            part.value = '';
            part.name = 'pin' + (blockCount) + '[' + index  + ']';
        });
        clone.getElement('.pinResultMsg').set('html', '');
        clone.getElement('.pinPriceMsg').set('html', '');
        //make unnesseary fields transparency
        this.BigPointGameCardShowFields(
            clone, clone.getElement('.pinlength').value
        )
        clone.getElement('.pinlength').value = '';
    },

    BigPointGameCardGetInputFieldsByPin: function(pin) {
        var res = false;
        var allInput = $('pinContainer').getElements('.pinInputFieldDiv');
        Array.each(allInput, function(inputDiv, indexInput){
            var pinParts = inputDiv.getElements('.gamecard_inputField');
            var pinCode = '';
            Array.each(pinParts, function(part, indexParts){
                pinCode += part.value;
            });
            if (pinCode == pin) {
                res = inputDiv;
            }
        });
        return res;
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //Epay pin functionalities, done in the "epin" way
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpayEpayOnClick: function(element) {
        HandlePayment.buildpayEpayOnInputchange(element);
    },

    buildpayEpayOnInputchange: function(element) {
        element = document.id(element);
        var parent = element.getParent('div');
        var actaulEpayParts = parent.getChildren('input');
        var actualPartNr = element.id.substr(3,1)
        var sizeOfField = (actualPartNr == 0) ? 3 : 4;
        //get prev and next input field if exists
        var prev = false;
        var next = false;
        Array.each(actaulEpayParts, function(part, index){
            if ((parseInt(actualPartNr) - 1) == index) {
                prev = part;
            }
            if ((parseInt(actualPartNr) + 1) == index) {
                next = part;
            }
        });

        element.value = element.value.toUpperCase();
        if (element.value.length > sizeOfField) {
            var t = new String(element.value);
            element.value = t.substr(0,sizeOfField);
            if (next) {
                next.focus();
                next.value = t.substr(sizeOfField, t.length - sizeOfField);
                next.onchange();
            }
        } else if (element.value.length == 0 && prev) {
            prev.focus();
        }
    },

    buildpayEpayCheckPinCode: function(cur) {
        //check if all Epay numbers are used
        cur = document.id(cur);
        var actualPinContainer = cur.getParent('div');
        var actaulEpayParts = actualPinContainer.getChildren('input');
        var count = 0;
        Array.each(actaulEpayParts, function(part, index){
            count += part.value.length;
        });
        if (count == 11) {
            //get pin codes
            var container = $('pinContainer');
            var EpayCodeContainer = container.getChildren('div');
            var pinCodes = [];
            Array.each(EpayCodeContainer, function(inputFields, indexC){
                var EpayParts = inputFields.getChildren('input');
                var EpayCode = '';
                Array.each(EpayParts, function(part, indexI){
                    EpayCode += part.value;
                });
                var actualEpay = [];
                actualEpay[indexC] = EpayCode;
                if (actualEpay[indexC].length == 11) {
                    var noMerge = false;
                    var index = 0;
                    Array.each(pinCodes, function(code, key) {
                        if (code == actualEpay[indexC]) {
                            inputFields.dispose();
                            noMerge = true;
                        }
                        index = parseInt(key) + 1;
                    });
                    if (!noMerge) {
                        pinCodes[index] = actualEpay[indexC];
                    }

                } else {
                    //delete incomplete input blocks
                    inputFields.dispose();
                }
            });
            Util.apiRequest(
                'gameapi.jsonPaymentInfo', {
                    'module': 'buildpay_epay',
                    'action': 'getInfo',
                    'data': {'pins': pinCodes}
                },
                function(res) {
                    HandlePayment.buildpayEpayCheckPinCodeCallback(res)
                }
            );
        } else {
            var msgBox = actualPinContainer.getElement('span[id=EpayResultMsg]');
            HandlePayment.buildpayEpaySetResultMsg(
                $('EpayResultMsgInsufficient'), msgBox
            );
        }
    },

    buildpayEpayCheckPinCodeCallback: function(result) {
        //if error display message
        if (result.res.status == 'ERROR') {
            HandlePayment.buildpayEpaySetResultMsg($('EpayResultMsgPinError'));
        }

        if (result.res.status == 'BLACKLIST') {
            HandlePayment.buildpayEpaySetResultMsg($('EpayResultMsgBlacklist'));
        }

        var objectKeys = [];
        for (var key in result.res.pinData) {
            if (result.res.pinData.hasOwnProperty(key)) {
                objectKeys.push(key);
            }
        }

        //set Epay result data
        var allPinValid = true;
        var count = 0;
        Array.each(objectKeys, function(EpayCode, index) {
            var EpayData = result.res.pinData[EpayCode];
            //get PinContainer by code
            var inputDiv = HandlePayment.buildpayEpayGetInputFieldsByEpay(EpayCode);
            var msgBox = inputDiv.getElement('span[id=EpayResultMsg]');
            switch (EpayData.status) {
                case 'valid':
                    var htmlPrice = '';
                    if (EpayData.formattedItemPrice) {
                        htmlPrice = EpayData.formattedPrice + ' ('
                            + EpayData.formattedItemPrice + ')';
                    } else {
                        htmlPrice = EpayData.formattedPrice;
                    }
                    msgBox.set('html', htmlPrice);
                    var priceClass = '';
                    if (result.res.pinAmountEnough) {
                        priceClass = 'fontColor_success';
                    }
                    msgBox.set('class', priceClass);
                    break;
                case 'insufficient':
                    HandlePayment.buildpayEpaySetResultMsg($('EpayResultMsgInsufficient'), msgBox);
                    break;
                case 'used':
                    HandlePayment.buildpayEpaySetResultMsg($('EpayResultMsgUsed'), msgBox);
                    allPinValid = false;
                    break;
                case 'pinerror':
                    HandlePayment.buildpayEpaySetResultMsg($('EpayResultMsgPinError'), msgBox);
                    allPinValid = false;
                    break;
            }
        });
        //add one more Epay input field if neccessary
        if (
            allPinValid && !result.res.pinAmountEnough && !result.res.status
            ) {
            HandlePayment.buildpayEpayCloneInputElement();
        }
    },

    buildpayEpaySetResultMsg: function(msgSource, msgBox) {
        if (!msgBox) {
            var allMsgBoxes
                = $('pinContainer').getElements('span[id=EpayResultMsg]');
            Array.each(allMsgBoxes, function(msgBox, index){
                msgBox.set('html', msgSource.innerHTML);
                msgBox.set('class', msgSource.get('class'));
            });
        } else {
            msgBox.set('html', msgSource.innerHTML);
            msgBox.set('class', msgSource.get('class'));
        }
    },

    buildpayEpayCloneInputElement: function() {
        //get all input fields and clone last EpayInputFields block
        var container = $('pinContainer');
        var allInput = container.getElements('div[id=EpayInputFields]');
        var blockCount = allInput.length;

        //just clone if not more as 10 code fields exists
        if (blockCount < 10) {
            var inputFields = allInput.getLast();
            var clone = inputFields.clone(true, true);
            var EpayParts = clone.getChildren('input');
            clone.inject(inputFields, 'after');

            //clean fields
            Array.each(EpayParts, function(part, index){
                part.value = '';
                part.name = 'pin' + (blockCount) + '[' + index  + ']';
            });
            clone.getElement('span[id=EpayResultMsg]').set('html', '');
        }
    },

    buildpayEpayGetInputFieldsByEpay: function(Epay) {
        var res = false;
        var container = $('pinContainer');
        var allInput = container.getElements('div[id=EpayInputFields]');
        Array.each(allInput, function(inputDiv, indexInput){
            var EpayParts = inputDiv.getChildren('input');
            var EpayCode = '';
            Array.each(EpayParts, function(part, indexParts){
                EpayCode += part.value;
            });
            if (EpayCode == Epay) {
                res = inputDiv;
            }
        });

        return res;
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpayOgoneOnClickSend: function(module) {

        HandlePayment.popup = window.open("", "externalpayment", "width=800,height=600,left=100,top=200,scrollbars=yes");

        var obj = new Object();
        var len = document.getElementById("frm").elements.length;
        for(var i=0; i<len; i++) {
            var elem = document.getElementById("frm").elements[i].name;
            if (elem.substr(0, 8) == "userinfo") {
                var val = elem.substr(9);
                val = val.substr(0, val.length - 1);
                obj[ val ] = document.getElementById("frm").elements[i].value;
            }
        }
        if (!module) {
        	module = 'buildpay_ogone';
        }
        getPaymentInfo(module, 'info', obj, HandlePayment.buildpayOgoneCallbackClickSend);
    },

    buildpayOgoneCallbackClickSend: function(res) {
        if (res['url']) {
            HandlePayment.popup.location.href= res['url'];
            $('inp_step').value = 7;
            AjaxFormHandler.reloadHandlePayment(res['accountID'], $('frm'));
            //location.href='index.es?action=doPayment&step=7&' + getSession();
        } else {
            HandlePayment.popup.close();
            //document.getElementById('frm').submit();
        }
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpayRamblerOpenRamblerIframe: function(url) {
        $('ramblerIframe').src = url;
        $('ramblerIframeLayer').style.display = 'inline';
    },

    buildpayRamblerCloseRamblerIframe: function() {
        $('ramblerIframeLayer').style.display='none';
        //$('ramblerIframe').src='#';
    },

 // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpayEprepagOnClickSend: function() {

        var obj = new Object();
        var len = document.getElementById('frm_buildpay').elements.length;
        var email = '';
        var emailElementNo = 0;
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/;

        for(var i=0; i<len; i++) {
            var elem =
                document.getElementById('frm_buildpay').elements[i].name;
            if (elem == 'email') {
            	email =
            	    document.getElementById('frm_buildpay').elements[i].value;
            	emailElementNo = i;
            }
        }

        if (emailPattern.test(email)) {
            HandlePayment.popup = window.open(
                    '', 'externalpayment',
                    'width=800,height=600,left=100,top=200,scrollbars=yes'
                );

            obj[elem] = email;
            getPaymentInfo(
                    'buildpay_eprepag', 'info', obj,
                    HandlePayment.buildpayEprepagClickSendCallback
                );
        } else {
        	document.getElementById('frm_buildpay').elements[emailElementNo].value = '';
        }

    },

    buildpayEprepagClickSendCallback: function(res) {
        if (res['post']['html']) {
        	HandlePayment.popup.document.write(res['post']['html']);
        	HandlePayment.popup.document.getElementById('eprepag').submit();
        	$('step').value = 7;
            AjaxFormHandler.reloadHandlePayment(
                res['accountID'], $('frm_buildpay')
            );
        } else {
            HandlePayment.popup.close();
        }
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpayXsollaOnClickSend: function(moduleType) {
        var obj = new Object();
        var len = document.getElementById('frm_buildpay').elements.length;

        for (var i=0; i<len; i++) {
        	var elem = document.getElementById('frm_buildpay').elements[i];
            switch (elem.name) {
                case 'email':
                    obj['email'] = elem.value;
                    break;
                case 'phone':
                    obj['phone'] = elem.value;
                    break;
            }
        }

        HandlePayment.popup = window.open(
            '', 'externalpayment',
            'width=800,height=600,left=100,top=200,scrollbars=yes'
        );
        getPaymentInfo(
            moduleType, 'info', obj,
            HandlePayment.buildpayXsollaClickSendCallback
        );
    },

    buildpayXsollaClickSendCallback: function(res) {
        if (res['url'] && res['get']) {
            HandlePayment.popup.location.href= res['url'] + res['get'];
            $('step').value = 7;
            AjaxFormHandler.reloadHandlePayment(
                res['accountID'], $('frm_buildpay')
            );
        } else {
            HandlePayment.popup.close();
        }
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpaySofortUeberweisungOnClickSend: function(moduleType) {
        //build param object out of form data
        var obj = new Object();
        var error = [];
        var len = document.getElementById('frm_buildpay').elements.length;
        for (var i=0; i<len; i++) {
            var elem = document.getElementById('frm_buildpay').elements[i];
            switch (elem.name) {
                case 'bankCode':
                    obj['bankCode'] = elem.value;
                    if (!HandlePayment.buildpaySofortUeberweisungCheckBankcode(elem.value)) {
                        error.push($('bankCode'));
                    }
                    break;
            }
        }

        var noError = true;
        Array.each(error, function(element, index){
            element.setStyle('background-color', "#FFC0C0");
            element.setStyle('color', "#000000");
            noError = false;
        });

        if (noError) {
            HandlePayment.popup = window.open(
                '', 'externalpayment',
                'width=800,height=600,left=100,top=200,scrollbars=yes'
            );

            getPaymentInfo(
                moduleType, 'info', obj,
                HandlePayment.buildpaySofortUeberweisungClickSendCallback
            );
        } else {
            $('overlayNextBtn').setStyle('display', 'block');
            Payment.unsetWaitingScreen();
        }
    },

    buildpaySofortUeberweisungClickSendCallback: function(res) {
        if (res['url']) {
            HandlePayment.popup.location.href = res['url'];
            try {
                HandlePayment.popup.resizeTo(
                    res['width'], res['height']
                );
            } catch(e) {
                //continue if resize not possible
            }
            $('step').value = 2;
        } else {
            $('step').value = 1;
            HandlePayment.popup.close();
        }
        AjaxFormHandler.reloadHandlePayment(
            res['accountID'], $('frm_buildpay')
        );
        Payment.unsetWaitingScreen();
    },

    buildpaySofortUeberweisungCheckBankcode: function(bankCode) {
        if (/^\d+$/.test(bankCode) && bankCode.length > 2) {
            return true;
        } else {
            return false;
        }
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpayGiroconnectOnClickSend: function(moduleType) {
        //build param object out of form data
        var obj = new Object();
        var error = [];
        var len = document.getElementById('frm_buildpay').elements.length;
        for (var i=0; i<len; i++) {
            var elem = document.getElementById('frm_buildpay').elements[i];
            switch (elem.name) {
                case 'bankCode':
                    obj['bankCode'] = elem.value;
                    if (!HandlePayment.buildpayGiroconnectCheckBankcode(elem.value)) {
                        error.push($('bankCode'));
                    }
                    break;
            }
        }

        var noError = true;
        Array.each(error, function(element, index){
            element.setStyle('background-color', "#FFC0C0");
            element.setStyle('color', "#000000");
            noError = false;
        });

        if (noError) {
            HandlePayment.popup = window.open(
                '', 'externalpayment',
                'width=800,height=600,left=100,top=200,scrollbars=yes'
            );

            getPaymentInfo(
                moduleType, 'info', obj,
                HandlePayment.buildpayGiroconnectClickSendCallback
            );
        } else {
            $('overlayNextBtn').setStyle('display', 'block');
            Payment.unsetWaitingScreen();
        }
    },

    buildpayGiroconnectClickSendCallback: function(res) {
        if (res['url']) {
            HandlePayment.popup.location.href = res['url'];
            try {
                 HandlePayment.popup.resizeTo(
                    res['width'], res['height']
                 );
            } catch(e) {
                //continue if resize not possible
            }
            $('step').value = 2;
        } else {
            $('step').value = 1;
            HandlePayment.popup.close();
        }
        AjaxFormHandler.reloadHandlePayment(
            res['accountID'], $('frm_buildpay')
        );
        Payment.unsetWaitingScreen();
    },

    buildpayGiroconnectCheckBankcode: function(bankCode) {
        if (/^\d+$/.test(bankCode) && bankCode.length == 8) {
            return true;
        } else {
            return false;
        }
    },

    buildpayGiroconnectIDOnClickSend: function(moduleType) {
        //build param object out of form data
        var obj = new Object();

        var len = document.getElementById('frm_buildpay').elements.length;
        for (var i=0; i<len; i++) {
            var elem = document.getElementById('frm_buildpay').elements[i];
            switch (elem.name) {
                case 'bankCode':
                    obj['bankCode'] = elem.value;
                    break;
            }
        }

        HandlePayment.popup = window.open(
            '', 'externalpayment',
            'width=800,height=600,left=100,top=200,scrollbars=yes'
        );

        getPaymentInfo(
            moduleType, 'info', obj,
            HandlePayment.buildpayGiroconnectClickSendCallback
        );
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    buildpayPproSofortueberwOnClickSend: function(moduleType) {
        //build param object out of form data
        var obj = new Object();
        var error = [];
        var len = document.getElementById('frm_buildpay').elements.length;
        for (var i=0; i<len; i++) {
            var elem = document.getElementById('frm_buildpay').elements[i];
            switch (elem.name) {
                case 'bankCode':
                    obj['bankCode'] = elem.value;
                    if (!HandlePayment.buildpayPproSofortueberwCheckBankcode(elem.value)) {
                        error.push($('bankCode'));
                    }
                    break;
                case 'accountNr':
                    obj['accountNr'] = elem.value;
                    if (!HandlePayment.buildpayPproSofortueberwCheckAccountNr(elem.value)) {
                        error.push($('accountNr'));
                    }
                    break;
            }
        }

        var noError = true;
        Array.each(error, function(element, index){
            element.setStyle('background-color', "#FFC0C0");
            element.setStyle('color', "#000000");
            noError = false;
        });

        if (noError) {
            HandlePayment.popup = window.open(
                '', 'externalpayment',
                'width=800,height=600,left=100,top=200,scrollbars=yes'
            );

            getPaymentInfo(
                moduleType, 'info', obj,
                HandlePayment.buildpayPproSofortueberwClickSendCallback
            );
        } else {
            $('overlayNextBtn').setStyle('display', 'block');
            Payment.unsetWaitingScreen();
        }
    },

    buildpayPproSofortueberwClickSendCallback: function(res) {
        if (res['url']) {
            HandlePayment.popup.location.href = res['url'];
            try {
                 HandlePayment.popup.resizeTo(
                    res['width'], res['height']
                 );
            } catch(e) {
                //continue if resize not possible
            }
            $('step').value = 2;
        } else {
            $('step').value = 1;
            HandlePayment.popup.close();
        }
        AjaxFormHandler.reloadHandlePayment(
            res['accountID'], $('frm_buildpay')
        );
        Payment.unsetWaitingScreen();
    },

    buildpayPproSofortueberwCheckBankcode: function(bankCode) {
        if (/^\d+$/.test(bankCode) && (bankCode.length == 5 || bankCode.length == 8)) {
            return true;
        } else {
            return false;
        }
    },

    buildpayPproSofortueberwCheckAccountNr: function(accountNr) {
        if (/^\d+$/.test(accountNr) && accountNr.length >= 3 &&  accountNr.length <= 11) {
            return true;
        } else {
            return false;
        }
    },


    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    activeVoucher: null,

    voucherCallbackClickSend: function(res) {
        if (res['result'] == 'OK') {
            Payment.allowedAccounts = res['allowedPayments'];
            res['restrictedPayments'].each(
                function(item, index) {
                    Payment.restrictedAccounts[index] = item;
                }
            );

            if (Payment.methodOpen === true) {
                Payment.checkPayments();
                Payment.checkFastPay();
                Payment.calcSums('foo');
            }
            Payment.checkVoucherSmsPhone();
            Payment.priceEventListener.add(HandlePayment.voucherPriceEventHandler);

            if ($('voucherButton')) {
                $('voucherButton').style.visibility = "hidden";
                $('voucherButtonDiv').setStyle('padding', "5px");
                $('voucherButtonDiv').innerHTML = res['voucherActivatedText'];
            }

            HandlePayment.activeVoucher = res;

            window.addEvent('domready', function() {
                HandlePayment.voucherPriceEventHandler(new EventPriceChange('', 0));
            });
        }
    },

    voucherPriceEventHandler: function(event)
    {
        var newPrice = event.getPrice();
        if (HandlePayment.activeVoucher.activationTexts) {
            HandlePayment.activeVoucher.activationTexts.each(
                function(item, index) {
                    var diffPrice = newPrice - (item.factor * newPrice + item.additional);
                    newPrice = item.factor * newPrice + item.additional

                    HandlePayment.addVoucherBonusDescription(
                        'voucherBonus'+index,
                        item.description,
                        item.bonus,
                        (diffPrice != 0) ? diffPrice : '',
                        (diffPrice != 0) ? ((item.additionalCurrency) ? item.additionalCurrency : event.getCurrency()) : ''
                    );
                }
            );
        }

        if (newPrice != 0 && event.getCurrency() != "") {
            HandlePayment.addVoucherBonusDescription(
                'voucherBonusTotal',
                Payment.lang.get('total'),
                '',
                newPrice,
                event.getCurrency()
            );
        }

    },

    addVoucherBonusDescription: function(id, description, value, amount, currency)
    {
        // first, remove old description
        if ($(id)) {
            $(id).destroy();
        }

        var icon = new Element('div', {'class':'cartItemSmallIcon','style':''});
        var description = new Element('div',{'class':'cartItemDescription','html':description});
        var deleteBtn = new Element('div',{'class':''});
        var price = new Element('div',{'class':'cartItemPrice','html':''});
        var discount = new Element('div',{'class':'cartItemVoucherBonus','html':value});
        var clear = new Element('div',{'class':'clear'});
        var item = new Element('div',{'id':id,'class':'shoppingCartItem','style':'opacity:0;'});
        item.adopt(icon,description,deleteBtn,price,discount,clear);
        $('shoppingCartListContainer').adopt(item);

        if (amount != 0) {
            setPriceInElement(amount, currency, price);
        } else {
            price.set('html', amount+""+currency);

        }

        item.style.opacity="0";
        Util.fadeIn(item.id, 0.0, 1.0, 500);
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    buildpayBasitChangeMethod: function(value)
    {
        $('basitodemeDiv').getElements('.basit_chooseDiv').addClass('hidden');
        $('basitodemeDiv').getElements('.basit_chooseDiv').set('style', '');
        if ($('choose_' + value)) {
            $('choose_' + value).removeClass('hidden');
            //Util.fadeIn('choose_' + value, 0.0, 1.0, 1500);
            if (value == 'cafe') {
                this.buildpayBasitChangeDetail(
                    value, $('cafeCity').value
                );
            } else {
                this.buildpayBasitChangeDetail(
                    value, $('choose_' + value).getElement('#' + value).value
                );
            }
        } else {
            this.buildpayBasitChangeDetail(value, 1);
        }
    },

    buildpayBasitChangeDetail: function(type, id)
    {
        $('basitodemeDiv').getElements('.basit_detailDiv').addClass('hidden');
        $('basitodemeDiv').getElements('.basit_detailDiv').set('style', '');
        $('basitodemeDiv').getElements('.choose_bankOption').addClass(
            'hidden'
        );
        $('basitodemeDiv').getElements('.choose_cafeOption').addClass(
            'hidden'
        );

        if ($('detail_' + type + '_' + id)) {
            $('detail_' + type + '_' + id).removeClass('hidden');
            //Util.fadeIn('detail_' + type + '_' + id, 0.0, 1.0, 1500);
        } else if ($('detail_' + type)) {
            $('detail_' + type).removeClass('hidden');
            //Util.fadeIn('detail_' + type, 0.0, 1.0, 1500);
        }

        if (
            (type == 'bank' || type == '')
            && $('choose_bankOption_' + id)
        ) {
            $('basitodemeDiv').getElements('.basit_chooseOptionDiv').set(
                'style', ''
            );
            $('choose_bankOption_' + id).removeClass('hidden');
            //Util.fadeIn('choose_bankOption_' + id, 0.0, 1.0, 1500);
        }

        if (
            (type == 'cafeCity' || type == 'cafe')
            && $('choose_cafeOption_' + $('cafeCity').value)
        ) {
            $('choose_cafeOption_' + $('cafeCity').value).removeClass('hidden');
            this.buildpayBasitChangeCafe('cafe', $('cafe_' + $('cafeCity').value).value);
        }
    },

    buildpayBasitChangeCafe: function(type, id)
    {
        $('basitodemeDiv').getElements('.basit_detailDiv').addClass('hidden');
        $('basitodemeDiv').getElements('.basit_detailDiv').set('style', '');

        if ($('detail_' + type + '_' + id)) {
            $('detail_' + type + '_' + id).removeClass('hidden');
            //Util.fadeIn('detail_' + type + '_' + id, 0.0, 1.0, 1500);
        } else if ($('detail_' + type)) {
            $('detail_' + type).removeClass('hidden');
            //Util.fadeIn('detail_' + type, 0.0, 1.0, 1500);
        }
    },

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    kongregate: null,

    buildpayKongregateStep1: function() {




    },

    fastPayGetAccount: function() {
        var radio = document.getElementsByName("transactionId");

        for(var i=0;radio[i];i++) {
            if(radio[i].checked) return ($(radio[i].value).value);
        }
    },

    buildpayKongregateLoadCompleted: function() {

    },

    directOverlaySelectionLoaded: function(params) {
        for (i=0; i<params.accountIDs.length; i++) {
            //alert('bla: '+params.descriptions[params.accountIDs[i]]);
            new ToolTipper('directOverlayPaymentMethod_'+params.accountIDs[i], params.descriptions[params.accountIDs[i]]);
        }
    },

    currencySwapInit: function(params) {
        initSwapTexts();
        if ($('swapCurrencySwitchlineA')) {
            $('swapCurrencySwitchlineA').addEvent('click', function(e) {
                onClickSwapHeader();
            });
        }
    },

    secureMethodCallBack: function(errorMsg) {
        Payment.paymentAccounts.each(
            function(item, index) {
                if (item.secureMethod !== true && item.id > 0) {
                    Payment.restrictedAccounts[item.id] = item.id;
                }
            }
        );
        Payment.checkPayments();
        Payment.checkFastPay();
        Payment.calcSums('foo');
        Payment.onlySecureMethods = true;
        Payment.updateItemGroup(getDefaultItemGroup());
        if (errorMsg !== false) {
            Payment.showAdditionalOverlay('error', errorMsg);
        }
    },

    setFocusToField: function(fieldId) {
        $(fieldId).focus();
    },

    webbillingRetry: function(params) {
        (function(params) {
            if (Payment.overlayOpen === true) {
                Payment.reloadHandlePayment(params.accountId, params.data);
            }
        }).delay(params.seconds * 1000, Payment, [params]);
    },

    phoneRetry: function(params) {
        (function(params) {
            if (Payment.overlayOpen === true) {

                Payment.reloadHandlePayment(params.accountId, params.data);
            }

        }).delay(params.seconds * 1000, this, [params]);
    },

    openOverlay: function(params) {
        var overlay = new Overlay(params.text);
        var overlayClass = overlay.getCssClass();
        overlay.execActions();

        Payment.enableOverlay(params.text, overlayClass);
        Payment.unsetWaitingScreen();
    }



}


function buildpayKongregateLoadCompleted() {

}

