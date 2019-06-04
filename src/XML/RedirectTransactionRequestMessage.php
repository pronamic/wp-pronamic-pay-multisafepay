<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

use Pronamic\WordPress\Pay\Core\XML\Util as XML_Util;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Customer;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Merchant;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Transaction;

/**
 * Title: MultiSafepay Connect XML redirect transaction request message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class RedirectTransactionRequestMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'redirecttransaction';

	/**
	 * Constructs and initialize an directory response message
	 *
	 * @param Merchant    $merchant    Merchant.
	 * @param Customer    $customer    Customer.
	 * @param Transaction $transaction Transaction.
	 */
	public function __construct( $merchant, $customer, $transaction ) {
		parent::__construct( self::NAME );

		$this->merchant    = $merchant;
		$this->customer    = $customer;
		$this->transaction = $transaction;
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
				'notification_url' => $this->merchant->notification_url,
				'redirect_url'     => $this->merchant->redirect_url,
				'cancel_url'       => $this->merchant->cancel_url,
				'close_window'     => $this->merchant->close_window,
			)
		);

		// Customer.
		$customer = XML_Util::add_element( $document, $document->documentElement, 'customer' );

		XML_Util::add_elements(
			$document,
			$customer,
			array(
				'locale'      => $this->customer->locale,
				'ipaddress'   => $this->customer->ip_address,
				'forwardedip' => $this->customer->forwarded_ip,
				'firstname'   => $this->customer->first_name,
				'lastname'    => $this->customer->last_name,
				'address1'    => $this->customer->address_1,
				'address2'    => $this->customer->address_2,
				'housenumber' => $this->customer->house_number,
				'zipcode'     => $this->customer->zip_code,
				'city'        => $this->customer->city,
				'country'     => $this->customer->country,
				'phone'       => $this->customer->phone,
				'email'       => $this->customer->email,
			)
		);

		// Transaction.
		$transaction = XML_Util::add_element( $document, $document->documentElement, 'transaction' );

		XML_Util::add_elements(
			$document,
			$transaction,
			array(
				'id'          => $this->transaction->id,
				'currency'    => $this->transaction->currency,
				'amount'      => $this->transaction->amount,
				'description' => $this->transaction->description,
				'var1'        => $this->transaction->var1,
				'var2'        => $this->transaction->var2,
				'var3'        => $this->transaction->var3,
				'items'       => $this->transaction->items,
				'manual'      => $this->transaction->manual,
				'gateway'     => $this->transaction->gateway,
				'daysactive'  => $this->transaction->days_active,
			)
		);

		// Signature.
		XML_Util::add_element( $document, $document->documentElement, 'signature', $this->signature );

		return $document;
	}
}
