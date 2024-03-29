<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use WP_UnitTestCase;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\IDealIssuersResponseMessage;

class IDealIssuersParserTest extends WP_UnitTestCase {
	/**
	 * Test init
	 */
	public function test_init() {
		$filename = dirname( __DIR__ ) . '/Mock/ideal-issuers-response.xml';

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
		$message = IDealIssuersResponseMessage::parse( $simplexml );

		$this->assertInstanceOf( 'Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\IDealIssuersResponseMessage', $message );

		return $message;
	}

	/**
	 * Test values
	 *
	 * @depends test_parser
	 */
	public function test_values( $message ) {
		$expected = new IDealIssuersResponseMessage();

		$expected->issuers = [
			'0031' => 'ABN AMRO',
			'0751' => 'SNS Bank',
			'0721' => 'ING',
			'0021' => 'Rabobank',
			'0091' => 'Friesland Bank',
			'0761' => 'ASN Bank',
			'0771' => 'SNS Regio Bank',
			'0511' => 'Triodos Bank',
			'0161' => 'Van Lanschot Bankiers',
		];

		$this->assertEquals( $expected, $message );
	}
}
