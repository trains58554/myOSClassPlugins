<?php
$offer_id	  = '';
if(Params::getParam('offer-id') != ''){
	$offer_id = Params::getParam('offer-id');
}
$user_id	  = '';
if(Params::getParam('user-id') != ''){
	$user_id = Params::getParam('user-id');
}
$item_id	  = '';
if(Params::getParam('item-id') != ''){
	$item_id = Params::getParam('item-id');
}
$bName	  = '';
if(Params::getParam('b_name') != ''){
	$bName = Params::getParam('b_name');
}
$bEmail	  = '';
if(Params::getParam('b_email') != ''){
	$bEmail = Params::getParam('b_email');
}
$nUser	  = '';
if(Params::getParam('n-user') != ''){
	$nUser = Params::getParam('n-user');
}
$rCode	  = '';
if(Params::getParam('r_code') != ''){
	$rCode = Params::getParam('r_code');
}

$promo_action = Params::getParam('offer-action');


switch($promo_action) {
	case 'accept':      
      ModelOffer::newInstance()->updateOfferStatus(1, $offer_id);          
      $buyUser = ModelOffer::newInstance()->getOffer('id', $offer_id, NULL, NULL, NULL, NULL, NULL, NULL);
      
      $item_idA = Item::newInstance()->findByPrimaryKey($item_id);
      if($buyUser['user_id'] != ''){
      	$user = User::newInstance()->findByPrimaryKey($buyUser['user_id']);
      } else{
      	$user['s_name'] = $bName;
      	$user['s_email'] = $bEmail;
      }
      
      $cName = $user['s_name'];
      $cEmail = $user['s_email'];
      if(osc_offerButton_email_temps()){
         offer_button_send_status_email($item_idA, 1, $cName, $cEmail);
      }
                
      //osc_add_flash_ok_message(__('Offer Accepted', 'offerButton'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 	
	break;
		
	case 'pending':
      ModelOffer::newInstance()->updateOfferStatus(2, $offer_id);
      $buyUser = ModelOffer::newInstance()->getOffer('id', $offer_id, NULL, NULL, NULL, NULL, NULL, NULL);
		$item_idA = Item::newInstance()->findByPrimaryKey($item_id);
		if($buyUser['user_id'] != ''){
      	$user = User::newInstance()->findByPrimaryKey($buyUser['user_id']);
      } else{
      	$user['s_name'] = $bName;
      	$user['s_email'] = $bEmail;
      }
      
      $cName = $user['s_name'];
      $cEmail = $user['s_email'];

      if(osc_offerButton_email_temps()){
         offer_button_send_status_email($item_idA, 2, $cName, $cEmail);
      }
                
		//osc_show_flash_message(__('Offer set to Pending', 'offerButton'), 'admin');
     	
     	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'declined':
      ModelOffer::newInstance()->updateOfferStatus(3, $offer_id);
      $buyUser = ModelOffer::newInstance()->getOffer('id', $offer_id, NULL, NULL, NULL, NULL, NULL, NULL);
      $item_idA = Item::newInstance()->findByPrimaryKey($item_id);
      if($buyUser['user_id'] != ''){
      	$user = User::newInstance()->findByPrimaryKey($buyUser['user_id']);
      } else{
      	$user['s_name'] = $bName;
      	$user['s_email'] = $bEmail;
      }
      
      $cName = $user['s_name'];
      $cEmail = $user['s_email'];

      if(osc_offerButton_email_temps()){
         offer_button_send_status_email($item_idA, 3, $cName, $cEmail);
      }
      
      //osc_add_flash_ok_message(__('Offer Declined', 'offerButton'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'delete':
		ModelOffer::newInstance()->updateDelete($offer_id);
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'reasonLock':		
		$reasons = ModelOffer::newInstance()->getReasons();
	   ?>
	   <div class="content user_account">
    <h1>
        <strong><?php _e('View Offers on Your Items', 'offerButton'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
	   <h2><?php _e('Select a Reason for locking the user','offerButton'); ?></h2>
	   <form action="<?php echo osc_base_url(true); ?>" method="post">
         <input type="hidden" name="page" value="custom" />
         <input type="hidden" name="offer-action" value="lock" />
         <input type="hidden" name="file" value="offerButton/offer_edit.php" />
         <input type="hidden" name="n-user" value="<?php echo $nUser; ?>" />
         <input type="hidden" name="offer-id" value="<?php echo $offer_id; ?>" />
         <input type="hidden" name="user-id" value="<?php echo $user_id; ?>" />
         <input type="hidden" name="item-id" value="<?php echo $item_id; ?>" />
         <input type="hidden" name="reason" value="1" />
         <select name="r_code" id="r_code">
         <?php foreach($reasons as $reason) {
            echo '<option value="' . $reason['id'] . '">' . $reason['reason'] . '</option>';
           } ?>
         </select>
         <input type="submit" value="Submit" />
    <div>
	 </div>
	</div>
	   <?php
	   exit; 
	break;
	
   case 'lock':
		$item_idA = Item::newInstance()->findByPrimaryKey($item_id);
		if($nUser == '' && $user_id != ''){
      	ModelOffer::newInstance()->updateLocking(1, 'user_id', $user_id);      	
      	ModelOffer::newInstance()->replaceLocked($item_idA['fk_i_user_id'], 'user_id', $user_id, $rCode , 1);
      } else {
      	ModelOffer::newInstance()->updateLocking(1, 'b_email', $nUser);      	
      	ModelOffer::newInstance()->replaceLocked($item_idA['fk_i_user_id'], 'email', $nUser, $rCode , 1);
      }
      
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'unlock':
		$item_idA = Item::newInstance()->findByPrimaryKey($item_id);
		if($nUser == '' && $user_id != ''){
      	ModelOffer::newInstance()->updateLocking(0, 'user_id', $user_id);
      	ModelOffer::newInstance()->replaceLocked($item_idA['fk_i_user_id'], 'user_id', $user_id, NULL , 0);
      } else {      	
      	ModelOffer::newInstance()->updateLocking(1, 'b_email', $nUser);
      	ModelOffer::newInstance()->replaceLocked($item_idA['fk_i_user_id'], 'email', $nUser, NULL , 0);
      }
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
}
?>
