<?php include('ajax-redeem.php'); ?>
<?php if(osc_is_web_user_logged_in() ) { ?>

<div class="content user_account">
    <h1>
        <strong><?php _e('Promotion Code', 'promo'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
     <div id="main">
     <form id="promo-code-form" action="ajax_redeem.php" method="POST" onsubmit="return false;">   
        <p><label for="promo_code"><?php _e('Enter Promotion Code', 'promo'); ?>:</label> <input id="promo_codes" name="promo_codes" type="text" />
        <input type="submit" value="<?php _e('Redeem', 'promo'); ?>" /></p>
     </form>
     <br />
     <span id="promo-message"></span>
     </div>
</div>
<?php } else { 
// HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php } ?>
