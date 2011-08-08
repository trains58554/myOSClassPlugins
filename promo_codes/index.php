<?php
/*
  Plugin Name: Promo Codes
  Plugin URI: http://www.osclass.org/
  Description: This plugin add promotion codes.
  Version: 0.5
  Author: JChapman
  Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
  Author Email: siouxfallsrummages@gmail.com
  Short Name: promo
  Plugin update URI: http://www.osclass.org/
 */
	function table(){
		//check if a table exist
		$conn = getConnection();
		$table_list = $conn->osc_dbFetchValue("SHOW TABLES FROM %s LIKE '%st_paypal%%'", DB_NAME, DB_TABLE_PREFIX);
		if ($table_list){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
$tableexist = table();

    function promo_user_menu() {
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'promo_code.php') . '" >' . __('Enter Promotion Codes', 'promo') . '</a></li>' ;
    }
       
    function promo_admin_menu() {
   	 echo '<h3><a href="#">Promo Code</a></h3><ul>';
   	    	 	 
        echo '<li class="" ><a href="' . osc_admin_render_plugin_url('promo_codes/user_reward.php') . '" >&raquo; ' . __('Signup Bonus Config', 'promo') . '</a></li>' .
        '<li class="" ><a href="' . osc_admin_render_plugin_url('promo_codes/admin_list.php') . '" >&raquo; ' . __('Manage promo Codes', 'promo') . '</a></li>' . 
        '<li class="" ><a href="' . osc_admin_render_plugin_url('promo_codes/admin_create.php') . '" >&raquo; ' . __('Create New Promo Code', 'promo') . '</a></li>' . 
        '<li class="" ><a href="' . osc_admin_render_plugin_url('promo_codes/help.php') . '" >&raquo; ' . __('F.A.Q. / Help', 'promo') . '</a></li>' .
        '<li class="" ><a href="' . osc_admin_render_plugin_url('promo_codes/promo_log.php') . '" >&raquo; ' . __('Promo Code Log', 'promo') . '</a></li>';
        echo '</ul>';
    }
           
    function promo_call_after_install() {
        $conn = getConnection() ;
        $path = osc_plugin_resource('promo_codes/struct.sql') ;
        $sql  = file_get_contents($path) ;
        $conn->osc_dbImportSQL($sql) ;
        
        $conn = getConnection();
	$conn->autocommit(false);
		try {
        $conn->commit();
        osc_set_preference('promo_reward_enabled', '0', 'plugin-promo', 'INTEGER');
        osc_set_preference('promo_reward_amount', '5', 'plugin-promo', 'FLOAT');
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
    }

    function promo_call_after_uninstall() {
        $conn = getConnection() ;
        $conn->osc_dbExec('DROP TABLE %st_promo_code', DB_TABLE_PREFIX) ;
        $conn->osc_dbExec('DROP TABLE %st_promo_code_redeemed', DB_TABLE_PREFIX) ;
        
        $conn = getConnection();
		 $conn->autocommit(false);
			try {
				osc_delete_preference('promo_reward_enabled', 'plugin-promo');
                		osc_delete_preference('promo_reward_amount', 'plugin-promo');
			}   catch (Exception $e) {
				$conn->rollback();
				echo $e->getMessage();
			}
			$conn->autocommit(true);
					
    }

    function promo_help() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/help.php') ;
    }
    
    // HELPER
    function osc_promo_reward_enabled() {
        return(osc_get_preference('promo_reward_enabled', 'plugin-promo')) ;
    }
	function osc_promo_reward_amount() {
        return(osc_get_preference('promo_reward_amount', 'plugin-promo')) ;
    }
    
    //user reward
    function user_reward($userId) {
    	$reward_enabled = (osc_promo_reward_enabled() != '') ? osc_promo_reward_enabled() : '' ;
    	$reward_amount = (osc_promo_reward_amount() != '') ? osc_promo_reward_amount() : '' ;
    	
    	if($reward_enabled == '1'){
    		//adds user to paypal_wallet and gives them the promo_value 
        	$conn = getConnection();
        	$conn->osc_dbExec("INSERT INTO %st_paypal_wallet (fk_i_user_id, f_amount) VALUES (%d, '%f')", DB_TABLE_PREFIX, $userId, $reward_amount); 
        }
    
    }
    
    function promo_config() {
    	osc_admin_render_plugin('promo_codes/admin_list.php') ;    
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
    function promo_user_delete($userId){
    $conn   = getConnection();
    $conn->osc_dbExec("DELETE FROM %st_promo_code_redeemed WHERE fk_i_user_id='%d'", DB_TABLE_PREFIX, $userId);
    }
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'promo_call_after_install') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'promo_call_after_uninstall') ;

    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'promo_config') ;
    
    // Add hook for user deleted
    osc_add_hook('delete_user', 'promo_user_delete');
    
    // checks if paypal_wallet table exists
    $tableexist = table();
    if($tableexist){
    // Add link in user menu page
    osc_add_hook('user_menu', 'promo_user_menu') ;
    }
    // Add link in admin menu page
    osc_add_hook('admin_menu', 'promo_admin_menu') ;
    // add javascript
    osc_add_hook('header', 'promo_js') ;
    
    if(OSCLASS_VERSION >= '2.2'){
    // checks if paypal_wallet table exists
    $tableexist = table();
    if($tableexist){
    // add user_reward to user register completed
    osc_add_hook('user_register_completed', 'user_reward');
    }
    }



?>
