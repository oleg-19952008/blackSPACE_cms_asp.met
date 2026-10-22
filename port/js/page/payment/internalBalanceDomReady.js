jQuery('docuemnt').ready(function(){
    jQuery('#balanceListContainer').jScrollPane({autoReinitialise: true, showArrows: true});
    jQuery('ul.balance_items').eq(1).find('li:even').addClass('even');
});