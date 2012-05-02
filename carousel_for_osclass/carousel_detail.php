<?php 
/**
     * Get if user is on item edit page
     *
     * @return boolean
     */
    function osc_is_item_edit_page() {
        $location = Rewrite::newInstance()->get_location();
        $section = Rewrite::newInstance()->get_section();
        if($location=='item' && $section=='item_edit') {
            return true;
        }
        return false;
    }

if(!osc_is_publish_page() && !osc_is_item_edit_page()){
//$osclassItems = View::newInstance()->_get('items');

$search1 = new search();
if($itemPage) {
   $pCategory = Category::newInstance()->findRootCategory(osc_item_category_id() );
   
   
   $search1->addCategory($pCategory['pk_i_id']);                   
   //$search1->addCategory(osc_item_category_id ());
   
   $search1->limit (0, $itemLimit);
}
if($picOnly == 1 ) {
	 $search1->addConditions(sprintf("%st_item_resource.fk_i_item_id = %st_item.pk_i_id", DB_TABLE_PREFIX, DB_TABLE_PREFIX));   
	 $search1->addTable(sprintf("%st_item_resource", DB_TABLE_PREFIX)); 
}
if($premOnly == 1) {  
    $search1->addConditions(sprintf("b_premium = %d", 1));    
}
	 $aItems = $search1->doSearch();
    $iTotalItems = $search1->count();
    $aCount = count($aItems);
    View::newInstance()->_exportVariableToView('items', $aItems);
?>

<div id="carousel">
 <div class="shadowblock_out"> 
       
                    <div id="list"> 
                        <?php //echo 'total ' . $iTotalItems;
                        if($aCount >= $items) {?>
                        <?php if (osc_carousel_arrows()) { ?>
                        <div class="prevCarousel"></div>
                        <?php } ?>
                        <div class="carouselSlider"> 
                            <ul> 
        
 				<?php if($premOnly == 0){ ?>
                                    <?php $class = "even"; ?>
                                    <?php while ( osc_has_items() ) { ?>
                                    <li>   <span class="feat_left"> 
                                         
                                        <?php if(osc_item_is_premium()){ _e('Premium Ad', 'carousel_for_osclass');}else{echo '<br />';}?>
                                                <?php if( osc_count_item_resources() ) { ?>
                                                
                                                    <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>" >
                                                        <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>" alt="<?php echo osc_item_title() ; ?>" /> 
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_item_title() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>"/></a>
                                                <?php } ?>
                                             <div class="clr"></div>
                                             <?php if( osc_price_enabled_at_items() ) { if($price == 1){?><span class="price_sm"><?php echo osc_item_formated_price() ; ?></span><?php }} ?>
                                             <div class="clr"></div> 

                                        <a href="<?php echo osc_item_url() ; ?>"><?php echo substr(osc_item_title(),0,30) ; ?></a>
                                        
                                        </span>
                                    </li>

                                        <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                    <?php } ?>
                                    
                            <?php //Premium Items only ?>
                                    
                                    <?php  }else{ ?>
                                    <?php $class = "even"; ?>
                                    <?php while ( osc_has_items() ) { ?>
				    							<?php if(osc_item_is_premium()){ ?>
                                         <li>   <span class="feat_left"> 
                                         
                                                <?php if( osc_count_item_resources() ) { ?>
                                                
                                                    <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>" >
                                                        <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>" alt="<?php echo osc_item_title() ; ?>" /> 
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_item_title() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>"/></a>
                                                <?php } ?>
                                             <div class="clr"></div>
                                             <?php if( osc_price_enabled_at_items() ) { if($price == 1){?><span class="price_sm"><?php echo osc_item_formated_price() ; ?></span><?php }} ?>
                                             <div class="clr"></div> 

                                        <a href="<?php echo osc_item_url() ; ?>"><?php echo substr(osc_item_title(),0,30) ; ?></a>
                                        </span>
                                    </li> 
				    							<?php } /* ends premium item if statement */?>

                                        <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                    <?php } ?>
                                    <?php /*osc_reset_premiums();*/ }  ?>
</ul>
                   
                       </div> <!-- /slider -->
                       <?php if (osc_carousel_arrows()) { ?>
                       <div class="nextCarousel"></div>
                       <?php } ?>
                       <?php } else { echo '<div class="noSlides">' . __('No items to display', 'carousel_for_osclass') . '</div>'; } ?>
                    </div> 
                    
                    <div class="clr"></div> 
                
        </div><!-- /shadowblock_out -->
</div>
<?php
//View::newInstance()->_exportVariableToView('items', $osclassItems);
osc_reset_items();
}
?>
