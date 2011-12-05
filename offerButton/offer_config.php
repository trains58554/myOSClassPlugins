<?php

    $enabled            = '';
    $dao_preference = new Preference();
    if(Params::getParam('enabled') != '') {
        $enabled = Params::getParam('enabled');
    } else {
        $enabled = (osc_offerButton_enabled() != '') ? osc_offerButton_enabled() : '' ;
    }
    $lastThree            = '';
    $dao_preference = new Preference();
    if(Params::getParam('lastThree') != '') {
        $lastThree = Params::getParam('lastThree');
    } else {
        $lastThree = (osc_offerButton_lastThree() != '') ? osc_offerButton_lastThree() : '' ;
    }
    $locking            = '';
    $dao_preference = new Preference();
    if(Params::getParam('locking') != '') {
        $locking = Params::getParam('locking');
    } else {
        $locking = (osc_offerButton_locking() != '') ? osc_offerButton_locking() : '' ;
    }
    $email            = '';
    $dao_preference = new Preference();
    if(Params::getParam('email') != '') {
        $email = Params::getParam('email');
    } else {
        $email = (osc_offerButton_email() != '') ? osc_offerButton_email() : '' ;
    }
    $delOff            = '';
    $dao_preference = new Preference();
    if(Params::getParam('delOff') != '') {
        $delOff = Params::getParam('delOff');
    } else {
        $delOff = (osc_offerButton_delOff() != '') ? osc_offerButton_delOff() : '' ;
    }
    $usersOnly            = '';
    $dao_preference = new Preference();
    if(Params::getParam('usersOnly') != '') {
        $usersOnly = Params::getParam('usersOnly');
    } else {
        $usersOnly = (osc_offerButton_usersOnly() != '') ? osc_offerButton_usersOnly() : '' ;
    }
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $enabled), array("s_section" => "plugin-offer", "s_name" => "offerButton_enabled")) ;
        $dao_preference->update(array("s_value" => $lastThree), array("s_section" => "plugin-offer", "s_name" => "offerButton_lastThree")) ;
        $dao_preference->update(array("s_value" => $locking), array("s_section" => "plugin-offer", "s_name" => "offerButton_locking")) ;
        $dao_preference->update(array("s_value" => $delOff), array("s_section" => "plugin-offer", "s_name" => "offerButton_delOff")) ;
        $dao_preference->update(array("s_value" => $email), array("s_section" => "plugin-offer", "s_name" => "offerButton_email")) ;
        $dao_preference->update(array("s_value" => $usersOnly), array("s_section" => "plugin-offer", "s_name" => "offerButton_usersOnly")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'offer_button') . '.</p></div>';
    }
    unset($dao_preference) ;
    
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="offerButton/offer_config.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Offer Button Preferences', 'offer_button'); ?></h2> 
        <a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=configure&plugin=offerButton/index.php'; ?>" ><?php _e('Configure which category this plugin displays in.'); ?></a><br /><br />
        <?php if(osc_offerButton_version() != '' && osc_offerButton_version() == obVersion()) { ?>
        <label for="enabled" style="font-weight: bold;"><?php _e('Enable offer button?', 'offer_button'); ?></label>:<br />
        <select name="enabled" id="enabled"> 
        	<option <?php if($enabled == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($enabled == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="lastThree" style="font-weight: bold;"><?php _e('Display the top three offers', 'offer_button'); ?></label>:<br />
        <select name="lastThree" id="lastThree"> 
        	<option <?php if($lastThree == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($lastThree == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="locking" style="font-weight: bold;"><?php _e('Allow sellers to lock users from making offers on there items?', 'offer_button'); ?></label>:<br />
        <select name="locking" id="locking"> 
        	<option <?php if($locking == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($locking == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="email" style="font-weight: bold;"><?php _e('Enable Email', 'offer_button'); ?></label>:<br />
        <select name="email" id="email"> 
        	<option <?php if($email == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($email == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="delOff" style="font-weight: bold;"><?php _e('Allow seller to delete offers', 'offer_button'); ?></label>:<br />
        <select name="delOff" id="delOff"> 
        	<option <?php if($delOff == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($delOff == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="usersOnly" style="font-weight: bold;"><?php _e('Only logged in users can submit offers', 'offer_button'); ?></label>:<br />
        <select name="usersOnly" id="usersOnly"> 
        	<option <?php if($usersOnly == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($usersOnly == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'carousel'); ?>" />
        <?php }else{
        		echo '<a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/update.php') . '">&raquo; ' . __('Click here to finish update', 'offer_button') . '</a>';
        } ?>
        <?php echo '<br /><br />Version ' .  osc_offerButton_version(); ?>
     </fieldset>
    </div>
</form>
