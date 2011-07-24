/*
 * ClassiPress theme jQuery functions
 * Written by AppThemes
 *
 * Copyright (c) 2010 App Themes (http://appthemes.com)
 *
 * Built for use with the jQuery library
 * http://jquery.com
 *
 * Version 1.2
 *
 * Left .js uncompressed so it's easier to customize
 */

// <![CDATA[


jQuery(document).ready(function(){

	/* initialize the form validation */
    //jQuery("#mainform").validate({errorClass: "invalid"});

	/* featured listings slider */
    jQuery(".slider").jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev",
        visible: <?php echo $items; ?>,
		hoverPause:true<?php if($autosp == 1) { echo $autospeed; } ?>
        easing: "easeOutQuint" // for different types of easing, see easing.js
    });

	

	/* mouse over main image fade */
    jQuery(".img-main, .ad-gallery img").mouseover(function() {
        jQuery(this).stop().animate( {opacity:0.6}, 200);
	}).mouseout(function() {
		jQuery(this).stop().animate( {opacity:1}, 200 );
    });

	
	/* initialize the image previewer */
	imagePreview();

});


/* Tab Control home main */
jQuery(function () {
    var tabContainers = jQuery('div.tabcontrol > div');
    tabContainers.hide().filter(':first').show();
    jQuery('div.tabcontrol ul.tabnavig a').click(function () {
        tabContainers.hide();
        tabContainers.filter(this.hash).fadeIn(100);
        jQuery('div.tabcontrol ul.tabnavig a').removeClass('selected');
        jQuery(this).addClass('selected');
        return false;
    }).filter(':first').click();
});

/* Tab Control sidebar */
jQuery(function () {
    var tabs = [];
    var tabContainers = [];
	//get all of the tabs and tabcontrainers and place them into the arrays
    jQuery('ul.tabnavig a').each(function () {
      // note that this only compares the pathname, not the entire url
      // which actually may be required for a more terse solution.
        if (window.location.pathname.match(this.pathname)) {
            tabs.push(this);
            tabContainers.push(jQuery(this.hash).get(0));
        }
    });
	
	//hide all contrainers except execpt for the one from the URL hash or the first container
	if(window.location.hash != "" && window.location.hash.search('priceblock') >= 0){ 
		jQuery(tabContainers).hide().filter(window.location.hash).show(); 
		//detecting <a> tab using its "href" which should always equal the hash
		jQuery(tabs).filter( function (index) {return jQuery(this).attr("href") == window.location.hash;}).addClass('selected'); 

		jQuery("body").scrollTop;
	}
	else { 
		jQuery(tabContainers).hide().filter(':first').show()
		jQuery(tabs).filter(':first').addClass('selected'); 
	}
	
    jQuery(tabs).click(function () {
        // hide all tabs
        jQuery(tabContainers).hide().filter(this.hash).fadeIn(500);
        
        // set up the selected class
        jQuery(tabs).removeClass('selected');
        jQuery(this).addClass('selected');
        //this stops the browser from jumping down to the div
        return false;
    });
	jQuery("html").scrollTop(0);//because pageloads with hashes cause page to scroll
});


/*  nav drop-down menu */
jQuery(document).ready(function() {

	sfHover = function() {
	  var linksReady = '';
	  var sfEls = '';
	  linksReady = document.getElementById("#nav");
	  if (linksReady) {
		sfEld = document.getElementById("##nav").getElementsByTagName("li.page_item");
		if (sfEls) {
		  for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
			  this.className+=" sfhover";
			}
			sfEls[i].onmouseout=function() {
			  this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
			}
		  }
		}
	  }
	}

    if (window.attachEvent) window.attachEvent("onload", sfHover);

    jQuery('ul#nav').superfish({
                delay:       0,
//                animation:   {
//                    opacity: 'show',
//                    height: 'show'
//                },  
                speed:       'fast',                          
                disableHI:   true,  // set to true to disable hoverIntent detection
                autoArrows:  true,  
                dropShadows: false  
        });
});



this.imagePreview = function(){
    xOffset = 10;
    yOffset = 30;

    jQuery("a.preview").hover(function(e){
		adTitle = jQuery(this).find('img').attr('alt');
        jQuery("body").append("<div id='preview'><img src='"+ this.rel +"' alt='' /><p>"+ adTitle +"</p></div>");
        jQuery("#preview")
		.css("top",(e.pageY - xOffset) + "px")
		.css("left",(e.pageX + yOffset) + "px")
		.fadeIn("fast");
},
    function(){
        jQuery("#preview").remove();
});
    jQuery("a.preview").mousemove(function(e){
        jQuery("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px");
    });
};



// auto complete the search field with tags
jQuery(document).ready(function(){
	
	jQuery( "#s" ).autocomplete({
		source: function( request, response ) {
			jQuery.ajax({
				url: ajaxurl + "?action=ajax-tag-search-front&tax=ad_tag",
				dataType: "json",
				data: {
					term: request.term
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					//alert('ERROR!: '+ errorThrown);
					//alert('ERROR!: '+ textStatus);
					//alert('ERROR!: '+ XMLHttpRequest);
				},
				success: function( data ) {
					response( jQuery.map( data, function( item ) {
						return {
							term: item,
							value: item.name
						}
					}));
				}
			});//end ajax
		},
		minLength: 2
	});

});//document ready



// highlight search results
jQuery.fn.extend({
	highlight: function(search, insensitive, hclass){
		var regex = new RegExp("(<[^>]*>)|(\\b"+ search.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +")", insensitive ? "ig" : "g");
		return this.html(this.html().replace(regex, function(a, b, c){
			return (a.charAt(0) == "<") ? a : "<span class=\""+ hclass +"\">" + c + "</span>";
		}));
	}
  });


/* Form Checkboxes Values Function */
function addRemoveCheckboxValues($cbval, $cbGroupVals) {
	var $a;
    if($cbval.checked==true) {
        $a = document.getElementById($cbGroupVals);
        $a.value += ','+$cbval.value;
        $a.value = $a.value.replace(/^\,/,'');
    } else {
        $a = document.getElementById($cbGroupVals);
        $a.value = $a.value.replace($cbval.value+',','');
        $a.value = $a.value.replace($cbval.value,'');
        $a.value = $a.value.replace(/\,$/,'');
    }
}


//jQuery(document).ready(function(){
//	if(typeof(search_query) != 'undefined'){
//	  jQuery(".ad-right").highlight(search_query, 1, "highlighted");
//	}
//});



// featured slider images
//jQuery(window).load(function() {
//	jQuery('.captify').fadeIn('slow');
//});



// ]]>
