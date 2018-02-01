<?php

use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\Transaction;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\RedirectTransactionResponseMessage;

class Pronamic_Pay_Gateways_MultiSafepay_Connect_TestRedirectTransactionParser extends WP_UnitTestCase {
	/**
	 * Test init
	 */
	public function test_init() {
		$filename = dirname( __FILE__ ) . '/Mock/redirect-transaction-response.xml';

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
		$message = RedirectTransactionResponseMessage::parse( $simplexml );

		$this->assertInstanceOf( 'Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\RedirectTransactionResponseMessage', $message );

		return $message;
	}

	/**
	 * Test values
	 *
	 * @depends test_parser
	 */
	public function test_values( $message ) {
		$expected = new RedirectTransactionResponseMessage();

		$expected->result = 'ok';

		$transaction = new Transaction();

		$transaction->id          = 'ABCD1234';
		$transaction->payment_url = 'http://www.multisafepay.com/pay/...&lang=en';

		$expected->transaction = $transaction;

		$this->assertEquals( $expected, $message );
	}
}
