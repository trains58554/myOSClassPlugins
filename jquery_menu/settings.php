<?php

    $p_disabled            = '';
    $dao_preference = new Preference();
    if(Params::getParam('p_disable') != '') {
        $p_disabled = Params::getParam('p_disable');
    } else {
        $p_disabled = (menu_disable() != '') ? menu_disable() : '' ;
    }
    $showArrow           = '';
    $dao_preference = new Preference();
    if(Params::getParam('s_arrow') != '') {
        $showArrow = Params::getParam('s_arrow');
    } else {
        $showArrow = (sArrow() != '') ? sArrow() : '' ;
    }
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $p_disabled), array("s_section" => "plugin-jMenu", "s_name" => "parent-selectable")) ;
        $dao_preference->update(array("s_value" => $showArrow), array("s_section" => "plugin-jMenu", "s_name" => "show-arrow")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'JQuery_Menu') . '.</p></div>';
    }
    unset($dao_preference) ;
    
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="jquery_menu/settings.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('JQuery Menu Preferences', 'JQuery_Menu'); ?></h2> <label for="p_disabled" style="font-weight: bold;"><?php _e('Disable parent category links?', 'JQuery_Menu'); ?></label>:<br />
        <select name="p_disable" id="p_disabled"> 
        	<option <?php if($p_disabled == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($p_disabled == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="s_arrow" style="font-weight: bold;"><?php _e('Display the arrow next to parent categories', 'JQuery_Menu'); ?></label>:<br />
        <select name="s_arrow" id="s_arrow"> 
        	<option <?php if($showArrow == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($showArrow == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'JQuery_Menu'); ?>" />
     </fieldset>
    </div>
</form>
