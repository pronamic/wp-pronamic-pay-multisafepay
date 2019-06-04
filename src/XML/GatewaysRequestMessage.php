<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Util as XML_Util;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Customer;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Merchant;

/**
 * Title: MultiSafepay Connect XML gateways request message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.0
 */
class GatewaysRequestMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'gateways';

	/**
	 * Constructs and initialize an directory response message
	 *
	 * @param Merchant $merchant Merchant.
	 * @param Customer $customer Customer.
	 */
	public function __construct( Merchant $merchant, Customer $customer ) {
		parent::__construct( self::NAME );

		$this->merchant = $merchant;
		$this->customer = $customer;
	}

	/**
	 * Get document
	 *
	 * @see Pronamic_Gateways_IDealAdvancedV3_XML_RequestMessage::get_document()
	 */
	public function get_document() {
		$document = parent::get_document();

		// Merchant.
		$merchant = XML_Util::add_element( $document, $document->documentElement, 'merchant' );

		XML_Util::add_elements(
			$document,
			$merchant,
			array(
				'account'          => $this->merchant->account,
				'site_id'          => $this->merchant->site_id,
				'site_secure_code' => $this->merchant->site_secure_code,
			)
		);

		// Customer.
		$customer = XML_Util::add_element( $document, $document->documentElement, 'customer' );

		XML_Util::add_elements(
			$document,
			$customer,
			array(
				'country' => $this->customer->country,
				'locale'  => $this->customer->locale,
			)
		);

		return $document;
	}
}
