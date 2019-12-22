<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use WP_Http;
use WP_UnitTestCase;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\MultiSafepay;

/**
 * Title: MultiSafepay gateway test
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.5
 * @since   1.2.0
 */
class GatewayTest extends WP_UnitTestCase {
	/**
	 * Pre HTTP request
	 *
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 * @return string
	 */
	public function pre_http_request( $preempt, $request, $url ) {
		$response = file_get_contents( dirname( dirname( __FILE__ ) ) . '/Mock/ideal-issuers-response.http' );

		$processed_response = WP_Http::processResponse( $response );

		$processed_headers = WP_Http::processHeaders( $processed_response['headers'], $url );

		$processed_headers['body'] = $processed_response['body'];

		return $processed_headers;
	}

	public function test_init() {
		// Mock HTTP request
		//add_action( 'http_api_debug', array( $this, 'http_api_debug' ), 10, 5 );
		add_filter( 'pre_http_request', array( $this, 'pre_http_request' ), 10, 3 );

		// Other
		$config = new Config();

		$config->mode       = getenv( 'MULTISAFEPAY_MODE' );
		$config->account_id = getenv( 'MULTISAFEPAY_ACCOUNT_ID' );
		$config->site_id    = getenv( 'MULTISAFEPAY_SITE_ID' );
		$config->site_code  = getenv( 'MULTISAFEPAY_SECURE_CODE' );

		if ( Gateway::MODE_TEST === $config->mode ) {
			$config->api_url = MultiSafepay::API_TEST_URL;
		} else {
			$config->api_url = MultiSafepay::API_PRODUCTION_URL;
		}

		$gateway = new Gateway( $config );

		try {
			$issuers = $gateway->get_issuers();
		} catch ( \Exception $e ) {
			$issuers = null;
		}

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
