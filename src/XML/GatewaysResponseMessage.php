<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML gateways response message
 * Description:
 * Copyright: 2005-2019 Pronamic
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
