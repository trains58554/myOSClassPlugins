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
?>

<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 0 20px 20px;">
        <div>
            <fieldset>
                <legend>
                    <h1><?php _e('Offer Button Help', 'offerButton'); ?></h1>
                </legend>
                <h2>
                    <?php _e('What is the Offer Button Plugin?', 'offerButton'); ?>
                </h2>
                <p>
                    <?php _e('The Offer Button Plugin creates a new and quicker way for buyers to submit offers to the seller.', 'offerButton'); ?>
                </p>
                <h2>
                    <?php _e('How does Offer Button plugin work?', 'offerButton'); ?>
                </h2>
                <p>
                    <?php _e('This plugin places a button on items that the user wants to accept offers on. Then the user can easly submit his/her offer to the seller.', 'offerButton'); ?>
                </p>
                <h2>
                    <?php _e('How do I install the  Offer Button plugin?', 'offerButton'); ?>
                </h2>
                <p>
                    <?php _e('You have to edit your item.php file in your theme folder. Then add the following line &lt;?php offerButton(); ?&gt; anywhere you want the offer button to show up.', 'offerButton'); ?>
                </p>
                <h2>
                    <?php _e('How do I edit the email templates?', 'offerButton'); ?>
                </h2>
                <p>
                    <?php _e('To edit the email templates you have to go under the Email & Alerts menu. Then you will see towards the end of the list two email templates.', 'offerButton'); ?>
                </p>
                <h2>
                    <?php _e('Which email template is for the seller and which is for the buyer?', 'offerButton'); ?>
                </h2>
                <p>
                    <?php _e('The "email_new_offer" template is for the seller and the "email_offer_status" template is for the buyers.', 'offerButton'); ?>
                </p>
                <h2>
                    <?php _e('What are the dynamic tags that can be used in the "email_new_offer" template?', 'offerButton'); ?>
                </h2>
                <p>
                    <?php _e('{ITEM_ID}, {CONTACT_NAME}, {CONTACT_EMAIL}, {WEB_URL}, {ITEM_TITLE}, {ITEM_URL}, {WEB_TITLE}, {OFFER_URL}, {OFFER_VALUE}.', 'offerButton'); ?>
                </p>
                <h2>
                    <?php _e('What are the dynamic tags that can be used in the "email_offer_status" template?', 'offerButton'); ?>
                </h2>
                <p>
                    <?php _e('{ITEM_ID}, {CONTACT_NAME}, {CONTACT_EMAIL}, {WEB_URL}, {ITEM_TITLE}, {ITEM_URL}, {WEB_TITLE}, {SELLER_EMAIL}, {OFFER_STATUS}, {OFFER_STATUS_URL}, {SELLER_PHONE}.', 'offerButton'); ?>
                </p>
            </fieldset>
        </div>
    </div>
</div>
