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
 $styleurl = "../oc-content/plugins/php_info/style.css";
?>
<style>
<?php include($styleurl) ; ?>
</style>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
	<div style="padding: 0 20px 20px;">
		<div>
			<h1><?php _e('PHP Info', 'phpInfo'); ?></h1>
			<blockquote>
<?php
ob_start();                                                                                                        
phpinfo();                                                                                                     
$info = ob_get_contents();                                                                                         
ob_end_clean();                                                                                                    
echo preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $info);
?>
</blockquote>
			
		</div>
	</div>
</div>
