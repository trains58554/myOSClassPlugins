<?php
/*
  Plugin Name: Promo Codes
  Plugin URI: http://www.osclass.org/
  Description: This plugin add promotion codes.
  Version: 0.1
  Author: JChapman
  Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
  Author Email: siouxfallsrummages@gmail.com
  Short Name: promo
  Plugin update URI: http://www.osclass.org/
 */

    /*function promo_code() {
        echo '<a href="javascript://" class="watchlist" id="' . osc_item_id() . '">' ;
        echo '<span>' . __('Add to watchlist', 'watchlist') . '</span>' ;
        echo '</a>' ;
    }*/

    function promo_user_menu() {
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user_promo_code.php') . '" >' . __('Enter Promotion Codes', 'promo') . '</a></li>' ;
    }
    
    function promo_admin_menu() {
   	 echo '<h3><a href="#">Promo Code</a></h3><ul>';
   	 
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . '#') . '" >&raquo; ' . __('Manage promo Codes', 'promo') . '</a></li>' .
        '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . '#') . '" >&raquo; ' . __('F.A.Q. / Help', 'promo') . '</a></li>' ;
        echo '</ul>';
    }
    
    function table(){
		  //check if a table exist
		  $conn = getConnection();
          $table_list = $conn->osc_dbFetchValues('SHOW TABLES FROM %s', DB_NAME);
		  if (in_array(vsprintf("%st_paypal_log", DB_TABLE_PREFIX), $table_list)) {
             $result = "Installed!";
          }else{
			$result = 'Not installed.';
		  }
		  return $result;
	  }
    
    function promo_call_after_install() {
        $conn = getConnection() ;
        $path = osc_plugin_resource('promo_codes/struct.sql') ;
        $sql  = file_get_contents($path) ;
        $conn->osc_dbImportSQL($sql) ;
    }

    function promo_call_after_uninstall() {
        $conn = getConnection() ;
        $conn->osc_dbExec('DROP TABLE %st_promo_code', DB_TABLE_PREFIX) ;
        $conn->osc_dbExec('DROP TABLE %st_promo_code_redeemed', DB_TABLE_PREFIX) ;
    }

    function promo_help() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/help.php') ;
    }
    
    // Promo code js
    function promo_js(){
    echo "\n";
    echo '<!-- promo_code js -->
    <script type="text/javascript">  
    $(document).ready(function(){
    $("#promo-code-form").submit(function(){
        $.post(
            "' . osc_ajax_plugin_url("promo_codes/ajax-redeem.php") . '",
            $("#promo-code-form").serialize(),
            function(data){
                if (data.success)
                    $("span#promo-message").css({"color":"green"});
                else
                    $("span#promo-message").css({"color":"red"});
                $("span#promo-message").html(data.message);
            },
            "json"
        );
    });
});
    </script>  ';
    }

    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'promo_call_after_install') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'promo_call_after_uninstall') ;

    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'promo_help') ;

    // Add link in user menu page
    osc_add_hook('user_menu', 'promo_user_menu') ;
    // Add link in admin menu page
    osc_add_hook('admin_menu', 'promo_admin_menu') ;
    // add javascript
    osc_add_hook('header', 'promo_js') ;



?>
