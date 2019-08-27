<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Core\Util;

/**
 * Title: MutliSafepay Connect signature
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class Signature {
	public $account;

	public $site_id;

	public $site_secure_code;

	public $notification_url;

	public $redirect_url;

	public $cancel_url;

	public $close_window;

	/**
	 * Constructs and initialize an MultiSafepay Connect merchant object
	 *
	 * @param $amount         string
	 * @param $currency       string
	 * @param $account        string
	 * @param $site_id        string
	 * @param $transaction_id string
	 *
	 * @return string
	 */
	public static function generate( $amount, $currency, $account, $site_id, $transaction_id ) {
		$values = array(
			$amount,
			$currency,
			$account,
			$site_id,
			$transaction_id,
		);

		$string = implode( '', $values );

		$signature = md5( $string );

		return $signature;
	}
}
