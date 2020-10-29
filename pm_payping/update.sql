PREPARE insertstm FROM "
INSERT IGNORE INTO `ilakm_jshopping_payment_method`
SET
	`payment_id`		=  ?,
	`payment_code`          = 'payping',
	`payment_class`         = 'pm_payping',
	`scriptname`            = 'pm_payping',
	`payment_publish`       = 0,
	`payment_ordering`      = 0,
	`payment_params`        = 'token=\nreturnUrl=\ncurrency=10\ntransaction_end_status=6\ntransaction_pending_status=1\ntransaction_failed_status=3\ncheckdatareturn=1',
	`payment_type`          = 2,
	`price`                 = 0.00,
	`price_type`            = 1,
	`tax_id`                = -1,
	`show_descr_in_email`   = 0,
	`name_en-GB`            = 'Payping peyment',
	`name_fa-IR`            = 'درگاه پرداخت پی‌پینگ'";
 SET @id = (SELECT DISTINCT `payment_id` FROM ilakm_jshopping_payment_method WHERE scriptname='pm_payping' LIMIT 1);
EXECUTE insertstm USING @id;