<?php

    $enabled            = '';
    $dao_preference = new Preference();
    if(Params::getParam('enabled') != '') {
        $enabled = Params::getParam('enabled');
    } else {
        $enabled = (osc_offer_button_enabled() != '') ? osc_offer_button_enabled() : '' ;
    }
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $enabled), array("s_section" => "plugin-offer", "s_name" => "offer_button_enabled")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'offer_button') . '.</p></div>';
    }
    unset($dao_preference) ;
    
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="offer_button/offer_config.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Offer Button Preferences', 'offer_button'); ?></h2> <label for="enabled" style="font-weight: bold;"><?php _e('Enable offer button?', 'offer_button'); ?></label>:<br />
        <select name="enabled" id="enabled"> 
        	<option <?php if($enabled == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($enabled == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'carousel'); ?>" />
     </fieldset>
    </div>
</form>
