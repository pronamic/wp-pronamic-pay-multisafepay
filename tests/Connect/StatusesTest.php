<?php

/**
 * Title: MultiSafepay statuses test
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
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
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::COMPLETED, Pronamic_WP_Pay_Statuses::SUCCESS ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::INITIALIZED, Pronamic_WP_Pay_Statuses::OPEN ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::UNCLEARED, Pronamic_WP_Pay_Statuses::OPEN ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::VOID, Pronamic_WP_Pay_Statuses::CANCELLED ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::DECLINED, Pronamic_WP_Pay_Statuses::FAILURE ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::REFUNDED, Pronamic_WP_Pay_Statuses::CANCELLED ),
			array( Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::EXPIRED, Pronamic_WP_Pay_Statuses::EXPIRED ),
			array( 'not existing response code', null ),
		);
	}
}
