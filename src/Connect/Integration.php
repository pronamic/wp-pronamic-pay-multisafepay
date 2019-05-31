<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

use Pronamic\WordPress\Pay\Gateways\MultiSafepay\AbstractIntegration;

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
	}

	/**
	 * Get config factory class.
	 *
	 * @return string
	 */
	public function get_config_factory_class() {
		return __NAMESPACE__ . '\ConfigFactory';
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
			'methods'  => array( 'multisafepay_connect' ),
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
			'methods'  => array( 'multisafepay_connect' ),
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
			'methods'  => array( 'multisafepay_connect' ),
			'tooltip'  => sprintf(
				'%s %s.',
				__( 'Site Security Code', 'pronamic_ideal' ),
				/* translators: %s: MultiSafepay */
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		return $fields;
	}
}
