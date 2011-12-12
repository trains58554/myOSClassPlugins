CREATE TABLE /*TABLE_PREFIX*/t_offer_button(
id int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
user_id int( 10 ) ,
b_name VARCHAR( 50),
b_email VARCHAR( 50),
seller_id int( 10 ) ,
item_id int(10) ,
offer_value FLOAT,
offer_status int(2),
user_locked int(2),
offer_type int(2) DEFAULT "1",
offer_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
sDelete int(2)DEFAULT "0",
oNew int (1),
PRIMARY KEY ( id )
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_offer_item_options(
    fk_i_item_id int(10) unsigned NOT NULL,
    b_offerYes BOOLEAN,
	 b_offerMonetary BOOLEAN,
	 b_offerTrade BOOLEAN,
	 
        PRIMARY KEY (fk_i_item_id),
        FOREIGN KEY (fk_i_item_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_offer_options(
    id int(10) unsigned NOT NULL,
	 allow_locking int(2),
	 allow_contact_email int(2),
	 
        PRIMARY KEY (id),

) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_offer_reason(
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
	 reason varchar(100),
	 
        PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_offer_user_locked(
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
	 seller_id int(11),
	 user_id int(11),
	 email varchar (50),
	 reason_code int(11),
	 locked int(1),
	 
        PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';
