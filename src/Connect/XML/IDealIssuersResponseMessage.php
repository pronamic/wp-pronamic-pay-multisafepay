<?php

/**
 * Title: MultiSafepay Connect XML iDEAL issuers response message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.0
 * @since 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersResponseMessage {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Transaction $transaction
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersResponseMessage();
		$message->issuers = array();

		foreach ( $xml->issuers->issuer as $issuer ) {
			$code        = Pronamic_WP_Pay_XML_Security::filter( $issuer->code );
			$description = Pronamic_WP_Pay_XML_Security::filter( $issuer->description );

			$message->issuers[ $code ] = $description;
		}

		return $message;
	}
}
