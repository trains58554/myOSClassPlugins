<?php
if (isset($_POST['promo_codes'])) {
$promocode = $_POST['promo_codes'];

        if ( osc_is_web_user_logged_in() ) {
            //check if promo code is in database and enabled
            $conn   = getConnection();
            $detail = $conn->osc_dbFetchResult("SELECT * FROM %st_promo_code WHERE promo_code LIKE '%s' AND enabled = '%d'", DB_TABLE_PREFIX, $promocode, 1);
            
            
            //If somthing is returned then we can process
	    if($detail){
	    	//check if the code has been used by this user
	    	$conn   = getConnection();
            	$promo_redeemed = $conn->osc_dbFetchResult("SELECT * FROM %st_promo_code_redeemed WHERE fk_i_user_id = '%d' AND promo_code_id = '%d'", DB_TABLE_PREFIX, osc_logged_user_id(), $detail['id']);
            	//checks if the code has been used
            	if(!$promo_redeemed){
            		//checks if max uses is not set to 0
            		if($detail['max_uses'] >0){
            			//checks if the code has uses left
            			if($detail['uses_remaining'] != 0){
            				$success = TRUE;
            				
            				$conn = getConnection();
                			$conn->osc_dbExec("INSERT INTO %st_promo_code_redeemed (fk_i_user_id, promo_code_id) VALUES (%d, '%d')", DB_TABLE_PREFIX, osc_logged_user_id(), $detail['id']);
                			
                			$conn = getConnection();
                			$conn->osc_dbExec("UPDATE %st_promo_code SET uses_remaining = '%d' WHERE id = '%d'", DB_TABLE_PREFIX, $detail['uses_remaining'] -1, $detail['id']);
            			}
            			else {
            				$success = FALSE;
            				$meserror = 'Sorry this code is no longer valid';
            			}
            		}
            		else {
            			$success = TRUE;
            		}
		
		}
		else{ 
			$sucess = FALSE;
			$meserror = 'Sorry you have already redeemed this code';
		}
	    }
	    else {
	    	$sucess= FALSE;
	    	$meserror = 'Sorry this code is not valid';
	    	
	    }
	}

if ($success){
    $message = 'Yay! Everything went well!';

}
else {
    $message = 'Error: ' . $meserror;
    
}
$json = array(
            'success' => $success,
            'message' => $message
            
        );

echo json_encode($json);
unset($detail);
}
?>
