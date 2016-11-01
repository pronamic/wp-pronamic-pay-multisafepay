<?php

/**
 * Title: MultiSafepay Connect XML status response message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_StatusResponseMessage {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Transaction $transaction
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_StatusResponseMessage();

		$message->result = Pronamic_WP_Pay_XML_Security::filter( $xml['result'] );

		// E-wallet
		if ( $xml->ewallet ) {
			$ewallet = new stdClass();
			$ewallet->id = Pronamic_WP_Pay_XML_Security::filter( $xml->ewallet->id );
			$ewallet->status = Pronamic_WP_Pay_XML_Security::filter( $xml->ewallet->status );
			$ewallet->created = Pronamic_WP_Pay_XML_Security::filter( $xml->ewallet->created );
			$ewallet->modified = Pronamic_WP_Pay_XML_Security::filter( $xml->ewallet->modified );
			$ewallet->reason_code = Pronamic_WP_Pay_XML_Security::filter( $xml->ewallet->reasoncode );
			$ewallet->reason = Pronamic_WP_Pay_XML_Security::filter( $xml->ewallet->reason );

			$message->ewallet = $ewallet;
		}

		// Customer
		if ( $xml->customer ) {
			$customer = new stdClass();
			$customer->currency = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->currency );
			$customer->amount = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->amount );
			$customer->exchange_rate = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->exchange_rate );
			$customer->first_name = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->firstname );
			$customer->last_name = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->lastname );
			$customer->last_name = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->lastname );
			$customer->city = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->city );
			$customer->state = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->state );
			$customer->country = Pronamic_WP_Pay_XML_Security::filter( $xml->customer->country );

			$message->customer = $customer;
		}

		// Transaction
		if ( $xml->transaction ) {
			$transaction = new stdClass();
			$transaction->id = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->id );
			$transaction->currency = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->currency );
			$transaction->amount = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->amount );
			$transaction->description = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->description );
			$transaction->var1 = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->var1 );
			$transaction->var2 = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->var2 );
			$transaction->var3 = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->var3 );
			$transaction->items = Pronamic_WP_Pay_XML_Security::filter( $xml->transaction->items );

			$message->transaction = $transaction;
		}

		// Payment details
		if ( $xml->paymentdetails ) {
			$payment_details = new stdClass();
			$payment_details->type = Pronamic_WP_Pay_XML_Security::filter( $xml->paymentdetails->type );
			$payment_details->account_iban = Pronamic_WP_Pay_XML_Security::filter( $xml->paymentdetails->accountiban );
			$payment_details->account_bic = Pronamic_WP_Pay_XML_Security::filter( $xml->paymentdetails->accountbic );
			$payment_details->account_id = Pronamic_WP_Pay_XML_Security::filter( $xml->paymentdetails->accountid );
			$payment_details->account_holder_name = Pronamic_WP_Pay_XML_Security::filter( $xml->paymentdetails->accountholdername );
			$payment_details->external_transaction_id = Pronamic_WP_Pay_XML_Security::filter( $xml->paymentdetails->externaltransactionid );

			$message->payment_details = $payment_details;
		}

		return $message;
	}
}
