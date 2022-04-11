<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;

/**
 * Title: MultiSafepay Connect integration
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.5
 * @since   1.2.6
 */
class Integration extends AbstractGatewayIntegration {
	/**
	 * API URL.
	 * 
	 * @var string
	 */
	private $api_url;

	/**
	 * Construct Mollie iDEAL integration.
	 *
	 * @param array $args Arguments.
	 */
	public function __construct( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'id'            => 'multisafepay-connect',
				'name'          => 'MultiSafepay - Connect',
				'api_url'       => MultiSafepay::API_PRODUCTION_URL,
				'url'           => 'http://www.multisafepay.com/',
				'product_url'   => \__( 'http://www.multisafepay.com/', 'pronamic_ideal' ),
				'dashboard_url' => 'https://merchant.multisafepay.com/',
				'provider'      => 'multisafepay',
				'supports'      => array(
					'payment_status_request',
					'webhook',
					'webhook_no_config',
				),
				'manual_url'    => \__( 'https://www.pronamic.eu/support/how-to-connect-multisafepay-with-wordpress-via-pronamic-pay/', 'pronamic_ideal' ),
			)
		);

		parent::__construct( $args );

		$this->api_url = $args['api_url'];

		// Filters.
		$function = array( WooCommerce::class, 'woocommerce_available_payment_gateways' );

		if ( ! \has_filter( 'woocommerce_available_payment_gateways', $function ) ) {
			\add_filter( 'woocommerce_available_payment_gateways', $function, 10 );
		}
	}

	/**
	 * Get settings fields.
	 *
	 * @return array
	 */
	public function get_settings_fields() {
		$fields = array();

		// Account ID.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_multisafepay_account_id',
			'title'    => __( 'Account ID', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'code' ),
			'tooltip'  => sprintf(
				'%s %s.',
				__( 'Account ID', 'pronamic_ideal' ),
				/* translators: %s: payment provider name */
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		// Site ID.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_multisafepay_site_id',
			'title'    => __( 'Site ID', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'code' ),
			'tooltip'  => sprintf(
				'%s %s.',
				__( 'Site ID', 'pronamic_ideal' ),
				/* translators: %s: payment provider name */
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		// Site Security Code.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_multisafepay_site_code',
			'title'    => __( 'Site Security Code', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'code' ),
			'tooltip'  => sprintf(
				'%s %s.',
				__( 'Site Security Code', 'pronamic_ideal' ),
				/* translators: %s: payment provider name */
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		return $fields;
	}

	/**
	 * Get config.
	 *
	 * @param int $post_id Gateway configuration post ID.
	 * @return Config
	 */
	public function get_config( $post_id ) {
		$config = new Config();

		$config->set_api_url( $this->api_url );

		$config->account_id = (string) get_post_meta( $post_id, '_pronamic_gateway_multisafepay_account_id', true );
		$config->site_id    = (string) get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_id', true );
		$config->site_code  = (string) get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_code', true );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $post_id ) {
		return new Gateway( $this->get_config( $post_id ) );
	}
}
