ALTER TABLE  `supliers` ADD  `sup_code` VARCHAR( 15 ) NULL;
UPDATE  `supliers` SET sup_code = CONCAT(  'NCC', LPAD( sup_id, 8,  '0' ) );
ALTER TABLE  `mat_msu` ADD  `price_input` INT UNSIGNED NULL , ADD  `discount_input` INT UNSIGNED NULL;