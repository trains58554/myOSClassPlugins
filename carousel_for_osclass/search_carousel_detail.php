
<div id="carousel">
 <div class="shadowblock_out"> 
            <div class="shadowblockdir">
              
                <div class="sliderblockdir"> 
                    <div id="list"> 
                        
                        <div class="slider"> 
                            <ul> 
        
 				<?php if($premOnly == 0){ ?>
                                    <?php $class = "even"; ?>
                                    <?php while ( osc_has_latest_items() ) { ?>
                                    <?php if(($picOnly ==1)) { 
                        	      			if(osc_count_item_resources()){ ?>
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
                                    <?php }}elseif($picOnly==0) { ?>
                                    <li>   <span class="feat_left"> 
                                         
                                        <?php if(osc_item_is_premium()){ echo 'Premium Ad';}else{echo '<br />';}?>
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
                                    <?php } /*ends picOnly else statement */?>


                                        <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                    <?php } ?>
                                    
                            <?php //Premium Items only ?>
                                    
                                    <?php  }else{ ?>
                                    <?php $class = "even"; ?>
                                    <?php while ( osc_has_latest_items() ) { ?>
                                    <?php if(($picOnly ==1)) { 
                        	      			if(osc_count_item_resources()){ ?>
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
				    							<?php }}elseif($picOnly==0) { ?>
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
				    							<?php } /* ends picOnly else statement */ ?>

                                        <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                    <?php } ?>
                                    <?php /*osc_reset_premiums();*/ }  ?>
</ul>
                   
                       </div> 
                       
                    </div><!-- /slider --> 
                    <div class="clr"></div> 
                </div><!-- /sliderblock --> 
            </div><!-- /shadowblock --> 
        </div><!-- /shadowblock_out -->
</div>
<?php osc_reset_items(); ?>
