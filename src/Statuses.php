<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Core\Statuses as Core_Statuses;

/**
 * Title: MultiSafepay statuses constants
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 */
class Statuses {
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

	/**
	 * Transform an MultiSafepay state to an more global status
	 *
	 * @param string $status
	 *
	 * @return null|string
	 */
	public static function transform( $status ) {
		switch ( $status ) {
			case self::COMPLETED:
				return Core_Statuses::SUCCESS;

			case self::INITIALIZED:
				return Core_Statuses::OPEN;

			case self::UNCLEARED:
				return Core_Statuses::OPEN;

			case self::VOID:
				return Core_Statuses::CANCELLED;

			case self::DECLINED:
				return Core_Statuses::FAILURE;

			case self::REFUNDED:
				return Core_Statuses::CANCELLED;

			case self::EXPIRED:
				return Core_Statuses::EXPIRED;

			default:
				return null;
		}
	}
}
