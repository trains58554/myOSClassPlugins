<?php
   
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
    
    $premOnly            = '';
    $dao_preference = new Preference();
    if(Params::getParam('premiumOnly') != '') {
        $premOnly = Params::getParam('premiumOnly');
    } else {
        $premOnly = (osc_carousel_premiumOnly() != '') ? osc_carousel_premiumOnly() : '' ;
    }
    
    $picOnly            = '';
    $dao_preference = new Preference();
    if(Params::getParam('picOnly') != '') {
        $picOnly = Params::getParam('picOnly');
    } else {
        $picOnly = (osc_carousel_picOnly() != '') ? osc_carousel_picOnly() : '' ;
    }
    
    $priceEnab            = '';
    $dao_preference = new Preference();
    if(Params::getParam('priceEnab') != '') {
        $priceEnab = Params::getParam('priceEnab');
    } else {
        $priceEnab = (osc_carousel_price() != '') ? osc_carousel_price() : '' ;
    }
    
    $arrows            = '';
    $dao_preference = new Preference();
    if(Params::getParam('arrows') != '') {
        $arrows = Params::getParam('arrows');
    } else {
        $arrows = (osc_carousel_arrows() != '') ? osc_carousel_arrows() : '' ;
    }
    
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $autosp), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_autoscroll")) ;
        $dao_preference->update(array("s_value" => $scrolldelay), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_scrolldelay")) ;
        $dao_preference->update(array("s_value" => $premOnly), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_premiumOnly")) ;
        $dao_preference->update(array("s_value" => $picOnly), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_picOnly")) ;
        $dao_preference->update(array("s_value" => $priceEnab), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_priceEnabled")) ;
        $dao_preference->update(array("s_value" => $arrows), array("s_section" =>"plugin-carousel_for_osclass", "s_name" => "carousel_arrows")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'carousel_for_osclass') . '.</p></div>';
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
        <h2><?php _e('Carousel for Osclass Preferences', 'carousel_for_osclass'); ?></h2> 
        <?php if(osc_carousel_version() != '' && osc_carousel_version() == cVersion()) { ?>
        <label for="autosp" style="font-weight: bold;"><br /><?php _e('Enable auto scrolling', 'carousel_for_osclass'); ?></label>:<br /> 
		  <select name="autosp" id="autosp"> 
        	<option <?php if($autosp == 0){echo 'selected="selected"';}?>value='0'><?php _e('No', 'carousel_for_osclass'); ?></option>
        	<option <?php if($autosp == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes', 'carousel_for_osclass'); ?></option>
        </select>
        <?php if($autosp ==1){?>
        <br />
        <label for="scrolldelay" style="font-weight: bold;"><?php _e('Number of seconds to delay scrolling (Default is 2800) ', 'carousel_for_osclass'); ?></label>:<br />
        <input type="text" name="scrolldelay" id="scrolldelay" value="<?php echo $scrolldelay; ?>" />
        <?php } ?>
        <br />
        <label for="premiumOnly" style="font-weight: bold;"><?php _e('Display premium ads only','carousel'); ?></label>:<br />
        <select name="premiumOnly" id="premiumOnly">
        	<option <?php if($premOnly ==0){echo 'selected="selected"';}?> value='0'><?php _e('No', 'carousel_for_osclass'); ?></option>
        	<option <?php if($premOnly ==1){echo 'selected="selected"';}?> value='1'><?php _e('Yes', 'carousel_for_osclass'); ?></option>
        </select>
        <br />
        <label for="picOnly" style="font-weight: bold;"><?php _e('Show ads with pictures only','carousel'); ?></label>:<br />
        <select name="picOnly" id="picOnly">
        	<option <?php if($picOnly ==0){echo 'selected="selected"';}?> value='0'><?php _e('No', 'carousel_for_osclass'); ?></option>
        	<option <?php if($picOnly ==1){echo 'selected="selected"';}?> value='1'><?php _e('Yes', 'carousel_for_osclass'); ?></option>
        </select>
        <?php if( osc_price_enabled_at_items() ) { ?>
        <br />
        <label for="priceEnab" style="font-weight: bold;"><?php _e('Enable Price','carousel'); ?></label>:<br />
        <select name="priceEnab" id="priceEnab">
        	<option <?php if($priceEnab ==0){echo 'selected="selected"';}?> value='0'><?php _e('No', 'carousel_for_osclass'); ?></option>
        	<option <?php if($priceEnab ==1){echo 'selected="selected"';}?> value='1'><?php _e('Yes', 'carousel_for_osclass'); ?></option>
        </select>
        <?php } ?>
        <br />
        <label for="arrows" style="font-weight: bold;"><?php _e('Enable Arrows','carousel'); ?></label>:<br />
        <select name="arrows" id="arrows">
        	<option <?php if($arrows ==0){echo 'selected="selected"';}?> value='0'><?php _e('No', 'carousel_for_osclass'); ?></option>
        	<option <?php if($arrows ==1){echo 'selected="selected"';}?> value='1'><?php _e('Yes', 'carousel_for_osclass'); ?></option>
        </select>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'carousel_for_osclass'); ?>" />
        <br />
        <br />
        <?php echo __('Version','carousel') . ' ' .osc_carousel_version(); ?>
        <?php }else{
        		echo '<a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/update.php') . '">&raquo; ' . __('Click here to finish update', 'carousel_for_osclass') . '</a>';
        } ?>
     </fieldset>
    </div>
</form>
