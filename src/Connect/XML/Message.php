<?php

/**
 * Title: MultiSafepay Connect XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_Message {
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

	//////////////////////////////////////////////////

	/**
	 * The name of this message
	 *
	 * @var string
	 */
	private $name;

	//////////////////////////////////////////////////

	/**
	 * User agent
	 *
	 * @var string
	 */
	private $user_agent;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an message
	 */
	public function __construct( $name ) {
		$this->name = $name;

		// User Agent
		// @since 1.2.0
		global $pronamic_pay_version;

		$this->set_user_agent( 'Pronamic Pay ' . $pronamic_pay_version );
	}

	//////////////////////////////////////////////////

	/**
	 * Get the name of this message
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	//////////////////////////////////////////////////

	/**
	 * Get user agent
	 *
	 * @return string
	 */
	public function get_user_agent() {
		return $this->user_agent;
	}

	/**
	 * Set user agent
	 *
	 * @param string $user_agent
	 */
	public function set_user_agent( $user_agent ) {
		$this->user_agent = $user_agent;
	}
}
