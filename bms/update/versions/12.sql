CREATE TABLE IF NOT EXISTS `domains` (
  `sdo_id` int(10) unsigned NOT NULL auto_increment,
  `domain_name` varchar(255) NOT NULL,
  `sdo_active` tinyint(3) unsigned NOT NULL default '0',
  `sdo_default` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`sdo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
INSERT INTO  `function_menu` (
`fmenu_id` ,
`fmenu_name` ,
`fmenu_act` ,
`fmenu_parid` ,
`fmenu_img` ,
`order_by`
)
VALUES (
NULL,  'Quản lý tên miền',  'domain_assign',  '4',  'regdomain.png',  '19'
);