<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML;

/**
 * Title: MultiSafepay Connect XML message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class Message {
	/**
	 * The XML version of the iDEAL messages
	 *
	 * @var string
	 */
	const XML_VERSION = '1.0';

	/**
	 * The XML encoding of the iDEAL messages
	 *
	 * @var string
	 */
	const XML_ENCODING = 'UTF-8';

	/**
	 * The name of this message
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Constructs and initialize an message
	 *
	 * @param string $name Name.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Get the name of this message
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}
}
