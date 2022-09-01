<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use WP_Http;
use WP_UnitTestCase;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\MultiSafepay;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Config;

class GatewaysTest extends WP_UnitTestCase {
	/**
	 * Pre HTTP request
	 *
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 * @return string
	 */
	public function pre_http_request( $preempt, $request, $url ) {
		$response = file_get_contents( dirname( dirname( __FILE__ ) ) . '/Mock/gateways-response.http' );

		$processed_response = WP_Http::processResponse( $response );

		$processed_headers = WP_Http::processHeaders( $processed_response['headers'], $url );

		$processed_headers['body'] = $processed_response['body'];

		return $processed_headers;
	}

	public function http_api_debug( $response, $context, $class, $args, $url ) {

	}

	public function test_init() {
		// Mock HTTP request
		//add_action( 'http_api_debug', array( $this, 'http_api_debug' ), 10, 5 );
		add_filter( 'pre_http_request', [ $this, 'pre_http_request' ], 10, 3 );

		// Config
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

		// Client
		$client = new Client();

		$client->api_url = $config->api_url;

		// Merchant
		$merchant = new Merchant();

		$merchant->account          = $config->account_id;
		$merchant->site_id          = $config->site_id;
		$merchant->site_secure_code = $config->site_code;

		// Customer
		$customer = new Customer();

		$customer->locale = get_locale();

		// Gateways
		$gateways = $client->get_gateways( $merchant, $customer );

		$expected = [
			'VISA'       => 'Visa',
			'GIROPAY'    => 'Giropay',
			'PAYAFTER'   => 'Pay After Delivery',
			'IDEAL'      => 'iDEAL',
			'DIRECTBANK' => 'SOFORT Banking',
			'BANKTRANS'  => 'Wire Transfer',
			'MASTERCARD' => 'MasterCard',
		];

		$this->assertEquals( $expected, $gateways );
	}
}
