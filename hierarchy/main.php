<?php
    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
    <head>
        <?php osc_current_web_theme_path('head.php') ; ?>
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
    </head>
    <body>
        <div class="container">
            <?php osc_current_web_theme_path('header.php') ; ?>
            <div id="form_publish">
                <?php osc_current_web_theme_path('inc.search.php') ; ?>
            </div>
            <div class="content home">
            <div id="leftsidebar">
                    <div class="navigation">
                        <div class="box location">
                            <h1><strong><?php _e("<a href=''>Home</a>", 'modern'); ?></strong></h1>
                            <ul>
                            <?php osc_goto_first_category() ; ?>
            		    <?php while ( osc_has_categories() ) { ?> 
            		    <li>           		
                            <h2><strong><a href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</span></strong></h2></li>
                        <?php } ?>
                            </ul>
                        </div>
                </div>
            </div>
                <div id="main">
                    <div class="latest_ads">
                        <h1><strong><?php _e('Latest Items', 'modern') ; ?></strong></h1>
                         <?php if (function_exists('carousel_item_detail')) { carousel_item_detail();} ?>
                         <?php if (function_exists('carousel')) { carousel(); } ?>
                        <?php /* osc_reset_items();*/ ?>
                        <?php if( osc_count_latest_items() == 0) { ?>
                            <p class="empty"><?php _e('No Latest Items', 'modern') ; ?></p>
                        <?php } else { ?>
                            <table border="0" cellspacing="0">
                                 <tbody>
                                    <?php $class = "even"; ?>
                                    <?php while ( osc_has_latest_items() ) { ?>
                                        <tr class="<?php echo $class ; ?>">
                                            <?php if( osc_images_enabled_at_items() ) { ?>
                                             <td class="photo">
                                                <?php if( osc_count_item_resources() ) { ?>
                                                    <a href="<?php echo osc_item_url() ; ?>">
                                                        <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75px" height="56px" title="" alt="" />
                                                    </a>
                                                <?php } else { ?>
                                                    <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                                                <?php } ?>
                                             </td>
                                            <?php } ?>
                                             <td class="text">
                                                 <h3><a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a></h3>
                                                 <p><strong><?php if( osc_price_enabled_at_items() ) { echo osc_item_formated_price() ; ?> - <?php } echo osc_item_city(); ?> (<?php echo osc_item_region();?>) - <?php echo osc_format_date(osc_item_pub_date()); ?></strong></p>
                                                 <p><?php echo osc_highlight( strip_tags( osc_item_description() ) ) ; ?></p>
                                             </td>                                       
                                         </tr>
                                        <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            
                            <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
                                <p class="see_more_link"><a href="<?php echo osc_search_show_all_url();?>"><strong><?php _e("See all offers", 'modern'); ?> &raquo;</strong></a></p>
                            <?php } ?>
                        <?php } ?>
                 
                    </div>
                </div>
                <div id="sidebar">
                    <div class="navigation">
                        <?php if(osc_count_list_cities()>0) {?>
                        <div class="box location">
                            <h3><strong><?php _e("Location", 'modern'); ?></strong></h3>
                            <ul>
                            <?php while(osc_has_list_cities()) { ?>
                                <li><a href="<?php echo osc_search_url(array('sCity' => osc_list_city_name()));?>"><?php echo osc_list_city_name();?></a> <em>(<?php echo osc_list_city_items();?>)</em></li>
                            <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <?php // comment the section below if you don't want the facebook social plugin ?>
                    	<div class="box location">
                    		<h3><strong><?php _e("Facebook", 'modern'); ?></strong></h3>
                    		<ul>
                    		    <li>
                    		        <iframe src="http://www.facebook.com/plugins/activity.php?site&amp;width=200&amp;height=300&amp;header=true&amp;colorscheme=light&amp;font&amp;border_color&amp;recommendations=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:300px;" allowTransparency="true"></iframe>
                    		    </li>
                    		</ul>
                     </div>
                </div>
            </div>
            <?php osc_current_web_theme_path('footer.php') ; ?>
        </div>
        <?php osc_show_flash_message() ; ?>
        <?php osc_run_hook('footer'); ?>

    </body>
</html>
