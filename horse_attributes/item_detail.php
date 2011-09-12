<h2 style="margin-top: 10px;"><?php _e('Horse attributes', 'horse_attr') ; ?></h2>
<table style="margin-left: 20px;">
    <?php if( !empty($detail['s_breed']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Breed', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['s_breed']; ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['s_secondbreed']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Secondary Breed', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['s_secondbreed']; ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['horse_registered_name']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Horse\'s Registered Name', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo $detail['horse_registered_name']; ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['horse_nick_name']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Horse\'s Nickname', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['horse_nick_name']; ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['gated']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Gated', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['gated'] ? '<strong>' . __('Yes', 'horse_attr') . '</strong>' : __('No', 'horse_attr'); ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['warm_blood']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Warm Blooded', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['warm_blood'] ? '<strong>' . __('Yes', 'horse_attr') . '</strong>' : __('No', 'horse_attr'); ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['registered']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Registered', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['registered'] ? '<strong>' . __('Yes', 'horse_attr') . '</strong>' : __('No', 'horse_attr'); ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['registration_associations']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Registration_associations', 'horse_attr'); ?></label></td>
        <td width="150px"><label><?php echo @$detail['registration_associations']; ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['registration_num']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Registration Number', 'horse_attr'); ?></label></td>
        <td width="150px"><label><?php echo $detail['registration_num']; ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['month_foaled']) ) { ?>
    <tr>
    	<?php $month = array('1'         => __('January', 'horse_attr')
                           ,'2'         => __('Febuary', 'horse_attr')
                           ,'3' 	=> __('March', 'horse_attr')
                           ,'4'         => __('April', 'horse_attr')
                           ,'5'         => __('May', 'horse_attr')
                           ,'6' 	=> __('June', 'horse_attr')
                           ,'7'         => __('July', 'horse_attr')
                           ,'8'         => __('August', 'horse_attr')
                           ,'9' 	=> __('September', 'horse_attr')
                           ,'10'        => __('October', 'horse_attr')
                           ,'11' 	=> __('November', 'horse_attr')
                           ,'12'        => __('December', 'horse_attr'));
        ?> 
        <td width="150px"><label><?php _e('Month Foaled', 'horse_attr'); ?></label></td>
        <td width="150px"><label><?php echo $month[$detail['month_foaled']]; ?></td>
    </tr>
    <?php } ?>
    <?php if( !empty($detail['year_foaled']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Year Foaled', 'horse_attr'); ?></label></td>
        <td width="150px"><label><?php echo $detail['year_foaled']; ?></td>
    </tr>
    <?php } ?>
    <tr>
    	<?php $gender = array('1'         => __('Mare', 'horse_attr')
                           ,'2'           => __('Gelding', 'horse_attr')
                           ,'3' 	  => __('Filly', 'horse_attr')
                           ,'4'           => __('Colt', 'horse_attr')
                           ,'5'           => __('Stallion', 'horse_attr')
                           ,'6' 	  => __('Unboarn Foal', 'horse_attr'));
        ?> 
        <td width="150px"><label><?php _e('Gender', 'horse_attr'); ?>: </label></td>
        <td width="150px"><?php echo $gender[$detail['gender']]; ?></td>
    </tr>
        <td><label><?php _e('Mare in Foal', 'horse_attr'); ?>: </label></td>
        <td width="150px"><?php echo @$detail['mare_in_foal'] ? '<strong>' . __('Yes', 'horse_attr') . '</strong>' : __('No', 'horse_attr'); ?></td>
    </tr> 
    <tr>
        <td width="150px"><label><?php _e('Covering Sire', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['covering_sire'] ? '<strong>' . __('Yes', 'horse_attr') . '</strong>' : __('No', 'horse_attr'); ?></td>
    </tr>
    <?php if( !empty($detail['i_gears']) ) { ?>
    <tr>
        <td width="150px"><label><?php _e('Gears', 'horse_attr'); ?></label></td>
        <td width="150px"><?php echo @$detail['i_gears']; ?></td>
    </tr>
    <?php } ?>
</table>
