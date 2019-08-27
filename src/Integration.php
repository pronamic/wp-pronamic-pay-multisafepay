<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Gateways\Common\AbstractIntegration;

/**
 * Title: MultiSafepay Connect integration
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.6
 */
class Integration extends AbstractIntegration {
	/**
	 * Integration constructor.
	 */
	public function __construct() {
		$this->id            = 'multisafepay-connect';
		$this->name          = 'MultiSafepay - Connect';
		$this->url           = 'http://www.multisafepay.com/';
		$this->product_url   = __( 'http://www.multisafepay.com/', 'pronamic_ideal' );
		$this->dashboard_url = 'https://merchant.multisafepay.com/';
		$this->provider      = 'multisafepay';
		$this->supports      = array(
			'payment_status_request',
			'webhook',
			'webhook_no_config',
		);
	}

	public function get_settings_fields() {
		$fields = array();

		// Account ID
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
				/* translators: %s: MultiSafepay */
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		// Site ID
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
				/* translators: %s: MultiSafepay */
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		// Site Security Code
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
				/* translators: %s: MultiSafepay */
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		return $fields;
	}

	/**
	 * Get config.
	 *
	 * @param $post_id
	 *
	 * @return Config
	 */
	public function get_config( $post_id ) {
		$config = new Config();

		$config->mode       = get_post_meta( $post_id, '_pronamic_gateway_mode', true );
		$config->account_id = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_account_id', true );
		$config->site_id    = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_id', true );
		$config->site_code  = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_code', true );

		if ( Gateway::MODE_TEST === $config->mode ) {
			$config->api_url = MultiSafepay::API_TEST_URL;
		} else {
			$config->api_url = MultiSafepay::API_PRODUCTION_URL;
		}

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
