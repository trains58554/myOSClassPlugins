<?php

    $item            = '';
    $dao_preference = new Preference();
    if(Params::getParam('item') != '') {
        $item = Params::getParam('item');
    } else {
        $item = (osc_carousel_items() != '') ? osc_carousel_items() : '' ;
    }
    
    $autosp            = '';
    $dao_preference = new Preference();
    if(Params::getParam('autosp') != '') {
        $autosp = Params::getParam('autosp');
    } else {
        $autosp = (osc_carousel_autosp() != '') ? osc_carousel_autosp() : '' ;
    }
    
    $scrolldelay            = '';
    $dao_preference = new Preference();
    if(Params::getParam('scrolldelay') != '') {
        $scrolldelay = Params::getParam('scrolldelay');
    } else {
        $scrolldelay = (osc_carousel_scrolldelay() != '') ? osc_carousel_scrolldelay() : '' ;
    }
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $item), array("s_section" => "plugin-carousel_for_osclass", "s_name" => "carousel_items")) ;
        $dao_preference->update(array("s_value" => $autosp), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_autoscroll")) ;
        $dao_preference->update(array("s_value" => $scrolldelay), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_scrolldelay")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'carousel') . '.</p></div>';
    }
    unset($dao_preference) ;
    
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="carousel_for_osclass/admin.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Carousel for Osclass Preferences', 'carousel'); ?></h2> <label for="item" style="font-weight: bold;"><?php _e('Number of items to display at one time', 'carousel'); ?></label>:<br />
        <select name="item" id="item"> 
        	<option <?php if($item == 3){echo 'selected="selected"';}?>value='3'>3</option>
        	<option <?php if($item == 4){echo 'selected="selected"';}?>value='4'>4</option>
        	<option <?php if($item == 5){echo 'selected="selected"';}?>value='5'>5</option>
        </select>
        <label for="autosp" style="font-weight: bold;"><br /><?php _e('Enable auto scrolling', 'carousel'); ?></label>:<br /> 
        
	<select name="autosp" id="autosp"> 
        	<option <?php if($autosp == 0){echo 'selected="selected"';}?>value='0'><?php _e('No', 'carousel'); ?></option>
        	<option <?php if($autosp == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes', 'carousel'); ?></option>
        </select>
        <?php if($autosp ==1){?>
        <br />
        <label for="scrolldelay" style="font-weight: bold;"><?php _e('Number of seconds to delay scrolling (Default is 2800) ', 'carousel'); ?></label>:<br />
        <input type="text" name="scrolldelay" id="scrolldelay" value="<?php echo $scrolldelay; ?>" />
        <?php } ?>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'carousel'); ?>" />
     </fieldset>
    </div>
</form>
