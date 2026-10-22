var Main = {

    sId: null,
    clientTitleDefault:  Tools.Text.get("seo_title_client"),
    mapRevolutionDisplayMode: null,
    intervalId: null,
    windowSpaceMap: null,

    Initialize: function (mapRevolutionDisplayMode, sId) {

        this.sId = sId;
        this.mapRevolutionDisplayMode = mapRevolutionDisplayMode;
        this.fetchElements();
        this.initializeEventListeners();

    },

    fetchElements : function () {

    },

    /**
     * Listener when the web browser is focus / visible or not
     * FF3+, C13+, IE10+
     *
     */
    initializeEventListeners : function () {

        // use the property name to generate the prefixed event name
        var visProp = this.getHiddenProp();
        if (visProp) {
            var evtname = visProp.replace(/[H|h]idden/,'') + 'visibilitychange';
        //    document.addEventListener(evtname, this.visChange);
        }
    },

    /**
     * used by web window
     * @param key
     */
    openFlashClient:function (factionID) {

        var factionString = '';
        if (factionID >= 1 && factionID <= 3) {
            factionString = '&factionID=' + factionID;
        }

        var map = 'internalMapRevolution';

        var popupModifiers = "";

        if (this.mapRevolutionDisplayMode == "0") {
            var popupModifiers = 'width=' + screen.availWidth + ',' +
                'height=' + screen.availHeight + ',' +
                'top=0,' +
                'left=0,' +
                'menubar=no,' +
                'location=no,' +
                'titlebar=no,' +
                'status=yes,' +
                'toolbar=no,' +
                'resizable=yes';
        }

        var url = 'indexInternal.es?action=' + map + '&' + this.sId + factionString;
        if(this.windowSpaceMap == null || this.windowSpaceMap.closed) {
            this.windowSpaceMap = window.open('','spaceMap', popupModifiers);

            //workaround special case.
            if (this.windowSpaceMap.location.search.length == 0) {
                this.windowSpaceMap.location = url;
            }
        }

        this.windowSpaceMap.moveTo(0, 0);
        this.windowSpaceMap.resizeTo(screen.availWidth, screen.availHeight);
        this.windowSpaceMap.focus();

        this.stopCurrentBlinking(this.intervalId);
        this.intervalId =  this.blinkHtmlTitle(this.windowSpaceMap);

        //after 10 seconds we removed the current interval (fallback for IE<10)
        setTimeout(function () {
            Main.clearCurrentInterval(Main.intervalId)
        }, 10000)

    },

    stopCurrentBlinking: function(intervalId){

        if(intervalId != null){
            //console.log("removing... " + intervalId);
            clearInterval(intervalId);
            this.windowSpaceMap.document.title =  Tools.Text.get("seo_title_client");
        }

    },


    /**
     * used by web  window
     * @param key
     */
    visChange: function(){

            if(Main.windowSpaceMap){

                if (!Main.isHidden()){
                Main.windowSpaceMap.InternalMapRevolution.clearCurrentInterval(Main.intervalId);
                   setTimeout(function(){
                     window.document.title = Tools.Text.get("seo_title_standard")
                   },1000);
                }

            }

    },

    /**
     * used by web window
     * Enable in website a feedback form
     */

    getHiddenProp: function () {
        var prefixes = ['webkit', 'moz', 'ms', 'o'];

        // if 'hidden' is natively supported just return it
        if ('hidden' in document) return 'hidden';

        // otherwise loop over all the known prefixes until we find one
        for (var i = 0; i < prefixes.length; i++) {
            if ((prefixes[i] + 'Hidden') in document)
                return prefixes[i] + 'Hidden';
        }

        // otherwise it's not supported
        return null;
    },

    /**
     * used by web window
     * Enable in website a feedback form
     */

    isHidden: function () {
        var prop = this.getHiddenProp();
        if (!prop) return false;

        return document[prop];
    },


    /**
     * Returns default title
     *
     */
    getDefaultTitle: function(){
        return Main.clientTitleDefault;
    },

    blinkHtmlTitle: function(winRef){

        var isOldTitle = true;
        var oldTitle  = Tools.Text.get("seo_title_client");
        var newTitle  = Tools.Text.get("seo_title_client_blinking");

        var interval = null;

        function changeTitle2() {
            winRef.document.title = isOldTitle ? oldTitle : newTitle;
            isOldTitle = !isOldTitle;
            //console.log("Blinking..." + this.intervalId)
        }

        this.intervalId = setInterval(changeTitle2, 700);
        return this.intervalId;

    },

    /**
     *
     * Clear the current blink
     * (fallback for IE<10)
     * @param intervalId
     * @param clientTitleDefault
     */
    clearCurrentInterval: function(intervalId){

        //clear interval
        clearInterval(intervalId);
        //console.log("Clearing..." + this.intervalId)
        //set document title by default if needed.
        if (this.windowSpaceMap){
            this.windowSpaceMap.document.title =  Tools.Text.get("seo_title_client");
        }

    },

    /**
     * get Instancelist with xajax
     */
    getInstanceList: function() {
        showBusyLayer();
        xajax_getListOfInstances()
    }



}
