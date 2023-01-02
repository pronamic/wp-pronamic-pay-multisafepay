<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML gateways response message
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.0
 */
class GatewaysResponseMessage {
	/**
	 * Gateways.
	 *
	 * @var array<string, string>
	 */
	public $gateways;

	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @return GatewaysResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new GatewaysResponseMessage();

		$message->gateways = [];

		foreach ( $xml->gateways->gateway as $gateway ) {
			$id          = (string) $gateway->id;
			$description = (string) $gateway->description;

			$message->gateways[ $id ] = $description;
		}

		return $message;
	}
}
