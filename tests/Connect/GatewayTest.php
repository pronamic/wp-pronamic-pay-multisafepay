<?php

class Pronamic_Pay_Gateways_MultiSafepay_Connect_GatewayTest extends WP_UnitTestCase {
	/**
	 * Pre HTTP request
	 *
	 * @see https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 * @return string
	 */
	public function pre_http_request( $preempt, $request, $url ) {
		$response = file_get_contents( dirname( __FILE__ ) . '/Mock/ideal-issuers-response.http' );

		$processed_response = WP_Http::processResponse( $response );

		$processed_headers = WP_Http::processHeaders( $processed_response['headers'], $url );
		$processed_headers['body'] = $processed_response['body'];

		return $processed_headers;
	}

	function test_init() {
		// Mock HTTP request
		//add_action( 'http_api_debug', array( $this, 'http_api_debug' ), 10, 5 );
		add_filter( 'pre_http_request', array( $this, 'pre_http_request' ), 10, 3 );

		// Other
		$config = new Pronamic_WP_Pay_Gateways_MultiSafepay_Config();

		$config->mode       = getenv( 'MULTISAFEPAY_MODE' );
		$config->account_id = getenv( 'MULTISAFEPAY_ACCOUNT_ID' );
		$config->site_id    = getenv( 'MULTISAFEPAY_SITE_ID' );
		$config->site_code  = getenv( 'MULTISAFEPAY_SECURE_CODE' );

		if ( 'test' === $config->mode ) {
			$config->api_url = Pronamic_WP_Pay_Gateways_MultiSafepay_MultiSafepay::API_TEST_URL;
		} else {
			$config->api_url = Pronamic_WP_Pay_Gateways_MultiSafepay_MultiSafepay::API_PRODUCTION_URL;
		}

		$gateway = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Gateway( $config );

		$issuers = $gateway->get_issuers();

		$expected = array(
			array(
				'options' => array(
					'3151' => 'Test bank',
				),
			),
		);

		$this->assertEquals( $expected, $issuers );
	}
}
