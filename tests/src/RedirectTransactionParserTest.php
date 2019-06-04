<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use WP_UnitTestCase;

class RedirectTransactionParserTest extends WP_UnitTestCase {
	/**
	 * Test init
	 */
	public function test_init() {
		$filename = dirname( dirname( dirname( __FILE__ ) ) ) . '/Mock/redirect-transaction-response.xml';

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
		$message = XML\RedirectTransactionResponseMessage::parse( $simplexml );

		$this->assertInstanceOf( __NAMESPACE__ . '\XML\RedirectTransactionResponseMessage', $message );

		return $message;
	}

	/**
	 * Test values
	 *
	 * @depends test_parser
	 */
	public function test_values( $message ) {
		$expected = new XML\RedirectTransactionResponseMessage();

		$expected->result = 'ok';

		$transaction = new Transaction();

		$transaction->id          = 'ABCD1234';
		$transaction->payment_url = 'http://www.multisafepay.com/pay/...&lang=en';

		$expected->transaction = $transaction;

		$this->assertEquals( $expected, $message );
	}
}
