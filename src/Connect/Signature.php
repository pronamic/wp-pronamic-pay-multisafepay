<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

use Pronamic\WordPress\Pay\Core\Util as Core_util;

/**
 * Title: MutliSafepay Connect signature
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @since  1.0.0
 */
class Signature {
	public $account;

	public $site_id;

	public $site_secure_code;

	public $notification_url;

	public $redirect_url;

	public $cancel_url;

	public $close_window;

	/////////////////////////////////////////////////

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
			Core_Util::amount_to_cents( $amount ),
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
