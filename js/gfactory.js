(function($) {	
	//= Collapsible Sidebar
	//////////////////////////////////////////////////////////////////////////////
	$('.brand').on('click', function(e) {
		e.preventDefault();	
			
		if ($('#browser').position().left == 242) {
			$('#browser').stop(true).animate({
				left: '0px'
			}, {
				duration: 340
			});
		} else {
			$('#browser').stop(true).animate({
				left: '242px'
			},{
				duration: 380		
			});			
		}
	});


	//= Accordion
	//////////////////////////////////////////////////////////////////////////////
	// Close all galleries' content
	$('.tab-content').slideUp();

	// A quick & simple accordion 
	jQuery.fn.quickAccordion = function(all_contents) {
		return this.each(function(i, domEl) {
			var $that = $(this);
			var $thatContent = $that.next();

			$that.on('click', function (e) {
				e.preventDefault();

				$(all_contents).not($thatContent).stop().slideUp();
				$thatContent.stop().slideToggle();
			});
		});
	};

	$('.tab').quickAccordion('.tab-content');
	$('.sub-tab').quickAccordion('.sub-tab-content');


	//= Image Viewer
	//////////////////////////////////////////////////////////////////////////////
	// CSS Classes
	var cssClasses  =  ['active', 'active-file'];

	// DOM Elements as jQ references
	var $nav  =  $('#sidebar-inner');
	var $main_image =  $('#main-img');
	var all_links = $nav.find('a');
	var i = 0;

	// Preload images...
	for (i; i < all_links.length; i += 1) {
		(new Image()).src = all_links[i].href;
	}

	$nav.click(function(e) {
		e.preventDefault();

		var $link, linkHref;
		var elem_tagname = e.target.nodeName.toLowerCase();

		if (elem_tagname === 'a') { 
			$link = $(e.target); 
		}	

		if ($link) {
			all_links.removeClass(cssClasses[1]);
			$link.addClass(cssClasses[1]);

			linkHref = $link.attr('href');
			$main_image.attr('src', linkHref);

			$('#img-name').text($link.attr('data-name'));

			$main_image.load(function() {
				$(this).css({'opacity':'0.0'}).stop().animate({'opacity':'1.0'}, 300); 
			});
		}
	});
}(jQuery));