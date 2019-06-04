# Sequel Pro dump
# Version 392
# http://code.google.com/p/sequel-pro
#
# Host: localhost (MySQL 5.0.45)
# Database: stilettotools
# Generation Time: 2009-04-29 11:45:29 -0700
# ************************************************************

# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `type` varchar(25) default NULL,
  `precedence` int(11) default '0',
  `parent` int(11) default '0',
  `active` int(11) default '0',
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `category` (`id`,`title`,`type`,`precedence`,`parent`,`active`,`date`)
VALUES
	(1,'Hammer Heads','locations',0,0,0,'0000-00-00'),
	(2,'Wood Handle','locations',0,0,0,'0000-00-00'),
	(3,'Ti-Bone Handles','locations',0,0,0,'0000-00-00'),
	(4,'Poly Handles','locations',0,0,0,'0000-00-00'),
	(5,'Bar','locations',0,0,0,'0000-00-00'),
	(6,'TiBone Heads','locations',0,0,0,'0000-00-00'),
	(7,'Charged Orders','orders',2,0,0,'0000-00-00'),
	(8,'Shipped Orders','orders',3,0,0,'0000-00-00'),
	(9,'New Orders','orders',1,0,0,'0000-00-00');



# Dump of table gallery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `precedence` int(11) default '0',
  `image` varchar(255) NOT NULL default '',
  `active` int(11) default '0',
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `gallery` (`id`,`title`,`precedence`,`image`,`active`,`date`)
VALUES
	(1,'Personalization Example',1,'',0,'2009-04-29'),
	(2,'Personalization Example',2,'',0,'2009-04-29'),
	(3,'Personalization Example',3,'',0,'2009-04-29'),
	(4,'Personalization Example',4,'',0,'2009-04-29'),
	(5,'Personalization Example',5,'',0,'2009-04-29'),
	(6,'Personalization Example',6,'',0,'2009-04-29'),
	(7,'Personalization Example',7,'',0,'2009-04-29');



# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `category` int(11) default '0',
  `precedence` int(11) default '0',
  `active` int(11) default '0',
  `date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO `locations` (`id`,`title`,`category`,`precedence`,`active`,`date`)
VALUES
	(1,'Front of Head',1,1,0,NULL),
	(2,'Back of Head',1,2,0,NULL),
	(3,'Bottom Front of Handle',2,3,0,NULL),
	(4,'Bottom Back of Handle',2,4,0,NULL),
	(5,'Bottom Front of Handle',3,3,0,NULL),
	(6,'Bottom Back of Handle',3,4,0,NULL),
	(7,'Bottom Front of Handle',4,3,0,NULL),
	(8,'Bottom Back of Handle',4,4,0,NULL),
	(9,'Top Front of Handle',2,5,0,NULL),
	(10,'Top Back of Handle',2,6,0,NULL),
	(11,'Bar (only option)',5,1,0,NULL),
	(12,'Front of Head',6,1,0,NULL),
	(14,'Whale Tail',5,2,0,NULL),
	(15,'Thumb Portion',5,3,0,NULL);



# Dump of table mbcms_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mbcms_users`;

CREATE TABLE `mbcms_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `nameu` varchar(255) NOT NULL default '',
  `pass` varchar(255) NOT NULL default '',
  `level` int(11) NOT NULL default '0',
  `active` int(11) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `mbcms_users` (`id`,`name`,`email`,`nameu`,`pass`,`level`,`active`,`date`)
VALUES
	(1,'Montana Banana','','montanab','adm1nmb',0,0,'2005-01-01'),
	(2,'Stiletto Tools','','client','password',1,0,'2009-04-29');



# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) NOT NULL auto_increment,
  `receipt` varchar(255) default NULL,
  `personalize` text,
  `checkout` text,
  `total` decimal(11,2) default '0.00',
  `category` int(11) default '0',
  `active` int(11) default '0',
  `date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `orders` (`id`,`receipt`,`personalize`,`checkout`,`total`,`category`,`active`,`date`)
VALUES
	(1,'STLI2363','a:6:{s:4:\"type\";s:3:\"new\";s:5:\"price\";d:29.989999999999998436805981327779591083526611328125;s:5:\"agree\";s:4:\"true\";s:7:\"product\";a:3:{s:9:\"productId\";s:1:\"3\";s:16:\"productOptionsId\";s:1:\"9\";s:5:\"price\";s:6:\"106.95\";}s:8:\"location\";s:1:\"3\";s:10:\"text_entry\";a:3:{s:7:\"message\";s:15:\"What\'s Up Homes\";s:4:\"font\";s:6:\"impact\";s:4:\"size\";s:0:\"\";}}','a:5:{s:16:\"shipping_address\";a:10:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:5:\"email\";s:19:\"jasonk@montanab.com\";s:13:\"confirm_email\";s:19:\"jasonk@montanab.com\";s:12:\"phone_number\";s:10:\"5035551234\";}s:15:\"shipping_method\";a:4:{s:15:\"shipping_method\";s:0:\"\";s:10:\"shippingId\";i:0;s:6:\"method\";s:13:\"Sample Method\";s:5:\"price\";d:2.9900000000000002131628207280300557613372802734375;}s:19:\"billing_information\";a:9:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:18:\"credit_card_images\";s:0:\"\";s:18:\"credit_cart_number\";s:16:\"gddddddddddddddd\";}s:5:\"total\";s:6:\"139.93\";s:18:\"order_confirmation\";a:1:{s:0:\"\";s:0:\"\";}}',139.93,9,0,'2009-04-23'),
	(2,'STLI2375','a:6:{s:4:\"type\";s:3:\"new\";s:5:\"price\";d:29.989999999999998436805981327779591083526611328125;s:5:\"agree\";s:4:\"true\";s:7:\"product\";a:3:{s:9:\"productId\";s:1:\"7\";s:16:\"productOptionsId\";s:2:\"50\";s:5:\"price\";s:5:\"79.95\";}s:8:\"location\";s:2:\"14\";s:10:\"text_entry\";a:3:{s:7:\"message\";s:10:\"SLIM SHADY\";s:4:\"font\";s:6:\"impact\";s:4:\"size\";s:0:\"\";}}','a:4:{s:16:\"shipping_address\";a:10:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:5:\"email\";s:19:\"jasonk@montanab.com\";s:13:\"confirm_email\";s:19:\"jasonk@montanab.com\";s:12:\"phone_number\";s:10:\"5035551234\";}s:15:\"shipping_method\";a:4:{s:15:\"shipping_method\";s:0:\"\";s:10:\"shippingId\";i:0;s:6:\"method\";s:13:\"Sample Method\";s:5:\"price\";d:2.9900000000000002131628207280300557613372802734375;}s:19:\"billing_information\";a:8:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:18:\"credit_card_images\";s:0:\"\";}s:5:\"total\";s:6:\"112.93\";}',112.93,9,0,'2009-04-23'),
	(3,'STLI2481','a:6:{s:4:\"type\";s:3:\"new\";s:5:\"price\";d:29.989999999999998436805981327779591083526611328125;s:5:\"agree\";s:4:\"true\";s:7:\"product\";a:3:{s:9:\"productId\";s:1:\"1\";s:16:\"productOptionsId\";s:1:\"1\";s:5:\"price\";s:6:\"262.50\";}s:8:\"location\";s:2:\"12\";s:10:\"text_entry\";a:3:{s:7:\"message\";s:10:\"fsdfsdfsdf\";s:4:\"font\";s:7:\"mistral\";s:4:\"size\";s:0:\"\";}}','a:4:{s:5:\"total\";s:6:\"295.48\";s:16:\"shipping_address\";a:10:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:5:\"email\";s:19:\"jasonk@montanab.com\";s:13:\"confirm_email\";s:19:\"jasonk@montanab.com\";s:12:\"phone_number\";s:10:\"5035551234\";}s:15:\"shipping_method\";a:4:{s:15:\"shipping_method\";s:0:\"\";s:10:\"shippingId\";i:0;s:6:\"method\";s:13:\"Sample Method\";s:5:\"price\";d:2.9900000000000002131628207280300557613372802734375;}s:19:\"billing_information\";a:11:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:18:\"credit_card_images\";s:0:\"\";s:18:\"credit_card_number\";s:16:\"gddddddddddddddd\";s:15:\"expiration_date\";s:5:\"01/09\";s:4:\"cvv2\";s:3:\"123\";}}',295.48,9,0,'2009-04-24'),
	(4,'STLI2777','a:2:{s:4:\"type\";s:8:\"existing\";s:5:\"price\";d:29.989999999999998436805981327779591083526611328125;}','a:4:{s:16:\"shipping_address\";a:10:{s:10:\"first_name\";s:5:\"jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:5:\"email\";s:19:\"jasonk@montanab.com\";s:13:\"confirm_email\";s:19:\"jasonk@montanab.com\";s:12:\"phone_number\";s:10:\"5035551234\";}s:15:\"shipping_method\";a:4:{s:15:\"shipping_method\";s:0:\"\";s:10:\"shippingId\";i:0;s:6:\"method\";s:13:\"Sample Method\";s:5:\"price\";d:2.9900000000000002131628207280300557613372802734375;}s:19:\"billing_information\";a:11:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:18:\"credit_card_images\";s:0:\"\";s:18:\"credit_card_number\";s:16:\"gddddo6gdo6gdo6g\";s:15:\"expiration_date\";s:5:\"02/11\";s:4:\"cvv2\";s:3:\"123\";}s:5:\"total\";s:5:\"32.98\";}',32.98,9,0,'2009-04-27'),
	(5,'STLI2946','a:6:{s:4:\"type\";s:3:\"new\";s:5:\"price\";d:29.989999999999998436805981327779591083526611328125;s:5:\"agree\";s:4:\"true\";s:7:\"product\";a:3:{s:9:\"productId\";s:1:\"1\";s:16:\"productOptionsId\";s:1:\"1\";s:5:\"price\";s:6:\"262.50\";}s:8:\"location\";s:2:\"12\";s:10:\"text_entry\";a:3:{s:7:\"message\";s:9:\"undefined\";s:4:\"font\";s:6:\"tahoma\";s:4:\"size\";s:0:\"\";}}','a:4:{s:16:\"shipping_address\";a:10:{s:10:\"first_name\";s:5:\"jason\";s:9:\"last_name\";s:7:\"kenison\";s:7:\"address\";s:14:\"1234 anystreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97123\";s:5:\"email\";s:19:\"jasonk@montanab.com\";s:13:\"confirm_email\";s:19:\"jasonk@montanab.com\";s:12:\"phone_number\";s:0:\"\";}s:15:\"shipping_method\";a:4:{s:15:\"shipping_method\";s:0:\"\";s:10:\"shippingId\";i:0;s:6:\"method\";s:13:\"Sample Method\";s:5:\"price\";d:2.9900000000000002131628207280300557613372802734375;}s:19:\"billing_information\";a:11:{s:10:\"first_name\";s:5:\"jason\";s:9:\"last_name\";s:7:\"kenison\";s:7:\"address\";s:14:\"1234 anystreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97123\";s:18:\"credit_card_images\";s:0:\"\";s:18:\"credit_card_number\";s:16:\"gddddddddddddddd\";s:15:\"expiration_date\";s:5:\"01/09\";s:4:\"cvv2\";s:3:\"123\";}s:5:\"total\";s:6:\"295.48\";}',295.48,9,0,'2009-04-29'),
	(6,'STLI2967','a:4:{s:4:\"type\";s:8:\"existing\";s:5:\"price\";d:29.989999999999998436805981327779591083526611328125;s:5:\"agree\";s:4:\"true\";s:7:\"product\";a:3:{s:9:\"productId\";s:1:\"7\";s:16:\"productOptionsId\";s:2:\"73\";s:5:\"price\";s:4:\"0.00\";}}','a:4:{s:16:\"shipping_address\";a:10:{s:10:\"first_name\";s:5:\"Jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:3:\"sdf\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:5:\"email\";s:19:\"jasonk@montanab.com\";s:13:\"confirm_email\";s:19:\"jasonk@montanab.com\";s:12:\"phone_number\";s:10:\"5035551234\";}s:15:\"shipping_method\";a:4:{s:15:\"shipping_method\";s:0:\"\";s:10:\"shippingId\";i:0;s:6:\"method\";s:13:\"Sample Method\";s:5:\"price\";d:2.9900000000000002131628207280300557613372802734375;}s:19:\"billing_information\";a:11:{s:10:\"first_name\";s:5:\"jason\";s:9:\"last_name\";s:7:\"Kenison\";s:7:\"address\";s:14:\"1234 AnyStreet\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Portland\";s:5:\"state\";s:2:\"OR\";s:3:\"zip\";s:5:\"97006\";s:18:\"credit_card_images\";s:0:\"\";s:18:\"credit_card_number\";s:16:\"gddddddddddddddd\";s:15:\"expiration_date\";s:5:\"01/09\";s:4:\"cvv2\";s:3:\"123\";}s:5:\"total\";s:5:\"32.98\";}',32.98,9,0,'2009-04-29');



# Dump of table pagecontent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pagecontent`;

CREATE TABLE `pagecontent` (
  `id` int(11) NOT NULL auto_increment,
  `page` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` text,
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `pagecontent` (`id`,`page`,`title`,`description`,`date`)
VALUES
	(1,'emailToCustomer_new','Email to Customer (New Tool)','Thank you for your order!','0000-00-00'),
	(2,'printToolNote','Existing Tool Inst.','<h2>* SPECIAL INSTRUCTIONS FOR  YOUR ORDER</h2>1. Print this page and include it with your hammer when you ship. <a href=\"javascript:launchwin(\\\'printable_receipt.html?order=6&printView=true\\\',\\\'printable_receipt\\\',\\\'width=620,height=690,scrollbars=no\\\');\">Click HERE</a> to print.<br /><br />2. Do not ship your hammer until you receive your order # and shipping label from Stiletto customer service.','2009-04-29'),
	(3,'printToolNoteOnPrintout','Existing Tool Inst. on Print Receipt','Thank you for your order. It is currently being processed. Please wait  for further instruction from our team before shipping us your tool.<br>  <br>  Here\'s what to expect from us:  An order confirmation number and a shipping label. ','0000-00-00'),
	(4,'disclaimer','Disclaimer','STILETTO(r) Personalization Program Policy and Agreement: STILETTO(r) personalized products are for personal use only and may not be used for competitive commercial gain. STILETTO TOOLS reserves the right to refuse any orders that contain wording or symbols that STILETTO TOOLS believes in its sole discretion to be inappropriate, infringing of other\'s rights or disparaging to the STILETTO(r) brand in any way. By ordering a personalized STILETTO(r) product, the consumer agrees to take full responsibility and to indemnify STILETTO TOOLS for any claims made by a third party that any part of the personalization created by the customer infringes the rights of or otherwise damages the third party.','2009-04-29'),
	(5,'introduction','Introduction','    Welcome to the official Stiletto Personalization Program. We are proud to offer this unique service to you, our loyal customer as an option to make your Stiletto Tool stand out more than it already does. You took the leap to buy the best of the best, now its time to make it your own!<p><b style=\"font-size: 14px;\">Features of the program:</b></p><ul><li>Personalize a brand new tool bought on Stiletto.com</li><li>Personalize your existing Stiletto Tool you have owned for years</li><li>Choose from 5 different fonts</li><li>Choose from numerous locations on your tool to personalize</li><li>Choose how fast you want your tool back (we can overnight if you so desire!)</li></ul><b style=\"font-size: 14px;\">Why Should I Personalize My Stiletto Tool?</b><ul><li>Prevents theft! Add your initials and phone number!</li><li>It makes your tool unique to you. Add your favorite nickname!</li><li>Great gift idea for loyal and hardworking employees</li><li>It makes your tool stand out as the best</li></ul>If you would like to personalize numerous hammers for your crew, or have a custom logo engraved in the head or handle, please contact Stiletto <a href=\"mailto:personalize@stiletto.com\">customer service</a>.    ','2009-04-28'),
	(6,'emailToCustomer_existing','Email to Customer (Existing Tool)','Thank you for your order. It is currently being processed. Please wait for further instruction from our team before shipping us your tool.<br /><br />Here\\\'s what to expect from us: An order confirmation number and a shipping label.','0000-00-00');



# Dump of table product_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_options`;

CREATE TABLE `product_options` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `price` decimal(11,2) default '0.00',
  `locations` varchar(255) default NULL,
  `products` int(11) default '0',
  `weight` decimal(10,1) default '0.0',
  `precedence` int(11) default '0',
  `active` int(11) default '0',
  `date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

INSERT INTO `product_options` (`id`,`title`,`price`,`locations`,`products`,`weight`,`precedence`,`active`,`date`)
VALUES
	(1,'TB15MC Milled Face w/ Curv. Handle',262.50,'5,6,12,',1,2.0,0,0,NULL),
	(2,'TB15MS Milled Face w/ Str. Handle',262.50,'5,6,12,',1,2.0,0,0,NULL),
	(3,'TB15SC Smooth Face w/ Curv. Handle',262.50,'5,6,12,',1,2.0,0,0,NULL),
	(4,'TB15SS Smooth Face w/ Str. Handle',262.50,'5,6,12,',1,2.0,0,0,NULL),
	(5,'TBM14RMC Milled Face w/ Curv. Handle',262.50,'5,6,12,',2,2.0,0,0,NULL),
	(6,'TBM14RMS Milled Face w/ Str. Handle',262.50,'5,6,12,',2,2.0,0,0,NULL),
	(7,'TBM14RSC Smooth Face w/ Curv. Handle',262.50,'5,6,12,',2,2.0,0,0,NULL),
	(8,'TBM14RSS Smooth Face w/ Str. Handle',262.50,'5,6,12,',2,2.0,0,0,NULL),
	(9,'TI16MC (18\" Hickory Handle)Milled Face w/ Curv. Handle',106.95,'1,2,3,4,9,10,',3,2.0,0,0,NULL),
	(10,'TI16MS (18\" Hickory Handle)Milled Face w/ Str. Handle',106.95,'1,2,3,4,9,10,',3,2.0,0,0,NULL),
	(11,'TI16SC (18\" Hickory Handle)Smooth. Face w/ Curv. Handle',106.95,'1,2,3,4,9,10,',3,2.0,0,0,NULL),
	(12,'TI16SS (18\" Hickory Handle)Smooth. Face w/ Str. Handle',106.95,'1,2,3,4,9,10,',3,2.0,0,0,NULL),
	(13,'TI16MS-P (Poly Fiberglass)Milled Face w/ Str. Handle',121.95,'1,2,7,8,',3,2.0,0,0,NULL),
	(14,'TI16SS-P (Poly Fiberglass)Smooth Face w/ Str. Handle',121.95,'1,2,7,8,',3,2.0,0,0,NULL),
	(15,'TI16MC-P (Poly Fiberglass)Milled Face w/ Curv. Handle',121.95,'1,2,7,8,',3,2.0,0,0,NULL),
	(16,'TI16SC-P (Poly Fiberglass)Smooth Face w/ Curv. Handle',121.95,'1,2,7,8,',3,2.0,0,0,NULL),
	(17,'TI14MC (18\" Hickory Handle)Milled Face w/ Curv. Handle',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(18,'TI14MS (18\" Hickory Handle)Milled Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(19,'TI14SC (18\" Hickory Handle)Smooth Face w/ Curv. Handle ',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(20,'TI14SS (18\" Hickory Handle)Smooth Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(21,'TI14MC-16 (16\" Hickory Handle)Milled Face w/ Curv. Handle',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(22,'TI14MS-16 (16\" Hickory Handle)Milled Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(23,'TI14SC-16 (16\" Hickory Handle)Smooth Face w/ Curv. Handle',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(24,'TI14SS-16 (16\" Hickory Handle)Smooth Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(25,'TI14MC-P16 (Poly Fiberglass)Milled Face w/ Curv. Handle',119.95,'1,2,7,8,',4,2.0,0,0,NULL),
	(26,'TI14SC-P16 (Poly Fiberglass)Smooth Face w/ Curv.Handle',119.95,'1,2,7,8,',4,2.0,0,0,NULL),
	(27,'TI14MC-P (Poly Fiberglass)Milled Face w/ Curv. Handle',119.95,'1,2,7,8,',4,2.0,0,0,NULL),
	(28,'TI14MS-P (Poly Fiberglass)Milled Face w/ Str. Handle',119.95,'1,2,7,8,',4,2.0,0,0,NULL),
	(29,'TI14SC-P (Poly Fiberglass)Smooth Face w/ Curv. Handle',119.95,'1,2,7,8,',4,2.0,0,0,NULL),
	(30,'TI14SS-P (Poly Fiberglass)Smooth Face w/ Str. Handle',119.95,'1,2,7,8,',4,2.0,0,0,NULL),
	(31,'TI12MC (18\" Hickory Handle)Milled Face w/ Curv. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(32,'TI12MS (18\" Hickory Handle)Milled Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(33,'TI12SC (18\" Hickory Handle)Smooth Face w/ Curv. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(34,'TI12SS (18\" Hickory Handle)Smooth Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(35,'TI12MC-16 (16\" Hickory Handle)Milled Face w/ Curv. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(36,'TI12MS-16 (16\" Hickory Handle)Milled Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(37,'TI12SC-16 (16\" Hickory Handle)Smooth Face w/ Curv. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(38,'TI12SS-16 (16\" Hickory Handle)Smooth Face w/ Str. Handle',104.95,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(39,'TI12MC-P16 (Poly Fiberglass)Milled Face w/ Curv. Handle',119.95,'1,2,7,8,',5,2.0,0,0,NULL),
	(40,'TI12SC-P16 (Poly Fiberglass)Smooth Face w/ Curv. Handle',119.95,'1,2,7,8,',5,2.0,0,0,NULL),
	(41,'TI12MC-P (Poly Fiberglass)Milled Face w/ Curv. Handle',119.95,'1,2,7,8,',5,2.0,0,0,NULL),
	(42,'TI12MS-P (Poly Fiberglass)Milled Face w/ Str. Handle',119.95,'1,2,7,8,',5,2.0,0,0,NULL),
	(43,'TI12SC-P (Poly Fiberglass)Smooth Face w/ Curv. Handle',119.95,'1,2,7,8,',5,2.0,0,0,NULL),
	(44,'TI12SS-P (Poly Fiberglass)Smooth Face w/ Str. Handle',119.95,'1,2,7,8,',5,2.0,0,0,NULL),
	(45,'FH10C (14.5\" Hickory Handle)Smooth Face w/ Curv. Handle',89.95,'1,2,3,4,9,10,',6,1.5,0,0,NULL),
	(46,'FH10S (16\" Hickory Handle)Smooth Face',89.95,'1,2,3,4,9,10,',6,1.5,0,0,NULL),
	(47,'FH10C-P (14\" Poly Handle)Smooth Face w/ Curv. Handle',119.05,'1,2,7,8,',6,1.5,0,0,NULL),
	(48,'TiBar16New 16\" Titanium Utility Bar',249.95,'15,',7,2.0,0,0,NULL),
	(49,'TiBar12New 12\" Titanium Utility Bar',169.95,'15,',7,2.0,0,0,NULL),
	(50,'TrimBar5New 5.5 oz. Titanium Trim Puller',79.95,'14,',7,2.0,0,0,NULL),
	(51,'TICLW1212\" Titanium w/ Dimpler',88.95,'15,',7,2.0,0,0,NULL),
	(52,'FB15 15 inch multi-functional titanium flat bar',179.99,'11,',7,2.0,0,0,NULL),
	(53,'FB11S 11.5 inch multi-functional titanium flat bar',129.99,'11,',7,2.0,0,0,NULL),
	(54,'FB11G 11.5 inch multi-functional titanium glazer bar',129.99,'11,',7,2.0,0,0,NULL),
	(55,'REN21MC (18\" Hickory Handle)Milled Face w/ Curv. Handle',44.95,'1,2,3,4,9,10,',8,3.0,0,0,NULL),
	(56,'REN21MS (18\" Hickory Handle)Milled Face w/ Str. Handle',44.95,'1,2,3,4,9,10,',8,3.0,0,0,NULL),
	(57,'REN19MC (18\" Hickory Handle)Milled Face w/ Curv. Handle',44.95,'1,2,3,4,9,10,',8,3.0,0,0,NULL),
	(58,'REN19MS (18\" Hickory Handle)Milled Face w/ Str. Handle',44.95,'1,2,3,4,9,10,',8,3.0,0,0,NULL),
	(59,'Existing Product',0.00,'5,6,12,',1,2.0,0,0,NULL),
	(60,'Existing Product',0.00,'5,6,12,',2,2.0,0,0,NULL),
	(61,'Hickory Handle',0.00,'1,2,3,4,9,10,',3,2.0,0,0,NULL),
	(62,'Poly Fiberglass Handle',0.00,'1,2,7,8,',3,2.0,0,0,NULL),
	(63,'Hickory Handle',0.00,'1,2,3,4,9,10,',4,2.0,0,0,NULL),
	(64,'Poly Fiberglass Handle',0.00,'1,2,7,8,',4,2.0,0,0,NULL),
	(65,'Hickory Handle',0.00,'1,2,3,4,9,10,',5,2.0,0,0,NULL),
	(66,'Poly Fiberglass Handle',0.00,'1,2,7,8,',5,2.0,0,0,NULL),
	(67,'Hickory Handle',0.00,'1,2,3,4,9,10,',6,1.5,0,0,NULL),
	(68,'Poly Fiberglass Handle',0.00,'1,2,7,8,',6,1.5,0,0,NULL),
	(74,'TiBar12New 12\" Titanium Utility Bar',0.00,'15,',7,2.0,0,0,NULL),
	(70,'Hickory Handle',0.00,'1,2,3,4,9,10,',8,3.0,0,0,NULL),
	(73,'TiBar16New 16\" Titanium Utility Bar',0.00,'15,',7,2.0,0,0,NULL),
	(75,'TrimBar5New 5.5 oz. Titanium Trim Puller',0.00,'14,',7,2.0,0,0,NULL),
	(76,'TICLW1212\" Titanium w/ Dimpler',0.00,'15,',7,2.0,0,0,NULL),
	(77,'FB15 15 inch multi-functional titanium flat bar',0.00,'11,',7,2.0,0,0,NULL),
	(78,'FB11S 11.5 inch multi-functional titanium flat bar',0.00,'11,',7,2.0,0,0,NULL),
	(79,'FB11G 11.5 inch multi-functional titanium glazer bar',0.00,'11,',7,2.0,0,0,NULL);



# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `summary` text,
  `description` text,
  `precedence` int(11) default '0',
  `url` text,
  `active` int(11) default '0',
  `date` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`,`title`,`summary`,`description`,`precedence`,`url`,`active`,`date`)
VALUES
	(1,'TiBone(r) 15oz. w/ Rplc. Face','Our BIG Titanium hammer! Incredibly strong, powerful and lightweight with 10 times less recoil shock than Steel!<br /><br /><b>Features:</b><ul><li>15oz Titanium head/Steel face combination drives like a 28oz Steel hammer</li><li>Durable Steel Replaceable Face (milled or smooth)</li><li>18\" Super-Strong Titanium handle with a BLACK, ergonomically contoured, hardwearing rubber grip</li><li>NEW! Patented Side Nail Puller eases 16s out with one 180 degree motion!</li><li>Magnetic Nail Starter</li></ul>',NULL,0,'TBII15.php3',0,NULL),
	(2,'TiBone(r) Mini 14 oz w/repl. Face','Our smaller, \\\"from the ground up\\\", version of the original TiBone hammer. Incredibly strong, powerful and even more lightweight with 10 times less shock than Steel.<br /><br /><b>Features:</b><ul><li>14oz Titanium head/Steel face combination drives like a 24oz Steel hammer</li><li>Durable Steel Replaceable Face (milled or smooth)</li><li>15 1/4\\\" Super-Strong Titanium handle with an ergonomically contoured, hardwearing rubber grip</li><li>NEW! Patented Side Nail Puller eases 16s out with one 180 degree motion!</li><li>Magnetic Nail Starter</li></ul>',NULL,0,'mini14.php3',0,NULL),
	(3,'16 oz. Titanium \"Musclehead(tm)\"','The biggest of our solid Titanium heads! Hits like a 28oz Steel, weighs less and has 10 times less recoil shock!<br /><br /><b>Features:</b><ul><li>16oz solid Titanium head</li><li>Magnetic Nail Starter</li><li>Straight claw design</li><li>Milled or Smooth Face</li><li>18\\\" curved or straight Polyfiberglass handle with inlaid rubber grip</li></ul>',NULL,0,'16oz_poly.php3',0,NULL),
	(4,'14 oz. Titanium \"Titan(tm)\"','Our most popular framing hammer! Incredibly lightweight and strong! Hits like a 24oz Steel hammer with 10 times less recoil shock!<br /><br /><b>Features:</b><ul><li>14oz solid Titanium head\nMagnetic Nail Starter</li><li>Straight claw design</li><li>Milled or Smooth Face</li><li>16\\\" or 18\\\" curved or straight Hickory handle</li></ul>',NULL,0,'14oz_poly.php3',0,NULL),
	(5,'12 oz. Titanium \"Remodeler(tm)\"','The power of a 21oz Steel hammer, without the weight and 10 times less recoil! Great for framing and a perfect tool for trim, deck, and siding too!<br /><br /><b>Features:</b><ul><li>12oz solid Titanium head</li><li>Magnetic Nail Starter</li><li>Straight claw design</li><li>Milled or Smooth Face</li><li>Available with 16\\\" or 18\\\" curved or straight Hickory handles</li></ul>',NULL,0,'12oz_poly.php3',0,NULL),
	(6,'10 oz. Titanium Finish Hammers','The lightest, most powerful little trim hammer in the world! With 10 times less shock than Steel!<br /><br /><b>Features:</b><ul><li>10oz solid Titanium head with the driving power of a 16oz Steel hammer</li><li>NEW! Magnetic nail starter for 3/4\\\" brad or wire nails</li><li>Straight claw design</li><li>Available with a 14.5\\\" curved or straight Hickory, or a 16\\\" straight Hickory handle</li><li>Smooth face for a clean finish</li></ul>',NULL,0,'10oz_poly.php3',0,NULL),
	(7,'Stiletto Nail Pullers and Bars','Complete line of multifunctional and lightweight utility bars, pry bars, and nail pullers. Please select from one of the following tools below:',NULL,0,'struck_bars.php3',0,NULL),
	(8,'Renegade(tm) Steel Framing Hammers','The Original Stiletto Renegades are back and better than ever!<br /><br /><b>Features:</b><ul><li>\n21oz Highly Polished solid Steel head</li><li>Straight claw design</li><li>Magnetic nail starter</li><li>Milled Face</li><li>18\\\" Hickory handle</li></ul>',NULL,0,'19oz_steel.php3',0,NULL);



