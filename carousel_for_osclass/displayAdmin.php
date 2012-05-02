<?php 

	 $item            = '';
    $dao_preference = new Preference();
    if(Params::getParam('item') != '') {
        $item = Params::getParam('item');
    } else {
        $item = (osc_carousel_items() != '') ? osc_carousel_items() : '' ;
    }
	 
    $vertical            = '';
    $dao_preference = new Preference();
    if(Params::getParam('vertical') != '') {
        $vertical = Params::getParam('vertical');
    } else {
        $vertical = (osc_carousel_vertical() != '') ? osc_carousel_vertical() : '' ;
    }
    
    $width            = '';
    $dao_preference = new Preference();
    if(Params::getParam('width') != '') {
        $width = Params::getParam('width');
    } else {
        $width = (osc_carousel_width() != '') ? osc_carousel_width() : '' ;
    }
    
    $Sheight            = '';
    $dao_preference = new Preference();
    if(Params::getParam('Sheight') != '') {
        $Sheight = Params::getParam('Sheight');
    } else {
        $Sheight = (osc_carousel_Sheight() != '') ? osc_carousel_Sheight() : '' ;
    }
    
    $Swidth            = '';
    $dao_preference = new Preference();
    if(Params::getParam('Swidth') != '') {
        $Swidth = Params::getParam('Swidth');
    } else {
        $Swidth = (osc_carousel_Swidth() != '') ? osc_carousel_Swidth() : '' ;
    }
    
    $height            = '';
    $dao_preference = new Preference();
    if(Params::getParam('height') != '') {
        $height = Params::getParam('height');
    } else {
        $height = (osc_carousel_height() != '') ? osc_carousel_height() : '' ;
    }
    
    $b_color            = '';
    $dao_preference = new Preference();
    if(Params::getParam('b_color') != '') {
        $b_color = Params::getParam('b_color');
    } else {
        $b_color = (osc_carousel_b_color() != '') ? osc_carousel_b_color() : '' ;
    }
    
    $i_color            = '';
    $dao_preference = new Preference();
    if(Params::getParam('i_color') != '') {
        $i_color = Params::getParam('i_color');
    } else {
        $i_color = (osc_carousel_i_color() != '') ? osc_carousel_i_color() : '' ;
    }
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $item), array("s_section" => "plugin-carousel_for_osclass", "s_name" => "carousel_items")) ;
        $dao_preference->update(array("s_value" => $vertical), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_vertical")) ;
        $dao_preference->update(array("s_value" => $width), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_width")) ;
        $dao_preference->update(array("s_value" => $height), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_height")) ;
        $dao_preference->update(array("s_value" => $Swidth), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_Swidth")) ;
        $dao_preference->update(array("s_value" => $Sheight), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_Sheight")) ;
        $dao_preference->update(array("s_value" => $b_color), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_b_color")) ;
        $dao_preference->update(array("s_value" => $i_color), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_i_color")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'carousel_for_osclass') . '.</p></div>';
    }
    unset($dao_preference) ;
    
?>
<script type="text/javascript" src="<?php echo osc_base_url(). 'oc-content/plugins/carousel_for_osclass/jscolor/jscolor.js'; ?>"></script>
<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="carousel_for_osclass/displayAdmin.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Carousel for Osclass Display Preferences', 'carousel_for_osclass'); ?></h2> 
        <?php if(osc_carousel_version() != '' && osc_carousel_version() == cVersion()) { ?>
        <label for="item" style="font-weight: bold;"><?php _e('Number of items to display at one time', 'carousel_for_osclass'); ?></label>:<br />
        <select name="item" id="item"> 
        	<option <?php if($item == 1){echo 'selected="selected"';}?>value='1'>1</option>
        	<option <?php if($item == 2){echo 'selected="selected"';}?>value='2'>2</option>
        	<option <?php if($item == 3){echo 'selected="selected"';}?>value='3'>3</option>
        	<option <?php if($item == 4){echo 'selected="selected"';}?>value='4'>4</option>
        	<option <?php if($item == 5){echo 'selected="selected"';}?>value='5'>5</option>
        	<option <?php if($item == 6){echo 'selected="selected"';}?>value='6'>6</option>
        </select>
        <br />
        <label for="vertical" style="font-weight: bold;"><?php _e('Display the carousel vertically','carousel'); ?></label>:<br />
        <select name="vertical" id="vertical">
        	<option <?php if($vertical ==0){echo 'selected="selected"';}?> value='0'><?php _e('No', 'carousel_for_osclass'); ?></option>
        	<option <?php if($vertical ==1){echo 'selected="selected"';}?> value='1'><?php _e('Yes', 'carousel_for_osclass'); ?></option>
        </select>        
        <br />
        <fieldset>
        <legend>Carousel Width and Height Settings:</legend>
        <label for="width" style="font-weight: bold;"><?php _e('Width in pixel\'s (Default is 718) ', 'carousel_for_osclass'); ?></label>:<br />
        <input type="text" name="width" id="width" value="<?php echo $width; ?>" />
        <br />
        <label for="height" style="font-weight: bold;"><?php _e('Height in pixel\'s (Default is 120) ', 'carousel_for_osclass'); ?></label>:<br />
        <input type="text" name="height" id="height" value="<?php echo $height; ?>" />
        </fieldset>
        <fieldset>
        <legend>Ad Slide Width and Height Settings:</legend>
        <label for="Swidth" style="font-weight: bold;"><?php _e('Ad Slide Width in pixel\'s (Default is 140) ', 'carousel_for_osclass'); ?></label>:<br />
        <input type="text" name="Swidth" id="Swidth" value="<?php echo $Swidth; ?>" />
        <br />
        <label for="Sheight" style="font-weight: bold;"><?php _e('Ad Slide Height in pixel\'s (Default is 110) ', 'carousel_for_osclass'); ?></label>:<br />
        <input type="text" name="Sheight" id="Sheight" value="<?php echo $Sheight; ?>" />
        </fieldset>
        <br />
        <label for="b_color" style="font-weight: bold;"><?php _e('Background Color (Default is #E9F5F9) ', 'carousel_for_osclass'); ?></label>:<br />
        <input type="text" class="color {hash:true}" name="b_color" id="b_color" value="<?php echo $b_color; ?>" />
        <br />
        <label for="i_color" style="font-weight: bold;"><?php _e('Hover Color (Default is #94CEE4) ', 'carousel_for_osclass'); ?></label>:<br />
        <input type="text" class="color {hash:true}" name="i_color" id="i_color" value="<?php echo $i_color; ?>" />
        <br />        
        <br />
        <input type="submit" value="<?php _e('Save', 'carousel_for_osclass'); ?>" />
        <br />
        <br />
        <?php 
        //admin_carouselosclass_js();
        //carousel(); ?>
        <?php }else{
        		echo '<a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/update.php') . '">&raquo; ' . __('Click here to finish update', 'carousel_for_osclass') . '</a>';
        } ?>
        </fieldset>
    </div>
</form>