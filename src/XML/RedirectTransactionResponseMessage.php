<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML redirect transaction response message
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class RedirectTransactionResponseMessage {
	/**
	 * Result
	 *
	 * @var string
	 */
	public $result;

	/**
	 * Transaction
	 *
	 * @var DirectTransactionResponseMessage
	 */
	public $transaction;

	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return RedirectTransactionResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new RedirectTransactionResponseMessage();

		$message->result      = (string) $xml['result'];
		$message->transaction = TransactionParser::parse( $xml->transaction );

		return $message;
	}
}
