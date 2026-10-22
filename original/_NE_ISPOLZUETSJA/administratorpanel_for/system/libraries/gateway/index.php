<?php

?>
<script src="js/jquery-1.11.0.min.js"></script>
<a href="payment.php" target="_blank" class="open_external">Payment Area</a>
<script type="text/javascript">
                

                    var openExternal = function (address, scroll) {
                        var external = window.open(address.replace(/\+/g,"%2B"), "paymentglobal", "width=840,height=680,left=100,top=200,scrollbars=" + scroll);
                        external.focus();
                    };

                    jQuery('document').ready(function(){
                        jQuery('.open_external').bind('click', function(evt){
                            evt.preventDefault();

                            var href = jQuery(this).attr('href');
                            openExternal(href,'no')
                        });

                        jQuery('.open_confirm').bind('click', function(evt){
                            evt.preventDefault();

                            var href = jQuery(this).attr('href');
                            confirmPackage(href)
                        });
                    });

                
                </script>