<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML gateways response message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.2.0
 * @since   1.2.0
 */
class GatewaysResponseMessage {
	/**
	 * Gateways.
	 *
	 * @var array
	 */
	public $gateways;

	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return GatewaysResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new GatewaysResponseMessage();

		$message->gateways = array();

		foreach ( $xml->gateways->gateway as $gateway ) {
			$id          = Security::filter( $gateway->id );
			$description = Security::filter( $gateway->description );

			$message->gateways[ $id ] = $description;
		}

		return $message;
	}
}
