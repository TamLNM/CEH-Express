UPDATE  `function_menu` SET  `order_by` =  '6' WHERE  `function_menu`.`fmenu_id` =43;
INSERT INTO  `function_menu` (`fmenu_id` ,`fmenu_name` ,`fmenu_act` ,`fmenu_parid` ,`fmenu_img` ,`order_by`)VALUES (NULL ,  'Quyền cập nhật',  'update', NULL , NULL ,  '5');
update `function_menu` set fmenu_parid=80 where fmenu_parid=43 and fmenu_id between 58 and 77