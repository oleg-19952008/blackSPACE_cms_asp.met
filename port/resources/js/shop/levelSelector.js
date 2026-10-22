/**
 * LevelSelector for DarkOrbit shop
 * 
 * @author  Wolfgang Timme <w.timme@bigpoint.net>
 */
Shop.LevelSelector = {
    Properties : {
        // Maximum level to choose
        maxLevel                    : -1,
        // Number of level the LevelSelector supports
        levelSupported              : 10,
        // Level offset of the level list
        // offset = 0: list is at top; offset = 1: second level is at the top, ...
        listOffset                  : 0,
        // Number of level visible at once
        levelVisibleAtOnce          : 3,
        // Duration of the scroll up/down animation in milliseconds
        scrollAnimationDuration     : 500,
        // Level the user selected
        selectedLevel               : -1
    },
    
    Initialize : function () {
        Shop.LevelSelector.fetchElements();
        Shop.LevelSelector.initializeEventListeners();
    },
    
    /**
     * Fetch all objects the shop needs later on
     * in order to speed up the application.
     * 
     * @author  Wolfgang Timme <w.timme@bigpoint.net>
     */
    fetchElements : function () {
        var levelSelector           = jQuery('#levelSelector'),
            allLevel                = levelSelector.find('.level'),
            i,
            levelArrayIndex,
            levelElementLibraryKey,
            levelSupported          = Shop.LevelSelector.getLevelSupported();
        
        Library.set('levelSelector',    levelSelector);
        Library.set('levelList',        levelSelector.find('#levelList'));
        Library.set('levelScrollUp',    levelSelector.find('#levelScrollUp'));
        Library.set('levelScrollDown',  levelSelector.find('#levelScrollDown'));
        Library.set('allLevel',         allLevel);

        // Get all level elements
        for (i = 1; i <= levelSupported; i++) {
            levelElementLibraryKey  = 'level' + i;
            levelArrayIndex         = i - 1;

            Library.set(levelElementLibraryKey, jQuery(allLevel[levelArrayIndex]));
        }
    },

    /**
     * Initialize all event listeners
     */
    initializeEventListeners : function () {
        var levelScrollUp   = Library.get('levelScrollUp'),
            levelScrollDown = Library.get('levelScrollDown'),
            allLevel        = Library.get('allLevel');
        
        // Add mouseOver/mouseDown events
        Tools.addDefaultMouseEventBehaviour(levelScrollUp);
        Tools.addDefaultMouseEventBehaviour(levelScrollDown);
        Tools.addDefaultMouseEventBehaviour(allLevel);

        // Add event listeners for scroll buttons
        levelScrollDown.live('click',   Shop.LevelSelector.Events.onScrollDownClick);
        levelScrollUp.live('click',     Shop.LevelSelector.Events.onScrollUpClick);

        // Add click event listeners for level buttons
        allLevel.live('click',          Shop.LevelSelector.Events.onLevelClick);
    },

    resetSelector : function () {
        var levelSupported          = Shop.LevelSelector.getLevelSupported(),
            maxLevelForActiveItem   = Shop.Item.getMaxLevel(),
            level,
            levelElementLibraryKey,
            levelElement;

        for (level = 1; level <= levelSupported; level++) {
            // Get jQuery HTML element for this level from Library.
            levelElementLibraryKey  = 'level' + level;
            levelElement            = Library.get(levelElementLibraryKey);

            if (level <= maxLevelForActiveItem) {
                levelElement.addClass('enabled');
            } else {
                levelElement.removeClass('enabled');
            }
        }

        // Set new max level
        Shop.LevelSelector.setMaxLevel(maxLevelForActiveItem);

        // Select level 1
        Shop.LevelSelector.selectLevel(1);

        // Update scroll button states
        Shop.LevelSelector.updateScrollButtonStates();

        // Reset level list position
        Shop.LevelSelector.resetLevelListPosition();
    },

    show : function () {
        Library.get('levelSelector').show();
    },

    hide : function () {
        Library.get('levelSelector').hide();
    },

    getLevelSupported : function () {
        return Shop.LevelSelector.Properties.levelSupported;
    },

    getMaxLevel : function () {
        return Shop.LevelSelector.Properties.maxLevel;
    },

    getLevelVisibleAtOnce : function () {
        return Shop.LevelSelector.Properties.levelVisibleAtOnce;
    },

    setMaxLevel : function (maxLevel) {
        Shop.LevelSelector.Properties.maxLevel = maxLevel;
    },

    getListOffset : function () {
        return Shop.LevelSelector.Properties.listOffset;
    },

    setListOffset : function (newOffset) {
        Shop.LevelSelector.Properties.listOffset = newOffset;
    },

    getScrollAnimationDuration : function () {
        return Shop.LevelSelector.Properties.scrollAnimationDuration;
    },

    getSelectedLevel : function () {
        return Shop.LevelSelector.Properties.selectedLevel;
    },

    setSelectedLevel : function (level) {
        Shop.LevelSelector.Properties.selectedLevel = level;
    },

    getListOffset : function () {
        return Shop.LevelSelector.Properties.listOffset;
    },

    setListOffset : function (listOffset) {
        Shop.LevelSelector.Properties.listOffset = listOffset;
    },

    updateScrollButtonStates : function () {
        var levelScrollUp               = Library.get('levelScrollUp'),
            levelScrollDown             = Library.get('levelScrollDown'),
            listOffset                  = Shop.LevelSelector.getListOffset(),
            maxListOffsetForActiveItem  = Shop.LevelSelector.getMaxListOffsetForActiveItem();
        
        if (0 === listOffset) {
            // List is at top; disable scroll up button.
            levelScrollUp.removeClass('enabled');
        } else {
            // List is not at top; enable scroll up button.
            levelScrollUp.addClass('enabled');
        }

        if (listOffset >= maxListOffsetForActiveItem) {
            // List is at bottom; disable scroll down button.
            levelScrollDown.removeClass('enabled');
        } else {
            // List is not at bottom; enable scroll down button.
            levelScrollDown.addClass('enabled');
        }
    },

    scrollUp : function () {
        var listOffset  = Shop.LevelSelector.getListOffset(),
            newOffset   = listOffset - 1;
        
        Shop.LevelSelector.updateLevelListOffset(newOffset);
    },

    scrollDown : function () {
        var listOffset  = Shop.LevelSelector.getListOffset(),
            newOffset   = listOffset + 1;
        
        Shop.LevelSelector.updateLevelListOffset(newOffset);
    },

    /**
     * Gets the maximum offset of the levelList for the active item.
     * 
     * @author  Wolfgang Timme <w.timme@bigpoint.net>
     */
    getMaxListOffsetForActiveItem : function () {
        var levelVisibleAtOnce      = Shop.LevelSelector.getLevelVisibleAtOnce(),
            maxLevelForActiveItem   = Shop.LevelSelector.getMaxLevel(),
            maxOffsetForActiveItem  = levelVisibleAtOnce >= maxLevelForActiveItem ? 0 : maxLevelForActiveItem - levelVisibleAtOnce;
        
        return maxOffsetForActiveItem
    },

    /**
     * Updates the levelList offset and scrolls the list.
     * 
     * @author  Wolfgang Timme <w.timme@bigpoint.net>
     */
    updateLevelListOffset : function (newOffset) {
        var levelVisibleAtOnce          = Shop.LevelSelector.getLevelVisibleAtOnce(),
            maxLevelForActiveItem       = Shop.LevelSelector.getMaxLevel(),
            maxOffsetForActiveItem      = Shop.LevelSelector.getMaxListOffsetForActiveItem(),
            isValidOffset               = 0 <= newOffset && newOffset <= maxOffsetForActiveItem,
            newMarginTop                = newOffset * -18,
            newMarginTopCSS             = newMarginTop + 'px',
            levelList                   = Library.get('levelList'),
            scrollAnimationDuration     = Shop.LevelSelector.getScrollAnimationDuration(),
            numAnimationsRunning        = levelList.queue('fx').length;
        
        if (isValidOffset) {
            // Check wether there is an animation already running for levelList
            if (0 < numAnimationsRunning) {
                // Stop all animations for levelList and clear queue.
                levelList.stop(true);
            }

            // Scroll down by one level, animated.
            levelList.animate({
                'marginTop' : newMarginTopCSS
            }, scrollAnimationDuration);

            // Set new offset
            Shop.LevelSelector.setListOffset(newOffset);

            // Update scroll button states
            Shop.LevelSelector.updateScrollButtonStates();
        }
    },

    /**
     * Resets the level list position so that it is scrolled to the top.
     * 
     * @author  Wolfgang Timme <w.timme@bigpoint.net>
     */
    resetLevelListPosition : function () {
        var levelList = Library.get('levelList');

        levelList.css('marginTop', '0px');
    },

    selectLevel : function (level, isTriggeredByUser) {
        var selectedLevelLibraryKey             = 'level' + level,
            selectedLevelElement                = Library.get(selectedLevelLibraryKey),
            isEnabled                           = selectedLevelElement.hasClass('enabled'),
            previouslySelectedLevel             = Shop.LevelSelector.getSelectedLevel(),
            previouslySelectedLevelLibraryKey   = 'level' + previouslySelectedLevel,
            previouslySelectedLevelElement      = Library.get(previouslySelectedLevelLibraryKey),
            alreadySelected                     = level === previouslySelectedLevel,
            isTriggeredByUser                   = 'undefined' !== typeof isTriggeredByUser && true === isTriggeredByUser;
        
        if (isEnabled && !alreadySelected) {
            // 'Unselect' previously selected level if there is one
            if (0 < previouslySelectedLevel) {
                previouslySelectedLevelElement.removeClass('selected');
            }

            // Mark as selected.
            selectedLevelElement.addClass('selected');

            // Store selected level
            Shop.LevelSelector.setSelectedLevel(level);

            // Tell Shop.Item about the level change if this has been
            // triggered by the user.
            if (isTriggeredByUser) {
                Shop.Item.updateInfoForLevelItem(true);
            }
        }
    },

    Events : {
        onScrollDownClick : function (event) {
            Shop.LevelSelector.scrollDown();
        },

        onScrollUpClick : function (event) {
            Shop.LevelSelector.scrollUp();
        },

        onLevelClick : function (event) {
            var btnLevel                            = jQuery(this),
                btnLevelId                          = btnLevel.attr('id'),
                levelAsString                       = btnLevelId.replace(/level/, ''),
                level                               = parseInt(levelAsString);
            
            Shop.LevelSelector.selectLevel(level, true);
        }
    }
};