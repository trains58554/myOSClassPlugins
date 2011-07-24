<?php
	if(OSCLASS_VERSION >= '2.2') {$verOK = 1;}else{$verOK= 0;}

    $item            = '';
    $dao_preference = new Preference();
    if(Params::getParam('item') != '') {
        $item = Params::getParam('item');
    } else {
        $item = (osc_item_carousel_items() != '') ? osc_item_carousel_items() : '' ;
    }
    
    $autosp            = '';
    $dao_preference = new Preference();
    if(Params::getParam('autosp') != '') {
        $autosp = Params::getParam('autosp');
    } else {
        $autosp = (osc_item_carousel_autosp() != '') ? osc_item_carousel_autosp() : '' ;
    }
    
    $scrolldelay            = '';
    $dao_preference = new Preference();
    if(Params::getParam('scrolldelay') != '') {
        $scrolldelay = Params::getParam('scrolldelay');
    } else {
        $scrolldelay = (osc_item_carousel_scrolldelay() != '') ? osc_item_carousel_scrolldelay() : '' ;
    }
    
	$max_items            = '';
    $dao_preference = new Preference();
    if(Params::getParam('scrolldelay') != '') {
        $max_items = Params::getParam('max_items');
    } else {
        $max_items = (osc_item_carousel_max_items() != '') ? osc_item_carousel_max_items() : '' ;
    }
    
    $item_price_enabled            = '';
    $dao_preference = new Preference();
    if(Params::getParam('item_price_enabled') != '') {
        $item_price_enabled = Params::getParam('item_price_enabled');
    } else {
        $item_price_enabled = (osc_item_carousel_price() != '') ? osc_item_carousel_price() : '' ;
    }
    
    $pictures_enabled		='';
    $dao_preference = new Preference();
    if(Params::getParam('pic_enabled') != ''){
    	$pictures_enabled = Params::getParam('pic_enabled');
    } else {
    	$pictures_enabled = (osc_pic_enabled() != '') ? osc_pic_enabled() : '' ;
    }

    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $item), array("s_section" => "plugin-item_carousel", "s_name" => "item_carousel_items")) ;
        $dao_preference->update(array("s_value" => $autosp), array("s_section" =>"plugin-item_carousel", "s_name" => "item_carousel_autoscroll")) ;
        $dao_preference->update(array("s_value" => $scrolldelay), array("s_section" =>"plugin-item_carousel", "s_name" => "item_carousel_scrolldelay")) ;
        $dao_preference->update(array("s_value" => $max_items), array("s_section" =>"plugin-item_carousel", "s_name" => "item_carousel_max_items")) ;
        $dao_preference->update(array("s_value" => $item_price_enabled), array("s_section" =>"plugin-item_carousel", "s_name" => "item_carousel_price")) ;
        $dao_preference->update(array("s_value" => $pictures_enabled), array("s_section" =>"plugin-item_carousel", "s_name" => "pic_enabled")) ;
        
         echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'item_carousel') . '.</p></div>';
    }
    unset($dao_preference) ;
    
?>
<?php
//version checking
if ($verOK == 0){
 echo '<div style="text-align:center; font-size:22px; background-color:#fff;"><p>' . __('We have detected you are not using OSClass 2.2. Some features are disabled', 'item_carousel') . '.</p></div>';}
?>
<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="item_carousel/admin.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('Item Carousel Preferences', 'item_carousel'); ?></h2> <label for="item" style="font-weight: bold;"><?php _e('Number of items', 'item_carousel'); ?></label>:<br />
        <select name="item" id="item"> 
        	<option <?php if($item == 3){echo 'selected="selected"';}?>value='3'>3</option>
        	<option <?php if($item == 4){echo 'selected="selected"';}?>value='4'>4</option>
        	<option <?php if($item == 5){echo 'selected="selected"';}?>value='5'>5</option>
        </select>
        <label for="autosp" style="font-weight: bold;"><br /><?php _e('Enable auto scroll', 'item_carousel'); ?></label>:<br /> 
        
	<select name="autosp" id="autosp"> 
        	<option <?php if($autosp == 0){echo 'selected="selected"';}?>value='0'><?php _e('No', 'item_carousel'); ?></option>
        	<option <?php if($autosp == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes', 'item_carousel'); ?></option>
        </select>
        <?php if($autosp ==1){?>
        <br />
        <label for="scrolldelay" style="font-weight: bold;"><?php _e('Number of seconds to delay scrolling (Default is 4000) ', 'item_carousel'); ?></label>:<br />
        <input type="text" name="scrolldelay" id="scrolldelay" value="<?php echo $scrolldelay; ?>" />
        <?php } ?>
		<br />
        <label for="max_items" style="font-weight: bold;"><?php _e('Number of items to show in the caroussel (Default is 10) ', 'item_carousel'); ?></label>:<br />
        <input type="text" name="max_items" id="max_items" value="<?php echo $max_items; ?>" />
        <br />
        <label for="item_price_enabled" style="font-weight: bold;"><?php _e('Enable price', 'item_carousel'); ?></label>:<br />
        <select name="item_price_enabled" id="item_price_enabled"> 
        	<option <?php if($item_price_enabled  == 0){echo 'selected="selected"';}?>value='0'>No</option>
        	<option <?php if($item_price_enabled  == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        </select>
        <br />
        <label for="pic_enabled" style="font-weight: bold;"><?php _e('Show ads with pictures only', 'item_carousel'); ?></label>:<br />
        <select name="pic_enabled" id="pic_enabled"> 
        	<option <?php if($pictures_enabled  == 0){echo 'selected="selected"';}?>value='0'>No</option>
        	<option <?php if($pictures_enabled  == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        </select>
        
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'item_carousel'); ?>" />
     </fieldset>
    </div>
</form>
