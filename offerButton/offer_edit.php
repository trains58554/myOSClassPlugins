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

$promo_action = Params::getParam('offer-action');


switch($promo_action) {
	case 'accept':
		$conn = getConnection();
                $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 1, $offer_id);
                
                
                //$item_idA = $conn->osc_dbFetchResult("SELECT * FROM %st_item WHERE pk_i_id = '%d'", DB_TABLE_PREFIX, $item_id);
                //$item_idA += $conn->osc_dbFetchResult("SELECT * FROM %st_item_description WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $item_id);
                $item_idA = Item::newInstance()->findByPrimaryKey($item_id);
                $user = User::newInstance()->findByPrimaryKey($item_idA['fk_i_user_id']);
                offer_button_send_status_email($item_idA, 1, $user['s_name'], $user['s_email']);
                
                osc_add_flash_ok_message(__('Offer Accepted', 'offer_button'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 	
	break;
		
	case 'pending':
		$conn = getConnection();
                $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 2, $offer_id);
		$item_idA = Item::newInstance()->findByPrimaryKey($item_id);
                $user = User::newInstance()->findByPrimaryKey($item_idA['fk_i_user_id']);
                offer_button_send_status_email($item_idA, 2, $user['s_name'], $user['s_email']);
                
		osc_show_flash_message(__('Offer set to Pending', 'offer_button'), 'admin');
     	
     	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'declined':
		$conn = getConnection();
                $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 3, $offer_id);
                $item_idA = Item::newInstance()->findByPrimaryKey($item_id);
                $user = User::newInstance()->findByPrimaryKey($item_idA['fk_i_user_id']);
                offer_button_send_status_email($item_idA, 3, $user['s_name'], $user['s_email']);
                osc_add_flash_ok_message(__('Offer Declined', 'offer_button'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
}
?>
