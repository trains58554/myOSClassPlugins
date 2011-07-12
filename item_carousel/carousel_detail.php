<?php
$items = (osc_item_carousel_max_items() != '') ? osc_item_carousel_max_items() : '' ;
$item_price_enabled = (osc_item_carousel_price() != '') ? osc_item_carousel_price() : '' ;
$pictures_enabled = (osc_pic_enabled() != '') ? osc_pic_enabled() : '' ;

$search = new Search();
$search->limit(0, $items);
View::newInstance()-> _exportVariableToView('items', $search->doSearch()) ;
?>
<div id="carouselContainerLeft">
<div id="carouselContainerRight">
<div id="carousel">
	<div class="prev"><img src="<?php echo osc_base_url() . 'oc-content/plugins/item_carousel/prev.jpg' ; ?>" alt="prev" width="19" height="19" /></div>
			<div class="slider">
				<ul>
                        	<?php osc_reset_items();?>
                        	<?php while ( osc_has_items() ) { ?>
                        	<?php if(($pictures_enabled ==1)) { 
                        	      if(osc_count_item_resources()){ ?>
						<li>
						<a href="<?php echo osc_item_url() ; ?>">
						<?php if( osc_images_enabled_at_items() ) { ?>		
						<?php  if( osc_count_item_resources() ) { ?>
						<img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="94" height="94" alt="" /><?php } else { ?><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/><?php } }?></a>
						<?php if($item_price_enabled == 1){?><strong><?php if( osc_price_enabled_at_items() ) { echo osc_item_formated_price() ;} ?></strong><br /><?php }?>
						<a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title(); ?></a>
						</li>
			<?php }}elseif($pictures_enabled==0) { ?>
						<li>
						<a href="<?php echo osc_item_url() ; ?>">
						<?php if( osc_images_enabled_at_items() ) { ?>		
						<?php  if( osc_count_item_resources() ) { ?>
						<img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="94" height="94" alt="" /><?php } else { ?><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/><?php } }?></a>
						<?php if($item_price_enabled == 1){?><strong><?php if( osc_price_enabled_at_items() ) { echo osc_item_formated_price() ;} ?></strong><br /><?php }?>
						<a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title(); ?></a>
						</li>
				<?php }} ?>
					</ul>
				</div>
					
				<div class="next"><img src="<?php echo osc_base_url() . 'oc-content/plugins/item_carousel/next.jpg' ; ?>" alt="next" width="19" height="19" /></div>
</div> 
</div>
</div>
<?php 
//need to do this to reset latest items
$search = new Search();
$search->limit(0, osc_max_latest_items());
View::newInstance()-> _exportVariableToView('items', $search->doSearch()) ;
?>
