  </div>
  
 <div class="grid_4" id="sidebar">
 
      <ul id="sidebar_widgeted">
      <?php getSideBar("<li class='widget widget_recent_entries'><div class='whitebox'>","</div></li>");?>
      </ul>
      
 </div>
    
    
    <div class="clear"></div>

<div class="grid_12" id="footer">
    <ul class="pages">
	    <?php if(FRIENDLY_URL) {?>
		    <li><a href="<?php echo SITE_URL."/".u(T_("Advanced Search"));?>.htm"><?php _e("Advanced Search");?></a></li>
		    <li><a href="<?php echo SITE_URL."/".u(T_("Sitemap"));?>.htm"><?php _e("Sitemap");?></a></li>   
		    <li><a href="<?php echo SITE_URL."/".u(T_("Privacy Policy"));?>.htm"><?php _e("Privacy Policy");?></a></li>
	    <?php }else { ?>
	        <li><a href="<?php echo SITE_URL;?>/content/search.php"><?php _e("Advanced Search");?></a></li>
	        <li><a href="<?php echo SITE_URL;?>/content/site-map.php"><?php _e("Sitemap");?></a></li>
		    <li><a href="<?php echo SITE_URL;?>/content/privacy.php"><?php _e("Privacy Policy");?></a></li>
	    <?php } ?>
	    <li><a href="<?php echo SITE_URL."/".contactURL();?>"><?php _e("Contact");?></a></li>
	    <li><a href="<?php echo SITE_URL.newURL();?>"><?php _e("Publish a new Ad");?></a></li>
	</ul>
    <p>
    <?php echo SITE_NAME;?> |
<!-- Open Classifieds License. To remove please visit http://open-classifieds.com/services/  -->
Powered by <a title="free open source php classifieds script" href="http://www.open-classifieds.com">Open Classifieds</a>
<!--End Open Classifieds License--></p>
  </div>
  <div class="clear"></div>

  </div>
</div>
