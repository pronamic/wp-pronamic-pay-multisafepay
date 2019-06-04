<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\GatewayInfo;
use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML direct transaction response message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.0
 */
class DirectTransactionResponseMessage {
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
	 * Gateway info.
	 *
	 * @var GatewayInfo
	 */
	public $gateway_info;

	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return DirectTransactionResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		// Message
		$message = new DirectTransactionResponseMessage();

		// Result
		$message->result = Security::filter( $xml['result'] );

		// Transaction
		$message->transaction = TransactionParser::parse( $xml->transaction );

		// Gateway info
		if ( $xml->gatewayinfo ) {
			$message->gateway_info               = new GatewayInfo();
			$message->gateway_info->redirect_url = Security::filter( $xml->gatewayinfo->redirecturl );
			$message->gateway_info->ext_var      = Security::filter( $xml->gatewayinfo->extvar );
			$message->gateway_info->issuer_id    = Security::filter( $xml->gatewayinfo->issuerid );
		}

		return $message;
	}
}
