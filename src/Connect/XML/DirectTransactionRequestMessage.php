<?php
use Pronamic\WordPress\Pay\Core\Util;
use Pronamic\WordPress\Pay\Core\XML\Util;

/**
 * Title: MultiSafepay Connect XML direct transaction request message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.0
 * @since 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionRequestMessage extends Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'directtransaction';

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an directory response message
	 */
	public function __construct( $merchant, $customer, $transaction, $gateway_info = null ) {
		parent::__construct( self::NAME );

		$this->merchant     = $merchant;
		$this->customer     = $customer;
		$this->transaction  = $transaction;
		$this->gateway_info = $gateway_info;
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

		$element = Util::add_element( $document, $document->documentElement, 'merchant' );

		Util::add_elements( $document, $element, array(
			'account'          => $merchant->account,
			'site_id'          => $merchant->site_id,
			'site_secure_code' => $merchant->site_secure_code,
			'notification_url' => $merchant->notification_url,
			'redirect_url'     => $merchant->redirect_url,
			'cancel_url'       => $merchant->cancel_url,
			'close_window'     => $merchant->close_window,
		) );

		// Customer
		$customer = $this->customer;

		$element = Util::add_element( $document, $document->documentElement, 'customer' );

		Util::add_elements( $document, $element, array(
			'locale'      => $customer->locale,
			'ipaddress'   => $customer->ip_address,
			'forwardedip' => $customer->forwarded_ip,
			'firstname'   => $customer->first_name,
			'lastname'    => $customer->last_name,
			'address1'    => $customer->address_1,
			'address2'    => $customer->address_2,
			'housenumber' => $customer->house_number,
			'zipcode'     => $customer->zip_code,
			'city'        => $customer->city,
			'country'     => $customer->country,
			'phone'       => $customer->phone,
			'email'       => $customer->email,
		) );

		// Transaction
		$transaction = $this->transaction;

		$element = Util::add_element( $document, $document->documentElement, 'transaction' );

		Util::add_elements( $document, $element, array(
			'id'          => $transaction->id,
			'currency'    => $transaction->currency,
			'amount'      => Util::amount_to_cents( $transaction->amount ),
			'description' => $transaction->description,
			'var1'        => $transaction->var1,
			'var2'        => $transaction->var2,
			'var3'        => $transaction->var3,
			'items'       => $transaction->items,
			'manual'      => $transaction->manual,
			'gateway'     => $transaction->gateway,
			'daysactive'  => $transaction->days_active,
		) );

		// Gateway info
		if ( $this->gateway_info ) {
			$gateway_info = $this->gateway_info;

			$element = Util::add_element( $document, $document->documentElement, 'gatewayinfo' );

			Util::add_elements( $document, $element, array(
				'issuerid' => $gateway_info->issuer_id,
			) );
		}

		// Signature
		$element = Util::add_element( $document, $document->documentElement, 'signature', $this->signature );

		return $document;
	}
}
