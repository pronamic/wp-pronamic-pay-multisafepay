<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use stdClass;
use WP_UnitTestCase;

class StatusParserTest extends WP_UnitTestCase {
	public function test_init() {
		$filename = dirname( dirname( __FILE__ ) ) . '/Mock/status-response.xml';

		$simplexml = simplexml_load_file( $filename );

		$this->assertInstanceOf( 'SimpleXMLElement', $simplexml );

		return $simplexml;
	}

	/**
	 * Test parser
	 *
	 * @depends test_init
	 */
	public function test_parser( $simplexml ) {
		$message = XML\StatusResponseMessage::parse( $simplexml );

		$this->assertInstanceOf( __NAMESPACE__ . '\XML\StatusResponseMessage', $message );

		return $message;
	}

	/**
	 * Test values
	 *
	 * @depends test_parser
	 */
	public function test_values( $message ) {
		$expected = new XML\StatusResponseMessage();

		$expected->result = 'ok';

		// E-wallet
		$ewallet = new stdClass();

		$ewallet->id          = '12345';
		$ewallet->status      = 'completed';
		$ewallet->created     = '20070723171623';
		$ewallet->modified    = '20070903155907';
		$ewallet->reason_code = null;
		$ewallet->reason      = null;

		$expected->ewallet = $ewallet;

		// Customer
		$customer = new stdClass();

		$customer->currency      = 'EUR';
		$customer->amount        = '1000';
		$customer->exchange_rate = '1';
		$customer->first_name    = 'First';
		$customer->last_name     = 'Last';
		$customer->city          = 'City';
		$customer->state         = null;
		$customer->country       = 'NL';

		$expected->customer = $customer;

		// Transaction
		$transaction = new stdClass();

		$transaction->id          = 'ABCD1234';
		$transaction->currency    = 'EUR';
		$transaction->amount      = '1000';
		$transaction->description = 'My Description';
		$transaction->var1        = null;
		$transaction->var2        = null;
		$transaction->var3        = null;
		$transaction->items       = 'My Items';

		$expected->transaction = $transaction;

		// Payment Details
		$payment_details = new stdClass();

		$payment_details->type                    = 'IDEAL';
		$payment_details->account_iban            = null;
		$payment_details->account_bic             = null;
		$payment_details->account_id              = null;
		$payment_details->account_holder_name     = null;
		$payment_details->external_transaction_id = null;

		$expected->payment_details = $payment_details;

		$this->assertEquals( $expected, $message );
	}
}
