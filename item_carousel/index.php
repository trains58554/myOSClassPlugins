<?php
/*
Plugin Name: Item Carousel
Plugin URI: http://www.osclass.org/
Description: This plugin extends main.php to embed an Item Carousel.
Version: 1.0
Author: JChapman & Keny
Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
Short Name: Carousel
Plugin update URI: 
*/

    function carousel_call_after_install() {
    	if(OSCLASS_VERSION >= '2.2') {$verOK = 1;}
        // Insert here the code you want to execute after the plugin's install
        // for example you might want to create a table or modify some values
	    $conn = getConnection();
	    $conn->autocommit(false);
		try {
        $conn->commit();
        osc_set_preference('item_carousel_items', '5', 'plugin-item_carousel', 'INTEGER');
        osc_set_preference('item_carousel_autoscroll', '1', 'plugin-item_carousel', 'BOOLEAN');
	osc_set_preference('item_carousel_scrolldelay', '4000','plugin-item_carousel','INTEGER');
	osc_set_preference('item_carousel_max_items', '10','plugin-item_carousel','INTEGER');
	osc_set_preference('item_carousel_price', '1','plugin-item_carousel','BOOLEAN');
	osc_set_preference('pic_enabled', '1','plugin-item_carousel','BOOLEAN');
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
    
    
   		
        }

    function carousel_call_after_uninstall() {
        // Insert here the code you want to execute after the plugin's uninstall
        // for example you might want to drop/remove a table or modify some values
		 $conn = getConnection();
		 $conn->autocommit(false);
			try {
				osc_delete_preference('item_carousel_items', 'plugin-item_carousel');
                		osc_delete_preference('item_carousel_autoscroll', 'plugin-item_carousel');
                		osc_delete_preference('item_carousel_scrolldelay', 'plugin-item_carousel');
				osc_delete_preference('item_carousel_max_items', 'plugin-item_carousel');
				osc_delete_preference('item_carousel_price', 'plugin-item_carousel');
				osc_delete_preference('pic_enabled', 'plugin-item_carousel');
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
    // HELPERS
    function osc_item_carousel_items() {
        return(osc_get_preference('item_carousel_items', 'plugin-item_carousel')) ;
    }
	function osc_item_carousel_max_items() {
        return(osc_get_preference('item_carousel_max_items', 'plugin-item_carousel')) ;
    }
    
    function osc_item_carousel_autosp() {
        return(osc_get_preference('item_carousel_autoscroll', 'plugin-item_carousel')) ;
    }
    
    function osc_item_carousel_scrolldelay() {
        return(osc_get_preference('item_carousel_scrolldelay', 'plugin-item_carousel')) ;
    }
    
    function osc_item_carousel_price() {
        return(osc_get_preference('item_carousel_price', 'plugin-item_carousel')) ;
    }
    
    function osc_pic_enabled() {
        return(osc_get_preference('pic_enabled', 'plugin-item_carousel')) ;
    }
    
    // Self-explanatory
    function carousel_item_detail() {
        require_once 'carousel_detail.php';
    }
    
    // Self-explanitory
    function carousel_js(){ ?>
    <?php 
    $items = (osc_item_carousel_items() != '') ? osc_item_carousel_items() : '' ;
    $autosp = (osc_item_carousel_autosp() != '') ? osc_item_carousel_autosp() : '' ;
    $scrolldelay = (osc_item_carousel_scrolldelay() != '') ? osc_item_carousel_scrolldelay() : '' ;
    $item_price_enabled = (osc_item_carousel_price() != '') ? osc_item_carousel_price() : '' ;
    $pictures_enabled = (osc_pic_enabled() != '') ? osc_pic_enabled() : '' ;
    //$items = '8';
    ?>
    	<style>
    		<?php 
    		if ($items==3){ $carouselWidth= '400px';}
    		elseif ($items==4){ $carouselWidth= '510px';}
    		else {$carouselWidth= '620px';}
    		//$carouselWidth = '950px';
    		$cssurl = 'oc-content/plugins/item_carousel/slideshow.css' ;
    		include($cssurl) ; ?>
    	</style>
    	<?php #<link href="<?php echo osc_base_url() . ('oc-content/plugins/item_carousel/slideshow.css') ; >" rel="stylesheet" type="text/css" /> ?>
  	<script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/item_carousel/jCarouselLite.js'; ?>">
  	</script>
  	<?php 
  	//used for enabling auto speed in carousel.
  	$autospeed = ',
					auto: ' . $scrolldelay . ' ,
					speed: 1000';?>
  	<script>
		jQuery(document).ready(function($) {
    			$(".slider").jCarouselLite({
        			btnNext: ".next",
        			btnPrev: ".prev",
        			visible: <?php echo $items; ?>, 
					scroll: 2<?php if($autosp == 1) { echo $autospeed; } ?>
    			});
		});
  	</script>
<?php }

     function carousel_admin_menu() {
        echo '<h3><a href="#">Item Carousel</a></h3>
        <ul>
		    <li><a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/admin.php') . '">&raquo; ' . __('Configuration', 'carousel') . '</a></li>
            <li><a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/help.php') . '">&raquo; ' . __('F.A.Q. / Help', 'carousel') . '</a></li>
        </ul>';
    }

    function carousel_admin() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin.php') ;
    }
    
    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'carousel_admin');
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'carousel_call_after_install');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__). '_uninstall', 'carousel_call_after_uninstall');

    // Add js to header
    osc_add_hook('header', 'carousel_js');
    osc_add_hook('admin_menu', 'carousel_admin_menu');
   
?>
