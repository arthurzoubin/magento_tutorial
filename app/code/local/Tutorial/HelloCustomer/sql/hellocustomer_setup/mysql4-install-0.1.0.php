<?php
/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-1
 * Time: 上午7:35
 */
$installer = $this;
$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('hellocustomer/hellocustomer')};
CREATE TABLE {$this->getTable('hellocustomer/hellocustomer')} (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `customer_id` tinyint(3) unsigned DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `message` varchar(45) DEFAULT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO ". $this->getTable('hellocustomer/hellocustomer') ." VALUES (1,'2017-07-31 14:36:30',1,'success','',1000010);
");
$installer->endSetup();