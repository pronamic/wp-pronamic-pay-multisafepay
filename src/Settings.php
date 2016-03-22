<?php

/**
 * Title: MultiSafepay gateway settings
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.1.4
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Settings extends Pronamic_WP_Pay_GatewaySettings {
	public function __construct() {
		add_filter( 'pronamic_pay_gateway_sections', array( $this, 'sections' ) );
		add_filter( 'pronamic_pay_gateway_fields', array( $this, 'fields' ) );
	}

	public function sections( array $sections ) {
		// iDEAL
		$sections['multisafepay'] = array(
			'title'       => __( 'MultiSafepay', 'pronamic_ideal' ),
			'methods'     => array( 'multisafepay' ),
			'description' => sprintf(
				__( 'Account details are provided by %s after registration. These settings need to match with the %1$s dashboard.', 'pronamic_ideal' ),
				__( 'MultiSafepay', 'pronamic_ideal' )
			),
		);

		// Return sections
		return $sections;
	}

	public function fields( array $fields ) {
		// Account ID
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'multisafepay',
			'meta_key'    => '_pronamic_gateway_multisafepay_account_id',
			'title'       => __( 'Account ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'methods'     => array( 'multisafepay_connect' ),
			'tooltip'     => sprintf(
				'%s %s.',
				__( 'Account ID', 'pronamic_ideal' ),
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		// Site ID
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'multisafepay',
			'meta_key'    => '_pronamic_gateway_multisafepay_site_id',
			'title'       => __( 'Site ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'methods'     => array( 'multisafepay_connect' ),
			'tooltip'     => sprintf(
				'%s %s.',
				__( 'Site ID', 'pronamic_ideal' ),
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		// Site Security Code
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'multisafepay',
			'meta_key'    => '_pronamic_gateway_multisafepay_site_code',
			'title'       => __( 'Site Security Code', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'methods'     => array( 'multisafepay_connect' ),
			'tooltip'     => sprintf(
				'%s %s.',
				__( 'Site Security Code', 'pronamic_ideal' ),
				sprintf( __( 'as mentioned in the %s dashboard', 'pronamic_ideal' ), __( 'MultiSafepay', 'pronamic_ideal' ) )
			),
		);

		// Transaction feedback
		$fields[] = array(
			'section'     => 'multisafepay',
			'title'       => __( 'Transaction feedback', 'pronamic_ideal' ),
			'type'        => 'description',
			'html'        => sprintf(
				'<span class="dashicons dashicons-yes"></span> %s',
				__( 'Payment status updates will be processed without any additional configuration.', 'pronamic_ideal' )
			),
		);

		// Return fields
		return $fields;
	}
}
