<?php
use Pronamic\WordPress\Pay\Core\XML\Security;

/**
 * Title: MultiSafepay Connect XML gateways response message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.0
 * @since 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_GatewaysResponseMessage {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Transaction $transaction
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_GatewaysResponseMessage();

		// @todo
		$message->gateways = array();

		foreach ( $xml->gateways->gateway as $gateway ) {
			$id          = Security::filter( $gateway->id );
			$description = Security::filter( $gateway->description );

			$message->gateways[ $id ] = $description;
		}

		return $message;
	}
}
