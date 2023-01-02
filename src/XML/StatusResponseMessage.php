<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use SimpleXMLElement;
use stdClass;

/**
 * Title: MultiSafepay Connect XML status response message
 * Description:
 * Copyright: 2005-2023 Pronamic
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

		if ( isset( $xml['result'] ) ) {
			$message->result = (string) $xml['result'];
		}

		// E-wallet
		if ( $xml->ewallet ) {
			$ewallet = new stdClass();

			$ewallet->id          = (string) $xml->ewallet->id;
			$ewallet->status      = (string) $xml->ewallet->status;
			$ewallet->created     = (string) $xml->ewallet->created;
			$ewallet->modified    = (string) $xml->ewallet->modified;
			$ewallet->reason_code = (string) $xml->ewallet->reasoncode;
			$ewallet->reason      = (string) $xml->ewallet->reason;

			$message->ewallet = $ewallet;
		}

		// Customer
		if ( $xml->customer ) {
			$customer = new stdClass();

			$customer->currency      = (string) $xml->customer->currency;
			$customer->amount        = (string) $xml->customer->amount;
			$customer->exchange_rate = (string) $xml->customer->exchange_rate;
			$customer->first_name    = (string) $xml->customer->firstname;
			$customer->last_name     = (string) $xml->customer->lastname;
			$customer->last_name     = (string) $xml->customer->lastname;
			$customer->city          = (string) $xml->customer->city;
			$customer->state         = (string) $xml->customer->state;
			$customer->country       = (string) $xml->customer->country;

			$message->customer = $customer;
		}

		// Transaction
		if ( $xml->transaction ) {
			$transaction = new stdClass();

			$transaction->id          = (string) $xml->transaction->id;
			$transaction->currency    = (string) $xml->transaction->currency;
			$transaction->amount      = (string) $xml->transaction->amount;
			$transaction->description = (string) $xml->transaction->description;
			$transaction->var1        = (string) $xml->transaction->var1;
			$transaction->var2        = (string) $xml->transaction->var2;
			$transaction->var3        = (string) $xml->transaction->var3;
			$transaction->items       = (string) $xml->transaction->items;

			$message->transaction = $transaction;
		}

		// Payment details
		if ( $xml->paymentdetails ) {
			$payment_details = new stdClass();

			$payment_details->type                    = (string) $xml->paymentdetails->type;
			$payment_details->account_iban            = (string) $xml->paymentdetails->accountiban;
			$payment_details->account_bic             = (string) $xml->paymentdetails->accountbic;
			$payment_details->account_id              = (string) $xml->paymentdetails->accountid;
			$payment_details->account_holder_name     = (string) $xml->paymentdetails->accountholdername;
			$payment_details->external_transaction_id = (string) $xml->paymentdetails->externaltransactionid;

			$message->payment_details = $payment_details;
		}

		return $message;
	}
}
