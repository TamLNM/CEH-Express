ALTER TABLE  `mat_return_invoices` ADD  `paid_type` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '1';
delete FROM `budget_invoices` WHERE `mriinv_id` is not null;