<?php
/*
Plugin Name: SEO Report
Plugin URI: http://www.osclass.org/
Description: This plugin displays your SEO Results.
Version: 1.0
Author: JChapman 
Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
Short Name: SEO
Plugin update URI: 
*/
    
    function seo_admin_menu() {
        echo '<h3><a href="#">SEO Report</a></h3>
        <ul>
		    <li><a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/seoreport.php') . '">&raquo; ' . __('SEO Report', 'seoreport') . '</a></li>
        </ul>';
    }

    osc_add_hook('admin_menu', 'seo_admin_menu');
// This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), '');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__). '_uninstall', '');
   
?>
