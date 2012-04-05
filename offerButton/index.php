<?php
/*
Plugin Name: Offer Button
Plugin URI: http://www.osclass.org/
Description: This plugin extends a category of items to display an offer button.
Version: 2.0
Author: JChapman
Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
Author Email: siouxfallsrummages@gmail.com
Short Name: offer
Plugin update URI: http://www.osclass.org/
*/

    require('ModelOffer.php');
    
 	 function obVersion() {
 	    $pluginInfo = osc_plugin_get_info('offerButton/index.php');
 	 	 $offerButton = $pluginInfo['version'];
	     return($offerButton);
 	 }
    function offer_user_menu() {
        $newOffers = ModelOffer::newInstance()->getOffers('seller_id', osc_logged_user_id(), 'oNew', 1, 1, 'id', 'DESC', NULL);
        ModelOffer::newInstance()->updateOfferNew(osc_logged_user_id());        
        $countOffers = count($newOffers);
        
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'offer_byItem.php') . '" >' . __('View Offers on Your Items', 'offerButton') . ' (' . $countOffers . ')</a></li>';
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'offer_button.php') . '" >' . __('View Your Submitted Offers', 'offerButton') . '</a></li>' ;
    }
       
    function offer_admin_menu() {
   	 echo '<h3><a href="#">Offer Button</a></h3><ul>';
   	    	 	 
        echo '<li class="" ><a href="' . osc_admin_render_plugin_url('offerButton/offer_config.php') . '" > &raquo; '. __('Configure', 'offerButton') . '</a></li>' .
        '<li class="" ><a href="' . osc_admin_render_plugin_url('offerButton/help.php') . '" >&raquo; ' . __('F.A.Q. / Help', 'offerButton') . '</a></li>';
        if(osc_offerButton_locking() == 1 || 1 == 1) { echo '<li class="" ><a href="' . osc_admin_render_plugin_url('offerButton/reason_conf.php') . '" >&raquo; ' . __('Manage Reasons', 'offerButton') . '</a></li>';}
        echo '</ul>';
    }
           
    function offer_call_after_install() {
       if(OSCLASS_VERSION >= 2.3) {
       
        $pluginInfo = osc_plugin_get_info('offerButton/index.php');
       
        ModelOffer::newInstance()->import('offerButton/struct.sql');
        
        osc_set_preference('offerButton_enabled', '1', 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_lastThree', '0', 'plugin-offer', 'INTEGER');
        //Added in version 2.0
        osc_set_preference('offerButton_version', $pluginInfo['version'] , 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_locking', '0', 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_email', '1', 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_email_temps', '1', 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_delOff', '0', 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_usersOnly', '1', 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_trade', '0', 'plugin-offer', 'INTEGER');
        osc_set_preference('offerButton_text', '1', 'plugin-offer', 'INTEGER');
        
        ModelOffer::newInstance()->insertEmailTemplates();
       } else {
          throw new Exception("Please upgrade your OSClass install to 2.3 or greater.");
       }
    }

    function offer_call_after_uninstall() {
        ModelOffer::newInstance()->removeEmailTemplates();

        ModelOffer::newInstance()->uninstall();      
        
				osc_delete_preference('offerButton_enabled', 'plugin-offer');
				osc_delete_preference('offerButton_lastThree', 'plugin-offer');
				//added in version 2.0
				osc_delete_preference('offerButton_version', 'plugin-offer');
				osc_delete_preference('offerButton_locking', 'plugin-offer');
				osc_delete_preference('offerButton_email', 'plugin-offer');
				osc_delete_preference('offerButton_email_temps', 'plugin-offer');
				osc_delete_preference('offerButton_delOff', 'plugin-offer');
				osc_delete_preference('offerButton_usersOnly', 'plugin-offer');
				osc_delete_preference('offerButton_trade', 'plugin-offer');
				osc_delete_preference('offerButton_text', 'plugin-offer');
					
    }

    function offer_help() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/help.php') ;
    }
    
    function offer_button() {
    if(osc_offerButton_enabled() == 1){    
	    $detail = ModelOffer::newInstance()->getOfferItemOption(osc_item_id());
	 // checks to see if the seller has accepted an offer
	 // if yes then it does not display the offer button.
	 $acceptedOffer = ModelOffer::newInstance()->getOffer('item_id', osc_item_id(), 'offer_status', 1, 1, 'id', 'DESC', NULL);
	 if(!$acceptedOffer) {
	
 	if (osc_is_web_user_logged_in() ){
 	if ($detail['b_offerYes'] == 1){
    	?>
    	<strong class="share"><a id="inline" href='#offer_form' rel='inline'><?php echo osc_offerButton_text_array(); ?></a></strong>
    	 <?php
	}// ends if offer button enabled
	}else if(osc_offerButton_usersOnly() == 0){
		if ($detail['b_offerYes'] == 1){
    	?>
    	<strong class="share"><a id="inline" href='#offer_form' rel='inline'><?php echo osc_offerButton_text_array(); ?></a></strong>
    	 <?php
		}// ends if offer button enabled
	}//ends else if statement for users only
	else{
	   Session::newInstance()->_setReferer(osc_user_login_url() . '&http_referer=' . osc_base_url(true) . '?page=item&id=' . osc_item_id() );
	   ?>
	   <strong class="share"><a id="" href='<?php echo osc_user_login_url(); ?>' ><?php _e('Login to Make An Offer', 'offerButton'); ?></a></strong>
	   <?php
	}
	}
	}//ends if statement for button enabled
    }//ends function
    
    // HELPER
    function osc_offerButton_enabled() {
        return(osc_get_preference('offerButton_enabled', 'plugin-offer')) ;
    }
    function osc_offerButton_lastThree() {
        return(osc_get_preference('offerButton_lastThree', 'plugin-offer')) ;
    }
    function osc_offerButton_locking() {
        return(osc_get_preference('offerButton_locking', 'plugin-offer')) ;
    }
    function osc_offerButton_email() {
        return(osc_get_preference('offerButton_email', 'plugin-offer')) ;
    }
    function osc_offerButton_email_temps() {
        return(osc_get_preference('offerButton_email_temps', 'plugin-offer')) ;
    }
    function osc_offerButton_delOff() {
        return(osc_get_preference('offerButton_delOff', 'plugin-offer')) ;
    }
    function osc_offerButton_usersOnly() {
        return(osc_get_preference('offerButton_usersOnly', 'plugin-offer')) ;
    }
    function osc_offerButton_version() {
        return(osc_get_preference('offerButton_version', 'plugin-offer')) ;
    }
    function osc_offerButton_trade() {
        return(osc_get_preference('offerButton_trade', 'plugin-offer')) ;
    }
    function osc_offerButton_text() {
        return(osc_get_preference('offerButton_text', 'plugin-offer')) ;
    }
    function osc_offerButton_text_array() {
        $otext = array();
        $otext = array( 1 => __('Make An Offer','offerButton'), 2 => __('Place An Offer','offerButton'));
        $buttonText = $otext[osc_offerButton_text()];
        return $buttonText;
    }
    /**
     * Get if user is on offer button.php page
     *
     * @return boolean
     */
    function offer_button_page() {
      $location = Rewrite::newInstance()->get_location();
      $file     = rtrim(Params::getParam('file'),'?');
      if($location == 'custom' && $file == 'offerButton/offer_button.php'){
         return TRUE;
      }
      return FALSE;
    }
    /**
     * Get if user is on offer_byItem.php page
     *
     * @return boolean
     */
    function offer_byItem_page() {
      $location = Rewrite::newInstance()->get_location();
      $file     = rtrim(Params::getParam('file'),'?');
      if($location == 'custom' && $file == 'offerButton/offer_byItem.php'){
         return TRUE;
      }
      return FALSE;
    }
      
    function offer_config() {
      osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/offer_config.php') ;
    	// Standard configuration page for plugin which extend item's attributes
	   //osc_plugin_configure_view(osc_plugin_path(__FILE__));
    }
    // Offer button js
    function offer_js(){
       if(osc_is_ad_page() ) {
    ?>
      <!-- offerButton js -->
    	<script type="text/javascript">
      ( function($) { 
         $(document).ready(function(){  
	        $("#offerType").change(function(){
            var offerType = $(this).val();
            if(offerType ==1 || offerType ==3) {
            	$("#offer").removeAttr("disabled");
            }
            else {
            	$("#offer").attr("disabled", true);
            }
            });
         });
       } ) ( jQuery );
       
       ( function($) { 
     		$(document).ready(function() {
          	$("a[rel=inline]").fancybox({
          		"overlayOpacity"	:	0.5,
			"overlayColor"		:	"black",
			"overlayShow"		:	true,
			"onClosed" 		:	function() {
				$("span#offer-message").html("")}
			
          	})
     	     });
     	   } ) ( jQuery );
     	 ( function($) {    
	     $(document).ready(function(){
    	     $("#offer_form").bind("submit", function(){
      if ($("#offerType").val() !=2 ) {
		if ($("#offer").val().length < 1) {
		    $("span#offer-message").css({"color":"red"});
                    $("span#offer-message").css({"font-size":"20px"} );
                    $("span#offer-message").html("Please enter an amount");
		    $.fancybox.resize();
		    return false;
		}
		}

      

		//$.fancybox.showActivity();

        		$.post(
		            "<?php echo osc_ajax_plugin_url('offerButton/ajax-offer.php'); ?>",
        		    $("#offer_form").serialize(),
        		    function(data){
                if (data.success){
                  $("span#offer-message").html(" ");
                  $("#offer").value="";
                  $.fancybox("<h1 style=\"font-size: 14px;\">" + data.message + "</h1>");
                  $('#offer').val('');
                  //document.getElementById("offer").value = "";  
                }
                else{
                    //$.fancybox.hideActivity();
                    $("span#offer-message").css({"color":"red"});
                    $("span#offer-message").css({"font-size":"20px"} );
                    $("span#offer-message").html(data.message);
                    $('#offer').val('');
                    //document.getElementById("offer").value = "";
                    $.fancybox.resize();
                }
                
        		    },
        		    "json"
        		);
    		});
		});
	} ) ( jQuery );
	</script>
	
	  <script type="text/javascript">
	  ( function($) {
        $(document).ready(function() {
	        if( $("form[name=item]").length > 0 ) {
					
           }
        }) ;
    } ) ( jQuery );
    </script>
    <!-- end offerButton js -->
    <!-- start offerbutton form code -->
    <?php 
    // Database connection using the new DAO Model.
    $lastThree = ModelOffer::newInstance()->getOffers('item_id', osc_item_id(), NULL, NULL, 1, 'id', 'DESC');   
    $offerTrade = ModelOffer::newInstance()->getOfferItemOption(osc_item_id());
    
    if(osc_offerButton_usersOnly() ==1 || osc_is_web_user_logged_in() ){ ?>
    <div style="display:none">
	<form id="offer_form" method="post"  onsubmit="return false;" >
		<input type="hidden" id="user_id" name="user_id" value="<?php echo osc_logged_user_id(); ?>" />
		<input type="hidden" id="seller_id" name="seller_id" value="<?php echo osc_item_user_id(); ?>" />
		<input type="hidden" id="item_id" name="item_id" value="<?php echo osc_item_id(); ?>" />
		
	    	<span id="offer-message"></span>
	    	<?php if(osc_offerButton_lastThree()){ ?>
	    	<h3 id="offer-last" style="text-align: center;">
	    	<?php _e('Top 3 offers','offerButton');?> <br />
	    		<?php foreach($lastThree as $a){
	    			printf('%01.2f'. osc_item_currency() . '<br />', $a['offer_value']);
	    		} ?>
	    	</h3>
	    	<?php } ?>
	    	<p><h3><?php _e('Please enter a your offer','offerButton'); ?></h3></p>
		<p class="offerP">
		<?php if($offerTrade['b_offerTrade'] == 1 && osc_offerButton_trade() == 1) { ?>
		   <label for="offerType"><?php _e('Offer Type','offerButton'); ?></label>
		   <select name="offerType" id="offerType">
		       <option value="1"><?php _e('Monetary Offer','offerButton'); ?></option>
		       <option value="2"><?php _e('Trade Offer','offerButton'); ?></option>
		       <option value="3"><?php _e('Monetary & Trade Offer','offerButton'); ?></option>
		   </select>
		<?php } ?>
			<label for="offer" id="offerL"><?php _e('Offer','offerButton'); ?>: </label>
			<input type="text" id="offer" name="offer" size="10" /><?php echo osc_item_currency();?>
		</p>
		<br />
		<p>
			<input type="submit" value="<?php _e('Submit Offer','offerButton'); ?>" />
		</p>
	</form>
	</div>
	
    <?php } else if(osc_offerButton_usersOnly() ==0){ ?>
    
    <div style="display:none">
		<form id="offer_form" method="post"  onsubmit="return false;" >
			
			<input type="hidden" id="seller_id" name="seller_id" value="<?php echo osc_item_user_id(); ?>" />
			<input type="hidden" id="item_id" name="item_id" value="<?php echo osc_item_id(); ?>" />
		
	    		<span id="offer-message"></span>
	    		<?php if(osc_offerButton_lastThree()){ ?>
	    		<h3 id="offer-last" style="text-align: center;">
	    		<?php _e('Top 3 offers','offerButton');?> <br />
	    			<?php foreach($lastThree as $a){
	    				printf('%01.2f'. osc_item_currency() . '<br />', $a['offer_value']);
	    			} ?>
	    		</h3>
	    		<?php } ?>
	    		<p><h3><?php _e('Please enter a your offer','offerButton'); ?></h3></p>
			<p>
			<table class="offerRows"> 
				<tr>
					<td> 
					<label for="name"><?php _e('Enter your Name','offerButton'); ?>: </label>
					</td>
					<td>
					<input type="text" id="name" name="name" value="" />
					</td>
				</tr>
				<tr> 
					<td> 
					<label for="eMail"><?php _e('Enter your Email Address','offerButton'); ?>: </label>
					</td>
					<td>
					<input type="text" id="eMail" name="eMail" value="" />
					</td>
				</tr>
				<?php if($offerTrade['b_offerTrade'] == 1 && osc_offerButton_trade() == 1) { ?>
				<tr>
				   <td>
				   <label for="offerType"><?php _e('Offer Type','offerButton'); ?></label>
				   </td>
				   <td>
		         <select name="offerType" id="offerType">
		             <option value="1"><?php _e('Monetary Offer','offerButton'); ?></option>
		             <option value="2"><?php _e('Trade Offer','offerButton'); ?></option>
		             <option value="3"><?php _e('Monetary & Trade Offer','offerButton'); ?></option>
		         </select>
				   </td>
				</tr>
				<?php } ?>
				<tr> 
					<td>
					<label for="offer" id="offerL"><?php _e('Offer','offerButton'); ?>: </label>
					</td>
					<td>
					<input type="text" id="offer" name="offer" size="10" /><?php echo osc_item_currency();?>
					</td>
				</tr>
			</table>
			</p>
			<p>
				<input type="submit" value="<?php _e('Submit Offer','offerButton'); ?>" />
			</p>
		</form>
		</div>
		<?php } ?>		
		<!-- end offerbutton form code -->
    <?php
    }
    }
    
    function offer_css() {
      if(osc_is_ad_page() || offer_byItem_page() || offer_button_page()) {
    	echo "\n";
    	echo '<!-- offerButton css -->
    	<link href="' . osc_base_url() . "oc-content/plugins/offerButton/css/demo_table.css" . '" rel="stylesheet" type="text/css" />
    	<link href="' . osc_base_url() . "oc-content/plugins/offerButton/css/style.css" . '" rel="stylesheet" type="text/css" />';
    	}
    }
    
    function offer_back_css() {
       echo "\n";
    	echo '<!-- offerButton css -->
    	<link href="' . osc_base_url() . "oc-content/plugins/offerButton/css/offer_back.css" . '" rel="stylesheet" type="text/css" />';
    }
    
    function offer_status($offerSt){
    	if ($offerSt == 1) {
    		return __('Accepted','offerButton');
    	}
    	elseif($offerSt == 2) {
    		return __('Pending...','offerButton');
    	}
    	else {
    		return __('Declined','offerButton');
    	}
    
    }
    
    function offer_form($catId = '') {
    // We received the categoryID
	if($catId!="") {
		// We check if the category is the same as our plugin
		if(osc_is_this_category('offer', $catId)) {
		   if(osc_is_web_user_logged_in()){
			   require_once('form.php');
			}
		}
	}
    }
    
    function offer_form_post($catId = null, $item_id = null) {
	// We received the categoryID and the Item ID
	if($catId!=null) {
		// We check if the category is the same as our plugin
		if(osc_is_this_category('offer', $catId) && $item_id!=null) {
				// Insert the data in our plugin's table
				     ModelOffer::newInstance()->insertOptions($item_id, (Params::getParam("offerYes")!='') ? 1 : 0, 0, (Params::getParam("offerTrade")!='') ? 1 : 0);                 
		}
	}
    }
    
    // Self-explanatory
    function offer_item_edit($catId = null, $item_id = null) {
    	if(osc_is_this_category('offer', $catId)) {
    	   if(osc_is_web_user_logged_in()){
		    $detail = ModelOffer::newInstance()->getOfferItemOption($item_id);

		    require_once 'item_edit.php';
		  }
    	}
    }
    
    function offer_item_edit_post($catId = null, $item_id = null) {
	 // We received the categoryID and the Item ID
	  if($catId!=null) 
	  {
		// We check if the category is the same as our plugin
		if(osc_is_this_category('offer', $catId))
		{
			// Insert the data in our plugin's table
            ModelOffer::newInstance()->replaceOptions($item_id, (Params::getParam("offerYes")!='') ? 1 : 0, 0, (Params::getParam("offerTrade")!='') ? 1 : 0);
		}
	  }
    }
       
    function offer_item_delete($id){
    	ModelOffer::newInstance()->deleteOfferItem($id);        	
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
               
        $offerCheck = ModelOffer::newInstance()->getOffer('seller_id', osc_logged_user_id(), 'item_id', osc_item_id() );
        
        if($offerCheck){
        $offer_url = osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php#item' . osc_item_id();
        $toolbar->addOption('<a href="' . $offer_url . '" />' . __('View offers on this ad', 'offfer_button') . '</a>');
        }
                
        $offerStatus = ModelOffer::newInstance()->getOffer('user_id', osc_logged_user_id(), 'item_id', osc_item_id() );
        
        if($offerStatus){
        $offerButton_url = osc_base_url(true).'?page=custom&file=offerButton/offerButton.php#item' . osc_item_id();
        $toolbar->addOption('<a href="' . $offerButton_url . '" />' . __('View status of offer', 'offfer_button') . '</a>');
        }
    }
    
    /**
     * Send email to users with offers and statuses
     * 
     * @param integer $item
     * @param integer $offer_value 
     *
     * @dynamic tags
     *
     * '{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
     * '{ITEM_URL}', '{WEB_TITLE}', '{OFFER_URL}', '{OFFER_VALUE}
     */
     
    function offer_button_send_email($item, $offer_value) {
       
        $mPages = new Page() ;
        $aPage = $mPages->findByInternalName('email_new_offer') ;
        $locale = osc_current_user_locale() ;
        $content = array();
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }
        
	     $item_url    = osc_item_url( ) ;
        $item_url    = '<a href="' . $item_url . '" >' . $item_url . '</a>';
        
        $offer_url    = osc_base_url(true) . '?page=custom&file=offerButton/offer_byItem.php#item' . $item['pk_i_id'] ;
        $offer_url    = '<a href="' . $offer_url . '" >' . $offer_url . '</a>';

        $words   = array();
        $words[] = array('{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
            '{ITEM_URL}', '{WEB_TITLE}', '{OFFER_URL}', '{OFFER_VALUE}');
        $words[] = array($item['pk_i_id'], $item['s_contact_name'], $item['s_contact_email'], osc_base_url(), $item['s_title'],
            $item_url, osc_page_title(), $offer_url, $offer_value) ;

        $title = osc_mailBeauty($content['s_title'], $words) ;
        $body  = osc_mailBeauty($content['s_text'], $words) ;

        $emailParams =  array('subject'  => $title
                             ,'to'       => $item['s_contact_email']
                             ,'to_name'  => $item['s_contact_name']
                             ,'body'     => $body
                             ,'alt_body' => $body);

        osc_sendMail($emailParams);
    }
    
    /**
     * Send email to user with offers and statuses
     * 
     * @param integer $item, $offer_status
     * @param string  $senderName, $senderEmail
     *
     * @dynamic tags
     *
     * '{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
     * '{ITEM_URL}', '{WEB_TITLE}', '{SELLER_EMAIL}', '{OFFER_STATUS}', '{OFFER_STATUS_URL}', '{SELLER_PHONE}'
     */
     
        function offer_button_send_status_email($item, $offer_status, $senderName, $senderEmail) {
       
        $mPages = new Page() ;
        $aPage = $mPages->findByInternalName('email_offer_status') ;
        $locale = osc_current_user_locale() ;
        $content = array();
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }
        
        $user = User::newInstance()->findByPrimaryKey($item['fk_i_user_id']);
        $itemEmail = $item['s_contact_email'];
        
        if($user['s_phone_land'] != '' || $user['s_phone_mobile'] !='') {
         if($user['s_phone_land'] != '') {
            $userPhone = $user['s_phone_land'];
         } else{
            $userPhone = $user['s_phone_mobile'];
         }
        } else {
           $userPhone = '';
        }
        
        if($senderEmail != ''){
        	$item['s_contact_email'] = $senderEmail;
        	$item['s_contact_name'] = $senderName;
        }
        $sendEmail = $item['s_contact_email'];
        $sendName = $item['s_contact_name'];
        
		  $item_url    = osc_item_url( ) ;
        $item_url    = '<a href="' . $item_url . '" >' . $item_url . '</a>';
        
        $offer_status_url    = osc_base_url(true) . '?page=custom&file=offerButton/offer_button.php#item' . $item['pk_i_id'] ;
        $offer_status_url    = '<a href="' . $offer_status_url . '" >' . $offer_status_url . '</a>';
        $status_offer = array();
        $status_offer = array('1' => __('has been accepted', 'offerButton'), '2' => __('has been changed to pending','offerButton'), '3' => __('has been declined','offerButton'));
		  
		  if ( $offer_status ==1) {
		  		$sEmail = $itemEmail;
		  }
		  else {
		  		$sEmail = '';
		  }
		  
        $words   = array();
        $words[] = array('{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
            '{ITEM_URL}', '{WEB_TITLE}', '{SELLER_EMAIL}', '{OFFER_STATUS}', '{OFFER_STATUS_URL}', '{SELLER_PHONE}');
        $words[] = array($item['pk_i_id'], $item['s_contact_name'], $item['s_contact_email'], osc_base_url(), $item['s_title'],
            $item_url, osc_page_title(), $sEmail, $status_offer[$offer_status], $offer_status_url, $userPhone) ;

        $title = osc_mailBeauty($content['s_title'], $words) ;
        $body  = osc_mailBeauty($content['s_text'], $words) ;

        $emailParams =  array('subject'  => $title
                             ,'to'       => $sendEmail
                             ,'to_name'  => $sendName
                             ,'body'     => $body
                             ,'alt_body' => $body);

        osc_sendMail($emailParams);
    }
    
    
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'offer_call_after_install') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'offer_call_after_uninstall') ;

    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'offer_config') ;
    
    // Add hook for item deleted
    osc_add_hook('delete_item', 'offer_item_delete');

    if(osc_offerButton_enabled() == 1){
    // Add link in user menu page
    osc_add_hook('user_menu', 'offer_user_menu') ;
    }
   
    // Add link in admin menu page
    osc_add_hook('admin_menu', 'offer_admin_menu') ;
    
    if(osc_offerButton_enabled() == 1){
    // add javascript
    osc_add_hook('item_detail', 'offer_js') ;
    
    // hook for header
    osc_add_hook('header', 'offer_css');
    
    // hook for admin header
    osc_add_hook('admin_header', 'offer_back_css');
    
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
