<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

use Pronamic\WordPress\Pay\Core\Util as Core_Util;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\MultiSafepay;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\DirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\DirectTransactionResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\GatewaysRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\GatewaysResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\IDealIssuersRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\IDealIssuersResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\RedirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\RedirectTransactionResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\StatusRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\StatusResponseMessage;
use WP_Error;

/**
 * Title: MultiSafepay Connect client
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class Client {
	/**
	 * Error
	 *
	 * @var WP_Error
	 */
	private $error;

	/**
	 * API URL
	 *
	 * @var string
	 */
	public $api_url;

	/**
	 * Constructs and initializes an MultiSafepay Connect client
	 */
	public function __construct() {
		$this->api_url = MultiSafepay::API_PRODUCTION_URL;
	}

	/**
	 * Get error
	 *
	 * @return WP_Error
	 */
	public function get_error() {
		return $this->error;
	}

	private function parse_xml( $xml ) {
		switch ( $xml->getName() ) {
			case IDealIssuersRequestMessage::NAME:
				return IDealIssuersResponseMessage::parse( $xml );

			case GatewaysRequestMessage::NAME:
				return GatewaysResponseMessage::parse( $xml );

			case DirectTransactionRequestMessage::NAME:
				return DirectTransactionResponseMessage::parse( $xml );

			case RedirectTransactionRequestMessage::NAME:
				return RedirectTransactionResponseMessage::parse( $xml );

			case StatusRequestMessage::NAME:
				return StatusResponseMessage::parse( $xml );
		}

		return false;
	}

	private function request( $message ) {
		$return = false;

		$result = Core_Util::remote_get_body( $this->api_url, 200, array(
			'method' => 'POST',
			'body'   => (string) $message,
		) );

		if ( is_wp_error( $result ) ) {
			$this->error = $result;

			return false;
		}

		$xml = Core_Util::simplexml_load_string( $result );

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

	/**
	 * Get iDEAL issuers
	 *
	 * @since 1.2.0
	 */
	public function get_ideal_issuers( $merchant ) {
		$return = false;

		$request = new IDealIssuersRequestMessage( $merchant );

		$response = $this->request( $request );

		if ( $response ) {
			$return = $response->issuers;
		}

		return $return;
	}

	/**
	 * Get gateways
	 *
	 * @since 1.2.0
	 */
	public function get_gateways( $merchant, $customer ) {
		$return = false;

		$request = new GatewaysRequestMessage( $merchant, $customer );

		$response = $this->request( $request );

		if ( $response ) {
			$return = $response->gateways;
		}

		return $return;
	}

	/**
	 * Start transaction
	 *
	 * @param array $message
	 */
	public function start_transaction( $message ) {
		$return = false;

		$response = $this->request( $message );

		if ( $response ) {
			$return = $response;
		}

		return $return;
	}

	/**
	 * Get status
	 *
	 * @param array $message
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
