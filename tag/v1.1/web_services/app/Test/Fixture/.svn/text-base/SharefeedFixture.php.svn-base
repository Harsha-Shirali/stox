<?php
/**
 * SharefeedFixture
 *
 */
class SharefeedFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'timestamp' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'symbol' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'exchange_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'last_trade_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of P'),
		'todays_closing_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of p'),
		'cumulative_volume' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'value of V'),
		'last_trade_time' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'value of T'),
		'open_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of O'),
		'days_high_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of H'),
		'days_low_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of L'),
		'previous_close_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of C'),
		'bid_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of B'),
		'ask_price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'value of A'),
		'bid_size' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'value of b'),
		'ask_size' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'value of a'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'symbol' => array('column' => array('symbol', 'exchange_id'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => null,
			'timestamp' => 'Lorem ipsum dolor sit amet',
			'symbol' => 'Lorem ipsum dolor sit amet',
			'exchange_id' => 1,
			'last_trade_price' => 1,
			'todays_closing_price' => 1,
			'cumulative_volume' => 1,
			'last_trade_time' => 1,
			'open_price' => 1,
			'days_high_price' => 1,
			'days_low_price' => 1,
			'previous_close_price' => 1,
			'bid_price' => 1,
			'ask_price' => 1,
			'bid_size' => 1,
			'ask_size' => 1,
			'created' => '2014-06-17 18:45:29',
			'modified' => '2014-06-17 18:45:29'
		),
	);

}
