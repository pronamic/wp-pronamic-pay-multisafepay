<?php

/**
 * Title: MultiSafepay Connect XML direct transaction response message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.0
 * @since 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionResponseMessage {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Transaction $transaction
	 */
	public static function parse( SimpleXMLElement $xml ) {
		// Message
		$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionResponseMessage();

		// Result
		$message->result = Pronamic_WP_Pay_XML_Security::filter( $xml['result'] );

		// Transaction
		$message->transaction = Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_TransactionParser::parse( $xml->transaction );

		// Gateway info
		if ( $xml->gatewayinfo ) {
			$message->gateway_info = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_GatewayInfo();
			$message->gateway_info->redirect_url = Pronamic_WP_Pay_XML_Security::filter( $xml->gatewayinfo->redirecturl );
			$message->gateway_info->ext_var      = Pronamic_WP_Pay_XML_Security::filter( $xml->gatewayinfo->extvar );
			$message->gateway_info->issuer_id    = Pronamic_WP_Pay_XML_Security::filter( $xml->gatewayinfo->issuerid );
		}

		// Return
		return $message;
	}
}
