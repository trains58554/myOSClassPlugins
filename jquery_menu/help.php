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
                    <h1><?php _e('OC JQuery Menu Help', 'JQuery Menu'); ?></h1>
                </legend>
                <h2>
                    <?php _e('What is JQuery Menu Plugin?', 'JQuery Menu'); ?>
                </h2>
                <p>
                    <?php _e('JQuery Menu Plugin allows you to show a JQuery Navigation Menu on any part of your site you want.', 'JQuery Menu'); ?>
                </p>
                <h2>
                    <?php _e('How does JQuery Menu Plugin work?', 'JQuery Menu'); ?>
                </h2>
                <p>
                    <?php _e('In order to use JQuery Menu Plugin, you should edit your theme files and add the following line anywhere in the code you want the JQuery Navigation Menu to appear.', 'JQuery Menu'); ?>
                </p>
                <pre>
                    &lt;?php jquery_menu(); ?&gt;
                </pre>
                <h2>
                <?php _e('Recommened Place', 'JQuery Menu'); ?>
                </h2>
                <p>
                    <?php _e('Locate these line in your main.php', 'JQuery Menu'); ?>
                </p>
                <pre>
                    &lt;div class="content home"&gt;
                </pre>
                <p>
                    <?php _e('Replace the above line with this', 'JQuery Menu'); ?>
                </p>
                <pre>
                    &lt;?php jquery_menu(); ?&gt;
                    &lt;div class="content home"&gt;
                </pre>
            </fieldset>
        </div>
    </div>
</div>
