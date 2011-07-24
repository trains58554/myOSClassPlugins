<?php
/*
Plugin Name: PHP Info
Plugin URI: http://www.osclass.org/
Description: This plugin displays your php info.
Version: 1.0
Author: JChapman 
Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
Short Name: phpInfo
Plugin update URI: 
*/
    
    function phpInfo_admin_menu() {
        echo '<h3><a href="#">PHP Info</a></h3>
        <ul>
		    <li><a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/phpinfo.php') . '">&raquo; ' . __('PHP Info', 'phpInfo') . '</a></li>
        </ul>';
    }

    osc_add_hook('admin_menu', 'phpInfo_admin_menu');
   
?>
