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
    $offerTrade            = '';
    $dao_preference = new Preference();
    if(Params::getParam('trade') != '') {
        $offerTrade = Params::getParam('trade');
    } else {
        $offerTrade = (osc_offerButton_trade() != '') ? osc_offerButton_trade() : '' ;
    }
    $offerText            = '';
    $dao_preference = new Preference();
    if(Params::getParam('oText') != '') {
        $offerText = Params::getParam('oText');
    } else {
        $offerText = (osc_offerButton_text() != '') ? osc_offerButton_text() : '' ;
    }
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $enabled), array("s_section" => "plugin-offer", "s_name" => "offerButton_enabled")) ;
        $dao_preference->update(array("s_value" => $lastThree), array("s_section" => "plugin-offer", "s_name" => "offerButton_lastThree")) ;
        $dao_preference->update(array("s_value" => $locking), array("s_section" => "plugin-offer", "s_name" => "offerButton_locking")) ;
        $dao_preference->update(array("s_value" => $delOff), array("s_section" => "plugin-offer", "s_name" => "offerButton_delOff")) ;
        $dao_preference->update(array("s_value" => $email), array("s_section" => "plugin-offer", "s_name" => "offerButton_email")) ;
        $dao_preference->update(array("s_value" => $usersOnly), array("s_section" => "plugin-offer", "s_name" => "offerButton_usersOnly")) ;
        $dao_preference->update(array("s_value" => $offerTrade), array("s_section" => "plugin-offer", "s_name" => "offerButton_trade")) ;
        $dao_preference->update(array("s_value" => $offerText), array("s_section" => "plugin-offer", "s_name" => "offerButton_text")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'offer_button') . '.</p></div>';
    }
    unset($dao_preference) ;
    $pluginInfo = osc_plugin_get_info('offerButton/index.php');
    //print_r(osc_plugin_get_info('offerButton/index.php'));    
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="offerButton/offer_config.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Offer Button Configuration', 'offer_button'); ?></h2> 
        <fieldset>
        <legend><?php _e('Configure Plugin Categories','offer_button'); ?></legend>
        <br />
        <a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=configure&plugin=offerButton/index.php'; ?>" ><?php _e('Configure which category this plugin displays in.'); ?></a><br /><br />
        </fieldset>
        <fieldset>
        <legend><?php echo _e('Offer Button Options','offer_button'); ?></legend>
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
        <label for="locking" style="font-weight: bold;"><?php _e('Allow sellers to lock users from making offers on their items?', 'offer_button'); ?></label>:<br />
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
        <label for="trade" style="font-weight: bold;"><?php _e('Allow users to accept trades', 'offer_button'); ?></label>:<br />
        <select name="trade" id="trade"> 
        	<option <?php if($offerTrade == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($offerTrade == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="oText" style="font-weight: bold;"><?php _e('Offer Buttton Text', 'offer_button'); ?></label>:<br />
        <select name="oText" id="oText"> 
        	<option <?php if($offerText == 1){echo 'selected="selected"';}?>value='1'><?php _e('Make An Offer','offer_button'); ?></option>
        	<option <?php if($offerText == 2){echo 'selected="selected"';}?>value='2'><?php _e('Place An Offer','offer_button'); ?></option>
        </select>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'carousel'); ?>" />        
        <?php }else{
        		echo '<a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/update.php') . '">&raquo; ' . __('Click here to finish update', 'offer_button') . '</a>';
        } ?>
        </fieldset>
        <?php echo '<br />' . __('Version ', 'offer_button') .  osc_offerButton_version() . ' <a class="update" href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/update.php?force=1') . '" onclick="javascript:return confirm(\'' . __('Are you sure you want to continue?', 'offer_button') . '\')">|</a> ' .  __('Author','offer_button') . ' <a class="external" target="_blank" href="' . $pluginInfo['author_uri'] . '">' . $pluginInfo['author'] . '</a>'; ?>        
     </fieldset>
    </div>
</form>
