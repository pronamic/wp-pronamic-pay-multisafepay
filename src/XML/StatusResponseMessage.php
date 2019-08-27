<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;
use stdClass;

/**
 * Title: MultiSafepay Connect XML status response message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class StatusResponseMessage {
	/**
	 * Result
	 *
	 * @var string
	 */
	public $result;

	/**
	 * E-wallet
	 *
	 * @var object
	 */
	public $ewallet;

	/**
	 * Customer
	 *
	 * @var object
	 */
	public $customer;

	/**
	 * Transaction
	 *
	 * @var object
	 */
	public $transaction;

	/**
	 * Payment details.
	 *
	 * @var object
	 */
	public $payment_details;

	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return StatusResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = new StatusResponseMessage();

		$message->result = Security::filter( $xml['result'] );

		// E-wallet
		if ( $xml->ewallet ) {
			$ewallet = new stdClass();

			$ewallet->id          = Security::filter( $xml->ewallet->id );
			$ewallet->status      = Security::filter( $xml->ewallet->status );
			$ewallet->created     = Security::filter( $xml->ewallet->created );
			$ewallet->modified    = Security::filter( $xml->ewallet->modified );
			$ewallet->reason_code = Security::filter( $xml->ewallet->reasoncode );
			$ewallet->reason      = Security::filter( $xml->ewallet->reason );

			$message->ewallet = $ewallet;
		}

		// Customer
		if ( $xml->customer ) {
			$customer = new stdClass();

			$customer->currency      = Security::filter( $xml->customer->currency );
			$customer->amount        = Security::filter( $xml->customer->amount );
			$customer->exchange_rate = Security::filter( $xml->customer->exchange_rate );
			$customer->first_name    = Security::filter( $xml->customer->firstname );
			$customer->last_name     = Security::filter( $xml->customer->lastname );
			$customer->last_name     = Security::filter( $xml->customer->lastname );
			$customer->city          = Security::filter( $xml->customer->city );
			$customer->state         = Security::filter( $xml->customer->state );
			$customer->country       = Security::filter( $xml->customer->country );

			$message->customer = $customer;
		}

		// Transaction
		if ( $xml->transaction ) {
			$transaction = new stdClass();

			$transaction->id          = Security::filter( $xml->transaction->id );
			$transaction->currency    = Security::filter( $xml->transaction->currency );
			$transaction->amount      = Security::filter( $xml->transaction->amount );
			$transaction->description = Security::filter( $xml->transaction->description );
			$transaction->var1        = Security::filter( $xml->transaction->var1 );
			$transaction->var2        = Security::filter( $xml->transaction->var2 );
			$transaction->var3        = Security::filter( $xml->transaction->var3 );
			$transaction->items       = Security::filter( $xml->transaction->items );

			$message->transaction = $transaction;
		}

		// Payment details
		if ( $xml->paymentdetails ) {
			$payment_details = new stdClass();

			$payment_details->type                    = Security::filter( $xml->paymentdetails->type );
			$payment_details->account_iban            = Security::filter( $xml->paymentdetails->accountiban );
			$payment_details->account_bic             = Security::filter( $xml->paymentdetails->accountbic );
			$payment_details->account_id              = Security::filter( $xml->paymentdetails->accountid );
			$payment_details->account_holder_name     = Security::filter( $xml->paymentdetails->accountholdername );
			$payment_details->external_transaction_id = Security::filter( $xml->paymentdetails->externaltransactionid );

			$message->payment_details = $payment_details;
		}

		return $message;
	}
}
