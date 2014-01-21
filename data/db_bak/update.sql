alter table home_shop_join add column if_pay_seller tinyint(1);

#2014-1-18
alter table home_shop_join add column deliver_total varchar(10) default 0.00;
CREATE TABLE `home_order_unit_info` (
  `order_id` mediumint(9) NOT NULL default '0',
  `unit_name` varchar(50) default NULL,
  `bill_number` varchar(100) default NULL,
  `other` text,
  PRIMARY KEY  (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#2014-1-21
alter table home_shop_join add column if_refundment tinyint(1) default 0;