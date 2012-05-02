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
		vertical: <?php if($vert == 1) { echo 'true';} else{ echo 'false';} ?>
        //easing: "easeOutQuint" // for different types of easing, see easing.js
    });

	

});

// ]]>
