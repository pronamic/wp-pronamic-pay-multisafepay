<?php

class Pronamic_Pay_Gateways_MultiSafepay_Connect_IDealIssuersParserTest extends WP_UnitTestCase {
	/**
	 * Test init
	 */
	function test_init() {
		$filename = dirname( __FILE__ ) . '/Mock/ideal-issuers-response.xml';

		$simplexml = simplexml_load_file( $filename );

		$this->assertInstanceOf( 'SimpleXMLElement', $simplexml );

		return $simplexml;
	}

	/**
	 * Test parser
	 *
	 * @depends test_init
	 */
	function test_parser( $simplexml ) {
		$message = Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersResponseMessage::parse( $simplexml );

		$this->assertInstanceOf( 'Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersResponseMessage', $message );

		return $message;
	}

	/**
	 * Test values
	 *
	 * @depends test_parser
	 */
	function test_values( $message ) {
		$expected = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersResponseMessage();
		$expected->issuers = array(
			'0031' => 'ABN AMRO',
			'0751' => 'SNS Bank',
			'0721' => 'ING',
			'0021' => 'Rabobank',
			'0091' => 'Friesland Bank',
			'0761' => 'ASN Bank',
			'0771' => 'SNS Regio Bank',
			'0511' => 'Triodos Bank',
			'0161' => 'Van Lanschot Bankiers',
		);

		$this->assertEquals( $expected, $message );
	}
}
