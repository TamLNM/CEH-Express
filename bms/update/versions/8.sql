ALTER TABLE  `mat_msu` ADD  `price_dealer2` INT NOT NULL DEFAULT  '0';
ALTER TABLE  `out_invoices` ADD  `draft` TINYINT( 1 ) NULL;
ALTER TABLE  `invoices` ADD  `draft` TINYINT( 1 ) NULL;