<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

/**
 * Title: MutliSafepay Connect transaction
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class Transaction {
	public $id;

	public $currency;

	public $amount;

	public $description;

	public $var1;

	public $var2;

	public $var3;

	public $items;

	public $manual;

	public $gateway;

	public $days_active;

	public $payment_url;
}
