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
                            	$conn   = getConnection();
				$promo_code = $conn->osc_dbFetchResult("SELECT * FROM %st_promo_code WHERE id = '%d'", DB_TABLE_PREFIX, $logs['promo_code_id']);
				
				$user = User::newInstance()->findByPrimaryKey($logs['fk_i_user_id']);
                            ?>
                            
                            <tr class="<?php echo $odd_even;?>">
                            	<td><?php echo $logs['id']; ?></td>
                            	<td><?php echo $logs['fk_i_user_id']; ?></td>
                            	<td><?php echo $user['s_name'];?></td>
                            	<td><?php echo $promo_code['promo_code']; ?></td>
                            	<td><?php echo $logs['date_redemed']; ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    
</div>
