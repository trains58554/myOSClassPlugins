ALTER TABLE /*TABLE_PREFIX*/t_offer_button ADD user_locked INT(2) DEFAULT "0" AFTER offer_status;
ALTER TABLE /*TABLE_PREFIX*/t_offer_button ADD b_name VARCHAR(50) AFTER user_id;
ALTER TABLE /*TABLE_PREFIX*/t_offer_button ADD b_email VARCHAR(50) AFTER b_name;
ALTER TABLE /*TABLE_PREFIX*/t_offer_button ADD b_email INT(1) DEFAULT "0" AFTER offer_value;
ALTER TABLE /*TABLE_PREFIX*/t_offer_button ADD sDelete INT(2) DEFAULT "0" AFTER offer_date;
ALTER TABLE /*TABLE_PREFIX*/t_offer_button ADD offer_type INT(2) DEFAULT "1" AFTER user_locked;

ALTER TABLE /*TABLE_PREFIX*/t_offer_item_options ADD b_offerMonetary BOOLEAN AFTER b_offerYes;
ALTER TABLE /*TABLE_PREFIX*/t_offer_item_options ADD b_offerTrade BOOLEAN AFTER b_offerMonetary;

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_offer_reason(
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
	 reason varchar(100),
	 
        PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_offer_user_locked(
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
	 seller_id int(11),
	 user_id int(11),
	 email varchar (50),
	 reason_code int(11),
	 locked int(1),
	 
        PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';
