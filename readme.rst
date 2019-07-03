###################
Codeigniter  Public and private key encryption
###################

Create Database pincodes_test

And Then create table

#######
DROP TABLE IF EXISTS `pincodes`;

CREATE TABLE `pincodes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pincode` text,
  `serial_no` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
#######

