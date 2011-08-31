<?php
/*
  Plugin Name: Offer Button
  Plugin URI: http://www.osclass.org/
  Description: This plugin extends a category of items to display an offer button.
  Version: 0.1
  Author: JChapman
  Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
  Author Email: siouxfallsrummages@gmail.com
  Short Name: offer
  Plugin update URI: http://www.osclass.org/
 */
    function offer_user_menu() {
        echo '<lo class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'offer_byItem.php') . '" >' . __('View Offers on Your Items', 'offer_button') . '</a></li>';
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'offer_button.php') . '" >' . __('View Your Submmited Offers', 'offer_button') . '</a></li>' ;
    }
       
    function offer_admin_menu() {
   	 echo '<h3><a href="#">Offer Button</a></h3><ul>';
   	    	 	 
        echo '<li class="" ><a href="' . osc_admin_render_plugin_url('offer_button/offer_config.php') . '" > &raquo; '. __('Configure', 'offer_button') . '</a></li>' .
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
        $conn->osc_dbExec('DROP TABLE %st_offer_item_options', DB_TABLE_PREFIX) ;
        
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
    if(osc_offer_button_enabled() == 1){
    	$conn = getConnection() ;
	$detail = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_item_options WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, osc_item_id());
 	if (osc_is_web_user_logged_in()){
 	if ($detail['b_offerYes'] == 1){
    	?>
    	
    	<strong class="share"><a id="inline" href='#offer_form' rel='inline'>Place An Offer</a></strong>
    	<div style="display:none">
	<form id="offer_form" method="post"  onsubmit="return false;" >
		<input type="hidden" id="user_id" name="user_id" value="<?php echo osc_logged_user_id(); ?>" />
		<input type="hidden" id="seller_id" name="seller_id" value="<?php echo osc_item_user_id(); ?>" />
		<input type="hidden" id="item_id" name="item_id" value="<?php echo osc_item_id(); ?>" />
		
	    	<span id="offer-message"></span>
	    	<p><h3><?php _e('Please enter a your offer','offer_button'); ?></h3></p>
		<p>
			<label for="offer"><?php _e('Offer','offer_button'); ?>: </label>
			<input type="text" id="offer" name="offer" size="10" />
		</p>
		<p>
			<input type="submit" value="<?php _e('Submit Offer','offer_button'); ?>" />
		</p>
	</form>
	</div> <?php
	}
	}
	}
    }
    
    
    // HELPER
    function osc_offer_button_enabled() {
        return(osc_get_preference('offer_button_enabled', 'plugin-offer')) ;
    }
       
    function offer_config() {
    	// Standard configuration page for plugin which extend item's attributes
	osc_plugin_configure_view(__FILE__);
    }
    // Offer button js
    function offer_js(){
    echo "\n";
    echo '<!-- offer_button js -->
    	<script type="text/javascript">
     		$(document).ready(function() {
          	$("a[rel=inline]").fancybox({
          		"overlayOpacity"	:	0.5,
			"overlayColor"		:	"black",
			"overlayShow"		:	true,
			"onClosed" 		:	function() {
				$("span#offer-message").html("")}
			
          	})
     	     });
     	     
	     $(document).ready(function(){
    	     $("#offer_form").bind("submit", function(){

		if ($("#offer").val().length < 1) {
		    $("span#offer-message").css({"color":"red"});
                    $("span#offer-message").css({"font-size":"20px"} );
                    $("span#offer-message").html("Please enter a number");
		    $.fancybox.resize();
		    return false;
		}

		$.fancybox.showActivity();

        		$.post(
		            "' . osc_ajax_plugin_url("offer_button/ajax-offer.php") . '",
        		    $("#offer_form").serialize(),
        		    function(data){
                if (data.success){
                  $("span#offer-message").html(" ");
                  $("#offer").value="";
                  $.fancybox("<h1 style=\"font-size: 14px;\">" + data.message + "</h1>");
                  document.getElementById("offer").value = "";  
                }
                else{
                    $.fancybox.hideActivity();
                    $("span#offer-message").css({"color":"red"});
                    $("span#offer-message").css({"font-size":"20px"} );
                    $("span#offer-message").html(data.message);
                    document.getElementById("offer").value = "";
                    $.fancybox.resize();
                }
                
        		    },
        		    "json"
        		);
    		});
		});
	</script>';
	   
    }
    
    function offer_css() {
    	echo "\n";
    	echo '<!-- offer_button css -->
    	<link href="./oc-content/plugins/offer_button/css/demo_table.css" rel="stylesheet" type="text/css" />';
    }
    
    function offer_status($offerSt){
    	if ($offerSt == 1) {
    		return __('Accepted','offer_button');
    	}
    	elseif($offerSt == 2) {
    		return __('Pending...','offer_button');
    	}
    	else {
    		return __('Declined','offer_button');
    	}
    
    }
    
    function offer_form($catId = '') {
    $conn = getConnection() ;
    // We received the categoryID
	if($catId!="") {
		// We check if the category is the same as our plugin
		if(osc_is_this_category('offer', $catId)) {
			require_once('form.php');
		}
	}
    }
    
    function offer_form_post($catId = null, $item_id = null) {
    $conn = getConnection() ;
	// We received the categoryID and the Item ID
	if($catId!=null) {
		// We check if the category is the same as our plugin
		if(osc_is_this_category('offer', $catId) && $item_id!=null) {
				// Insert the data in our plugin's table
                    $conn->osc_dbExec("INSERT INTO %st_offer_item_options (fk_i_item_id, b_offerYes) VALUES (%d, %d)",
						DB_TABLE_PREFIX,
						$item_id,
						(Params::getParam("offerYes")!='') ? 1 : 0
					);
		}
	}
    }
    
    // Self-explanatory
    function offer_item_edit($catId = null, $item_id = null) {
    	$conn = getConnection() ;
    	if(osc_is_this_category('offer', $catId)) {
		    $detail = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_item_options WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $item_id);

		    require_once 'item_edit.php';
    	}
    }
    
    function offer_item_edit_post($catId = null, $item_id = null) {
	// We received the categoryID and the Item ID
	if($catId!=null) 
	{
		// We check if the category is the same as our plugin
		if(osc_is_this_category('offer', $catId))
		{
			$conn = getConnection() ;
			// Insert the data in our plugin's table
            $conn->osc_dbExec("REPLACE INTO %st_offer_item_options (fk_i_item_id, b_offerYes) VALUES (%d, %d)",
				DB_TABLE_PREFIX,
				$item_id,
				(Params::getParam("offerYes")!='') ? 1 : 0
			);
		}
	}
    }
    
    function offer_user_delete($userId){
    	$conn   = getConnection();
    	$conn->osc_dbExec("DELETE FROM %st_offer_button WHERE user_id='%d'", DB_TABLE_PREFIX, $userId);
    }
    
    function offer_item_delete($id){
    	$conn   = getConnection();
    	$conn->osc_dbExec("DELETE FROM %st_offer_button WHERE item_id='%d'", DB_TABLE_PREFIX, $id);
    }
    
    /**
     * Add new options to supertoolbar plugin (if installed)
     */
    function offer_supertoolbar() {

        if( !osc_is_web_user_logged_in() ) {
            return false;
        }
        
        if( Rewrite::newInstance()->get_location() != 'item' ) {
            return false;
        }
        
        //if( osc_item_user_id() != osc_logged_user_id() ) {
          //  return false;
        //}
        
        $toolbar = SuperToolBar::newInstance();
        $conn    = getConnection();
        $offerCheck = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE seller_id  = '%d' AND item_id = '%d'", DB_TABLE_PREFIX, osc_logged_user_id(), osc_item_id());
        
        if($offerCheck){
        $offer_url = osc_base_url(true).'?page=custom&file=offer_button/offer_byItem.php#item' . osc_item_id();
        $toolbar->addOption('<a href="' . $offer_url . '" />' . __('View offers on this ad', 'offfer_button') . '</a>');
        }
        
        $offerStatus = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE user_id  = '%d' AND item_id = '%d'", DB_TABLE_PREFIX, osc_logged_user_id(), osc_item_id());
        
        if($offerStatus){
        $offer_button_url = osc_base_url(true).'?page=custom&file=offer_button/offer_button.php#item' . osc_item_id();
        $toolbar->addOption('<a href="' . $offer_button_url . '" />' . __('View status of offer', 'offfer_button') . '</a>');
        }
    }
    
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'offer_call_after_install') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'offer_call_after_uninstall') ;

    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'offer_config') ;
    
    // Add hook for user deleted
    osc_add_hook('delete_user', 'offer_user_delete');
    
    // Add hook for item deleted
    osc_add_hook('delete_item', 'offer_item_delete');

    if(osc_offer_button_enabled() == 1){
    // Add link in user menu page
    osc_add_hook('user_menu', 'offer_user_menu') ;
    }
   
    // Add link in admin menu page
    osc_add_hook('admin_menu', 'offer_admin_menu') ;
    
    if(osc_offer_button_enabled() == 1){
    // add javascript
    osc_add_hook('item_detail', 'offer_js') ;
    
    // hook for header
    osc_add_hook('header', 'offer_css');
    
    // When publishing an item we show an extra form with more attributes
    osc_add_hook('item_form', 'offer_form');
    
    // To add that new information to our custom table
    osc_add_hook('item_form_post', 'offer_form_post');
    
    // Edit an item special attributes
    osc_add_hook('item_edit', 'offer_item_edit');

    // Edit an item special attributes POST
    osc_add_hook('item_edit_post', 'offer_item_edit_post');
    
    // Add hook to supertoolbar
    osc_add_hook('supertoolbar_hook' , 'offer_supertoolbar');
    }

?>
