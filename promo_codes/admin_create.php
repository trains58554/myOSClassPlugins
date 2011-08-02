<?php
    $promo            = '';
    if(Params::getParam('promo_code') != '') {
        $promo = Params::getParam('promo_code');
    }

    $enabled            = '';
    if(Params::getParam('enable_promo') != '') {
        $enabled = Params::getParam('enable_promo');
    }
    
    $max_uses            = '';
    if(Params::getParam('max_uses') != '') {
        $max_uses = Params::getParam('max_uses');
    }
    
    $promo_value            = '';
    if(Params::getParam('promo_value') != '') {
        $promo_value = Params::getParam('promo_value');
    }
    $createDate= date("m-d-y"); 
    
    if( Params::getParam('option') == 'stepone' ) {
        
        $conn = getConnection();
        $conn->osc_dbExec("INSERT INTO %st_promo_code (enabled, promo_code, create_dates, max_uses, uses_remaining, promo_value) VALUES (%d, '%s', '%s', '%d', '%d', '%f')", DB_TABLE_PREFIX, $enabled, $promo, $createDate, $max_uses, $max_uses, $promo_value);
        
     	osc_add_flash_message(__('Promotion Code Created', 'promo'), 'admin');
     	// HACK TO DO A REDIRECT
    	echo "<script>location.href='".osc_admin_render_plugin_url("promo_codes/admin_list.php")."'</script>";   
    }
?>
<script language="JavaScript">

function GeneratePassword() {

    if (parseInt(navigator.appVersion) <= 3) {
        alert("Sorry this only works in 4.0+ browsers");
        return true;
    }

    var sPassword = "";
    var length = 6;
    var noPunction = "FALSE";

    for (i=0; i < length; i++) {

        numI = getRandomNum();
	if (noPunction) { while (checkPunc(numI)) { numI = getRandomNum(); } }
        sPassword = sPassword + String.fromCharCode(numI);
    }

    document.create_promo.promo_code.value = sPassword

    return true;
}

function getRandomNum() {

    // between 0 - 1
    var rndNum = Math.random()

    // rndNum from 0 - 1000
    rndNum = parseInt(rndNum * 1000);

    // rndNum from 33 - 127
    rndNum = (rndNum % 94) + 33;

    return rndNum;
}

function checkPunc(num) {

    if ((num >=33) && (num <=47)) { return true; }
    if ((num >=58) && (num <=64)) { return true; }
    if ((num >=91) && (num <=96)) { return true; }
    if ((num >=123) && (num <=126)) { return true; }

    return false;
}
</script>
<?php 
 $tableexist = table();
    if(!$tableexist){
	echo'<h2>' .__('Your users will not be able to use your promotion codes untill you install the paypal plugin.','promo') . '</h2>';
}
?>
<form name="create_promo" action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="promo_codes/admin_create.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Create Promotion Code', 'promo'); ?></h2> 
        <label for="promo_code" style="font-weight: bold;"><?php _e('Enter Promotion Code', 'promo'); ?></label>: <a onclick="javascript:GeneratePassword()" href="#"><?php _e('Generate random promotion code', 'promo'); ?></a><br />
        <input type="text" name="promo_code" id="promo_code" value="" />
        
        <label for="enable_promo" style="font-weight: bold;"><br /><?php _e('Enable Promotion Code', 'promo'); ?></label>:<br /> 
	<select name="enable_promo" id="enable_promo"> 
        	<option value='1'><?php _e('Yes', 'promo'); ?></option>
        	<option value='0'><?php _e('No', 'promo'); ?></option>
        </select>
        <br />
        
        <label for="max_uses" style="font-weight: bold;"><?php _e('Maximum number of uses (set to 0 for unlimited uses) ', 'promo'); ?></label>:<br />
        <input type="text" name="max_uses" id="max_uses" value="0" />
        
		<br />
		
        <label for="promo_value" style="font-weight: bold;"><?php _e('Promotion Code Value', 'promo'); ?></label>:<br />
        <input type="text" name="promo_value" id="promo_value" value="0" />
        
        <br />
        <br />
        <input type="submit" value="<?php _e('Create Promotion Code', 'promo'); ?>" />
     </fieldset>
    </div>
</form>
