<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Http\Facades\Http;
use Pronamic\WordPress\Pay\Core\Util as Core_Util;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\DirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\DirectTransactionResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\GatewaysRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\GatewaysResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\IDealIssuersRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\IDealIssuersResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\RedirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\RedirectTransactionResponseMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\StatusRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\StatusResponseMessage;
use SimpleXMLElement;

/**
 * Title: MultiSafepay Connect client
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.5
 * @since   1.0.0
 */
class Client {
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
	 * Parse XML.
	 *
	 * @param SimpleXMLElement $xml XML to parse.
	 * @return false|IDealIssuersResponseMessage|GatewaysResponseMessage|DirectTransactionResponseMessage|RedirectTransactionResponseMessage|StatusResponseMessage
	 */
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

	/**
	 * Request.
	 *
	 * @param string $message Message.
	 * @return false|DirectTransactionResponseMessage|GatewaysResponseMessage|IDealIssuersResponseMessage|RedirectTransactionResponseMessage|StatusResponseMessage
	 */
	private function request( $message ) {
		$response = Http::request(
			$this->api_url,
			[
				'method' => 'POST',
				'body'   => (string) $message,
			]
		);

		$xml = $response->simplexml();

		$return = $this->parse_xml( $xml );

		if ( is_object( $return ) && isset( $return->result ) && 'error' === $return->result ) {
			throw new \Exception(
				\esc_html( $xml->error->description )
			);
		}

		return $return;
	}

	/**
	 * Get iDEAL issuers
	 *
	 * @param Merchant $merchant Merchant.
	 * @return false|array<string, string>
	 * @since 1.2.0
	 */
	public function get_ideal_issuers( $merchant ) {
		$request = new IDealIssuersRequestMessage( $merchant );

		$response = $this->request( $request );

		if ( ! ( $response instanceof IDealIssuersResponseMessage ) ) {
			return false;
		}

		return $response->issuers;
	}

	/**
	 * Get gateways.
	 *
	 * @param Merchant $merchant Merchant.
	 * @param Customer $customer Customer.
	 * @return false|array<string, string>
	 * @since 1.2.0
	 */
	public function get_gateways( Merchant $merchant, Customer $customer ) {
		$request = new GatewaysRequestMessage( $merchant, $customer );

		$response = $this->request( $request );

		if ( ! ( $response instanceof GatewaysResponseMessage ) ) {
			return false;
		}

		return $response->gateways;
	}

	/**
	 * Start transaction
	 *
	 * @param DirectTransactionRequestMessage|RedirectTransactionRequestMessage $message Message.
	 * @return false|DirectTransactionResponseMessage|RedirectTransactionResponseMessage
	 */
	public function start_transaction( $message ) {
		$response = $this->request( $message );

		if (
			! ( $response instanceof DirectTransactionResponseMessage )
				&&
			! ( $response instanceof RedirectTransactionResponseMessage )
		) {
			return false;
		}

		return $response;
	}

	/**
	 * Get status
	 *
	 * @param StatusRequestMessage $message Message.
	 * @return false|StatusResponseMessage
	 */
	public function get_status( StatusRequestMessage $message ) {
		$response = $this->request( $message );

		if ( ! ( $response instanceof StatusResponseMessage ) ) {
			return false;
		}

		return $response;
	}
}
