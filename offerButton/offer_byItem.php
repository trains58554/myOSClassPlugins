<?php if(osc_is_web_user_logged_in() ) { 
    
    $i_userId = osc_logged_user_id();
    $itemsPerPage = (Params::getParam('itemsPerPage') != '') ? Params::getParam('itemsPerPage') : 5;
    $iPage        = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 0;
	 $search = new Search();
    $search->addConditions(sprintf("%st_offer_button.seller_id = %d", DB_TABLE_PREFIX, $i_userId));
    $search->addConditions(sprintf("%st_offer_button.item_id = %st_item.pk_i_id", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
    $search->addTable(sprintf("%st_offer_button", DB_TABLE_PREFIX));
    $search->page($iPage, $itemsPerPage);

    $aItems      = $search->doSearch();
    $iTotalItems = $search->count();
    $iNumPages   = ceil($iTotalItems / $itemsPerPage) ;

    View::newInstance()->_exportVariableToView('items', $aItems);
    View::newInstance()->_exportVariableToView('search_total_pages', $iNumPages);
    View::newInstance()->_exportVariableToView('search_page', $iPage) ;
    
    //Check to see if user flagging plugin installed
    $plugE = Plugins::listEnabled();
    $uFlag = array_search('user_flag/index.php',Plugins::listEnabled());
    if($uFlag !='') {
    	$flag_enabled = 1;
    } else{
    	$flag_enabled = 0;
    }
    
?>

<div class="content user_account">
    <h1>
        <strong><?php _e('View Offers on Your Items', 'offer_button'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
                    <h2><?php _e('Offers on Your Items', 'offer_button'); ?></h2>
                    <?php //osc_reset_items(); ?>
                    <?php if(osc_count_items() == 0) { ?>
                        <h3><?php _e('You don\'t have any offers yet', 'offer_button'); ?></h3>
                    <?php } else { ?>
                        <?php while(osc_has_items()) { ?>
                                <div class="item" >
                                        <h3>
                                            <a name="item<?php echo osc_item_id();?>"></a>
                                            <a class="external" href="<?php echo osc_item_url(); ?>" target="_blank"><?php echo osc_item_title(); ?></a>
                                            
                                        </h3>
                                        <p>
                                        <?php if( osc_price_enabled_at_items() ) { _e('Price', 'modern') ; ?>: <?php echo osc_format_price(osc_item_price()); } ?>
                                        <br />
                                        <br />
                                        <?php 
                                        $conn   = getConnection();
                                        $offers = $conn->osc_dbFetchResults("SELECT * FROM %st_offer_button WHERE item_id  = '%d' && sDelete != '%d' ORDER BY id DESC", DB_TABLE_PREFIX, osc_item_id(), 1);
                                        ?>
                                        
                                        <div class="dataTables_wrapper">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_list">
                                        	<thead>
                                        	<tr>
                                        		<?php //<th>ID</th> ?>
                                        		<th><?php _e('User Name:','offer_button'); ?></th>
                                        		<th><?php _e('Offer','offer_button'); ?></th>
                                        		<th><?php _e('status','offer_button'); ?></th>
                                        		<th><?php _e('Offer Date','offer_button'); ?></th>
                                        	</tr>
                                        	</thead>
                                        	<tbody>
                                        	<?php 
                                        	foreach($offers as $offer) {
                                        		if ($offer['offer_status'] ==1){
                                        			$offer_acept = 1;
                                        		}
                                        	}
                                        	
                                        	$odd = 1;
                                        	foreach($offers as $userOffer){ 
                                        		 if($odd==1) {
                                        			$odd_even = "odd";
                                        			$odd = 0;
                                    			 } else {
                                        			$odd_even = "even";
                                        			$odd = 1;
                                    			 }
                                        	?>
                                        	<?php echo 'test help'; ?>
                                        	<tr class="<?php echo $odd_even;?><?php if($userOffer['user_locked'] == 1){echo ' gray'; }?>">
                                        	<?php 
	                                       if($userOffer['user_id'] !=''){
                                        		$user = User::newInstance()->findByPrimaryKey($userOffer['user_id']);
                                        		$userName = $user['s_name'];
                                        		if(OSCLASS_VERSION >= '2.3'){
                                        			$user['s_name'] =  '<a title="'. __("View ","offer_button"). $user['s_name'] . __("'s profile", "offer_button") . '" href="'. osc_base_url(true) .'?page=user&action=pub_profile&id='. $userOffer['user_id'] .'" >'. $user['s_name'] . '</a>';
                                        			$userName = '';
                                        		} 
                                        	} else{
                                        		$user['s_name'] = $userOffer['b_name'] . ' *';
                                        		$user['s_email'] = $userOffer['b_email'];
                                        		$userName = $userOffer['b_email'];
                                        	}
                                        	?>
                                        		<?php //<td><?php echo $userOffer['id']; </td> ?>
                                        		<td><?php echo $user['s_name']; ?><div><?php if(($userOffer['offer_status'] == 2) || ($userOffer['offer_status'] == 3)){?><a href="<?php echo osc_base_url(true).'?page=custom&file=offerButton/offer_edit.php&offer-action=accept&offer-id='.$userOffer['id'] .'&user-id=' . $userOffer['user_id'] . '&item-id=' . $userOffer['item_id']; ?>" onclick="<?php if(($userOffer['user_locked'] == 1) || ($offer_acept == 1)){ echo 'return false'; } ?>"><?php }?><?php _e('Accept', 'offer_button'); ?><?php if(($userOffer['offer_status'] == 2) || ($userOffer['offer_status'] == 3)){?></a><?php }?> | <?php if(($userOffer['offer_status'] == 1) || ($userOffer['offer_status'] == 3)){?><a href="<?php echo osc_base_url(true).'?page=custom&file=offerButton/offer_edit.php&offer-action=pending&offer-id='.$userOffer['id'] .'&user-id=' . $userOffer['user_id'] . '&item-id=' . $userOffer['item_id']; ?>" onclick="<?php if($userOffer['user_locked'] == 1){ echo 'return false'; } ?>"><?php }?><?php _e('Pending', 'offer_button'); ?><?php if(($userOffer['offer_status'] == 1) || ($userOffer['offer_status'] == 3)){?></a><?php }?> | <?php if(($userOffer['offer_status'] == 1) || ($userOffer['offer_status'] == 2)){?><a href="<?php echo osc_base_url(true).'?page=custom&file=offerButton/offer_edit.php&offer-action=declined&offer-id='.$userOffer['id'] .'&user-id=' . $userOffer['user_id'] . '&item-id=' . $userOffer['item_id']; ?>" onclick="<?php if($userOffer['user_locked'] == 1){ echo 'return false'; } ?>"><?php }?><?php _e('Decline', 'offer_button'); ?><?php if(($userOffer['offer_status'] == 1) || ($userOffer['offer_status'] == 2)){?></a><?php }?> <?php if(osc_offerButton_email() ==1){ ?><a title="<?php echo __('Send Email to ','offer_button') . $user['s_email']; ?>" href="mailto:<?php echo $user['s_email']; ?>"><img src="<?php echo osc_base_url() . 'oc-content/plugins/offerButton/images/email_compose.png'; ?>"  width="25px" height="25px" alt="<?php _e('send email','offer_button'); ?>" /></a><?php } ?> <?php if(osc_offerButton_locking() == 1 ){ ?><a class="<?php if($userOffer['user_locked'] == 1){ echo 'gray';} ?>" title="<?php echo __('Lock User','offer_button'); ?>" href="<?php echo osc_base_url(true) . '?page=custom&file=offerButton/offer_edit.php&offer-action=lock&offer-id='.$userOffer['id'] .'&user-id=' . $userOffer['user_id'] . '&item-id=' . $userOffer['item_id'] . '&n-user=' . $userName; ?>"><img src="<?php echo osc_base_url() . 'oc-content/plugins/offerButton/images/Lock.png'; ?>"  width="25px" height="25px" alt="<?php _e('Lock User','offer_button'); ?>" /></a><a class="<?php if($userOffer['user_locked'] == 0){ echo 'gray';} ?>" title="<?php echo __('Unlock User','offer_button'); ?>" href="<?php echo osc_base_url(true) . '?page=custom&file=offerButton/offer_edit.php&offer-action=unlock&offer-id='.$userOffer['id'] .'&user-id=' . $userOffer['user_id'] . '&item-id=' . $userOffer['item_id'] . '&n-user=' . $userName; ?>"><img src="<?php echo osc_base_url() . 'oc-content/plugins/offerButton/images/Lock-Open.png'; ?>"  width="25px" height="25px" alt="<?php _e('Unlock User','offer_button'); ?>" /></a><?php } ?></div></td>
                                        		<td><?php echo sprintf(__('$%.2f','offer_button'), $userOffer['offer_value']); ?></td>
                                        		<td><?php echo offer_status($userOffer['offer_status']); ?></td>
                                        		<td><?php echo $userOffer['offer_date']; ?><div class="delFlag"><?php if(osc_offerButton_delOff() == 1){ if($userOffer['offer_status'] != 1) {?><a title="<?php _e('Delete Offer', 'offer_button'); ?>" onclick="javascript:return confirm('<?php _e('This action can not be undone. Are you sure you want to continue?', 'offer_button'); ?>')" href="<?php echo osc_base_url(true).'?page=custom&file=offerButton/offer_edit.php&offer-action=delete&offer-id='.$userOffer['id']; ?>"><img src="<?php echo osc_base_url() . 'oc-content/plugins/offerButton/images/icon-remove.png'; ?>" alt="<?php _e('delete offer','offer_button'); ?>" width="15px" height="15px" /></a><?php }} ?><?php if($flag_enabled == 1) { ?> <img src="<?php echo osc_base_url() . 'oc-content/plugins/offerButton/images/report_flag.gif'; ?>" alt="<?php _e('flag user','offer_button'); ?>" width="15px" height="15px" /><?php } ?></div></td>
                                        	</tr>
                                        	<?php }
                                        	$offer_acept = 0; ?>
                                        	</tbody>
                                        </table>
                                        <?php if (osc_offerButton_usersOnly() == 0){echo '* ' . __('Non registered user.','offer_button');} ?>
                                        </div>
                                        </p>
                                </div>
                        <?php } ?>
                        <br />
                        <div class="paginate">
            <?php echo osc_pagination(array('url' => osc_render_file_url(osc_plugin_folder(__FILE__) . 'offer_byItem.php') . '?iPage={PAGE}')); ?>
        </div>
                    <?php } ?>
                </div>
</div>
<?php } else { 
// HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php } ?>
