﻿<?php
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
<?php 

    $conn = getConnection() ;
    
    if(Params::getParam("plugin_action")!='') 
    {
        switch(Params::getParam("plugin_action")) 
        {
            case("breed_delete"):    if(Params::getParam("id")!="") {
                                        $conn->osc_dbExec('DELETE FROM %st_item_car_breed_attr WHERE pk_i_id = %d', DB_TABLE_PREFIX, Params::getParam("id"));
                                    }
            break;
            case("breed_add"):       if(Params::getParam("breed")!="") {
                                        $conn->osc_dbExec("INSERT INTO `%st_item_car_breed_attr` ( `s_name`) VALUES ( '%s')", DB_TABLE_PREFIX, Params::getParam("breed"));
                                    }
            break;
            case("breed_edit"):      $breed = Params::getParam("breed");
                                    if(is_array($breed)) {
                                        foreach($breed as $k => $v) {
                                            $conn->osc_dbExec("UPDATE  `%st_item_car_breed_attr` SET  `s_name` =  '%s' WHERE  `pk_i_id` = %d ;", DB_TABLE_PREFIX, $v, $k);
                                        }
                                    }
            break;
            case("secondbreed_delete"):   if(Params::getParam("id")!="") {
                                        $conn->osc_dbExec('DELETE FROM %st_item_car_secondbreed_attr WHERE pk_i_id = %d', DB_TABLE_PREFIX, Params::getParam("id"));
                                    }
            break;
            case("secondbreed_add"):      if(Params::getParam("breedId")!='' && Params::getParam("secondbreed")!='') {
                                        $conn->osc_dbExec("INSERT INTO `%st_item_car_secondbreed_attr` ( `fk_i_breed_id`, `s_name`) VALUES ( %d, '%s')", DB_TABLE_PREFIX, Params::getParam("breedId"), Params::getParam("secondbreed"));
                                    }
            break;
            case("secondbreed_edit"):     $breedId = Params::getParam("breedId");
                                    $secondbreed = Params::getParam("secondbreed");
                                    if($breedId!="" && is_array($secondbreed)) {
                                        foreach($secondbreed as $k => $v) {
                                            $conn->osc_dbExec("UPDATE  `%st_item_car_secondbreed_attr` SET  `s_name` =  '%s' WHERE  `pk_i_id` = %d AND `fk_i_breed_id` = %d;", DB_TABLE_PREFIX, $v, $k, $breedId);
                                        }
                                    }
            break;
            case("type_delete"):    if(Params::getParam("id")!="") {
                                        $conn->osc_dbExec('DELETE FROM %st_item_car_vehicle_type_attr WHERE pk_i_id = %d', DB_TABLE_PREFIX, Params::getParam("id"));
                                    }
            break;
            case("type_add"):       $dataItem = array();
                                    $requestParams = Params::getParamsAsArray();
                                    foreach ($requestParams as $k => $v) {
                                        if (preg_match('|(.+?)#(.+)|', $k, $m)) {
                                            $dataItem[$m[1]][$m[2]] = $v;
                                        }
                                    }
                                    // insert locales
                                    $lastId = $conn->osc_dbFetchResult('SELECT pk_i_id FROM %st_item_car_vehicle_type_attr ORDER BY pk_i_id DESC LIMIT 1', DB_TABLE_PREFIX) ;
                                    $lastId = $lastId['pk_i_id'] + 1 ;
                                    foreach ($dataItem as $k => $_data) {
                                        $conn->osc_dbExec("REPLACE INTO %st_item_car_vehicle_type_attr (pk_i_id, fk_c_locale_code, s_name) VALUES (%d, '%s', '%s')", DB_TABLE_PREFIX, $lastId, $k, $_data['car_type']);
                                    }
            break;
            case("type_edit"):      $car_type = Params::getParam("car_type");
                                    foreach($car_type as $k => $v) {
                                        foreach($v as $kj => $vj) {
                                            $conn->osc_dbExec("REPLACE INTO %st_item_car_vehicle_type_attr (pk_i_id, fk_c_locale_code, s_name) VALUES (%d, '%s', '%s')", DB_TABLE_PREFIX, $k, $kj, $vj );
                                        }
                                    }
        }
    }
    
    switch(Params::getParam("section")) 
    {
        case("breeds"): ?>
    
                            <div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
                                <div style="padding: 20px;">
                                    <div style="float: left; width: 50%;">
                                        <fieldset>
                                        <legend><?php echo __('Breeds'); ?></legend>
                                        <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true);?>" method="GET" enctype="multipart/form-data" >
                                        <input type="hidden" name="page" value="plugins" />
                                        <input type="hidden" name="action" value="renderplugin" />
                                        <input type="hidden" name="file" value="cars_attributes/conf.php" />
                                        <input type="hidden" name="section" value="breeds" />
                                        <input type="hidden" name="plugin_action" value="breed_edit" />
                                        <ul>
                                        <?php
                                            $breeds = $conn->osc_dbFetchResults('SELECT * FROM %st_item_car_breed_attr ORDER BY s_name ASC', DB_TABLE_PREFIX);
                                            foreach($breeds as $breed) {
                                                echo '<li><input name="breed['.$breed['pk_i_id'].']" id="'.$breed['pk_i_id'].'" type="text" value="'.$breed['s_name'].'" /> <a href="'.osc_admin_base_url(true).'?page=plugins&action=renderplugin&file=cars_attributes/conf.php?section=breeds&plugin_action=breed_delete&id='.$breed['pk_i_id'].'" ><button>'.__('Delete').'</button></a> </li>';
                                            }
                                        ?>
                                        </ul>
                                        <button type="submit"><?php echo  __('Edit');?></button>
                                        </form>
                                        </fieldset>
                                    </div>
                            
                                    <div style="float: left; width: 50%;">
                                        <fieldset>
                                        <legend><?php echo __('Add new breed'); ?></legend>
                                        <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true);?>" method="GET" enctype="multipart/form-data" >
                                        <input type="hidden" name="page" value="plugins" />
                                        <input type="hidden" name="action" value="renderplugin" />
                                        <input type="hidden" name="file" value="cars_attributes/conf.php" />
                                        <input type="hidden" name="section" value="breeds" />
                                        <input type="hidden" name="plugin_action" value="breed_add" />
                            
                                        
                                        <input name="breed" id="breed" value="" /><button type="submit" ><?php echo  __('Add new'); ?></button>
                                        </form>
                                        </fieldset>
                                    </div>
                            
                                    <div style="clear: both;"></div>
                            												
                                </div>
                            </div>
        <?php 
        break;
        case ("secondbreeds"):    $breedId = Params::getParam("breedId");
                         ?>
                            <div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
                                <div style="padding: 20px;">
                                    <div style="float: left; width: 50%;">
                                        <fieldset>
                                        <legend><?php echo __('Secondary Breeds'); ?></legend>
                                        <?php $breed = $conn->osc_dbFetchResults('SELECT * FROM %st_item_car_breed_attr ORDER BY s_name ASC', DB_TABLE_PREFIX); ?>
                                        <select name="breed" id="breed" onchange="location.href = '<?php echo osc_admin_base_url(true);?>?page=plugins&action=renderplugin&file=cars_attributes/conf.php?section=secondbreeds&breedId=' + this.value" >
                                            <option value=""><?php echo  __('Select a breed'); ?></option>
                                            <?php foreach($breed as $a): ?>
                                            <option value="<?php echo $a['pk_i_id']; ?>" <?php if($breedId==$a['pk_i_id']) { echo 'selected'; };?>><?php echo $a['s_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true);?>" method="GET" enctype="multipart/form-data" >
                                        <input type="hidden" name="page" value="plugins" />
                                        <input type="hidden" name="action" value="renderplugin" />
                                        <input type="hidden" name="file" value="cars_attributes/conf.php" />
                                        <input type="hidden" name="section" value="secondbreeds" />
                                        <input type="hidden" name="plugin_action" value="secondbreed_edit" />
                                        <input type="hidden" name="breedId" value="<?php echo  $breedId;?>" />
                                        <ul>
                                        <?php
                                            if($breedId!="") {
                                                $secondbreeds = $conn->osc_dbFetchResults('SELECT * FROM %st_item_car_secondbreed_attr WHERE fk_i_breed_id = %d ORDER BY s_name ASC', DB_TABLE_PREFIX, $breedId);
                                                foreach($secondbreeds as $secondbreed) {
                                                    echo '<li><input name="secondbreed['.$secondbreed['pk_i_id'].']" id="'.$secondbreed['pk_i_id'].'" type="text" value="'.$secondbreed['s_name'].'" /> <a href="'.osc_admin_base_url(true).'?page=plugins&action=renderplugin&file=cars_attributes/conf.php?section=secondbreeds&plugin_action=secondbreed_delete&breedId='.$breedId.'&id='.$secondbreed['pk_i_id'].'" ><button>'.__('Delete').'</button></a> </li>';
                                                }
                                            } else {
                                                echo '<li>Select a breed first.</li>';
                                            }
                                        ?>
                                        </ul>
                                        <button type="submit"><?php echo  __('Edit');?></button>
                                        </form>
                                        </fieldset>
                                    </div>
                            
                                    <div style="float: left; width: 50%;">
                                        <fieldset>
                                        <legend><?php echo __('Add new secondbreed'); ?></legend>
                                        <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true);?>" method="GET" enctype="multipart/form-data" >
                                        <input type="hidden" name="page" value="plugins" />
                                        <input type="hidden" name="action" value="renderplugin" />
                                        <input type="hidden" name="file" value="cars_attributes/conf.php" />
                                        <input type="hidden" name="section" value="secondbreeds" />
                                        <input type="hidden" name="plugin_action" value="secondbreed_add" />
                            
                                        <?php if($breedId!='') { ?>
                                            <input type="hidden" name="breedId" value="<?php echo $breedId;?>" />
                                            <input name="secondbreed" id="secondbreed" value="" /><button type="submit" ><?php echo  __('Add new'); ?></button>
                                        <?php }; ?>
                                        </form>
                                        </fieldset>
                                    </div>
                            
                                    <div style="clear: both;"></div>
                            												
                                </div>
                            </div>
        <?php 
        break;
        case("types"): ?>
                            <div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
                                <div style="padding: 20px;">
                                    <div style="float: left; width: 50%;">
                                        <fieldset>
                                        <legend><?php echo __('Vehicle types'); ?></legend>
                                        <div class="tabber">
                                        <?php $locales = OSCLocale::newInstance()->listAllEnabled();
                                            $car_type = $conn->osc_dbFetchResults('SELECT * FROM %st_item_car_vehicle_type_attr', DB_TABLE_PREFIX);
                                            $data = array();
                                            foreach ($car_type as $c) {
                                                $data[$c['fk_c_locale_code']][] = array('pk_i_id' => $c['pk_i_id'], 's_name' => $c['s_name']);
                                            }
                                        ?>
                                        <?php foreach($locales as $locale) {?>
                                        <div class="tabbertab">
                                        <h2><?php echo $locale['s_name']; ?></h2>
                                        <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true);?>" method="GET" enctype="multipart/form-data" >
                                        <input type="hidden" name="page" value="plugins" />
                                        <input type="hidden" name="action" value="renderplugin" />
                                        <input type="hidden" name="file" value="cars_attributes/conf.php" />
                                        <input type="hidden" name="section" value="types" />
                                        <input type="hidden" name="plugin_action" value="type_edit" />
                                        <ul>
                                            <?php
                                            if(count($data)>0) {
                                            foreach($data[$locale['pk_c_code']] as $car_type) { ?>
                                            <li><input name="car_type[<?php echo  $car_type['pk_i_id'];?>][<?php echo  $locale['pk_c_code'];?>]" id="<?php echo  $car_type['pk_i_id'];?>" type="text" value="<?php echo  $car_type['s_name'];?>" /> <a href="<?php echo osc_admin_base_url(true);?>?page=plugins&action=renderplugin&file=cars_attributes/conf.php?section=types&plugin_action=type_delete&id=<?php echo  $car_type['pk_i_id'];?>" ><button><?php echo __('Delete');?></button></a> </li>
                                            <?php }; }; ?>
                                        </ul>
                                        <button type="submit"><?php echo  __('Edit');?></button>
                                        </form>
                                        </div>
                                        <?php }; ?>
                                        </div>
                                        </fieldset>
                                    </div>
                            
                                    <div style="float: left; width: 50%;">
                                        <fieldset>
                                        <legend><?php echo __('Add new car type'); ?></legend>
                                        <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true);?>" method="GET" enctype="multipart/form-data" >
                                        <input type="hidden" name="page" value="plugins" />
                                        <input type="hidden" name="action" value="renderplugin" />
                                        <input type="hidden" name="file" value="cars_attributes/conf.php" />
                                        <input type="hidden" name="section" value="types" />
                                        <input type="hidden" name="plugin_action" value="type_add" />
                            
                                        <div class="tabber">
                                        <?php $locales = OSCLocale::newInstance()->listAllEnabled();
                                            $car_type = $conn->osc_dbFetchResults('SELECT * FROM %st_item_car_vehicle_type_attr', DB_TABLE_PREFIX);
                                            $data = array();
                                            foreach ($car_type as $c) {
                                                $data[$locale['pk_c_code']] = array('pk_i_id' => $c['pk_i_id'], 's_name' => $c['s_name']);
                                            }
                                        ?>
                                        <?php foreach($locales as $locale) {?>
                                        <div class="tabbertab">
                                        <h2><?php echo $locale['s_name']; ?></h2>
                                        <input name="<?php echo  $locale['pk_c_code'];?>#car_type" id="car_type" type="text" value="" />
                                        </div>
                                        <?php }; ?>
                                        </div>
                                        
                                        
                                        <button type="submit" ><?php echo  __('Add new'); ?></button>
                                        </form>
                                        </fieldset>
                                    </div>
                            
                                    <div style="clear: both;"></div>
                            												
                                </div>
                            </div>
        <?php 
        break;
    } ?>
    
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <fieldset style="border: 1px solid #ff0000;">
            <legend><?php echo __('Warning'); ?></legend>
                <p>
                <?php _e("Deleting breeds or secondbreeds may end in errors. Some of those breeds/secondbreeds could be attached to some actual items."); ?>
                </p>
            </fieldset>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>
