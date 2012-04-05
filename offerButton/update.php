<?php
$override = Params::getParam('force');
/*update section */ 
if ((osc_get_preference('offerButton_version', 'plugin-offer') == '' ) || (obVersion() > osc_offerButton_version() ) || ($override == 1)){
  	update(obVersion());
}else {
  	echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('The Offer Button is up to date', 'offerButton') . '.</p></div>';
}

function update($version) {
	if($version < '2.0'){

		ModelOffer::newInstance()->import('offerButton/update.sql');

		osc_set_preference('offerButton_version', '2.0', 'plugin-offer', 'INTEGER');
		osc_set_preference('offerButton_locking', '0', 'plugin-offer', 'INTEGER');
		osc_set_preference('offerButton_email', '1', 'plugin-offer', 'INTEGER');
		osc_set_preference('offerButton_email_temps', '1', 'plugin-offer', 'INTEGER');
		osc_set_preference('offerButton_delOff', '0', 'plugin-offer', 'INTEGER');
		osc_set_preference('offerButton_usersOnly', '1', 'plugin-offer', 'INTEGER');
		osc_set_preference('offerButton_trade', '0', 'plugin-offer', 'INTEGER');
		osc_set_preference('offerButton_text', '1', 'plugin-offer', 'INTEGER');
   }
	if($version == '2.0') {
	   osc_set_preference('offerButton_text', '1', 'plugin-offer', 'INTEGER');
	}
	
	echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Offer Button Updated to version', 'offerButton') . ' ' . osc_offerButton_version() . '.</p></div>';
}
?>