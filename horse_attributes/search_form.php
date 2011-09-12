
<h3><?php _e('Cars attributes') ; ?></h3>

<table>
<tr>
	<td><label for="type"><?php echo __('Type'); ?></label></td>
	<td><input type="text" name="type" id="type" value="" /></td>
</tr>
<tr>
	<td><label for="secondbreed"><?php echo __('Secondary Breed'); ?></label></td>
	<td><input type="text" name="secondbreed" id="secondbreed" value="" /></td>
</tr>
<tr>
	<td><label for="numAirbags"><?php echo __('Num. of airbags'); ?></label></td>
	<td>
	<select name="numAirbags" id="numAirbags">
		<?php foreach(range(0, 8) as $n): ?>
			<option value="<?php echo $n; ?>"><?php echo $n; ?></option>
		<?php endforeach; ?>
	</select>
	</td>
</tr>
<tr>
	<td><label for="warmblood"><?php echo __('Warmblood?'); ?></label></td>
	<td>
		<input type="radio" name="warmblood" value="Yes" id="yes" /> <label for="yes"><?php echo __('Yes'); ?></label><br />
		<input type="radio" name="warmblood" value="No" id="no" /> <label for="no"><?php echo __('No'); ?></label><br />
	</td>
</tr>
<tr>
	<td><label for="gaited"><?php echo __('Gaited?'); ?></label></td>
	<td>
		<input type="radio" name="gaited" value="Yes" id="yes" /> <label for="yes"><?php echo __('Yes'); ?></label><br />
		<input type="radio" name="warmblood" value="No" id="no" /> <label for="no"><?php echo __('No'); ?></label><br />
	</td>
</tr>
</table>
