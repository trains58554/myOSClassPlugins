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

<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
	<div style="padding: 0 20px 20px;">
		<div>
			<fieldset>
			<legend>
			<h1><?php _e('Item Carousel Help', 'carousel'); ?></h1>
			</legend>
				<h2>
					<?php _e('What is Item Carousel Plugin?', 'carousel'); ?>
				</h2>
				<p>
					<?php _e('Item Carousel is a slide show way of showing the latests ads.', 'carousel'); ?>
				</p>
				<h2>
					<?php _e('How does Item Carousel plugin work?', 'carousel'); ?>
				</h2>
				<p>
					<?php _e('In order to use Item Carousel plugin, you should edit your theme file <b>main.php</b> and add the following line anywhere in the code you want the carousel to display.', 'carousel'); ?>:
				</p>
		                
                    			<b>&lt;?php if (function_exists('carousel_item_detail')) { carousel_item_detail();} ?&gt;</b>
                		
            		</fieldset>
        	</div>
    </div>
</div>
