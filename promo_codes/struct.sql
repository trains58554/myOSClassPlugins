CREATE TABLE /*TABLE_PREFIX*/t_promo_code_redeemed (
    id INT(10) unsigned NOT NULL AUTO_INCREMENT,
    fk_i_user_id INT(10) UNSIGNED NOT NULL,
    promo_code_id INT(10) UNSIGNED NOT NULL,
    date_redemed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        FOREIGN KEY (fk_i_user_id) REFERENCES /*TABLE_PREFIX*/t_user (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_promo_code(
id int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
enabled int(1) NOT NULL,
promo_code VARCHAR( 10 ) ,
number_days VARCHAR( 10 ) ,
create_dates VARCHAR( 10 ) ,
max_uses int( 4 ) ,
uses_remaining int( 4 ) ,
promo_value DECIMAL( 6,2 ) ,
PRIMARY KEY ( id )
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI'

