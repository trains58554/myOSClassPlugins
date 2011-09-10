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
                
                /*//$title = osc_mailBeauty($content['s_title'], $words) ;
                //$body = osc_mailBeauty($content['s_text'], $words) ;
		$user = User::newInstance()->findByPrimaryKey($user_id); 
		$item = Item::newInstance()->findByPrimaryKey($offer_id);
                $emailParams = array('subject'  => $item['s_title']
                                    ,'to'       => $user['s_email']
                                    ,'to_name'  => $user['s_name']
                                    ,'body'     => 'The seller of ' . $item['s_title'] . '. Has accepted your offer please respond to seller within 24 hours or the seller may accept another offer.'
                                    ,'alt_body' => 'The seller of ' . $item['s_title'] . '. Has accepted your offer please respond to seller within 24 hours or the seller may accept another offer.'
                ) ;
                osc_sendMail($emailParams);*/
                osc_add_flash_ok_message(__('Offer Accepted', 'offer_button'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 	
	break;
		
	case 'pending':
		$conn = getConnection();
                $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 2, $offer_id);
	
		osc_show_flash_message(__('Offer set to Pending', 'offer_button'), 'admin');
     	
     	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
	
	case 'declined':
		$conn = getConnection();
                $conn->osc_dbExec("UPDATE %st_offer_button SET offer_status = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, 3, $offer_id);
                osc_add_flash_ok_message(__('Offer Declined', 'offer_button'), 'admin');
	// HACK TO DO A REDIRECT
    	echo '<script>location.href="' . osc_base_url(true).'?page=custom&file=offerButton/offer_byItem.php"</script>';
    	exit; 
	break;
}
