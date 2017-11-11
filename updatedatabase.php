<?php
	require_once($_SERVER["DOCUMENT_ROOT"].'/library/core.php');
	
	if(!$_SESSION['user']['is_admin']) die('Go away!');
	
	echo "<strong>Database update script</strong><br />";

	if(!db_fieldexists('cms_functions','visible')) {
		echo "Created field 'visible' in table 'cms_functions'<br />";
		db_query('ALTER TABLE `cms_functions` ADD `visible` TINYINT NOT NULL');
		db_query('UPDATE `cms_functions` SET `visible` = 1');
	} else {
		echo "Field 'visible' in table 'cms_functions' already exists<br />";
	}
	if(!db_fieldexists('cms_functions','allusers')) {
		echo "Created field 'allusers' in table 'cms_functions'<br />";
		db_query('ALTER TABLE `cms_functions` ADD `allusers` TINYINT NOT NULL');
		db_query('UPDATE `cms_functions` SET `visible` = 0');
	} else {
		echo "Field 'allusers' in table 'cms_functions' already exists<br />";
	}

	if(!db_fieldexists('products','comments')) {
		echo "Created field 'comments' in table 'products'<br />";
		db_query('ALTER TABLE `products` ADD `comments` VARCHAR(255)');
	} else {
		echo "Field 'comments' in table 'products' already exists<br />";
	}

	if(!db_fieldexists('cms_functions','adminonly')) {
		echo "Created field 'adminonly' in table 'cms_functions'<br />";
		db_query('ALTER TABLE `cms_functions` ADD `adminonly` TINYINT  NOT NULL  DEFAULT "0"  AFTER `title_ar`');
	} else {
		echo "Field 'adminonly' in table 'cms_functions' already exists<br />";
	}

	if(!db_fieldexists('people','camp_id')) {
		echo "Created field 'camp_id' in table 'people'<br />";
		db_query('ALTER TABLE `people` ADD `camp_id` INT  NOT NULL  DEFAULT 0  AFTER `comments`;');
		db_query('UPDATE people SET camp_id = 1');
	} else {
		echo "Field 'camp_id' in table 'people' already exists<br />";
	}

	if(!db_fieldexists('products','camp_id')) {
		echo "Created field 'camp_id' in table 'products'<br />";
		db_query('ALTER TABLE `products` ADD `camp_id` INT  NOT NULL  DEFAULT 0  AFTER `sizegroup_id`;');
		db_query('UPDATE products SET camp_id = 1');
		db_query('CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM products;');
		db_query('UPDATE tmptable_1 SET camp_id = 2, id = NULL');
		db_query('INSERT INTO products SELECT * FROM tmptable_1;');
		db_query('DROP TEMPORARY TABLE IF EXISTS tmptable_1;');

		$result = db_query('SELECT s.* FROM stock AS s, locations AS l WHERE s.location_id = l.id AND l.camp_id = 2');
		while($row = db_fetch($result)) {
			echo "Box ".$row['box_id']." has product_id ".$row['product_id']."<br />";
			$product = db_row('SELECT * FROM products WHERE id = :id',array('id'=>$row['product_id']));
			$newid = db_value('SELECT id FROM products WHERE name = :name AND gender_id = :gender_id AND sizegroup_id = :sizegroup_id AND camp_id = 2',array('name'=>$product['name'],'gender_id'=>$product['gender_id'],'sizegroup_id'=>$product['sizegroup_id']));
			echo "New product_id is be ".$newid."<br />";
			db_query('UPDATE stock SET product_id = :product_id WHERE id = :id',array('product_id'=>$newid,'id'=>$row['id']));
		}


	} else {
		echo "Field 'camp_id' in table 'products' already exists<br />";
	}

	if(!db_fieldexists('locations','is_lost')) {
		echo "Created field 'is_lost' in table 'locations'<br />";
		db_query('ALTER TABLE `locations` ADD `is_lost` TINYINT(4) NOT NULL DEFAULT 0;');
		db_query('UPDATE locations SET is_lost = 1 WHERE UPPER(label) = "LOST";');
		$result = db_query('SELECT camp_id, MAX(is_lost) AS has_lost FROM locations GROUP BY camp_id');
		while($row = db_fetch($result)) {
			if(!$row['has_lost']) {
				db_query('INSERT INTO locations(label, camp_id, created, visible, is_lost, created_by) VALUES ("LOST", :id, NOW(), 0, 1, :user);', array('id' => $row['camp_id'],'user'=>$_SESSION['user']['id']));
			}
		}
	} else {
		echo "Field 'is_lost' in table 'locations' already exists<br />";
	}

	if(db_fieldexists('cms_functions','title_nl')) {
		echo "Dropped field 'title_nl' in table 'cms_functions'<br />";
		db_query('ALTER TABLE `cms_functions` DROP `title_nl`');
	} else {
		echo "Field 'title_nl' in table 'cms_functions' already removed<br />";
	}


	if(!db_fieldexists('camps','food')) {
		echo "Created field 'food' in table 'camps'<br />";
		db_query('ALTER TABLE `camps` ADD `food` TINYINT(4) NOT NULL DEFAULT 0;');
		db_query('UPDATE `camps` SET food=1 WHERE name = "Nea Kavala";');
	} else {
		echo "Field 'food' in table 'camps' already added<br />";
	}

	if(!db_fieldexists('camps','bicycle')) {
		echo "Created field 'bicycle' in table 'camps'<br />";
		db_query('ALTER TABLE `camps` ADD `bicycle` TINYINT(4) NOT NULL DEFAULT 0;');
		db_query('UPDATE `camps` SET bicycle=1 WHERE name = "Nea Kavala";');
	} else {
		echo "Field 'bicycle' in table 'camps' already added<br />";
	}

	if(!db_fieldexists('people','bicycletraining')) {
		echo "Created field 'bicycletraining' in table 'people'<br />";
		db_query('ALTER TABLE `people` ADD `bicycletraining` INT  NOT NULL  DEFAULT 0  AFTER `comments`;');
	} else {
		echo "Field 'bicycletraining' in table 'people' already exists<br />";
	}

	if(!db_fieldexists('people','phone')) {
		echo "Created field 'phone' in table 'people'<br />";
		db_query('ALTER TABLE `people` ADD `phone` VARCHAR(255)  AFTER `comments`;');
	} else {
		echo "Field 'phone' in table 'people' already exists<br />";
	}
	
	if(!db_tableexists('bicycles')) {
		echo "Created table 'bicycles'<br />";
		db_query("CREATE TABLE `bicycles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
LOCK TABLES `bicycles` WRITE;
INSERT INTO `bicycles` (`id`, `name`, `deleted`)
VALUES (1,'1',0), (2,'2',0), (3,'3',0), (4,'4',0), (5,'5',0), (6,'6',0), (7,'7',0), (8,'8',0), (9,'9',0), (10,'10',0), (11,'11',0), (12,'12',0), (13,'13',0), (14,'14',0), (15,'15',0), (16,'16',0), (17,'17',0), (18,'18',0), (19,'19',0), (20,'20',0);
UNLOCK TABLES;");
	} else {
		echo "Table 'bicycles' already exists<br />";
	}

