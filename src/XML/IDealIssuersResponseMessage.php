<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect XML iDEAL issuers response message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.0
 */
class IDealIssuersResponseMessage {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return IDealIssuersResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new IDealIssuersResponseMessage();

		$message->issuers = array();

		foreach ( $xml->issuers->issuer as $issuer ) {
			$code        = Security::filter( $issuer->code );
			$description = Security::filter( $issuer->description );

			$message->issuers[ $code ] = $description;
		}

		return $message;
	}
}
