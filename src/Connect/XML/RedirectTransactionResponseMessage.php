<?php

/**
 * Title: MultiSafepay Connect XML redirect transaction response message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RedirectTransactionResponseMessage {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Transaction $transaction
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RedirectTransactionResponseMessage();

		$message->result = Pronamic_WP_Pay_XML_Security::filter( $xml['result'] );
		$message->transaction = Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_TransactionParser::parse( $xml->transaction );

		return $message;
	}
}
