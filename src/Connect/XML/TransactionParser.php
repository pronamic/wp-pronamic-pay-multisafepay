<?php

/**
 * Title: MultiSafepay Connect XML transaction parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_TransactionParser {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Transaction $transaction
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$transaction = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Transaction();

		$transaction->id = Pronamic_WP_Pay_XML_Security::filter( $xml->id );
		$transaction->payment_url = Pronamic_WP_Pay_XML_Security::filter( $xml->payment_url );

		return $transaction;
	}
}
