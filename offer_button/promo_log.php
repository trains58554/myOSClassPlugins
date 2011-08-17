<?php 
$conn   = getConnection();
$promo_log = $conn->osc_dbFetchResults("SELECT * FROM %st_promo_code_redeemed", DB_TABLE_PREFIX);
?>
<div class="dataTables_wrapper">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_list">
                        <thead>
                            <tr>
                                <th class="sorting"><?php _e('ID', 'promo'); ?></th>
                                <th ><?php _e('User ID', 'promo'); ?></th>
                                <th ><?php _e('User Name', 'promo'); ?></th>
                                <th ><?php _e('Promo Code', 'promo'); ?></th>
                                <th ><?php _e('Date Redeemed', 'promo'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $odd = 1;
                                foreach($promo_log as $logs) {
                                    if($odd==1) {
                                        $odd_even = "odd";
                                        $odd = 0;
                                    } else {
                                        $odd_even = "even";
                                        $odd = 1;
                                    }
				
				$user = User::newInstance()->findByPrimaryKey($logs['fk_i_user_id']);
                            ?>
                            
                            <tr class="<?php echo $odd_even;?>">
                            	<td><?php echo $logs['id']; ?></td>
                            	<td><?php echo $logs['fk_i_user_id']; ?></td>
                            	<td><?php echo $user['s_name'];?></td>
                            	<td><?php echo $logs['promo_code_id']; ?></td>
                            	<td><?php echo $logs['date_redemed']; ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    
</div>
