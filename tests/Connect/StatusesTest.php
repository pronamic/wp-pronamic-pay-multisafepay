<?php
use Pronamic\WordPress\Pay\Core\Statuses;

/**
 * Title: MultiSafepay statuses test
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.0
 * @since 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_StatusesTest extends WP_UnitTestCase {
	/**
	 * Test transform
	 *
	 * @dataProvider status_matrix_provider
	 */
	public function test_transform( $status, $expected ) {
		$status = Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::transform( $status );

		$this->assertEquals( $expected, $status );
	}

	public function status_matrix_provider() {
		return array(
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::COMPLETED, Statuses::SUCCESS ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::INITIALIZED, Statuses::OPEN ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::UNCLEARED, Statuses::OPEN ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::VOID, Statuses::CANCELLED ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::DECLINED, Statuses::FAILURE ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::REFUNDED, Statuses::CANCELLED ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::EXPIRED, Statuses::EXPIRED ),
			array( 'not existing response code', null ),
		);
	}
}
