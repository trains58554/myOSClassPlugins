CREATE TABLE /*TABLE_PREFIX*/t_offer_button(
id int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
user_id int( 10 ) ,
seller_id int( 10 ) ,
item_id int(10) ,
offer_value FLOAT,
offer_status int(2),
offer_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY ( id )
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_offer_item_options(
    fk_i_item_id int(10) unsigned NOT NULL,
    b_offerYes BOOLEAN,
	
        PRIMARY KEY (fk_i_item_id),
        FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';
