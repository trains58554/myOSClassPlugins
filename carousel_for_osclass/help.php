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
                    <h1><?php _e('Carousel for Osclass Help', 'carousel_for_osclass'); ?></h1>
                </legend>
                <h2>
                    <?php _e('What is Carousel for Osclass Plugin?', 'carousel_for_osclass'); ?>
                </h2>
                <p>
                    <?php _e('Carousel for Osclass is an easy to use plugin to display the latest ads submitted on your Osclass Installation. Your visitors will get a very quick overview of the ads on your site.', 'carousel_for_osclass'); ?>
                </p>
                <h2>
                    <?php _e('How does Carousel for Osclass plugin work?', 'carousel_for_osclass'); ?>
                </h2>
                <p>
                    <?php _e('In order to use Carousel for Osclass plugin, you should edit your theme file <b>main.php</b> and add the following line anywhere in the code you want the carousel to display.', 'carousel_for_osclass'); ?>:
                </p>
                <pre>
                    &lt;?php if (function_exists('carousel')) {carousel();} ?&gt;
                </pre>
                <h2>
                   <?php _e('Could I cutomize the style of Carousel for Osclass plugin?','carousel'); ?>
                </h2>
                <p>
                   <?php _e('You can configure the layout under configure Display.', 'carousel_for_osclass'); ?>
                </p>
                <p>
                   <?php _e('The plugin is compatible with Osclass version 2.1 and up.', 'carousel_for_osclass'); ?>
                </p>
                <p>
                   <?php _e('Created by Sultan Semlali and JChapman using Superfish and Jquery.', 'carousel_for_osclass'); ?>
                </p>
            </fieldset>
        </div>
    </div>
</div>
