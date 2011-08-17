<?php
$promo_id	  = '';
if(Params::getParam('promo-id') != ''){
	$promo_id = Params::getParam('promo-id');
}

$conn   = getConnection();
$detail = $conn->osc_dbFetchResult("SELECT * FROM %st_promo_code WHERE id='%d'", DB_TABLE_PREFIX, $promo_id);

$promo_action = Params::getParam('promo-action');

switch($promo_action) {
	case 'edit':
		
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
    	//$createDate= date("m-d-y"); 
    
    	if( Params::getParam('option') == 'stepone' ) {
        
        $conn = getConnection();
        $conn->osc_dbExec("UPDATE %st_promo_code SET enabled = '%d', max_uses = '%d', uses_remaining = '%d', promo_value = '%f' WHERE id = '%d'", DB_TABLE_PREFIX, $enabled, $max_uses, $max_uses, $promo_value, $promo_id);
        
     	osc_add_flash_message(__('Promotion Code Changes Saved', 'promo'), 'admin');
     	// HACK TO DO A REDIRECT
    	echo "<script>location.href='".osc_admin_render_plugin_url("promo_codes/admin_list.php")."'</script>";
    	exit;   
    	} ?>
    	
    	<form name="edit_promo" action="<?php osc_admin_base_url(true); ?>" method="post">
    	<input type="hidden" name="page" value="plugins" />
    	<input type="hidden" name="action" value="renderplugin" />
    	<input type="hidden" name="file" value="promo_codes/edit.php?promo-action=edit" />
    	<input type="hidden" name="option" value="stepone" />
    	<div>
    	<fieldset>
        	<h2><?php echo __('Edit Promotion Code ', 'promo') . $detail['promo_code']; ?></h2>   
        	<label for="enable_promo" style="font-weight: bold;"><br /><?php _e('Enable Promotion Code', 'promo'); ?></label>:<br /> 
		<select name="enable_promo" id="enable_promo"> 
        		<option <?php if($detail['enabled'] == 1){echo 'selected="selected"';}?> value='1'><?php _e('Yes', 'promo'); ?></option>
        		<option <?php if($detail['enabled'] == 0){echo 'selected="selected"';}?>  value='0'><?php _e('No', 'promo'); ?></option>
        	</select>
        	<br />
        
        	<label for="max_uses" style="font-weight: bold;"><?php _e('Maximum number of uses (set to 0 for unlimited uses) ', 'promo'); ?></label>:<br />
        	<input type="text" name="max_uses" id="max_uses" value="<?php echo $detail['max_uses']; ?>" />
        
			<br />
		
        	<label for="promo_value" style="font-weight: bold;"><?php _e('Promotion Code Value', 'promo'); ?></label>:<br />
        	<input type="text" name="promo_value" id="promo_value" value="<?php echo $detail['promo_value']; ?>" />
        
        	<br />
        	<br />
        	<input type="submit" value="<?php _e('Edit Promotion Code', 'promo'); ?>" />
     	</fieldset>
    	</div>
	</form>
	<?php break;
		
	case 'delete':
	$conn   = getConnection();
	$conn->osc_dbExec("DELETE FROM %st_promo_code WHERE id='%d'", DB_TABLE_PREFIX, $promo_id);
	
	osc_add_flash_message(__('Promotion Code Deleted', 'promo'), 'admin');
     	
     	// HACK TO DO A REDIRECT
    	echo "<script>location.href='".osc_admin_render_plugin_url("promo_codes/admin_list.php")."'</script>";
    	exit; 
	break;
}
