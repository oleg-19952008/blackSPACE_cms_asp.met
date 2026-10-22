$(function(){if($('.slider').length) {	
			$('.slider')._TMS({
				prevBu:'.button_prev',
				nextBu:'.button_next',
				duration:800,
				easing:'easeInOutExpo',
				preset:'gorizontalLines',
				pagination:'.pagination',//'.pagination',true,'<ul></ul>'
				pagNums:false,
				slideshow:6000,
				numStatus:false,
				banners:false,// fromLeft, fromRight, fromTop, fromBottom
				waitBannerAnimation:false,
				progressBar:false
				})
				   } })
			$(function(){
			   $('.pagination li').hover(
					function(){$(this).find('em').stop().animate({width:109},500)},
					function(){$(this).not('.current').find('em').stop().animate({width:0},500)}
					);
			})
			$(function(){
			   $('dl dd:even').addClass('alt');
			})
	$(function(){if($('.scroll-pane').length) {var pane = $('.scroll-pane');
				pane.jScrollPane(
					{
						showArrows: true,
						animateScroll: true
					}
				);
				var api = pane.data('jsp');
				$('#but-scroll-by').bind(
					'click',
					function()
					{
						api.scrollBy(parseInt($('#byX').val()), parseInt($('#byY').val()));
						return false;
					}
				);} })
			
	$(function(){if($('.scroll-pane2').length) {var pane = $('.scroll-pane2');
				pane.jScrollPane(
					{
						showArrows: true,
						animateScroll: true
					}
				);
				var api = pane.data('jsp');
				$('#but-scroll-by').bind(
					'click',
					function()
					{
						api.scrollBy(parseInt($('#byX').val()), parseInt($('#byY').val()));
						return false;
					}
				);} })