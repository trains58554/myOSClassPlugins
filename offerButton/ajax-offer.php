<?php 
$conn   = getConnection();

$userOffer    = Params::getParam('offer');
$userId       = Params::getParam('user_id');
$sellerId     = Params::getParam('seller_id');
$itemId       = Params::getParam('item_id');
$bName		  = Params::getParam('name');
$bEmail		  = Params::getParam('eMail');
$offerType    = Params::getParam('offerType');
if($offerType == '') {
   $offerType = 1;
}
$item_idA = Item::newInstance()->findByPrimaryKey($itemId);


$message = '';
if (osc_is_web_user_logged_in()){

	$locked = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_user_locked WHERE seller_id  = '%d' AND user_id = '%d'", DB_TABLE_PREFIX, $sellerId, $userId );
	$reason = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_reason WHERE id = '%d'", DB_TABLE_PREFIX, $locked['readon_code'] );
	if(osc_offerButton_locking() == 0){
	   $locked['locked'] = 0;
	}
	//$locked['locked'] = 1;
	if($locked['locked'] != 1) {


if ($userId != $sellerId){
	$success = True;

	if(is_numeric($userOffer) || $offerType == 2){
			//checks for an accepted item and not deleted
    		$offerAccepted = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE item_id  = '%d' AND offer_status = '%d' AND sDelete !='1' ORDER BY id DESC", DB_TABLE_PREFIX, $itemId, 1);
    		if (!$offerAccepted) {
    			$offerCheck = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE user_id  = '%d' AND item_id = '%d' AND sDelete !='1' ORDER BY id DESC", DB_TABLE_PREFIX, osc_logged_user_id(), $itemId);	
    			//checks if user has already submitted an offer
    			if($offerCheck){
    				if($offerCheck['offer_status'] == 2){
    					$message = __('Please wait until seller accepts or declines your last offer','offer_button');
    				} else{
    					if(($offerCheck['offer_type'] != 2 || $offerCheck['offer_type'] != 3) && (($offerCheck['offer_status'] = 3) && ($userOffer < $offerCheck['offer_value']))){
    						$message = __('Please submit an offer greater than ' . $offerCheck['offer_value'] . ' ' . $item_idA['fk_c_currency_code'],'offer_button');
    					} else{
    						//adds offer to item from user 
                				$conn->osc_dbExec("INSERT INTO %st_offer_button (user_id, seller_id, item_id, offer_value, offer_status, offer_type) VALUES ('%d', '%d', '%d', '%f', '%d', '%d')", DB_TABLE_PREFIX, osc_logged_user_id(), $sellerId, $itemId, $userOffer, '2', $offerType);
                				
                				offer_button_send_email($item_idA, $userOffer);
                				$message = __('Your new offer has been submitted' ,'offer_button');
                				
    					}// ends else for $offerCheck status == 3
    				}//ends else for $offerCheck status == 2
    			}// ends if ($offerCheck)
    			else{
    				//adds offer to item from user 
                		$conn->osc_dbExec("INSERT INTO %st_offer_button (user_id, seller_id, item_id, offer_value, offer_status, offer_type) VALUES ('%d', '%d', '%d', '%f', '%d', '%d')", DB_TABLE_PREFIX, osc_logged_user_id(), $sellerId, $itemId, $userOffer, '2', $offerType);
                		offer_button_send_email($item_idA, $userOffer);
                		$message = __('Your offer has been submitted','offer_button');
    			}
    			
		}else{
			$message = __('Sorry this seller is not currenly taking offers.', 'offer_button');
		}
	}
	else{
		$message = __('Please enter numbers only', 'offer_button');
		$success = False;
	}
}
else {
$success = True;
$message = __('You are submitting an offer to your self. Offer canceled', 'offer_buton');
}
} else{
   //reason for locking user.
   $success = True;
   $message = __('You are blocked ', 'offer_buton') . $reason['reason'];
}
} else if(osc_offerButton_usersOnly() == 0) {
   
   $locked = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_user_locked WHERE seller_id  = '%d' AND email = '%s'", DB_TABLE_PREFIX, $sellerId, $bEmail );
	$reason = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_reason WHERE id = '%d'", DB_TABLE_PREFIX, $locked['reason_code'] );
	if(osc_offerButton_locking() == 0){
	   $locked['locked'] = 0;
	}
	//$locked['locked'] = 1;
	if($locked['locked'] != 1) {

if ($userId != $sellerId){
	$success = True;
	
	if(is_numeric($userOffer) || $offerType == 2){
	if($bName != '') {
	if($bEmail != '') {
	if (filter_var($bEmail, FILTER_VALIDATE_EMAIL)) {		
			//checks for an accepted item
    		$offerAccepted = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE item_id  = '%d' AND offer_status = '%d' AND sDelete !='1' ORDER BY id DESC", DB_TABLE_PREFIX, $itemId, 1);
    		if (!$offerAccepted) {
    			$offerCheck = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE b_email  = '%s' AND item_id = '%d' AND sDelete !='1' ORDER BY id DESC", DB_TABLE_PREFIX, $bEmail, $itemId);	
    			//checks if user has already submitted an offer
    			if($offerCheck){
    				if($offerCheck['offer_status'] == 2){
    					$message = __('Please wait until seller accepts or declines your last offer','offer_button');
    				} else{
    					if(($offerCheck['offer_type'] != 2 || $offerCheck['offer_type'] != 3) && (($offerCheck['offer_status'] = 3) && ($userOffer < $offerCheck['offer_value']))){
    						$message = __('Please submit an offer greater than ' . $offerCheck['offer_value'] . ' ' . $item_idA['fk_c_currency_code'],'offer_button');
    					} else{
    						//adds offer to item from user 
                				$conn->osc_dbExec("INSERT INTO %st_offer_button (b_email, b_name, seller_id, item_id, offer_value, offer_status, offer_type) VALUES ('%s', '%s', '%d', '%d', '%f', '%d', '%d')", DB_TABLE_PREFIX, $bEmail, $bName, $sellerId, $itemId, $userOffer, '2', $offerType);
                				
                				offer_button_send_email($item_idA, $userOffer);
                				$message = __('Your new offer has been submitted' ,'offer_button');
                				
    					}// ends else for $offerCheck status == 3
    				}//ends else for $offerCheck status == 2
    			}// ends if ($offerCheck)
    			else{
    				//adds offer to item from user 
                		$conn->osc_dbExec("INSERT INTO %st_offer_button (b_email, b_name, seller_id, item_id, offer_value, offer_status, offer_type) VALUES ('%s', '%s', '%d', '%d', '%f', '%d', '%d')", DB_TABLE_PREFIX, $bEmail, $bName, $sellerId, $itemId, $userOffer, '2', $offerType);
                		offer_button_send_email($item_idA, $userOffer);
                		$message = __('Your offer has been submitted','offer_button');
    			}
    			
		}else{
			$message = __('Sorry this seller is not currently taking offers.', 'offer_button');
		}
	}
	else{
		$message = __('Please enter a valid Email', 'offer_button');
		$success = False;
	}
	}
	else{
		$message = __('Please enter your email', 'offer_button');
		$success = False;
	}
	}
	else{
		$message = __('Please enter your name', 'offer_button');
		$success = False;
	}
	}
	else{
		$message = __('Please enter numbers only', 'offer_button');
		$success = False;
	}
}
else {
$success = True;
$message = __('You are submitting an offer to your self. Offer canceled', 'offer_buton');
}
} else{
   //reason for locking user.
   $success = True;
   $message = __('You are blocked ', 'offer_buton') . $reason['reason'];
}
}
//$message = __('Your offer of $' . $userOffer . ' has been submitted' . $userId . $sellerId . $itemId ,'offer_button');
$json = array(
            'success' => $success,
            'message' => $message
            
        );

echo json_encode($json);
?>
