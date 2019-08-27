<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Util as XML_Util;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Merchant;

/**
 * Title: MultiSafepay Connect XML iDEAL issuers request message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.0
 */
class IDealIssuersRequestMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'idealissuers';

	/**
	 * Merchant.
	 *
	 * @var Merchant
	 */
	public $merchant;

	/**
	 * Constructs and initialize an directory response message
	 *
	 * @param Merchant $merchant Merchant.
	 */
	public function __construct( Merchant $merchant ) {
		parent::__construct( self::NAME );

		$this->merchant = $merchant;
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

		return $document;
	}
}
