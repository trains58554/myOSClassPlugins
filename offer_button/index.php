<?php
/*
  Plugin Name: Offer Button
  Plugin URI: http://www.osclass.org/
  Description: This plugin adds the functions of a offer button.
  Version: 0.1
  Author: JChapman
  Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
  Author Email: siouxfallsrummages@gmail.com
  Short Name: offer
  Plugin update URI: http://www.osclass.org/
 */
    function offer_user_menu() {
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'offer_button.php') . '" >' . __('View Offers', 'offer_button') . '</a></li>' ;
    }
       
    function offer_admin_menu() {
   	 echo '<h3><a href="#">Offer Button</a></h3><ul>';
   	    	 	 
        echo '<li class="" ><a href="' . osc_admin_render_plugin_url('offer_button/user_reward.php') . '" >&raquo; ' . __('Offer Button Config', 'offer_button') . '</a></li>' .
        '<li class="" ><a href="' . osc_admin_render_plugin_url('offer_button/admin_list.php') . '" >&raquo; ' . __('View Offers', 'offer_button') . '</a></li>' . 
        '<li class="" ><a href="' . osc_admin_render_plugin_url('offer_button/help.php') . '" >&raquo; ' . __('F.A.Q. / Help', 'offer_button') . '</a></li>';
        echo '</ul>';
    }
           
    function offer_call_after_install() {
        $conn = getConnection() ;
        $path = osc_plugin_resource('offer_button/struct.sql') ;
        $sql  = file_get_contents($path) ;
        $conn->osc_dbImportSQL($sql) ;
        
        $conn = getConnection();
	$conn->autocommit(false);
		try {
        $conn->commit();
        osc_set_preference('offer_button_enabled', '1', 'plugin-offer', 'INTEGER');
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
    }

    function offer_call_after_uninstall() {
        $conn = getConnection() ;
        $conn->osc_dbExec('DROP TABLE %st_offer_button', DB_TABLE_PREFIX) ;
        //$conn->osc_dbExec('DROP TABLE %st_promo_code_redeemed', DB_TABLE_PREFIX) ;
        
        $conn = getConnection();
		 $conn->autocommit(false);
			try {
				osc_delete_preference('offer_button_enabled', 'plugin-offer');
			}   catch (Exception $e) {
				$conn->rollback();
				echo $e->getMessage();
			}
			$conn->autocommit(true);
					
    }

    function offer_help() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/help.php') ;
    }
    
    function offer_button() {
    	?>
    	<a id="inline" href='#login_form'>offer</a>
    	<div style="display:none">
	<form id="login_form" method="post" action="">
	    	<p id="login_error">Please, enter data</p>
		<p>
			<label for="login_name">Login: </label>
			<input type="text" id="login_name" name="login_name" size="30" />
		</p>
		<p>
			<label for="login_pass">Password: </label>
			<input type="password" id="login_pass" name="login_pass" size="30" />
		</p>
		<p>
			<input type="submit" value="Login" />
		</p>
		<p>
		    <em>Leave empty so see resizing</em>
		</p>
	</form>
</div> <?php
    }
    // HELPER
    function osc_offer_button_enabled() {
        return(osc_get_preference('offer_button_enabled', 'plugin-offer')) ;
    }
       
    function offer_config() {
    	osc_admin_render_plugin('offer_button/admin_list.php') ;    
    }
    // Offer button js
    function offer_js(){
    echo "\n";
    echo '<!-- offer_button js -->
    <script type="text/javascript">  
    $(document).ready(function(){
    $("#promo-code-form").submit(function(){
        $.post(
            "' . osc_ajax_plugin_url("offer_button/ajax-redeem.php") . '",
            $("#promo-code-form").serialize(),
            function(data){
                if (data.success){
                    $("span#promo-message").css({"color":"green"} );
                    $("span#promo-message").css({"font-size":"20px"} );
                }
                else{
                    $("span#promo-message").css({"color":"red"});
                    $("span#promo-message").css({"font-size":"20px"} );
                }
                $("span#promo-message").html(data.message);
            },
            "json"
        );
    });
});
    </script>  ';
    }
    function offer_user_delete($userId){
    $conn   = getConnection();
    $conn->osc_dbExec("DELETE FROM %st_offer_button WHERE fk_i_user_id='%d'", DB_TABLE_PREFIX, $userId);
    }
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'offer_call_after_install') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'offer_call_after_uninstall') ;

    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'offer_config') ;
    
    // Add hook for user deleted
    osc_add_hook('delete_user', 'offer_user_delete');
    
    // checks if paypal_wallet table exists
    $tableexist = table();
    if($tableexist){
    // Add link in user menu page
    osc_add_hook('user_menu', 'offer_user_menu') ;
    }
    // Add link in admin menu page
    osc_add_hook('admin_menu', 'offer_admin_menu') ;
    // add javascript
    osc_add_hook('header', 'offer_js') ;
    
    // add user_reward to user register completed
    osc_add_hook('user_register_completed', 'user_reward');

?>
