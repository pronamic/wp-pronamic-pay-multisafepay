<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use DOMDocument;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Customer;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Merchant;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Transaction;

/**
 * Title: MultiSafepay Connect XML request message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
abstract class RequestMessage extends Message {
	/**
	 * Merchant.
	 *
	 * @var Merchant
	 */
	protected $merchant;

	/**
	 * Customer.
	 *
	 * @var Customer
	 */
	protected $customer;

	/**
	 * Transaction.
	 *
	 * @var Transaction
	 */
	protected $transaction;

	/**
	 * Get the DOM document
	 *
	 * @return DOMDocument
	 */
	protected function get_document() {
		$document = new DOMDocument( parent::XML_VERSION, parent::XML_ENCODING );

		// We can't disable preserve white space and format the output
		// this is causing 'Invalid electronic signature' errors.
		$document->preserveWhiteSpace = true;
		$document->formatOutput       = true;

		// Root.
		$root = $document->createElement( $this->get_name() );

		$document->appendChild( $root );

		return $document;
	}

	/**
	 * Create a string representation
	 *
	 * @return string
	 */
	public function __toString() {
		$document = $this->get_document();

		return $document->saveXML();
	}
}
