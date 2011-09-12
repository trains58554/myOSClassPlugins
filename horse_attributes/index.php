<?php
/*
Plugin Name: Horse attributes
Plugin URI: http://www.osclass.org/
Description: This plugin extends a category of items to store horse attributes such as breed, second breed, gender, and so on.
Version: 0.1
Author: hallartistry & JChapman
Author URI: http://www.osclass.org/
Short Name: horse_plugin
Plugin update URI: http://www.osclass.org/files/plugins/horse_attributes/update.php
*/



// Adds some plugin-specific search conditions
function horse_search_conditions($params) {

	// we need conditions and search tables (only if we're using our custom tables)
    $has_conditions = false;
    foreach($params as $key => $value) {

        // We may want to  have param-specific searches 
        switch($key) {
            case 'type':
                Search::newInstance()->addConditions(sprintf("%st_item_horse_attr.fk_i_vehicle_type_id = %st_item_car_vehicle_type_attr.pk_i_id AND %st_item_car_vehicle_type_attr.s_name = '%%%s%%'", DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, $value));
                Search::newInstance()->addTable(sprintf("%st_item_car_vehicle_type_attr", DB_TABLE_PREFIX));
                $has_conditions = true;
                break;
            case 'secondbreed':
                Search::newInstance()->addConditions(sprintf("%st_item_horse_attr.fk_i_secondbreed_id = %st_item_horse_secondbreed_attr.pk_i_id AND %st_item_car_secondbreed_attr.s_name = '%%%s%%'", DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, $value));
                Search::newInstance()->addTable(sprintf("%st_item_secondbreed_attr", DB_TABLE_PREFIX));
                $has_conditions = true;
                break;
            case 'numAirbags':
                Search::newInstance()->addConditions(sprintf("%st_item_car_attr.i_num_airbags = %d", DB_TABLE_PREFIX, $value));
                $has_conditions = true;
                break;
            case 'wamrblood':
                Search::newInstance()->addConditions(sprintf("%st_item_car_attr.e_wamrblood = '%s'", DB_TABLE_PREFIX, $value));
                $has_conditions = true;
                break;
    		default:
                break;

        }
    }

    // Only if we have some values at the params we add our table and link with the ID of the item.
    if($has_conditions) {
        Search::newInstance()->addConditions(sprintf("%st_item.pk_i_id = %st_item_car_attr.fk_i_item_id ", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
        Search::newInstance()->addTable(sprintf("%st_item_car_attr", DB_TABLE_PREFIX));
	}	
}



function horse_call_after_install() {

	// Insert here the code you want to execute after the plugin's install
	// for example you might want to create a table or modify some values
	
	// In this case we'll create a table to store the Example attributes	
	$conn = getConnection() ;
	$conn->autocommit(false) ;
	try {
		$path = osc_plugin_resource('horse_attributes/struct.sql');
		$sql = file_get_contents($path);
		$conn->osc_dbImportSQL($sql);		
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		echo $e->getMessage();
	}
	$conn->autocommit(true);

}

function horse_call_after_uninstall() {

	// Insert here the code you want to execute after the plugin's uninstall
	// for example you might want to drop/remove a table or modify some values
	
	// In this case we'll remove the table we created to store Example attributes	
	$conn = getConnection() ;
	$conn->autocommit(false);
	try {
		$conn->osc_dbExec("DELETE FROM %st_plugin_category WHERE s_plugin_name = 'horse_plugin'", DB_TABLE_PREFIX);
		$conn->osc_dbExec('DROP TABLE %st_item_horse_breed_attr', DB_TABLE_PREFIX);
		$conn->osc_dbExec('DROP TABLE %st_item_horse_secondbreed_attr', DB_TABLE_PREFIX);
		$conn->osc_dbExec('DROP TABLE %st_item_horse_skills_attr', DB_TABLE_PREFIX);
		$conn->osc_dbExec('DROP TABLE %st_item_horse_attr', DB_TABLE_PREFIX);
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		echo $e->getMessage();
	}
	$conn->autocommit(true);
}


function horse_form($catId = '') {
    $conn = getConnection() ;
    // We received the categoryID
	if($catId!="") {
		// We check if the category is the same as our plugin
		if(osc_is_this_category('horse_plugin', $catId)) {
            $breed = $conn->osc_dbFetchResults('SELECT * FROM %st_item_horse_breed_attr ORDER BY s_name ASC', DB_TABLE_PREFIX);
            $skills = $conn->osc_dbFetchResults('SELECT * FROM %st_item_horse_skills_attr ORDER BY s_name ASC', DB_TABLE_PREFIX);
			require_once 'form.php';
			Session::newInstance()->_clearVariables();
		}
	}
}

function horse_search_form($catId = null) {
	// We received the categoryID
	if($catId!=null) {
		// We check if the category is the same as our plugin
        foreach($catId as $id) {
    		if(osc_is_this_category('horse_plugin', $id)) {
	    		include_once 'search_form.php';
	    		break;
	    	}
        }
	}
}


function horse_form_post($catId = null, $item_id = null) {
    $conn = getConnection() ;
	// We received the categoryID and the Item ID
	if($catId!=null) {
		// We check if the category is the same as our plugin
		if(osc_is_this_category('horse_plugin', $catId) && $item_id!=null) {
		$skillsH = Params::getParam("h_skills");
		$Hskills = implode(',', $skillsH);
				// Insert the data in our plugin's table
                    $conn->osc_dbExec("INSERT INTO %st_item_horse_attr (fk_i_item_horse_id, horse_registered_name, horse_nick_name, gated, warm_blood, registered, fk_i_breed_id, fk_i_secondbreed_id, registration_associations, registration_num, month_foaled, year_foaled, gender, mare_in_foal, covering_sire, base_color, other_color, height_in_hands, approx_weight, temperament, skills, trade) VALUES ('%d', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%s', '%f', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d')",
						DB_TABLE_PREFIX,
						$item_id,
						Params::getParam("h_registered_name"),
						Params::getParam("h_nickname"),
						(Params::getParam("h_gated")!='') ? 1 : 0,
						(Params::getParam("h_warm_blood")!='') ? 1 : 0,
						(Params::getParam("h_registered")!='') ? 1 : 0,
						Params::getParam("breed"),
						Params::getParam("secondbreed"),
						Params::getParam("h_registration_assoc"),
						Params::getParam("h_registration_num"),
						Params::getParam("h_month_foaled"),
						Params::getParam("h_year_foaled"),
						Params::getParam("h_gender"),
						(Params::getParam("h_mare_foal")!='') ? 1 : 0,
						(Params::getParam("H_cover_sire")!='') ? 1 : 0,
						Params::getParam("h_base_color"),
						Params::getParam("h_other_color"),
						Params::getParam("h_height"),
						Params::getParam("h_weight"),
						Params::getParam("h_temp"),
						$Hskills,
						(Params::getParam("h_trade")!='') ? 1 : 0
					);
		}
	}
}

// Self-explanatory
function horse_item_detail() {
    $conn = getConnection() ;
    if(osc_is_this_category('horse_plugin', osc_item_category_id())) {
	$detail = $conn->osc_dbFetchResult("SELECT * FROM %st_item_horse_attr WHERE fk_i_item_horse_id = %d", DB_TABLE_PREFIX, osc_item_id());
        $breed = $conn->osc_dbFetchResult('SELECT * FROM %st_item_horse_breed_attr WHERE pk_i_id = %d', DB_TABLE_PREFIX, $detail['fk_i_breed_id']);
        $secondbreed = $conn->osc_dbFetchResult('SELECT * FROM %st_item_horse_secondbreed_attr WHERE pk_i_id = %d', DB_TABLE_PREFIX, $detail['fk_i_secondbreed_id']);
        $skills = $conn->osc_dbFetchResults('SELECT * FROM %st_item_horse_skills_attr ORDER BY s_name ASC', DB_TABLE_PREFIX);
        $detail['s_breed']  = $breed['s_name'];
        $detail['s_secondbreed'] = $secondbreed['s_name'];
	    require_once 'item_detail.php';
    }
}


// Self-explanatory
function horse_item_edit($catId = null, $item_id = null) {
    $conn = getConnection() ;
    if(osc_is_this_category('horse_plugin', $catId)) {
	    $detail = $conn->osc_dbFetchResult("SELECT * FROM %st_item_horse_attr WHERE fk_i_item_horse_id = %d", DB_TABLE_PREFIX, $item_id);
	$detail['skills'] = explode(',',$detail['skills']);
        $breed = $conn->osc_dbFetchResults('SELECT * FROM %st_item_horse_breed_attr ORDER BY s_name ASC', DB_TABLE_PREFIX);
        $secondbreed = $conn->osc_dbFetchResults('SELECT * FROM %st_item_horse_secondbreed_attr WHERE `fk_i_breed_id` = %d ORDER BY s_name ASC', DB_TABLE_PREFIX, $detail['fk_i_breed_id']);
	$skills = $conn->osc_dbFetchResults('SELECT * FROM %st_item_horse_skills_attr ORDER BY s_name ASC', DB_TABLE_PREFIX);
	    require_once 'form.php';
	    Session::newInstance()->_clearVariables();
    }
}

function horse_item_edit_post($catId = null, $item_id = null) {
	// We received the categoryID and the Item ID
	if($catId!=null) 
	{
		// We check if the category is the same as our plugin
		if(osc_is_this_category('horse_plugin', $catId))
		{
		$skillsH = Params::getParam("h_skills");
		$Hskills = implode(',', $skillsH);
			$conn = getConnection() ;
			// Insert the data in our plugin's table
            $conn->osc_dbExec("REPLACE INTO %st_item_horse_attr (fk_i_item_horse_id, horse_registered_name, horse_nick_name, gated, warm_blood, registered, fk_i_breed_id, fk_i_secondbreed_id, registration_associations, registration_num, month_foaled, year_foaled, gender, mare_in_foal, covering_sire, base_color, other_color, height_in_hands, approx_weight, temperament, skills, trade) VALUES ('%d', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%s', '%f', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d')",
				DB_TABLE_PREFIX,
				$item_id,
				Params::getParam("h_registered_name"),
				Params::getParam("h_nickname"),
				(Params::getParam("h_gated")!='') ? 1 : 0,
				(Params::getParam("h_warm_blood")!='') ? 1 : 0,
				(Params::getParam("h_registered")!='') ? 1 : 0,
				Params::getParam("breed"),
				Params::getParam("secondbreed"),
				Params::getParam("h_registration_assoc"),
				Params::getParam("h_registration_num"),
				Params::getParam("h_month_foaled"),
				Params::getParam("h_year_foaled"),
				Params::getParam("h_gender"),
				(Params::getParam("h_mare_foal")!='') ? 1 : 0,
				(Params::getParam("H_cover_sire")!='') ? 1 : 0,
				Params::getParam("h_base_color"),
				Params::getParam("h_other_color"),
				Params::getParam("h_height"),
				Params::getParam("h_weight"),
				Params::getParam("h_temp"),
				$Hskills,
				(Params::getParam("h_trade")!='') ? 1 : 0
			);
		}
	}
}


function horse_admin_menu() {
    echo '<h3><a href="#">'. __('Horse plugin','horse_attr') . '</a></h3>
    <ul> 
        <li><a href="'.osc_admin_configure_plugin_url("horse_attributes/index.php").'">&raquo; '.__('Configure plugin', 'horse_attr').'</a></li>
        <li><a href="'.osc_admin_render_plugin_url("horse_attributes/conf.php").'?section=breeds">&raquo; '.__('Manage breeds', 'horse_attr').'</a></li>
        <li><a href="'.osc_admin_render_plugin_url("horse_attributes/conf.php").'?section=secondbreeds">&raquo; '.__('Manage secondbreeds', 'horse_attr').'</a></li>
        <li><a href="'.osc_admin_render_plugin_url("horse_attributes/conf.php").'?section=types">&raquo; '.__('Manage vehicle types', 'horse_attr').'</a></li>
    </ul>';
}

function horse_delete_item($item) {
    $conn = getConnection();
    $conn->osc_dbExec("DELETE FROM %st_item_horse_attr WHERE fk_i_item_id = '" . $item . "'", DB_TABLE_PREFIX);
}


function horse_admin_configuration() {

	// Standard configuration page for plugin which extend item's attributes
	osc_plugin_configure_view(__FILE__);

}
function horse_header() {

	echo "\n";
    echo '<!-- horse_attributes_js -->
    	<script type="text/javascript" src="' . osc_base_url() . "oc-content/plugins/horse_attributes/js/jquery.field.min.js" . '">
     		
	</script>';
	
	?>
	<script>
  $(document).ready(function(){
  if($("form[name=item]").length){
   $("form[name=item]").validate({
  rules:{
    	breed: {
		required: true
	},
	h_registered_name: {
		required: true
	},
	h_year_foaled: {
		required: true
	},
	h_gender: {
		requried: true
	},
	h_base_color: {
		requried: true
	}
  },
  messages: {
    breed: {
    	required: "<?php _e('Please select a breed','horse_attr');?>",
    },
    h_registered_name: {
    	required: "<?php _e('Please enter the horse\'s registered name','horse_attr');?>",
    },
    h_year_foaled: {
    	required: "<?php _e('Please select a year','horse_attr');?>",
    },
    h_gender: {
    	required: "<?php _e('Please select a gender','horse_attr');?>",
    },
    h_base_color: {
    	required: "<?php _e('Please choose a base color','horse_attr');?>",
    }
  }
  })
  }
  });
  </script>
  <?php
  

}

function horse_pre_item_post() {
        $gated = (Params::getParam("h_gated")!='') ? 1 : 0 ;
        $warmBlood = (Params::getParam("h_warm_blood")!='') ? 1 : 0 ;
        $reg = (Params::getParam("h_registered")!='') ? 1 : 0 ;
        $mare_foal = (Params::getParam("h_mare_foal")!='') ? 1 : 0 ;
        $cover_sire = (Params::getParam("h_cover_sire")!='') ? 1 : 0 ;
        $trade = (Params::getParam("h_trade")!='') ? 1 : 0 ;

        Session::newInstance()->_setForm('ha_reg_name' ,Params::getParam("h_registered_name") );
        Session::newInstance()->_setForm('ha_nickname' ,Params::getParam("h_nick_name") );
        Session::newInstance()->_setForm('ha_gated' ,$gated );
        Session::newInstance()->_setForm('ha_warm_blood' ,$warmBlood );
        Session::newInstance()->_setForm('ha_reg' ,$reg );
        Session::newInstance()->_setForm('ha_breed' ,Params::getParam("breed") );
        Session::newInstance()->_setForm('ha_second_breed' ,Params::getParam("secondbreed") );
        Session::newInstance()->_setForm('ha_reg_assoc' ,Params::getParam("h_registration_assoc") );
        Session::newInstance()->_setForm('ha_reg_num' ,Params::getParam("h_registration_num") );
        Session::newInstance()->_setForm('ha_month' ,Params::getParam("h_month_foaled") );
        Session::newInstance()->_setForm('ha_year' ,Params::getParam("h_year_foaled") );
        Session::newInstance()->_setForm('ha_gender' ,Params::getParam("h_gender") );
        Session::newInstance()->_setForm('ha_mare_foal' ,$mare_foal );
        Session::newInstance()->_setForm('ha_cover_sire' ,$cover_sire );
        Session::newInstance()->_setForm('ha_base_color' ,Params::getParam("h_base_color") );
        Session::newInstance()->_setForm('ha_other_color' ,Params::getParam("h_other_color") );
        Session::newInstance()->_setForm('ha_height' ,Params::getParam("h_height") );
        Session::newInstance()->_setForm('ha_weight' ,Params::getParam("h_weight") );
        Session::newInstance()->_setForm('ha_temp' ,Params::getParam("h_temp") );
        Session::newInstance()->_setForm('ha_skills' ,Params::getParam("h_skills") );
        Session::newInstance()->_setForm('ha_trade' ,$trade );
        // keep values on session
        Session::newInstance()->_keepForm('ha_reg_name');
        Session::newInstance()->_keepForm('ha_nickname');
        Session::newInstance()->_keepForm('ha_gated');
        Session::newInstance()->_keepForm('ha_warm_blood');
        Session::newInstance()->_keepForm('ha_reg');
        Session::newInstance()->_keepForm('ha_breed');
        Session::newInstance()->_keepForm('ha_second_breed');
        Session::newInstance()->_keepForm('ha_reg_assoc');
        Session::newInstance()->_keepForm('ha_reg_num');
        Session::newInstance()->_keepForm('ha_month');
        Session::newInstance()->_keepForm('ha_year');
        Session::newInstance()->_keepForm('ha_gender');
        Session::newInstance()->_keepForm('ha_mare_foal');
        Session::newInstance()->_keepForm('ha_cover_sire');
        Session::newInstance()->_keepForm('ha_base_color');
        Session::newInstance()->_keepForm('ha_other_color');
        Session::newInstance()->_keepForm('ha_height');
        Session::newInstance()->_keepForm('ha_weight');
        Session::newInstance()->_keepForm('ha_temp');
        Session::newInstance()->_keepForm('ha_skills');
        Session::newInstance()->_keepForm('ha_trade');
    }

    function save_inputs_into_horse_session() {
        // keep values on session
        Session::newInstance()->_keepForm('ha_reg_name');
        Session::newInstance()->_keepForm('ha_nickname');
        Session::newInstance()->_keepForm('ha_gated');
        Session::newInstance()->_keepForm('ha_warm_blood');
        Session::newInstance()->_keepForm('ha_reg');
        Session::newInstance()->_keepForm('ha_breed');
        Session::newInstance()->_keepForm('ha_second_breed');
        Session::newInstance()->_keepForm('ha_reg_assoc');
        Session::newInstance()->_keepForm('ha_reg_num');
        Session::newInstance()->_keepForm('ha_month');
        Session::newInstance()->_keepForm('ha_year');
        Session::newInstance()->_keepForm('ha_gender');
        Session::newInstance()->_keepForm('ha_mare_foal');
        Session::newInstance()->_keepForm('ha_cover_sire');
        Session::newInstance()->_keepForm('ha_base_color');
        Session::newInstance()->_keepForm('ha_other_color');
        Session::newInstance()->_keepForm('ha_height');
        Session::newInstance()->_keepForm('ha_weight');
        Session::newInstance()->_keepForm('ha_temp');
        Session::newInstance()->_keepForm('ha_skills');
        Session::newInstance()->_keepForm('ha_trade');
    }

// This is needed in order to be able to activate the plugin
osc_register_plugin(__FILE__, 'horse_call_after_install');
// This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(__FILE__."_configure", 'horse_admin_configuration');
// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(__FILE__."_uninstall", 'horse_call_after_uninstall');

// Add js to header
osc_add_hook('header', 'horse_header');

// When publishing an item we show an extra form with more attributes
osc_add_hook('item_form', 'horse_form');

// To add that new information to our custom table
osc_add_hook('item_form_post', 'horse_form_post');

// When searching, display an extra form with our plugin's fields
osc_add_hook('search_form', 'horse_search_form');

// When searching, add some conditions
osc_add_hook('search_conditions', 'horse_search_conditions');

// Show an item special attributes
osc_add_hook('item_detail', 'horse_item_detail');

// Edit an item special attributes
osc_add_hook('item_edit', 'horse_item_edit');

// Edit an item special attributes POST
osc_add_hook('item_edit_post', 'horse_item_edit_post');

//
osc_add_hook('admin_menu', 'horse_admin_menu');

//Delete locale
osc_add_hook('delete_locale', 'horse_delete_locale');

//Delete item
osc_add_hook('delete_item', 'horse_delete_item');

// previous to insert item
osc_add_hook('pre_item_post', 'horse_pre_item_post') ;

// save input values into session
osc_add_hook('save_input_session', 'save_inputs_into_horse_session' );

?>
