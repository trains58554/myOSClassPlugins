<?php 
$conn   = getConnection();
$detail = $conn->osc_dbFetchResults("SELECT * FROM %st_promo_code", DB_TABLE_PREFIX);
?>
<div class="dataTables_wrapper">
<?php print_r($detail); ?>
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
                            	<td><?php echo $details['promo_code']; ?></td>
                            	<td><?php echo $details['enabled']; ?></td>
                            	<td><?php echo $details['create_dates']; ?></td>
                            	<td><?php echo $details['max_uses']; ?></td>
                            	<td><?php echo $details['uses_remaining']; ?></td>
                            	<td><?php echo $details['promo_value']; ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    
</div>
