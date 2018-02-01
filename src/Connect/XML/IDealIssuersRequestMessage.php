<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML;

use Pronamic\WordPress\Pay\Core\XML\Util as XML_Util;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\Merchant;

/**
 * Title: MultiSafepay Connect XML iDEAL issuers request message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.2.0
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

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an directory response message
	 *
	 * @param Merchant $merchant
	 */
	public function __construct( Merchant $merchant ) {
		parent::__construct( self::NAME );

		$this->merchant = $merchant;
	}

	//////////////////////////////////////////////////

	/**
	 * Get document
	 *
	 * @see Pronamic_Gateways_IDealAdvancedV3_XML_RequestMessage::get_document()
	 */
	public function get_document() {
		$document = parent::get_document();

		// Merchant
		$merchant = XML_Util::add_element( $document, $document->documentElement, 'merchant' );

		XML_Util::add_elements( $document, $merchant, array(
			'account'          => $merchant->account,
			'site_id'          => $merchant->site_id,
			'site_secure_code' => $merchant->site_secure_code,
		) );

		return $document;
	}
}
