<?php
$conn = getConnection() ;
    
    if(Params::getParam("plugin_action") != '') {
        switch(Params::getParam("plugin_action")) {
            case("reason_delete"):    if(Params::getParam("id")!="") {
                                        $conn->osc_dbExec('DELETE FROM %st_offer_reason WHERE id = %d', DB_TABLE_PREFIX, Params::getParam("id"));
                                        
                                    }
            break;
            case("reason_add"):       if(Params::getParam("reason")!="") {
                                        $conn->osc_dbExec("INSERT INTO `%st_offer_reason` ( `reason`) VALUES ( '%s')", DB_TABLE_PREFIX, Params::getParam("reason"));
                                    }
            break;
            case("reason_edit"):      $reason = Params::getParam("reason");
                                    if(is_array($reason)) {
                                        foreach($reason as $k => $v) {
                                            $conn->osc_dbExec("UPDATE  `%st_offer_reason` SET  `reason` =  '%s' WHERE  `id` = %d ;", DB_TABLE_PREFIX, $v, $k);
                                        }
                                    }
            break;
        }
    }
?>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
                                <div style="padding: 20px;">
                                    <div style="float: left; width: 65%;">
                                        <fieldset>
                                            <legend><?php _e('Reasons', 'offer_button'); ?></legend>
                                            <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true);?>" method="GET" enctype="multipart/form-data" >
                                                <input type="hidden" name="page" value="plugins" />
                                                <input type="hidden" name="action" value="renderplugin" />
                                                <input type="hidden" name="file" value="offerButton/reason_conf.php" />
                                                <input type="hidden" name="section" value="reason" />
                                                <input type="hidden" name="plugin_action" value="reason_edit" />
                                                <ul>
                                                <?php
                                                    $reasons = $conn->osc_dbFetchResults('SELECT * FROM %st_offer_reason ORDER BY id ASC', DB_TABLE_PREFIX);
                                                    foreach($reasons as $reason) {
                                                        echo '<li>' . $reason['id'] . '<input name="reason[' . $reason['id'] . ']" id="' . $reason['id'] . '" type="text" value="' . $reason['reason'] . '" /> <a href="' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=offerButton/reason_conf.php?section=reasons&plugin_action=reason_delete&id=' . $reason['id'] . '" ><button type="button">' . __('Delete', 'offer_button') . '</button></a> </li>';
                                                    }
                                                ?>
                                                </ul>
                                                <button type="submit"><?php _e('Edit', 'offer_button'); ?></button>
                                            </form>
                                        </fieldset>
                                    </div>
                            
                                    <div style="float: left; width: 35%;">
                                        <fieldset>
                                            <legend><?php _e('Add new Reasons', 'offer_button'); ?></legend>
                                            <form name="cars_form" id="cars_form" action="<?php echo osc_admin_base_url(true); ?>" method="GET" enctype="multipart/form-data" >
                                                <input type="hidden" name="page" value="plugins" />
                                                <input type="hidden" name="action" value="renderplugin" />
                                                <input type="hidden" name="file" value="offerButton/reason_conf.php" />
                                                <input type="hidden" name="section" value="reason" />
                                                <input type="hidden" name="plugin_action" value="reason_add" />
                                                <input name="reason" id="reason" value="" />
                                                <button type="submit" ><?php _e('Add new', 'offer_button'); ?></button>
                                            </form>
                                        </fieldset>
                                    </div>
                                    <div style="clear: both;"></div>					
                                </div>
                            </div>