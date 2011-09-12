CREATE TABLE /*TABLE_PREFIX*/t_item_horse_breed_attr (
    pk_i_id INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    s_name VARCHAR(255),
	
        
        PRIMARY KEY (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_item_horse_secondbreed_attr (
    pk_i_id INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    fk_i_breed_id INT(2) UNSIGNED NOT NULL,
    s_name VARCHAR(255),

        PRIMARY KEY (pk_i_id),
        FOREIGN KEY (fk_i_breed_id) REFERENCES /*TABLE_PREFIX*/t_item_horse_breed_attr (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_item_horse_skills_attr (
    pk_i_id INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    s_name VARCHAR(255),
	
        
        PRIMARY KEY (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_item_horse_attr (
    fk_i_item_horse_id INT(10) UNSIGNED NOT NULL,
    horse_registered_name  varchar(25),
    horse_nick_name varchar(25),
    gated INT(1),
    warm_blood INT(1),
    registered INT(1),
    fk_i_breed_id INT(2) UNSIGNED,
    fk_i_secondbreed_id INT(2) UNSIGNED,
    registration_associations varchar(255),
    registration_num float,
    month_foaled INT(2),
    year_foaled INT(4),
    gender INT(1),
    mare_in_foal BOOLEAN,
    covering_sire INT(1),
    base_color INT(4),
    other_color VARCHAR(100),
    height_in_hands INT(4),
    approx_weight INT(4),
    temperament INT(2),
    skills VARCHAR(100),
    trade BOOLEAN,
    
        INDEX (fk_i_item_horse_id),
        PRIMARY KEY (fk_i_item_horse_id),
        FOREIGN KEY (fk_i_item_horse_id) REFERENCES /*TABLE_PREFIX*/t_item (pk_i_id),
        FOREIGN KEY (fk_i_breed_id) REFERENCES /*TABLE_PREFIX*/t_item_horse_breed_attr (pk_i_id),
        FOREIGN KEY (fk_i_secondbreed_id) REFERENCES /*TABLE_PREFIX*/t_item_horse_secondbreed_attr (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

