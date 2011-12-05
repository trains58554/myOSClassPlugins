<?php
/*
 *      OSCLass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2010 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
Plugin Name: JQuery Menu
Plugin URI: http://www.osclass.org/
Description: This Plugin Shows a JQuery Navigation Menu Where Ever You Want.
Version: 2.0
Author: RajaSekar & JChapman
Author URI: http://www.osclass.org/
Short Name: JQuery Menu
*/

 function jMenu_call_after_install() {
        $conn = getConnection() ;
        $path = osc_base_url() . '/oc-content/plugins/jquery_menu/struct.sql' ;
        $sql  = file_get_contents($path) ;
        $conn->osc_dbImportSQL($sql) ;
        
        $conn = getConnection();
	$conn->autocommit(false);
		try {
        $conn->commit();
        osc_set_preference('parent-selectable', '1', 'plugin-jMenu', 'INTEGER');
        osc_set_preference('show-arrow', '1', 'plugin-jMenu', 'INTEGER');
        osc_set_preference('show-ad-count', '1', 'plugin-jMenu', 'INTEGER');
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
        $conn->autocommit(true);
    }

    function jMenu_call_after_uninstall() {
        $conn = getConnection() ;
        $conn->osc_dbExec('DROP TABLE %st_jMenu', DB_TABLE_PREFIX) ;
               
        $conn = getConnection();
		 $conn->autocommit(false);
			try {
				osc_delete_preference('parent-selectable', 'plugin-jMenu');
				osc_delete_preference('show-arrow', 'plugin-jMenu');
				osc_delete_preference('show-ad-count', 'plugin-jMenu');
			}   catch (Exception $e) {
				$conn->rollback();
				echo $e->getMessage();
			}
			$conn->autocommit(true);
					
    }
    
	 // HELPER
    function menu_disable() {
        return(osc_get_preference('parent-selectable', 'plugin-jMenu')) ;
    }
    
    function sArrow() {
        return(osc_get_preference('show-arrow', 'plugin-jMenu')) ;
    }
    
    function sAd() {
        return(osc_get_preference('show-ad-count', 'plugin-jMenu')) ;
    }

	 function jquery_menu_js(){
		echo '<link href="'.osc_base_url().'oc-content/plugins/jquery_menu/jquery_menu.css" rel="stylesheet" type="text/css" />';
		echo '<script type="text/javascript" src="'.osc_base_url().'oc-content/plugins/jquery_menu/jquery_menu.js"></script>';
		
		if(sArrow() != 1){		
		?>
			<script type="text/javascript" >
				$(document).ready(function(){
					$(".topnav").children('li').children('span').remove();
				});
			</script>
		<?php
		}
	 }
	 
	 function jquery_menu(){
	 	
		echo '<ul class="topnav"><li><a href="'.osc_base_url().'">'. __('Home', 'JQuery_Menu') . '</a></li>';
		while ( osc_has_categories() ){
			if(menu_disable()){
				echo '<li><a href="'.osc_search_category_url().'" onClick="return false;">'.osc_category_name().'</a><ul class="subnav">';
			} else{
				echo '<li><a href="'.osc_search_category_url().'">'.osc_category_name().'</a><ul class="subnav">';
			}

			while ( osc_has_subcategories() ) {
				 $catCount ='';
				 if (sAd()) { $catCount = ' ('.osc_category_total_items().')'; }
				 echo '<li><a href="'.osc_search_category_url().'">'.osc_category_name(). $catCount . '</a></li>'; 
			}
				echo '</ul></li>';
		}
		echo '</ul>';
	}
	
	function jquery_admin_menu() {
   	 echo '<h3><a href="#">JQuery Menu</a></h3>
    	<ul>
    		  <li><a href="'.osc_admin_render_plugin_url("jquery_menu/settings.php") . '">&raquo; ' . __('JQuery Menu Settings', 'JQuery_Menu') . '</a></li>
      	  <li><a href="'.osc_admin_render_plugin_url("jquery_menu/help.php").'?section=types">&raquo; ' . __('F.A.Q. / Help', 'JQuery_Menu') . '</a></li>
    	</ul>';
	}
	
	function jquery_menu_help() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/help.php') ;
   }

// This is needed in order to be able to activate the plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'jMenu_call_after_install');
// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'jMenu_call_after_uninstall');
//Header
osc_add_hook('header', 'jquery_menu_js');
// Admin menu
osc_add_hook('admin_menu', 'jquery_admin_menu');
// This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'jquery_menu_help');
?>