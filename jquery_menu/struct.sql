CREATE TABLE /*TABLE_PREFIX*/t_jMenu(
	 id   int(10) unsigned NOT NULL,
    p_id int(10),
    c_id int(10), 
    menu_name varchar(25),
    menu_url varchar(300),
	
        PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';
