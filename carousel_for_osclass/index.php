<?php
/*
Plugin Name: Carousel for Osclass
Plugin URI: http://www.osclass.org/
Description: 
Version: 0.9.2
Author: kingsult
Author URI: 
Short Name: CarouselforOsclass
Plugin update URI: 
*/

    function carouselosclass_call_after_install() {
        // Insert here the code you want to execute after the plugin's install
        // for example you might want to create a table or modify some values
	    $conn = getConnection();
	    $conn->autocommit(false);
		try {
        $conn->commit();
        osc_set_preference('carousel_items', '4', 'plugin-carousel_for_osclass', 'INTEGER');
        osc_set_preference('carousel_autoscroll', '1', 'plugin-carousel_for_osclass', 'BOOLEAN');
	osc_set_preference('carousel_scrolldelay', '2800','plugin-carousel_for_osclass','INTEGER');
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
		
        }

    function carouselosclass_call_after_uninstall() {
        // Insert here the code you want to execute after the plugin's uninstall
        // for example you might want to drop/remove a table or modify some values
		 $conn = getConnection();
		 $conn->autocommit(false);
			try {
				osc_delete_preference('carousel_items', 'plugin-carousel_for_osclass');
                		osc_delete_preference('carousel_autoscroll', 'plugin-carousel_for_osclass');
                		osc_delete_preference('carousel_scrolldelay', 'plugin-carousel_for_osclass');
			}   catch (Exception $e) {
				$conn->rollback();
				echo $e->getMessage();
			}
			$conn->autocommit(true);
		}
		$conn = getConnection();
		try {
        
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
       
    // HELPER
    function osc_carousel_items() {
        return(osc_get_preference('carousel_items', 'plugin-carousel_for_osclass')) ;
    }
    
    function osc_carousel_autosp() {
        return(osc_get_preference('carousel_autoscroll', 'plugin-carousel_for_osclass')) ;
    }
    
    function osc_carousel_scrolldelay() {
        return(osc_get_preference('carousel_scrolldelay', 'plugin-carousel_for_osclass')) ;
    }
    
    // Self-explanatory
    function carousel() {
        
        require_once 'carousel_detail.php';
    }
    
    // Self-explanitory
    function carouselosclass_js(){ ?>
    <?php 
    $items = (osc_carousel_items() != '') ? osc_carousel_items() : '' ;
    $autosp = (osc_carousel_autosp() != '') ? osc_carousel_autosp() : '' ;
    $scrolldelay = (osc_carousel_scrolldelay() != '') ? osc_carousel_scrolldelay() : '' ;
    ?>
    	<style type="text/css">
    	  <?php $cssurl = 'oc-content/plugins/carousel_for_osclass/css/slideshow.css' ;
    		include($cssurl) ; ?>
    	</style>

  	<script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/carousel_for_osclass/js/jCarouselLite.js'; ?>">
  	</script>
  	<script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/carousel_for_osclass/js/superfish.js'; ?>">
  	</script>
  	<script type='text/javascript'>
  	<?php
  	//used for enabling auto speed in carousel.
  	$autospeed = ',
					auto: ' . $scrolldelay . ' ,
					speed: 1100,';?>
					
  	<?php include('oc-content/plugins/carousel_for_osclass/js/theme-scripts.js'); ?>
  	</script>
  	 
<?php }

     function carouselosclass_admin_menu() {
        echo '<h3><a href="#">Carousel for Osclass</a></h3>
        <ul> 
            <li><a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/help.php') . '">&raquo; ' . __('F.A.Q. / Help', 'carousel') . '</a></li>
        </ul>';
    }

    function carouselosclass_admin() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin.php') ;
    }
    
    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'carouselosclass_admin');
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'carouselosclass_call_after_install');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__). '_uninstall', 'carouselosclass_call_after_uninstall');

    // Add js to header
    osc_add_hook('header', 'carouselosclass_js');
    osc_add_hook('admin_menu', 'carouselosclass_admin_menu');

?>
