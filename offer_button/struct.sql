CREATE TABLE /*TABLE_PREFIX*/t_offer_button(
id int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
user_id int( 10 ) ,
Seller_id int( 10 ) ,
offer_date VARCHAR( 10 ) ,
offer_value FLOAT,
offer_status int(2),
PRIMARY KEY ( id )
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI'

