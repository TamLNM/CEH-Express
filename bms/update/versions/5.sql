INSERT INTO  `function_menu` (`fmenu_id` ,`fmenu_name` ,`fmenu_act` ,`fmenu_parid` ,`fmenu_img` ,`order_by`)VALUES (NULL ,  'Xuất kho nội bộ',  'mat_move',  '1',  'homenext.png',  '12');
INSERT INTO  `function_menu` (`fmenu_id` ,`fmenu_name` ,`fmenu_act` ,`fmenu_parid` ,`fmenu_img` ,`order_by`)VALUES (NULL ,  'Thống kê xuất kho nội bộ',  'mat_move_report',  '1',  'documents.png',  '13');
INSERT INTO  `function_menu` (`fmenu_id` ,`fmenu_name` ,`fmenu_act` ,`fmenu_parid` ,`fmenu_img` ,`order_by`)VALUES (NULL ,  'Sửa phiếu xuất kho nội bộ',  'edit_mat_move',  '43', NULL ,  '21');
INSERT INTO  `function_menu` (`fmenu_id` ,`fmenu_name` ,`fmenu_act` ,`fmenu_parid` ,`fmenu_img` ,`order_by`)VALUES (NULL ,  'Xóa phiếu xuất kho nội bộ',  'del_mat_move',  '43', NULL ,  '22');
INSERT INTO  `function_menu` (`fmenu_id` ,`fmenu_name` ,`fmenu_act` ,`fmenu_parid` ,`fmenu_img` ,`order_by`)VALUES (NULL ,  'Xem tất cả giá nhập hàng',  'view_input_price',  '43', NULL ,  '23');
INSERT INTO  `function_menu` (`fmenu_id` ,`fmenu_name` ,`fmenu_act` ,`fmenu_parid` ,`fmenu_img` ,`order_by`)VALUES (NULL ,  'Xem tất cả giá bán hàng',  'view_output_price',  '43', NULL ,  '24');
ALTER TABLE  `materials` ADD  `vat` TINYINT( 2 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `out_invoice_details` ADD  `price` INT NULL, ADD  `vat` TINYINT( 2 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `invoice_details` ADD  `price` INT NULL, ADD  `vat` TINYINT( 2 ) NOT NULL DEFAULT  '0';
CREATE TABLE `mat_move_invoices` (
`inv_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
 `user_id` INT( 10 ) UNSIGNED NOT NULL ,
 `created_date` INT( 10 ) UNSIGNED NOT NULL ,
 `inv_code` VARCHAR( 20 ) NOT NULL ,
 `comment` VARCHAR( 255 ) DEFAULT NULL ,
 `created_user` INT( 10 ) UNSIGNED NOT NULL ,
 `stock_id` INT( 10 ) UNSIGNED DEFAULT NULL ,
 `stock_id_to` INT( 10 ) UNSIGNED DEFAULT NULL ,
PRIMARY KEY (  `inv_id` ) ,
KEY  `fk_inv_usr` (  `user_id` ) ,
KEY  `fk_inv_usr2` (  `created_user` ) ,
KEY  `fk_inv_stock` (  `stock_id` ) ,
KEY  `fk_mri_stock_to` (  `stock_id_to` )
) ENGINE = INNODB DEFAULT CHARSET = utf8;

ALTER TABLE  `mat_move_invoices` ADD FOREIGN KEY (  `user_id` ) REFERENCES  `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE  `mat_move_invoices` ADD FOREIGN KEY (  `created_user` ) REFERENCES  `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE  `mat_move_invoices` ADD FOREIGN KEY (  `stock_id` ) REFERENCES  `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE  `mat_move_invoices` ADD FOREIGN KEY (  `stock_id_to` ) REFERENCES  `stocks` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE ;


CREATE TABLE  `mat_move_invoice_details` (
`invd_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
 `inv_id` INT( 10 ) UNSIGNED NOT NULL ,
 `mat_quantity` FLOAT UNSIGNED NOT NULL ,
 `smm_id` INT( 10 ) UNSIGNED DEFAULT NULL ,
 `serials` TEXT,
PRIMARY KEY (  `invd_id` ) ,
KEY  `fk_invd_inv` (  `inv_id` ) ,
KEY  `fk_invd_smm` (  `smm_id` )
) ENGINE = INNODB DEFAULT CHARSET = utf8;

ALTER TABLE  `mat_move_invoice_details` ADD FOREIGN KEY (  `inv_id` ) REFERENCES  `mat_move_invoices` (`inv_id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE  `mat_move_invoice_details` ADD FOREIGN KEY (  `smm_id` ) REFERENCES  `stock_mat_msu` (`smm_id`) ON DELETE CASCADE ON UPDATE CASCADE ;