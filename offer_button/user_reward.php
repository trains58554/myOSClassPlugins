<?php

    $reward_enabled            = '';
    $dao_preference = new Preference();
    if(Params::getParam('reward_enabled') != '') {
        $reward_enabled = Params::getParam('reward_enabled');
    } else {
        $reward_enabled = (osc_promo_reward_enabled() != '') ? osc_promo_reward_enabled() : '' ;
    }
    
    $reward_amount            = '';
    $dao_preference = new Preference();
    if(Params::getParam('reward_amount') != '') {
        $reward_amount = Params::getParam('reward_amount');
    } else {
        $reward_amount = (osc_promo_reward_amount() != '') ? osc_promo_reward_amount() : '' ;
    }

    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $reward_enabled), array("s_section" => "plugin-promo", "s_name" => "promo_reward_enabled")) ;
        $dao_preference->update(array("s_value" => $reward_amount), array("s_section" =>"plugin-promo", "s_name" => "promo_reward_amount")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'promo') . '.</p></div>';
    }
    unset($dao_preference) ; 
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="promo_codes/user_reward.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Signup Bonus Configuration', 'promo'); ?></h2> 
        <label for="reward_enabled" style="font-weight: bold;"><?php _e('Enable Signup Bonus', 'promo'); ?></label>:<br />
        <select name="reward_enabled" id="reward_enabled"> 
        	<option <?php if($reward_enabled == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($reward_enabled == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <label for="reward_amount" style="font-weight: bold;"><br /><?php _e('Signup Bouns Amount', 'promo'); ?></label>:<br /> 
      	<input type="text" name="reward_amount" id="reward_amount" value="<?php echo $reward_amount; ?>" />
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'promo'); ?>" />
     </fieldset>
    </div>
</form>

