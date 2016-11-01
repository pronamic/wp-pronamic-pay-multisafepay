<?php

/**
 * Title: MultiSafepay Connect XML status request message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_StatusRequestMessage extends Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'status';

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an status message
	 */
	public function __construct( $merchant, $transaction_id ) {
		parent::__construct( self::NAME );

		$this->merchant       = $merchant;
		$this->transaction_id = $transaction_id;
	}

	//////////////////////////////////////////////////

	/**
	 * Get document
	 *
	 * @see Pronamic_Gateways_IDealAdvancedV3_XML_RequestMessage::get_document()
	 */
	public function get_document() {
		$document = parent::get_document();

		// Root
		$root = $document->documentElement;

		// Merchant
		$merchant = $this->merchant;

		$element = Pronamic_WP_Pay_XML_Util::add_element( $document, $document->documentElement, 'merchant' );
		Pronamic_WP_Pay_XML_Util::add_elements( $document, $element, array(
			'account'          => $merchant->account,
			'site_id'          => $merchant->site_id,
			'site_secure_code' => $merchant->site_secure_code,
		) );

		// Transaction
		$element = Pronamic_WP_Pay_XML_Util::add_element( $document, $document->documentElement, 'transaction' );
		Pronamic_WP_Pay_XML_Util::add_elements( $document, $element, array(
			'id' => $this->transaction_id,
		) );

		// Return
		return $document;
	}
}
