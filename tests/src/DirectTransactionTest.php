<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use stdClass;
use WP_Http;
use WP_UnitTestCase;
use Pronamic\WordPress\Pay\Core\Server;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\MultiSafepay;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Config;

class DirectTransactionTest extends WP_UnitTestCase {
	/**
	 * Pre HTTP request
	 *
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 * @return string
	 */
	public function pre_http_request( $preempt, $request, $url ) {
		$response = file_get_contents( dirname( __DIR__ ) . '/Mock/direct-transaction-response.http' );

		$processed_response = WP_Http::processResponse( $response );

		$processed_headers = WP_Http::processHeaders( $processed_response['headers'], $url );

		$processed_headers['body'] = $processed_response['body'];

		return $processed_headers;
	}

	public function http_api_debug( $response, $context, $c, $args, $url ) {
	}

	public function test_init() {
		// Actions
		// add_action( 'http_api_debug', array( $this, 'http_api_debug' ), 10, 5 );
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

		// Message
		$merchant = new Merchant();

		$merchant->account          = $config->account_id;
		$merchant->site_id          = $config->site_id;
		$merchant->site_secure_code = $config->site_code;
		$merchant->notification_url = home_url();
		$merchant->redirect_url     = home_url();
		$merchant->cancel_url       = home_url();
		$merchant->close_window     = 'false';

		$customer = new Customer();

		$customer->locale       = get_locale();
		$customer->ip_address   = Server::get( 'REMOTE_ADDR', FILTER_VALIDATE_IP );
		$customer->forwarded_ip = Server::get( 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP );
		$customer->first_name   = '';
		$customer->last_name    = '';
		$customer->address_1    = 'Test';
		$customer->address_2    = '';
		$customer->house_number = '1';
		$customer->zip_code     = '1234 AB';
		$customer->city         = 'Test';
		$customer->country      = 'Test';
		$customer->phone        = '';
		$customer->email        = get_option( 'admin_email' );

		$transaction = new Transaction();

		$transaction->id          = uniqid();
		$transaction->currency    = 'EUR';
		$transaction->amount      = 123;
		$transaction->description = 'Test';
		$transaction->var1        = '';
		$transaction->var2        = '';
		$transaction->var3        = '';
		$transaction->items       = '';
		$transaction->manual      = 'false';
		$transaction->gateway     = '';
		$transaction->days_active = '';
		$transaction->gateway     = Methods::IDEAL;
		// $transaction->gateway     = Pronamic\WordPress\Pay\Gateways\MultiSafepay\Gateways::MASTERCARD;
		// $transaction->gateway     = Pronamic\WordPress\Pay\Gateways\MultiSafepay\Gateways::BANK_TRANSFER;

		// $gateway_info = null;
		$gateway_info = new GatewayInfo();

		$gateway_info->issuer_id = '3151';

		$message = new XML\DirectTransactionRequestMessage( $merchant, $customer, $transaction, $gateway_info );

		$signature = Signature::generate( $transaction->amount, $transaction->currency, $merchant->account, $merchant->site_id, $transaction->id );

		$message->signature = $signature;

		// Response
		$response = $client->start_transaction( $message );

		// Expected
		$expected = new XML\DirectTransactionResponseMessage();

		$expected->result = 'ok';

		$expected->transaction = new Transaction();

		$expected->transaction->id = '554202bb33498';

		$expected->gateway_info = new GatewayInfo();

		$expected->gateway_info->issuer_id    = '3151';
		$expected->gateway_info->redirect_url = 'http://testpay.multisafepay.com/simulator/ideal?trxid=10447735643871196&ideal=prob&issuerid=3151&merchantReturnURL=https%3A%2F%2Ftestpay%2Emultisafepay%2Ecom%2Fdirect%2Fcomplete%2F%3Fid%3D9943038943576689';
		$expected->gateway_info->ext_var      = 'https://testpay.multisafepay.com/direct/complete/';

		// Assert
		$this->assertEquals( $expected, $response );
	}
}
