<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML;

use DOMDocument;

/**
 * Title: MultiSafepay Connect XML request message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
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
		// this is causing 'Invalid electronic signature' errors
		$document->preserveWhiteSpace = true;
		$document->formatOutput       = true;

		// Root
		$root = $document->createElement( $this->get_name() );

		$root->setAttribute( 'ua', $this->get_user_agent() );

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
