<?php

class Pronamic_Pay_Gateways_MultiSafepay_Connect_GatewaysTest extends WP_UnitTestCase {
	/**
	 * Pre HTTP request
	 *
	 * @see https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 * @return string
	 */
	public function pre_http_request( $preempt, $request, $url ) {
		$response = file_get_contents( dirname( __FILE__ ) . '/Mock/gateways-response.http' );

		$processedResponse = WP_Http::processResponse( $response );

		$processedHeaders = WP_Http::processHeaders( $processedResponse['headers'], $url );
		$processedHeaders['body'] = $processedResponse['body'];

		return $processedHeaders;
	}

	public function http_api_debug( $response, $context, $class, $args, $url ) {

	}

	function test_init() {
		// Mock HTTP request
		//add_action( 'http_api_debug', array( $this, 'http_api_debug' ), 10, 5 );
		add_filter( 'pre_http_request', array( $this, 'pre_http_request' ), 10, 3 );

		// Config
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

		// Client
		$client = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Client();
		$client->api_url = $config->api_url;

		// Merchant
		$merchant = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Merchant();
		$merchant->account = $config->account_id;
		$merchant->site_id = $config->site_id;
		$merchant->site_secure_code = $config->site_code;

		// Customer
		$customer = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Customer();
		$customer->locale = get_locale();

		// Gateways
		$gateways = $client->get_gateways( $merchant, $customer );

		$expected = array(
			'VISA'       => 'Visa',
			'GIROPAY'    => 'Giropay',
			'PAYAFTER'   => 'Pay After Delivery',
			'IDEAL'      => 'iDEAL',
			'DIRECTBANK' => 'SOFORT Banking',
			'BANKTRANS'  => 'Wire Transfer',
			'MASTERCARD' => 'MasterCard',
		);

		$this->assertEquals( $expected, $gateways );
	}
}
