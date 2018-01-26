<?php
use Pronamic\WordPress\Pay\Core\Statuses;

/**
 * Title: MultiSafepay statuses constants
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses {
	/**
	 * Completed successfully
	 *
	 * @var string
	 */
	const COMPLETED = 'completed';

	/**
	 * Created, but uncompleted
	 *
	 * @var string
	 */
	const INITIALIZED = 'initialized';

	/**
	 * Created, but not yet exempted (credit cards)
	 *
	 * @var string
	 */
	const UNCLEARED = 'uncleared';

	/**
	 * Cancelled
	 *
	 * @var string
	 */
	const VOID = 'void';

	/**
	 * Rejected
	 *
	 * @var string
	 */
	const DECLINED = 'declined';

	/**
	 * Refunded
	 *
	 * @var string
	 */
	const REFUNDED = 'refunded';

	/**
	 * Expired
	 *
	 * @var string
	 */
	const EXPIRED = 'expired';

	/////////////////////////////////////////////////

	/**
	 * Transform an MultiSafepay state to an more global status
	 *
	 * @param string $status
	 */
	public static function transform( $status ) {
		switch ( $status ) {
			case self::COMPLETED:
				return Statuses::SUCCESS;
			case self::INITIALIZED:
				return Statuses::OPEN;
			case self::UNCLEARED:
				return Statuses::OPEN;
			case self::VOID:
				return Statuses::CANCELLED;
			case self::DECLINED:
				return Statuses::FAILURE;
			case self::REFUNDED:
				return Statuses::CANCELLED;
			case self::EXPIRED:
				return Statuses::EXPIRED;
			default:
				return null;
		}
	}
}
