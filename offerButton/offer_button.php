<?php if(osc_is_web_user_logged_in() ) { 
    
    $i_userId = osc_logged_user_id();
    $itemsPerPage = (Params::getParam('itemsPerPage') != '') ? Params::getParam('itemsPerPage') : 5;
    $iPage        = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 0;

    Search::newInstance()->addConditions(sprintf("%st_offer_button.user_id = %d", DB_TABLE_PREFIX, $i_userId));
    Search::newInstance()->addConditions(sprintf("%st_offer_button.item_id = %st_item.pk_i_id", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
    Search::newInstance()->addTable(sprintf("%st_offer_button", DB_TABLE_PREFIX));
    Search::newInstance()->page($iPage, $itemsPerPage);

    $aItems      = Search::newInstance()->doSearch();
    $iTotalItems = Search::newInstance()->count();
    $iNumPages   = ceil($iTotalItems / $itemsPerPage) ;

    View::newInstance()->_exportVariableToView('items', $aItems);
    View::newInstance()->_exportVariableToView('search_total_pages', $iNumPages);
    View::newInstance()->_exportVariableToView('search_page', $iPage) ;
?>

<div class="content user_account">
    <h1>
        <strong><?php _e('View Your Submitted Offers', 'offer_button'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
                    <h2><?php _e('Your Offers', 'offer_button'); ?></h2>
                    <?php //osc_reset_items(); ?>
                    <?php if(osc_count_items() == 0) { ?>
                        <h3><?php _e('You have not placed any offers yet', 'offer_button'); ?></h3>
                    <?php } else { ?>
                        <?php while(osc_has_items()) { ?>
                                <div class="item" >
                                        <h3>
                                            <a name="item<?php echo osc_item_id();?>"></a>
                                            <?php echo osc_item_title(); ?>
                                        </h3>
                                        <p>
                                        <?php if( osc_price_enabled_at_items() ) { _e('Price', 'modern') ; ?>: <?php echo osc_format_price(osc_item_price()); } ?>
                                        <br />
                                        <br />
                                        <?php 
                                        $conn   = getConnection();
                                        $offers = $conn->osc_dbFetchResults("SELECT * FROM %st_offer_button WHERE item_id  = '%d' AND user_id='%d' ORDER BY id DESC", DB_TABLE_PREFIX, osc_item_id(),osc_logged_user_id()); ?>
                                        
                                        <div class="dataTables_wrapper">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_list">
                                        	<thead>
                                        	<tr>
                                        		<th><?php _e('Offer','offer_button'); ?></th>
                                        		<th><?php _e('status','offer_button'); ?></th>
                                        		<th><?php _e('Offer Date','offer_button'); ?></th>
                                        	</tr>
                                        	</thead>
                                        	<tbody>
                                        	<?php 
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
                                        	<tr class="<?php echo $odd_even;?>">
                                        	<?php $user = User::newInstance()->findByPrimaryKey($userOffer['user_id']); ?>
                                        		<td><?php echo sprintf(__('$%.2f','offer_button'), $userOffer['offer_value']); ?></td>
                                        		<td><?php echo offer_status($userOffer['offer_status']); ?></td>
                                        		<td><?php echo $userOffer['offer_date']; ?></td>
                                        	</tr>
                                        	<?php } ?>
                                        	</tbody>
                                        </table>
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
