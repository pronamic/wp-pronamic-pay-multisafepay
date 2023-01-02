<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Transaction;
use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML transaction parser
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class TransactionParser {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return Transaction
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$transaction = new Transaction();

		$transaction->id          = (string) $xml->id;
		$transaction->payment_url = (string) $xml->payment_url;

		return $transaction;
	}
}
