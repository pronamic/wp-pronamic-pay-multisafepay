<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

/**
 * Title: MutliSafepay Connect transaction
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @since  1.0.0
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
