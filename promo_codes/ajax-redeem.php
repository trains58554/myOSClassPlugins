<?php
if (isset($_POST['promo_codes'])) {
$promocode = $_POST['promo_codes'];

        if ( osc_is_web_user_logged_in() ) {
            //check if promo code is in database and enabled
            $conn   = getConnection();
            $detail = $conn->osc_dbFetchResult("SELECT * FROM %st_promo_code WHERE promo_code LIKE '%s' AND enabled = '%d'", DB_TABLE_PREFIX, $promocode, 1);
            
            //checks if the user already has a row in the paypal_walet table
            $conn = getConnection();
            $paypal_wallet = $conn->osc_dbFetchResult("SELECT * FROM %st_paypal_wallet WHERE fk_i_user_id  = '%d'", DB_TABLE_PREFIX, osc_logged_user_id());
            
            //If somthing is returned then we can process
	    if($detail){
	    	//check if the code has been used by this user
	    	$conn   = getConnection();
            	$promo_redeemed = $conn->osc_dbFetchResult("SELECT * FROM %st_promo_code_redeemed WHERE fk_i_user_id = '%d' AND promo_code_id = '%d'", DB_TABLE_PREFIX, osc_logged_user_id(), $detail['promo_code']);
            	//checks if the code has been used
            	if(!$promo_redeemed){
            		//checks if max uses is not set to 0
            		if($detail['max_uses'] >0){
            			//checks if the code has uses left
            			if($detail['uses_remaining'] != 0){
            				$success = TRUE;
            				
            				//logs the promo code 
            				$conn = getConnection();
                			$conn->osc_dbExec("INSERT INTO %st_promo_code_redeemed (fk_i_user_id, promo_code_id) VALUES (%d, '%s')", DB_TABLE_PREFIX, osc_logged_user_id(), $detail['promo_code']);
                			
                			//udates the number of uses remaining for promo code
                			$conn = getConnection();
                			$conn->osc_dbExec("UPDATE %st_promo_code SET uses_remaining = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, $detail['uses_remaining'] -1, $detail['id']);
                			                			
                			//if user exists in table then update else add user to table
                			if ($paypal_wallet){
                				$new_amount = $paypal_wallet['f_amount'] + $detail['promo_value'];
                				//udates wallet amount plus the promo_value
                				$conn = getConnection();
                				$conn->osc_dbExec("UPDATE %st_paypal_wallet SET f_amount = '%f' WHERE fk_i_user_id = '%d'", DB_TABLE_PREFIX, $new_amount, osc_logged_user_id());
                			}
                			else{
                				//adds user to paypal_wallet and gives them the promo_value 
            					$conn = getConnection();
                				$conn->osc_dbExec("INSERT INTO %st_paypal_wallet (fk_i_user_id, f_amount) VALUES (%d, '%f')", DB_TABLE_PREFIX, osc_logged_user_id(), $detail['promo_value']);
                			}
            			}
            			else {
            				$success = FALSE;
            				$meserror = __('Sorry this code is no longer valid', 'promo');
            			}
            		}
            		else {
            			$success = TRUE;
            			
            			//logs the promo code 
            			$conn = getConnection();
                		$conn->osc_dbExec("INSERT INTO %st_promo_code_redeemed (fk_i_user_id, promo_code_id) VALUES (%d, '%s')", DB_TABLE_PREFIX, osc_logged_user_id(), $detail['promo_code']);
                			
            			//if user exists in table then update else add user to table
                		if ($paypal_wallet){
                			$new_amount = $paypal_wallet['f_amount'] + $detail['promo_value'];
                			//udates wallet amount plus the promo_value
                			$conn = getConnection();
                			$conn->osc_dbExec("UPDATE %st_paypal_wallet SET f_amount = '%f' WHERE fk_i_user_id = '%d'", DB_TABLE_PREFIX, $new_amount, osc_logged_user_id());
                		}
                		else{
                			//adds user to paypal_wallet and gives them the promo_value 
            				$conn = getConnection();
                			$conn->osc_dbExec("INSERT INTO %st_paypal_wallet (fk_i_user_id, f_amount) VALUES (%d, '%f')", DB_TABLE_PREFIX, osc_logged_user_id(), $detail['promo_value']);
                		}
            		}
		
		}
		else{ 
			$success = FALSE;
			$meserror = __('Sorry you have already redeemed this code', 'promo');
		}
	    }
	    else {
	    	$success= FALSE;
	    	$meserror = __('Sorry this code is not valid', 'promo');
	    	
	    }
	}
	else {
            //error user is not login in
           $meserror = '<a href="' . osc_user_login_url() . '">' . __('Please login', 'promo') . '</a>';
        }

if ($success){
    $message = sprintf(__('You just got %.2f %s credited to your account', 'promo'),$detail['promo_value'],osc_get_preference('currency', 'promo'));

}
else {
    $message = __('Error: ','promo') . $meserror;
    
}
$json = array(
            'success' => $success,
            'message' => $message
            
        );

echo json_encode($json);
unset($detail);
}
?>
