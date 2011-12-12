
<h3 class="offerPostOptions"><?php _e('Offer Button Options','offer_button') ; ?></h3>

<table>

<tr>
	<td>
	<input type="checkbox" name="offerYes" id="offerYes" value="1" <?php if($detail['b_offerYes']==1) {echo 'checked="yes"';};?>/> <label class="offerYes"><?php echo __('Add Offer Button','offer_button'); ?></label><br />
	</td>
</tr>
<?php if(osc_offerButton_trade() == 1) { ?>
<tr>
	<td>
	<input type="checkbox" name="offerTrade" id="offerTrade" value="1" <?php if($detail['b_offerTrade']==1) {echo 'checked="yes"';};?>/> <label class="offerType"><?php echo __('Allow trades','offer_button'); ?></label><br />
	</td>
</tr>
<?php } ?>
</table>

