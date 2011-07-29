<?php 
$conn   = getConnection();
$detail = $conn->osc_dbFetchResults("SELECT * FROM %st_promo_code", DB_TABLE_PREFIX);
 $tableexist = table();
    if(!$tableexist){
	echo'<h2>'. __('Please install the paypal plugin for this plugin to work.','promo') . '</h2>';
}

echo '<a href="' . osc_admin_render_plugin_url('promo_codes/admin_create.php') . '" >' . __('Create New Promo Code', 'promo') . '</a>';

?>
<div class="dataTables_wrapper">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_list">
                        <thead>
                            <tr>
                                <th class="sorting"><?php _e('ID', 'promo'); ?></th>
                                <th ><?php _e('Promo Code', 'promo'); ?></th>
                                <th ><?php _e('Enabled', 'promo'); ?></th>
                                <th ><?php _e('Created Date', 'promo'); ?></th>
                                <th ><?php _e('Max Uses', 'promo'); ?></th>
                                <th ><?php _e('Uses Left', 'promo'); ?></th>
                                <th ><?php _e('Promo Value', 'promo'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $odd = 1;
                                foreach($detail as $details) {
                                    if($odd==1) {
                                        $odd_even = "odd";
                                        $odd = 0;
                                    } else {
                                        $odd_even = "even";
                                        $odd = 1;
                                    }
                            ?>
                            <tr class="<?php echo $odd_even;?>">
                            	<td><?php echo $details['id']; ?></td>
                            	<td><?php echo $details['promo_code']; ?><div><a href="<?php echo osc_admin_render_plugin_url("promo_codes/edit.php").'?promo-action=edit&promo-id='.$details['id']; ?>"><?php _e('Edit', 'promo'); ?></a> | <a onclick="javascript:return confirm('<?php _e('This action can not be undone. Are you sure you want to continue?', 'promo'); ?>')" href="<?php echo osc_admin_render_plugin_url("promo_codes/edit.php").'?promo-action=delete&promo-id='.$details['id']; ?>"><?php _e('Delete' ,'promo'); ?></a></div></td>
                            	<td><?php if($details['enabled'] = 1){echo __('Enabled','promo');} else{ echo __('Disabled','promo');} ?></td>
                            	<td><?php echo $details['create_dates']; ?></td>
                            	<td><?php if($details['max_uses'] == 0){echo __('Unlimited','promo');} else{echo $details['max_uses'];} ?></td>
                            	<td><?php if($details['uses_remaining'] == 0){echo __('Unlimited','promo');} else{echo $details['uses_remaining'];} ?></td>
                            	<td><?php echo $details['promo_value']; ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    
</div>
