<?php 
$userOffer    = $_POST['offer'];
$userId       = $_POST['user_id'];
$sellerId     = $_POST['seller_id'];
$itemId       = $_POST['item_id'];

$item_idA = Item::newInstance()->findByPrimaryKey($itemId);

$message = '';
if (osc_is_web_user_logged_in()){
if ($userId != $sellerId){
	$success = True;
	
	if(is_numeric($userOffer)){
		$conn   = getConnection();
    		$offerAccepted = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE item_id  = '%d' AND offer_status = '%d' ORDER BY id DESC", DB_TABLE_PREFIX, $itemId, 1);
    		if (!$offerAccepted) {
			$conn   = getConnection();
    			$offerCheck = $conn->osc_dbFetchResult("SELECT * FROM %st_offer_button WHERE user_id  = '%d' AND item_id = '%d' ORDER BY id DESC", DB_TABLE_PREFIX, osc_logged_user_id(), $itemId);	
    			//checks if user has already submitted an offer
    			if($offerCheck){
    				if($offerCheck['offer_status'] == 2){
    					$message = __('Please wait until seller accepts or declines your last offer','offer_button');
    				} else{
    					if(($offerCheck['offer_status'] = 3) && ($userOffer < $offerCheck['offer_value'])){
    						$message = __('Please submit an offer greater than $' . $offerCheck['offer_value'],'offer_button');
    					} else{
    						//adds offer to item from user 
            					$conn = getConnection();
                				$conn->osc_dbExec("INSERT INTO %st_offer_button (user_id, seller_id, item_id, offer_value, offer_status) VALUES ('%d', '%d', '%d', '%f', '%d')", DB_TABLE_PREFIX, osc_logged_user_id(), $sellerId, $itemId, $userOffer, '2');
                				
                				offer_button_send_email($item_idA, $userOffer);
                				$message = __('Your new offer of $'. $userOffer . ' has been submitted' ,'offer_button');
                				
    					}
    				}
    			}
    			else{
    				//adds offer to item from user 
            			$conn = getConnection();
                		$conn->osc_dbExec("INSERT INTO %st_offer_button (user_id, seller_id, item_id, offer_value, offer_status) VALUES ('%d', '%d', '%d', '%f', '%d')", DB_TABLE_PREFIX, osc_logged_user_id(), $sellerId, $itemId, $userOffer, '2');
                		offer_button_send_email($item_idA, $userOffer);
                		$message = __('Your offer of $' . $userOffer . ' has been submitted','offer_button');
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
$message = __('You are submitting an offer to your self offer canceled', 'offer_buton');
}
}
//$message = __('Your offer of $' . $userOffer . ' has been submitted' . $userId . $sellerId . $itemId ,'offer_button');
$json = array(
            'success' => $success,
            'message' => $message
            
        );

echo json_encode($json);
?>
