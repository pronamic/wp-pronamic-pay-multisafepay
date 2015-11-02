<?php

/**
 * Title: MultiSafepay gateway settings
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.2.0
 * @since 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_GatewaySettings extends Pronamic_WP_Pay_GatewaySettings {
	public function __construct() {
		add_filter( 'pronamic_pay_gateway_sections', array( $this, 'sections' ) );
		add_filter( 'pronamic_pay_gateway_fields', array( $this, 'fields' ) );
	}

	public function sections( array $sections ) {
		// iDEAL
		$sections['multisafepay'] = array(
			'title'   => __( 'MultiSafepay', 'pronamic_ideal' ),
			'methods' => array( 'multisafepay_connect' ),
		);

		// Return
		return $sections;
	}

	public function fields( array $fields ) {
		// Partner ID
		$fields[] = array(
			'section'     => 'multisafepay',
			'meta_key'    => '_pronamic_gateway_multisafepay_account_id',
			'title'       => __( 'Account ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'methods'     => array( 'multisafepay_connect' ),
		);

		$fields[] = array(
			'section'     => 'multisafepay',
			'meta_key'    => '_pronamic_gateway_multisafepay_site_id',
			'title'       => __( 'Site ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'methods'     => array( 'multisafepay_connect' ),
		);

		$fields[] = array(
			'section'     => 'multisafepay',
			'meta_key'    => '_pronamic_gateway_multisafepay_site_code',
			'title'       => __( 'Site Security Code', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
			'methods'     => array( 'multisafepay_connect' ),
		);

		// Return
		return $fields;
	}
}
