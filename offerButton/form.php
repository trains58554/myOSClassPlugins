
<h3><?php _e('Offer Button Options','offer_button') ; ?></h3>

<table>
<tr>
	<td>
	<input type="checkbox" name="offerYes" id="offerYes" value="1" checked /> <label><?php _e('Add Offer Button','offer_button'); ?></label><br />
	</td>
</tr>
<?php if(osc_offerButton_trade() == 1) { ?>
<tr>
	<td>
	<input type="checkbox" name="offerTrade" id="offerTrade" value="1" checked /> <label><?php _e('Allow Trades','offer_button'); ?></label><br />
	</td>
</tr>
<?php } ?>
</table>

<script type="text/javascript">
    tabberAutomatic();
</script>
