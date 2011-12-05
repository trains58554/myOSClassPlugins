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
		$conn = getConnection();
      $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 1, $offer_id);
      $buyUser = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE id  = '%d'", DB_TABLE_PREFIX, $offer_id);          
      
      $item_idA = Item::newInstance()->findByPrimaryKey($item_id);
      if($buyUser['user_id'] != ''){
      	$user = User::newInstance()->findByPrimaryKey($buyUser['user_id']);
      } else{
      	$user['s_name'] = $bName;
      	$user['s_email'] = $bEmail;
      }
      
      offer_button_send_status_email($item_idA, 1, $user['s_name'], $user['s_email']);
                
      osc_add_flash_ok_message(__('Offer Accepted', 'offer_button'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 	
	break;
		
	case 'pending':
		$conn = getConnection();
      $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 2, $offer_id);
      $buyUser = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE id  = '%d'", DB_TABLE_PREFIX, $offer_id);
		$item_idA = Item::newInstance()->findByPrimaryKey($item_id);
		if($buyUser['user_id'] != ''){
      	$user = User::newInstance()->findByPrimaryKey($buyUser['user_id']);
      } else{
      	$user['s_name'] = $bName;
      	$user['s_email'] = $bEmail;
      }
      offer_button_send_status_email($item_idA, 2, $user['s_name'], $user['s_email']);
                
		osc_show_flash_message(__('Offer set to Pending', 'offer_button'), 'admin');
     	
     	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'declined':
		$conn = getConnection();
      $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 3, $offer_id);
      $buyUser = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE id  = '%d'", DB_TABLE_PREFIX, $offer_id);
      $item_idA = Item::newInstance()->findByPrimaryKey($item_id);
      if($buyUser['user_id'] != ''){
      	$user = User::newInstance()->findByPrimaryKey($buyUser['user_id']);
      } else{
      	$user['s_name'] = $bName;
      	$user['s_email'] = $bEmail;
      }
                offer_button_send_status_email($item_idA, 3, $user['s_name'], $user['s_email']);
                osc_add_flash_ok_message(__('Offer Declined', 'offer_button'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'delete':
		$conn = getConnection();
		$conn->osc_dbExec("UPDATE %st_offer_button SET sDelete = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 1, $offer_id);
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'reasonLock':
	   $conn = getConnection();
		$reasons = $conn->osc_dbFetchResults("SELECT * FROM %st_offer_reason", DB_TABLE_PREFIX);
	   ?>
	   <div class="content user_account">
    <h1>
        <strong><?php _e('View Offers on Your Items', 'offer_button'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
	   <h2><?php _e('Select a Reason for locking the user','offer_button'); ?></h2>
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
		$conn = getConnection();
		$item_idA = Item::newInstance()->findByPrimaryKey($item_id);
		if($nUser == '' && $user_id != ''){
      	$conn->osc_dbExec("UPDATE %st_offer_button SET user_locked = '%d' WHERE user_id = '%d'", DB_TABLE_PREFIX, 1, $user_id);
      	$conn->osc_dbExec("REPLACE INTO %st_offer_user_locked SET seller_id = '%d', user_id = '%d', reason_code = '%d', locked = '%d'", DB_TABLE_PREFIX, $item_idA['fk_i_user_id'], $user_id, $rCode , 1);
      } else {
      	$conn->osc_dbExec("UPDATE %st_offer_button SET user_locked = '%d' WHERE b_email = '%s'", DB_TABLE_PREFIX, 1, $nUser);
      	$conn->osc_dbExec("REPLACE INTO %st_offer_user_locked SET seller_id = '%d', email = '%s', reason_code = '%d', locked = '%d'", DB_TABLE_PREFIX, $item_idA['fk_i_user_id'], $nUser, $rCode , 1);
      }
      
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'unlock':
		$conn = getConnection();
		$item_idA = Item::newInstance()->findByPrimaryKey($item_id);
		if($nUser == '' && $user_id != ''){
      	$conn->osc_dbExec("UPDATE %st_offer_button SET user_locked = '%d' WHERE user_id = '%d'", DB_TABLE_PREFIX, 0, $user_id);
      	$conn->osc_dbExec("DELETE FROM %st_offer_user_locked WHERE seller_id = '%d' AND user_id = '%d'", DB_TABLE_PREFIX, $item_idA['fk_i_user_id'], $user_id);
      } else {
      	$conn->osc_dbExec("UPDATE %st_offer_button SET user_locked = '%d' WHERE b_email = '%s'", DB_TABLE_PREFIX, 0, $nUser);
      	$conn->osc_dbExec("DELETE FROM %st_offer_user_locked WHERE seller_id = '%d' AND email = '%s'", DB_TABLE_PREFIX, $item_idA['fk_i_user_id'], $nUser);
      }
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
}
?>
