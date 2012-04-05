<?php 

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
	
	@$locked = ModelOffer::newInstance()->getLockedStatus($sellerId, 'user_id', $userId);
	if(@$locked['locked'] != 0){	
	  $reason = ModelOffer::newInstance()->getReason($locked['readon_code']);
   }
	if(osc_offerButton_locking() == 0){
	   $locked['locked'] = 0;
	}
	//$locked['locked'] = 1; debugging only
	if(@$locked['locked'] != 1) {


if ($userId != $sellerId){
	$success = True;

	if(is_numeric($userOffer) || $offerType == 2){
			//checks for an accepted item and not deleted    		
    		$offerAccepted = ModelOffer::newInstance()->getOffer('item_id', $itemId, 'offer_status', 1, 1, 'id', 'DESC', NULL);
    		if (!$offerAccepted) {    			
    			$offerCheck = ModelOffer::newInstance()->getOffer('user_id', osc_logged_user_id(), 'item_id', $itemId, 1, 'id', 'DESC', NULL);	
    			//checks if user has already submitted an offer
    			if($offerCheck){
    				if($offerCheck['offer_status'] == 2){
    					$message = __('Please wait until seller accepts or declines your last offer','offerButton');
    				} else{
    					if(($offerCheck['offer_type'] != 2 || $offerCheck['offer_type'] != 3) && (($offerCheck['offer_status'] = 3) && ($userOffer < $offerCheck['offer_value']))){
    						$message = __('Please submit an offer greater than','offerButton') . ' ' . $offerCheck['offer_value'] . ' ' . $item_idA['fk_c_currency_code'];
    					} else{
    						//adds offer to item from user                 				
                				ModelOffer::newInstance()->insertOffer(osc_logged_user_id(), NULL, NULL, $sellerId, $itemId, $userOffer, '2', $offerType, 1);
                				
                				offer_button_send_email($item_idA, $userOffer);
                				$message = __('Your new offer has been submitted' ,'offerButton');
                				
    					}// ends else for $offerCheck status == 3
    				}//ends else for $offerCheck status == 2
    			}// ends if ($offerCheck)
    			else{
    				//adds offer to item from user 
                		ModelOffer::newInstance()->insertOffer(osc_logged_user_id(), NULL, NULL, $sellerId, $itemId, $userOffer, '2', $offerType, 1);
                		
                		if(osc_offerButton_email_temps()){
                		   offer_button_send_email($item_idA, $userOffer);
                		}
                		
                		$message = __('Your offer has been submitted','offerButton');
    			}
    			
		}else{
			$message = __('Sorry this seller is not currently taking offers.', 'offerButton');
		}
	}
	else{
		$message = __('Please enter numbers only', 'offerButton');
		$success = False;
	}
}
else {
$success = True;
$message = __('You are submitting an offer to your self. Offer cancelled', 'offerButton');
}
} else{
   //reason for locking user.
   $success = True;
   $message = __('You are blocked', 'offerButton') . ' ' . $reason['reason'];
}
} else if(osc_offerButton_usersOnly() == 0) {
      
	@$locked = ModelOffer::newInstance()->getLockedStatus($sellerId, 'email', $bEmail);	
	if(@$locked['locked'] != 0){	
	  $reason = ModelOffer::newInstance()->getReason($locked['readon_code']);
   }
	
	if(osc_offerButton_locking() == 0){
	   $locked['locked'] = 0;
	}
	//$locked['locked'] = 1;
	if(@$locked['locked'] != 1) {

if ($userId != $sellerId){
	$success = True;
	
	if(is_numeric($userOffer) || $offerType == 2){
	if($bName != '') {
	if($bEmail != '') {
	if (filter_var($bEmail, FILTER_VALIDATE_EMAIL)) {		
			//checks for an accepted item
    		$offerAccepted = ModelOffer::newInstance()->getOffer('item_id', $itemId, 'offer_status', 1, 1, 'id', 'DESC', NULL);
    		if (!$offerAccepted) {    			
    			$offerCheck = ModelOffer::newInstance()->getOffer('b_email', $bEmail, 'item_id', $itemId, 1, 'id', 'DESC', NULL);	
    			//checks if user has already submitted an offer
    			if($offerCheck){
    				if($offerCheck['offer_status'] == 2){
    					$message = __('Please wait until seller accepts or declines your last offer','offerButton');
    				} else{
    					if(($offerCheck['offer_type'] != 2 || $offerCheck['offer_type'] != 3) && (($offerCheck['offer_status'] = 3) && ($userOffer < $offerCheck['offer_value']))){
    						$message = __('Please submit an offer greater than','offerButton') . ' ' . $offerCheck['offer_value'] . ' ' . $item_idA['fk_c_currency_code'];
    					} else{
    						//adds offer to item from user                 				
                				ModelOffer::newInstance()->insertOffer(NULL, $bEmail, $bName, $sellerId, $itemId, $userOffer, '2', $offerType, 1);
                				
                				offer_button_send_email($item_idA, $userOffer);
                				$message = __('Your new offer has been submitted' ,'offerButton');
                				
    					}// ends else for $offerCheck status == 3
    				}//ends else for $offerCheck status == 2
    			}// ends if ($offerCheck)
    			else{
    				//adds offer to item from user 
                		ModelOffer::newInstance()->insertOffer(NULL, $bEmail, $bName, $sellerId, $itemId, $userOffer, '2', $offerType, 1);
                		
                		if(osc_offerButton_email_temps()){
                		   offer_button_send_email($item_idA, $userOffer);
                		}
                		
                		$message = __('Your offer has been submitted','offerButton');
    			}
    			
		}else{
			$message = __('Sorry this seller is not currently taking offers.', 'offerButton');
		}
	}
	else{
		$message = __('Please enter a valid Email', 'offerButton');
		$success = False;
	}
	}
	else{
		$message = __('Please enter your email', 'offerButton');
		$success = False;
	}
	}
	else{
		$message = __('Please enter your name', 'offerButton');
		$success = False;
	}
	}
	else{
		$message = __('Please enter numbers only', 'offerButton');
		$success = False;
	}
}
else {
$success = True;
$message = __('You are submitting an offer to your self. Offer cancelled', 'offerButton');
}
} else{
   //reason for locking user.
   $success = True;
   $message = __('You are blocked ', 'offerButton') . $reason['reason'];
}
}
//$message = __('Your offer of $' . $userOffer . ' has been submitted' . $userId . $sellerId . $itemId ,'offerButton');
$json = array(
            'success' => $success,
            'message' => $message
            
        );

echo json_encode($json);
?>
