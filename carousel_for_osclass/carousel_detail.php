                <div id="carousel">
 <div class="shadowblock_out"> 
            <div class="shadowblockdir">
              
                <div class="sliderblockdir"> 
                    <div id="list"> 
                        
                        <div class="slider"> 
                            <ul> 
        
 
                                    <?php $class = "even"; ?>
                                    <?php while ( osc_has_latest_items() ) { ?>
                                         <li>   <span class="feat_left"> 
                                         
                                         
                                                <?php if( osc_count_item_resources() ) { ?>
                                                    <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>" >
                                                        <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>" alt="<?php echo osc_item_title() ; ?>" /> 
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_item_title() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>"/></a>
                                                <?php } ?>
                                             <div class="clr"></div>
                                             <span class="price_sm"><?php echo osc_item_formated_price() ; ?></span> 
                                             <div class="clr"></div> 

                                        <a href="<?php echo osc_item_url() ; ?>"><?php echo substr(osc_item_title(),0,40) ; ?></a>
                                        </span>
                                    </li> 


                                        <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                    <?php } ?>
</ul>
                   
                       </div> 
                       
                    </div><!-- /slider --> 
                    <div class="clr"></div> 
                </div><!-- /sliderblock --> 
            </div><!-- /shadowblock --> 
        </div><!-- /shadowblock_out -->
</div>
<?php osc_reset_items(); ?>
