<?php

/**
 * Title: MultiSafepay Connect client
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.3.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Client {
	/**
	 * Error
	 *
	 * @var WP_Error
	 */
	private $error;

	/////////////////////////////////////////////////

	/**
	 * API URL
	 *
	 * @var string
	 */
	public $api_url;

	/////////////////////////////////////////////////

	/**
	 * Constructs and initializes an MultiSafepay Connect client
	 */
	public function __construct() {
		$this->api_url = Pronamic_WP_Pay_Gateways_MultiSafepay_MultiSafepay::API_PRODUCTION_URL;
	}

	/////////////////////////////////////////////////

	/**
	 * Get error
	 *
	 * @return WP_Error
	 */
	public function get_error() {
		return $this->error;
	}

	/////////////////////////////////////////////////

	private function parse_xml( $xml ) {
		switch ( $xml->getName() ) {
			case Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersRequestMessage::NAME :
				return Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersResponseMessage::parse( $xml );
			case Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_GatewaysRequestMessage::NAME :
				return Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_GatewaysResponseMessage::parse( $xml );
			case Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionRequestMessage::NAME :
				return Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionResponseMessage::parse( $xml );
			case Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RedirectTransactionRequestMessage::NAME :
				return Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RedirectTransactionResponseMessage::parse( $xml );
			case Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_StatusRequestMessage::NAME :
				return Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_StatusResponseMessage::parse( $xml );
		}

		return false;
	}

	/////////////////////////////////////////////////

	private function request( $message ) {
		$return = false;

		$result = Pronamic_WP_Pay_Util::remote_get_body( $this->api_url, 200, array(
			'method' => 'POST',
			'body'   => (string) $message,
		) );

		if ( is_wp_error( $result ) ) {
			$this->error = $result;

			return false;
		}

		$xml = Pronamic_WP_Pay_Util::simplexml_load_string( $result );

		if ( is_wp_error( $xml ) ) {
			$this->error = $xml;
		} else {
			$return = $this->parse_xml( $xml );

			if ( is_object( $return ) && isset( $return->result ) && 'error' === $return->result ) {
				$this->error = new WP_Error( 'multisafepay_error', $xml->error->description, $xml->error );
				$return      = false;
			}
		}

		return $return;
	}

	/////////////////////////////////////////////////

	/**
	 * Get iDEAL issuers
	 *
	 * @since 1.2.0
	 */
	public function get_ideal_issuers( $merchant ) {
		$request = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_IDealIssuersRequestMessage( $merchant );

		$response = $this->request( $request );

		return $response->issuers;
	}

	/////////////////////////////////////////////////

	/**
	 * Get gateways
	 *
	 * @since 1.2.0
	 */
	public function get_gateways( $merchant, $customer ) {
		$request = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_GatewaysRequestMessage( $merchant, $customer );

		$response = $this->request( $request );

		return $response->gateways;
	}

	/////////////////////////////////////////////////

	/**
	 * Start transaction
	 *
	 * @param array $data
	 */
	public function start_transaction( $message ) {
		$return = false;

		$response = $this->request( $message );

		if ( $response ) {
			$return = $response;
		}

		return $return;
	}

	/////////////////////////////////////////////////

	/**
	 * Get status
	 *
	 * @param array $data
	 */
	public function get_status( $message ) {
		$return = false;

		$response = $this->request( $message );

		if ( $response ) {
			$return = $response;
		}

		return $return;
	}
}
