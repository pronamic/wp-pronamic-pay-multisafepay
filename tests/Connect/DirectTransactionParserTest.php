<?php

class Pronamic_Pay_Gateways_MultiSafepay_Connect_DirectTransactionParserTest extends WP_UnitTestCase {
	function test_init() {
		$filename = dirname( __FILE__ ) . '/Mock/direct-transaction-response.xml';

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
		$message = Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionResponseMessage::parse( $simplexml );

		$this->assertInstanceOf( 'Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionResponseMessage', $message );

		return $message;
	}

	/**
	 * Test values
	 *
	 * @depends test_parser
	 */
	function test_values( $message ) {
		$expected = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionResponseMessage();
		$expected->result = 'ok';

		$expected->transaction = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Transaction();
		$expected->transaction->id = '554202bb33498';

		$expected->gateway_info = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_GatewayInfo();
		$expected->gateway_info->redirect_url = 'http://testpay.multisafepay.com/simulator/ideal?trxid=10447735643871196&ideal=prob&issuerid=3151&merchantReturnURL=https%3A%2F%2Ftestpay%2Emultisafepay%2Ecom%2Fdirect%2Fcomplete%2F%3Fid%3D9943038943576689';
		$expected->gateway_info->ext_var      = 'https://testpay.multisafepay.com/direct/complete/';
		$expected->gateway_info->issuer_id    = '3151';

		$this->assertEquals( $expected, $message );
	}
}
