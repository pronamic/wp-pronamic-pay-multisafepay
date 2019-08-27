<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Util as XML_Util;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Merchant;

/**
 * Title: MultiSafepay Connect XML status request message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class StatusRequestMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'status';

	/**
	 * Transaction ID.
	 *
	 * @var string
	 */
	public $transaction_id;

	/**
	 * Constructs and initialize an status message
	 *
	 * @param Merchant $merchant       Merchant.
	 * @param string   $transaction_id Transaction ID.
	 */
	public function __construct( Merchant $merchant, $transaction_id ) {
		parent::__construct( self::NAME );

		$this->merchant       = $merchant;
		$this->transaction_id = $transaction_id;
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

		// Transaction.
		$transaction = XML_Util::add_element( $document, $document->documentElement, 'transaction' );

		XML_Util::add_elements(
			$document,
			$transaction,
			array(
				'id' => $this->transaction_id,
			)
		);

		return $document;
	}
}
