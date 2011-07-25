<?php
if (isset($_POST['promo_codes'])) {
$promocode = $_POST['promo_codes'];
/*if (Params::getParam('id') != '') {
        $id    = Params::getParam('id');
        $count = 0; */

        //if ( osc_is_web_user_logged_in() ) {
            //check if promo code is in database
            $conn   = getConnection();
            $detail = $conn->osc_dbFetchResult("SELECT * FROM %st_promo_code WHERE promo_code = %d", DB_TABLE_PREFIX, $promocode);
            if($detail){
            //$idws = $detail['promo_code'];
            //If nothing returned then we can process
            //if ($detail['promo_code'] == $promocode) {

		$success = TRUE;
		
	    }
	    else {
	    	$sucess= FALSE;
	    	
	    }
	//}

if ($success){
    $message = 'Yay! Everything went well! ' . $detail['id'] . ' ' . $detail['number_days'];
    //unset($detail);
}
else {
    $message = 'Doh! Something happened' . $detail['promo_code'];
    //unset($detail);
}
$json = array(
            'success' => $success,
            'message' => $message,
            'test'    => $detail
            
        );

echo json_encode($json);

}
?>
