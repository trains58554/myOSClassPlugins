<script type="text/javascript">
    $(document).ready(function(){
        $("#breed").change(function(){
            var breed_id = $(this).val();
            var url = '<?php echo osc_ajax_plugin_url('horse_attributes/ajax.php') . '&breedId='; ?>' + breed_id;
            var result = '';
            if(breed_id != '') {
                $("#secondbreed").attr('disabled',false);
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    success: function(data){
                        var length = data.length;
                        if(length > 0) {
                            result += '<option value="" selected><?php _e('Select a model', 'horse_attri'); ?></option>';
                            for(key in data) {
                                result += '<option value="' + data[key].pk_i_id + '">' + data[key].s_name + '</option>';
                            }
                        } else {
                            result += '<option value=""><?php _e('No results', 'horse_attr'); ?></option>';
                        }
                        $("#secondbreed").html(result);
                        if (typeof $.uniform != 'undefined') {
                            $.uniform.restore('#secondbreed');
                            $("#secondbreed").uniform();
                        }
                    }
                 });
             } else {
                result += '<option value="" selected><?php _e('Select a model', 'horse_attr'); ?></option>';
                $("#secondbreed").attr('disabled',true);
                $("#secondbreed").html(result);
                if (typeof $.uniform != 'undefined') {
                    $.uniform.restore('#secondbreed');
                    $("#secondbreed").uniform();
                }
             }
        });
        
        // uniform()
        if (typeof $.uniform != 'undefined') {
            $('#plugin-hook input:text, select#breed, select#secondbreed, select#h_month_foaled, select#h_year_foaled, select#h_base_color, select#h_height, select#h_weight').uniform();
        }
    });
</script>
<h3><?php _e('Horse attributes','horse_attr') ; ?></h3>

<table>
<tr>
	<td><label><?php _e('Breed','horse_attr'); ?> *</label></td>
	<td>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_breed') != '' ) {
                $detail['fk_i_breed_id'] = Session::newInstance()->_getForm('ha_breed');
            }
        ?>
    <select name="breed" id="breed" >
        <option value=""><?php  _e('Select a breed','horse_attr'); ?></option>
		<?php foreach($breed as $a): ?>
			<option value="<?php echo $a['pk_i_id']; ?>" <?php if(@$detail['fk_i_breed_id'] == $a['pk_i_id']){echo 'selected'; } ?>><?php echo $a['s_name']; ?></option>
		<?php endforeach; ?>
	</select>
    </td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_second_breed') != '' ) {
                $detail['fk_i_secondbreed_id'] = Session::newInstance()->_getForm('ha_second_breed');
            }
        ?>
	<td><label><?php _e('Secondary Breed','horse_attr'); ?></label></td>
	<td>
    <select name="secondbreed" id="secondbreed">
    	<option value="" ><?php _e('Select a second breed', 'horse_attr'); ?></option>
            <?php foreach($secondbreed as $a) { ?>
            <option value="<?php echo $a['pk_i_id']; ?>" <?php if(@$detail['fk_i_secondbreed_id'] == $a['pk_i_id']) { echo 'selected'; } ?>><?php echo $a['s_name']; ?></option>
            <?php } ?>
	</select>
    </td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_reg_name') != '' ) {
                $detail['horse_registered_name'] = Session::newInstance()->_getForm('ha_reg_name');
            }
        ?>
	<td><label><?php _e('Horse\'s Registered Name','horse_attr'); ?> *</label></td>
	<td><input type="text" name="h_registered_name" id="h_registered_name" class="requir" value="<?php if(@$detail['horse_registered_name'] != ''){echo @$detail['horse_registered_name'];}?>" /></td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_nickname') != '' ) {
                $detail['horse_nick_name'] = Session::newInstance()->_getForm('ha_nickname');
            }
        ?>
	<td><label><?php _e('horse\'s Nickname','horse_attr'); ?></label></td>
	<td><input type="text" name="h_nickname" id="h_nickname" value="<?php if(@$detail['horse_nick_name'] != ''){echo @$detail['horse_nick_name'];}?>" /></td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_gated') != '' ) {
                $detail['gated'] = Session::newInstance()->_getForm('ha_gated');
            }
        ?>
	<td><label><?php _e('Gated','horse_attr'); ?></label></td>
	<td>
    		<input type="radio" name="h_gated" value="1" <?php if(@$detail['gated'] == 1){echo 'checked';}?>><?php _e('Yes','horse_attr');?><br>
		<input type="radio" name="h_gated" value="0" <?php if(@$detail['gated'] == 0){echo 'checked';}?>><?php _e('No','horse_attr');?> 
    	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_warm_blood') != '' ) {
                $detail['warm_blood'] = Session::newInstance()->_getForm('ha_warm_blood');
            }
        ?>
	<td><label><?php _e('Warm Blooded','horse_attr'); ?>?</label></td>
	<td>
    		<input type="radio" name="h_warm_blood" value="1" <?php if(@$detail['warm_blood'] == 1){echo 'checked';}?>><?php _e('Yes','horse_attr');?><br>
		<input type="radio" name="h_warm_blood" value="0" <?php if(@$detail['warm_blood'] == 0){echo 'checked';}?>><?php _e('No','horse_attr');?> 
    	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_reg') != '' ) {
                $detail['registered'] = Session::newInstance()->_getForm('ha_reg');
            }
        ?>
	<td><label><?php _e('Registered','horse_attr'); ?>?</label></td>
	<td><input type="checkbox" name="h_registered" id="h_registered" value="1" <?php if(@$detail['registered'] == 1){echo 'checked';}?> /></td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_reg_assoc') != '' ) {
                $detail['registration_associations'] = Session::newInstance()->_getForm('ha_reg_assoc');
            }
        ?>
	<td><label><?php _e('Registration Associations','horse_attr'); ?></label></td>
	<td><input type="text" name="h_registration_assoc" id="h_registration_assoc" value="<?php if(@$detail['registration_associations'] != ''){echo @$detail['registration_associations'];}?>" /></td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_reg_num') != '' ) {
                $detail['registration_num'] = Session::newInstance()->_getForm('ha_reg_num');
            }
        ?>
	<td><label><?php _e('Registration #','horse_attr'); ?></label></td>
	<td><input type="text" name="h_registration_num" id="h_registration_num" value="<?php if(@$detail['registration_num'] != ''){echo @$detail['registration_num'];}?>" /></td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_month') != '' ) {
                $detail['month_foaled'] = Session::newInstance()->_getForm('ha_month');
            }
        ?>
	<td><label><?php _e('Month Foaled','horse_attr'); ?>?</label></td>
	<td>
    	<select name="h_month_foaled" id="h_month_foaled">
    		<option value=""><?php _e('Please select a month','horse_attr');?></option>
		<option value="1" <?php if(@$detail['month_foaled'] == 1) { echo 'selected'; } ?>><?php _e('January','horse_attr');?></option>
		<option value="2" <?php if(@$detail['month_foaled'] == 2) { echo 'selected'; } ?>><?php _e('Febuary','horse_attr');?></option>
		<option value="3" <?php if(@$detail['month_foaled'] == 3) { echo 'selected'; } ?>><?php _e('March','horse_attr');?></option>
		<option value="4" <?php if(@$detail['month_foaled'] == 4) { echo 'selected'; } ?>><?php _e('April','horse_attr');?></option>
		<option value="5" <?php if(@$detail['month_foaled'] == 5) { echo 'selected'; } ?>><?php _e('May','horse_attr');?></option>
		<option value="6" <?php if(@$detail['month_foaled'] == 6) { echo 'selected'; } ?>><?php _e('June','horse_attr');?></option>
		<option value="7" <?php if(@$detail['month_foaled'] == 7) { echo 'selected'; } ?>><?php _e('July','horse_attr');?></option>
		<option value="8" <?php if(@$detail['month_foaled'] == 8) { echo 'selected'; } ?>><?php _e('August','horse_attr');?></option>
		<option value="9" <?php if(@$detail['month_foaled'] == 9) { echo 'selected'; } ?>><?php _e('September','horse_attr');?></option>
		<option value="10" <?php if(@$detail['month_foaled'] == 10) { echo 'selected'; } ?>><?php _e('October','horse_attr');?></option>
		<option value="11" <?php if(@$detail['month_foaled'] == 11) { echo 'selected'; } ?>><?php _e('November','horse_attr');?></option>
		<option value="12" <?php if(@$detail['month_foaled'] == 12) { echo 'selected'; } ?>><?php _e('December','horse_attr');?></option>
	</select>
    	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_year') != '' ) {
                $detail['year_foaled'] = Session::newInstance()->_getForm('ha_year');
            }
        ?>
	<td><label><?php _e('Year Foaled','horse_attr'); ?>? *</label></td>
	<td>
	<select name="h_year_foaled" id="h_year_foaled">
			<option value=""><?php _e('Please select a year','horse_attr');?></option>
			<option value="<?php echo date('Y');?>" <?php if(@$detail['year_foaled'] == date('Y')) { echo 'selected'; } ?>><?php echo date('Y');?></option>
        	<?php for($i=0; $i <= 30; $i++){ ?>
        		<?php $yDate = date('Y',mktime(0,0,0,0,0,date('Y')-$i));?>
			<option value="<?php echo $yDate; ?>" <?php if(@$detail['year_foaled'] == $yDate) { echo 'selected'; } ?>><?php echo $yDate; ?></option>
		<?php } ?>
			<option value="0">Unknown</option>
    	</select>
    	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_gender') != '' ) {
                $detail['gener'] = Session::newInstance()->_getForm('ha_gender');
            }
        ?>
	<td><label><?php _e('Gender','horse_attr'); ?> *</label></td>
	<td>
		<input type="radio" name="h_gender" value="1" <?php if(@$detail['gender'] == 1) { echo 'checked'; } ?>><?php _e('Mare','horse_attr');?>
		<input type="radio" name="h_gender" value="2" <?php if(@$detail['gender'] == 2) { echo 'checked'; } ?>><?php _e('Gelding','horse_attr');?>
		<input type="radio" name="h_gender" value="3" <?php if(@$detail['gender'] == 3) { echo 'checked'; } ?>><?php _e('Filly','horse_attr');?>
		<input type="radio" name="h_gender" value="4" <?php if(@$detail['gender'] == 4) { echo 'checked'; } ?>><?php _e('Colt','horse_attr');?>
		<input type="radio" name="h_gender" value="5" <?php if(@$detail['gender'] == 5) { echo 'checked'; } ?>><?php _e('Stallion','horse_attr');?>
		<input type="radio" name="h_gender" value="6" <?php if(@$detail['gender'] == 6) { echo 'checked'; } ?>><?php _e('Unboarn Foal','horse_attr');?><br />
	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_mare_foal') != '' ) {
                $detail['mare_in_foal'] = Session::newInstance()->_getForm('ha_mare_foal');
            }
        ?>
	<td>
		<input type="checkbox" name="h_mare_foal" id="h_mare_foal" value="1" <?php if(@$detail['mare_in_foal'] == 1) { echo 'checked'; } ?> /><label><?php _e('Mare in Foal','horse_attr'); ?>?</label><br />
	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_cover_sire') != '' ) {
                $detail['covering_sire'] = Session::newInstance()->_getForm('ha_cover_sire');
            }
        ?>
	<td>
		<input type="checkbox" name="h_cover_sire" id="h_cover_sire" value="1" <?php if(@$detail['covering_sire'] == 1) { echo 'checked'; } ?> /> <label><?php _e('Covering Sire'); ?>?</label><br />
	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_base_color') != '' ) {
                $detail['base_color'] = Session::newInstance()->_getForm('ha_base_color');
            }
        ?>
	<td><label><?php _e('Base Color','horse_attr'); ?> *</label></td>
	<td>
	<select name="h_base_color" id="h_base_color">
		<option value=""><?php _e('Please Select a color','horse_attr');?></option>
        	<option value="1" <?php if(@$detail['base_color'] == 1) { echo 'selected'; } ?>><?php _e('Bay','horse_attr');?></option>
        	<option value="2" <?php if(@$detail['base_color'] == 2) { echo 'selected'; } ?>><?php _e('Black','horse_attr');?></option>
        	<option value="3" <?php if(@$detail['base_color'] == 3) { echo 'selected'; } ?>><?php _e('Blue Roan','horse_attr');?></option>
        	<option value="4" <?php if(@$detail['base_color'] == 4) { echo 'selected'; } ?>><?php _e('Brindle','horse_attr');?></option>
        	<option value="5" <?php if(@$detail['base_color'] == 5) { echo 'selected'; } ?>><?php _e('Brown','horse_attr');?></option>
        	<option value="6" <?php if(@$detail['base_color'] == 6) { echo 'selected'; } ?>><?php _e('Buckskin','horse_attr');?></option>
        	<option value="7" <?php if(@$detail['base_color'] == 7) { echo 'selected'; } ?>><?php _e('Chestnut','horse_attr');?></option>
        	<option value="8" <?php if(@$detail['base_color'] == 8) { echo 'selected'; } ?>><?php _e('Chocolate','horse_attr');?></option>
        	<option value="9" <?php if(@$detail['base_color'] == 9) { echo 'selected'; } ?>><?php _e('Cremello','horse_attr');?></option>
        	<option value="10" <?php if(@$detail['base_color'] == 11) { echo 'selected'; } ?>><?php _e('Dun','horse_attr');?></option>
        	<option value="11" <?php if(@$detail['base_color'] == 11) { echo 'selected'; } ?>><?php _e('Grey','horse_attr');?></option>
        	<option value="12" <?php if(@$detail['base_color'] == 12) { echo 'selected'; } ?>><?php _e('Grulla','horse_attr');?></option>
        	<option value="13" <?php if(@$detail['base_color'] == 13) { echo 'selected'; } ?>><?php _e('Liver Chestnut','horse_attr');?></option>
        	<option value="14" <?php if(@$detail['base_color'] == 14) { echo 'selected'; } ?>><?php _e('other Palomino','horse_attr');?></option>
        	<option value="15" <?php if(@$detail['base_color'] == 15) { echo 'selected'; } ?>><?php _e('Perlino','horse_attr');?></option>
        	<option value="16" <?php if(@$detail['base_color'] == 16) { echo 'selected'; } ?>><?php _e('Red Dun','horse_attr');?></option>
        	<option value="17" <?php if(@$detail['base_color'] == 17) { echo 'selected'; } ?>><?php _e('Red Roan','horse_attr');?></option>
        	<option value="18" <?php if(@$detail['base_color'] == 18) { echo 'selected'; } ?>><?php _e('Silver','horse_attr');?></option>
        	<option value="19" <?php if(@$detail['base_color'] == 19) { echo 'selected'; } ?>><?php _e('Smokey Black','horse_attr');?></option>
        	<option value="20" <?php if(@$detail['base_color'] == 20) { echo 'selected'; } ?>><?php _e('Smokey Cream','horse_attr');?></option>
        	<option value="21" <?php if(@$detail['base_color'] == 21) { echo 'selected'; } ?>><?php _e('Sorrel','horse_attr');?></option>
        	<option value="22" <?php if(@$detail['base_color'] == 22) { echo 'selected'; } ?>><?php _e('White','horse_attr');?></option>
    	</select>
    	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_other_color') != '' ) {
                $detail['other_color'] = Session::newInstance()->_getForm('ha_other_color');
            }
        ?>
	<td><label><?php _e('Other Color, markings or pattern','horse_attr'); ?></label></td> 
	<td><input type="text" name="h_other_color" id="h_other_color" value="<?php if(@$detail['other_color'] != ''){echo @$detail['other_color'];}?>" /></td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_height') != '' ) {
                $detail['height_in_hands'] = Session::newInstance()->_getForm('ha_height');
            }
        ?>
	<td><label><?php _e('Height in Hands','horse_attr'); ?></label></td> 
	<td>
	<select name="h_height" id="h_height">
		<option value=""><?php _e('Please select a height','horse_attr');?></option>
        	<option value="1" <?php if(@$detail['height_in_hands'] == 1) { echo 'selected'; } ?>><?php _e('5.0 hh (20in)','horse_attr');?></option>
        	<option value="2" <?php if(@$detail['height_in_hands'] == 2) { echo 'selected'; } ?>><?php _e('6.0 hh (24in)','horse_attr');?></option>
        	<option value="3" <?php if(@$detail['height_in_hands'] == 3) { echo 'selected'; } ?>><?php _e('7.0 hh (28in)','horse_attr');?></option>
        	<option value="4" <?php if(@$detail['height_in_hands'] == 4) { echo 'selected'; } ?>><?php _e('8.0 hh (32in)','horse_attr');?></option>
        	<option value="5" <?php if(@$detail['height_in_hands'] == 5) { echo 'selected'; } ?>><?php _e('8.2 hh (34in)','horse_attr');?></option>
        	<option value="6" <?php if(@$detail['height_in_hands'] == 6) { echo 'selected'; } ?>><?php _e('9.0 hh (36in)','horse_attr');?></option>
        	<option value="7" <?php if(@$detail['height_in_hands'] == 7) { echo 'selected'; } ?>><?php _e('9.2 hh (38in)','horse_attr');?></option>
        	<option value="8" <?php if(@$detail['height_in_hands'] == 8) { echo 'selected'; } ?>><?php _e('10.0 hh (40in)','horse_attr');?></option>
        	<option value="9" <?php if(@$detail['height_in_hands'] == 9) { echo 'selected'; } ?>><?php _e('10.2 hh (42in)','horse_attr');?></option>
        	<option value="10" <?php if(@$detail['height_in_hands'] == 10) { echo 'selected'; } ?>><?php _e('11.0 hh (44in)','horse_attr');?></option>
        	<option value="11" <?php if(@$detail['height_in_hands'] == 11) { echo 'selected'; } ?>><?php _e('11.2 hh (46in)','horse_attr');?></option>
        	<option value="12" <?php if(@$detail['height_in_hands'] == 12) { echo 'selected'; } ?>><?php _e('12.0 hh (48in)','horse_attr');?></option>
        	<option value="13" <?php if(@$detail['height_in_hands'] == 13) { echo 'selected'; } ?>><?php _e('12.1 hh (49in)','horse_attr');?></option>
        	<option value="14" <?php if(@$detail['height_in_hands'] == 14) { echo 'selected'; } ?>><?php _e('12.2 hh (50in)','horse_attr');?></option>
        	<option value="15" <?php if(@$detail['height_in_hands'] == 15) { echo 'selected'; } ?>><?php _e('12.3 hh (51in)','horse_attr');?></option>
        	<option value="16" <?php if(@$detail['height_in_hands'] == 16) { echo 'selected'; } ?>><?php _e('13.0 hh','horse_attr');?></option>
        	<option value="17" <?php if(@$detail['height_in_hands'] == 17) { echo 'selected'; } ?>><?php _e('13.1 hh','horse_attr');?></option>
        	<option value="18" <?php if(@$detail['height_in_hands'] == 18) { echo 'selected'; } ?>><?php _e('13.2 hh','horse_attr');?></option>
        	<option value="19" <?php if(@$detail['height_in_hands'] == 19) { echo 'selected'; } ?>><?php _e('13.3 hh','horse_attr');?></option>
        	<option value="20" <?php if(@$detail['height_in_hands'] == 20) { echo 'selected'; } ?>><?php _e('14.0 hh','horse_attr');?></option>
        	<option value="21" <?php if(@$detail['height_in_hands'] == 21) { echo 'selected'; } ?>><?php _e('14.1 hh','horse_attr');?></option>
        	<option value="22" <?php if(@$detail['height_in_hands'] == 22) { echo 'selected'; } ?>><?php _e('14.2 hh','horse_attr');?></option>
        	<option value="23" <?php if(@$detail['height_in_hands'] == 23) { echo 'selected'; } ?>><?php _e('14.3 hh','horse_attr');?></option>
        	<option value="24" <?php if(@$detail['height_in_hands'] == 24) { echo 'selected'; } ?>><?php _e('15.0 hh','horse_attr');?></option>
        	<option value="25" <?php if(@$detail['height_in_hands'] == 25) { echo 'selected'; } ?>><?php _e('15.1 hh','horse_attr');?></option>
        	<option value="26" <?php if(@$detail['height_in_hands'] == 26) { echo 'selected'; } ?>><?php _e('15.2 hh','horse_attr');?></option>
        	<option value="27" <?php if(@$detail['height_in_hands'] == 27) { echo 'selected'; } ?>><?php _e('15.3 hh','horse_attr');?></option>
        	<option value="28" <?php if(@$detail['height_in_hands'] == 28) { echo 'selected'; } ?>><?php _e('16.0 hh','horse_attr');?></option>
        	<option value="29" <?php if(@$detail['height_in_hands'] == 29) { echo 'selected'; } ?>><?php _e('16.1 hh','horse_attr');?></option>
        	<option value="30" <?php if(@$detail['height_in_hands'] == 30) { echo 'selected'; } ?>><?php _e('16.2 hh','horse_attr');?></option>
        	<option value="31" <?php if(@$detail['height_in_hands'] == 31) { echo 'selected'; } ?>><?php _e('16.3 hh','horse_attr');?></option>
        	<option value="32" <?php if(@$detail['height_in_hands'] == 32) { echo 'selected'; } ?>><?php _e('17.0 hh','horse_attr');?></option>
        	<option value="33" <?php if(@$detail['height_in_hands'] == 33) { echo 'selected'; } ?>><?php _e('17.1 hh','horse_attr');?></option>
        	<option value="34" <?php if(@$detail['height_in_hands'] == 34) { echo 'selected'; } ?>><?php _e('18.2 hh','horse_attr');?></option>
        	<option value="35" <?php if(@$detail['height_in_hands'] == 35) { echo 'selected'; } ?>><?php _e('18.3 hh','horse_attr');?></option>
        	<option value="36" <?php if(@$detail['height_in_hands'] == 36) { echo 'selected'; } ?>><?php _e('19.0 hh','horse_attr');?></option>
        	<option value="37" <?php if(@$detail['height_in_hands'] == 37) { echo 'selected'; } ?>><?php _e('19.1 hh','horse_attr');?></option>
        	<option value="38" <?php if(@$detail['height_in_hands'] == 38) { echo 'selected'; } ?>><?php _e('19.2 hh','horse_attr');?></option>
        	<option value="39" <?php if(@$detail['height_in_hands'] == 39) { echo 'selected'; } ?>><?php _e('19.3 hh','horse_attr');?></option>
        	<option value="40" <?php if(@$detail['height_in_hands'] == 40) { echo 'selected'; } ?>><?php _e('20.0 hh','horse_attr');?></option>
        	<option value="41" <?php if(@$detail['height_in_hands'] == 41) { echo 'selected'; } ?>><?php _e('21.0 hh','horse_attr');?></option>
    	</select>
    	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_weight') != '' ) {
                $detail['approx_weight'] = Session::newInstance()->_getForm('ha_weight');
            }
        ?>
	<td><label><?php _e('Weight (lbs)','horse_attr'); ?></label></td> 
	<td>
	<select name="h_weight" id="h_weight">
		<option value=""> <?php _e('Please select a weight','horse_attr');?></option>
        	<option value="1" <?php if(@$detail['approx_weight'] == 1) { echo 'selected'; } ?>><?php _e('200 lbs','horse_attr');?></option>
        	<option value="2" <?php if(@$detail['approx_weight'] == 2) { echo 'selected'; } ?>><?php _e('300 lbs','horse_attr');?></option>
        	<option value="3" <?php if(@$detail['approx_weight'] == 3) { echo 'selected'; } ?>><?php _e('400 lbs','horse_attr');?></option>
        	<option value="4" <?php if(@$detail['approx_weight'] == 4) { echo 'selected'; } ?>><?php _e('500 lbs','horse_attr');?></option>
        	<option value="5" <?php if(@$detail['approx_weight'] == 5) { echo 'selected'; } ?>><?php _e('600 lbs','horse_attr');?></option>
        	<option value="6" <?php if(@$detail['approx_weight'] == 6) { echo 'selected'; } ?>><?php _e('700 lbs','horse_attr');?></option>
        	<option value="7" <?php if(@$detail['approx_weight'] == 7) { echo 'selected'; } ?>><?php _e('800 lbs','horse_attr');?></option>
        	<option value="8" <?php if(@$detail['approx_weight'] == 8) { echo 'selected'; } ?>><?php _e('900 lbs','horse_attr');?></option>
        	<option value="9" <?php if(@$detail['approx_weight'] == 9) { echo 'selected'; } ?>><?php _e('1000 lbs','horse_attr');?></option>
        	<option value="10" <?php if(@$detail['approx_weight'] == 10) { echo 'selected'; } ?>><?php _e('1100 lbs','horse_attr');?></option>
        	<option value="11" <?php if(@$detail['approx_weight'] == 11) { echo 'selected'; } ?>><?php _e('1200 lbs','horse_attr');?></option>
        	<option value="12" <?php if(@$detail['approx_weight'] == 12) { echo 'selected'; } ?>><?php _e('1300 lbs','horse_attr');?></option>
        	<option value="13" <?php if(@$detail['approx_weight'] == 13) { echo 'selected'; } ?>><?php _e('1400 lbs','horse_attr');?></option>
        	<option value="14" <?php if(@$detail['approx_weight'] == 14) { echo 'selected'; } ?>><?php _e('1500 lbs','horse_attr');?></option>
        	<option value="15" <?php if(@$detail['approx_weight'] == 15) { echo 'selected'; } ?>><?php _e('1600 lbs','horse_attr');?></option>
        	<option value="16" <?php if(@$detail['approx_weight'] == 16) { echo 'selected'; } ?>><?php _e('1700 lbs','horse_attr');?></option>
        	<option value="17" <?php if(@$detail['approx_weight'] == 17) { echo 'selected'; } ?>><?php _e('1800 lbs','horse_attr');?></option>
        	<option value="18" <?php if(@$detail['approx_weight'] == 18) { echo 'selected'; } ?>><?php _e('1900 lbs','horse_attr');?></option>
        	<option value="19" <?php if(@$detail['approx_weight'] == 19) { echo 'selected'; } ?>><?php _e('2000 lbs','horse_attr');?></option>
        </select>
        </td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_temp') != '' ) {
                $detail['temperament'] = Session::newInstance()->_getForm('ha_temp');
            }
        ?>
	<td><label><?php _e('Temperment','horse_attr'); ?></label></td> 
	<td>
		<input type="radio" name="h_temp" value="1" <?php if(@$detail['temperament'] == 1) { echo 'checked'; } ?>><?php _e('0 - Bomb Proof','horse_attr');?>
		<input type="radio" name="h_temp" value="2" <?php if(@$detail['temperament'] == 2) { echo 'checked'; } ?>><?php _e('1','horse_attr');?>
		<input type="radio" name="h_temp" value="3" <?php if(@$detail['temperament'] == 3) { echo 'checked'; } ?>><?php _e('2','horse_attr');?>
		<input type="radio" name="h_temp" value="4" <?php if(@$detail['temperament'] == 4) { echo 'checked'; } ?>><?php _e('3','horse_attr');?>
		<input type="radio" name="h_temp" value="5" <?php if(@$detail['temperament'] == 5) { echo 'checked'; } ?>><?php _e('4','horse_attr');?>
		<input type="radio" name="h_temp" value="6" <?php if(@$detail['temperament'] == 6) { echo 'checked'; } ?>><?php _e('5','horse_attr');?>
		<input type="radio" name="h_temp" value="7" <?php if(@$detail['temperament'] == 7) { echo 'checked'; } ?>><?php _e('6','horse_attr');?>
		<input type="radio" name="h_temp" value="8" <?php if(@$detail['temperament'] == 8) { echo 'checked'; } ?>><?php _e('7','horse_attr');?>
		<input type="radio" name="h_temp" value="9" <?php if(@$detail['temperament'] == 9) { echo 'checked'; } ?>><?php _e('8','horse_attr');?>
		<input type="radio" name="h_temp" value="10" <?php if(@$detail['temperament'] == 10) { echo 'checked'; } ?>><?php _e('9','horse_attr');?>
		<input type="radio" name="h_temp" value="11" <?php if(@$detail['temperament'] == 11) { echo 'checked'; } ?>><?php _e('10 - High Strung','horse_attr');?><br />
	</td>
</tr>
<tr>
	<td></td>
	<td><br /><?php _e('Select up to 5 Skills - Disciplines - Attributes','horse_attr'); ?><br /></td> 
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
	    //turn $detail['skills'] back into an array
            //$skillsA = explode(',', $detail['skills']);
            if( Session::newInstance()->_getForm('ha_skills') != '' ) {
                $detail['skills'] = Session::newInstance()->_getForm('ha_skills');
            }
            
        ?>
	<td></td>
	<td>
	<select multiple="true" id="h_skills[]" name="h_skills[]" size=10>
		<?php foreach($skills as $hs): ?>
			<option value="skill<?php echo $hs['pk_i_id'];?>" <?php if(in_array('skill'. $hs['pk_i_id'],$detail['skills'])) { echo 'selected'; } ?>><?php echo $hs['s_name'];?></option>	
		<?php endforeach; ?>
	</select>
	</td>
</tr>
<tr>
	<?php // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('ha_trade') != '' ) {
                $detail['trade'] = Session::newInstance()->_getForm('ha_trade');
            }
        ?>
	<td><label><?php _e('May Trade','horse_attr'); ?></label></td>
	<td>
		<input type="checkbox" name="h_trade" id="h_trade" value="1" <?php if(@$detail['trade'] == 1) { echo 'checked'; } ?> /> 
	</td>
</tr>
</table>
<script>
$('select[name="h_skills[]"]').limitSelection(5);
</script>

