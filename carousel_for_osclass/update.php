<?php 
	  $override = Params::getParam('force');
     /*update section */ 
	  if ((osc_get_preference('carousel_version', 'plugin-carousel_for_osclass') == '' ) || (cVersion() > osc_carousel_version() ) || ($override == 1)){
	  	update(cVersion());
	  }else {
	  	echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('The Carousel is up to date', 'carousel_for_osclass') . '.</p></div>';
	  }
	  
     function update($version) {
     	if($version <= '2.0'){
     	  osc_set_preference('carousel_vertical'     , '0','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_picOnly'      , '0','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_priceEnabled' , '1','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_width'        , '718','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_height'       , '120','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_Swidth'       , '140','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_Sheight'      , '110','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_b_color'      , '#E9F5F9','plugin-carousel_for_osclass','STRING');
	     osc_set_preference('carousel_i_color'      , '#94CEE4','plugin-carousel_for_osclass','STRING');
	     osc_set_preference('carousel_arrows'       , '0','plugin-carousel_for_osclass','INTEGER');
	     osc_set_preference('carousel_version'      , '2.0','plugin-carousel_for_osclass','STRING');
	   }
	   if($version <= '2.1') {
         osc_set_preference('carousel_version'      , '2.1','plugin-carousel_for_osclass','STRING');
      }
      if($version <= '2.2') {
         osc_set_preference('carousel_version'      , '2.2','plugin-carousel_for_osclass','STRING');
      }
      if($version <= '2.3') {
         osc_set_preference('carousel_version'      , '2.3','plugin-carousel_for_osclass','STRING');
      }
	     echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Carousel Updated to version', 'carousel_for_osclass') . ' ' . cVersion() . '.</p></div>';
     }
      /*end update section */
?>