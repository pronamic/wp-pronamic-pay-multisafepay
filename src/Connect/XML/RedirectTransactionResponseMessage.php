<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML redirect transaction response message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
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

	/////////////////////////////////////////////////

	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return RedirectTransactionResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new RedirectTransactionResponseMessage();

		$message->result      = Security::filter( $xml['result'] );
		$message->transaction = TransactionParser::parse( $xml->transaction );

		return $message;
	}
}
