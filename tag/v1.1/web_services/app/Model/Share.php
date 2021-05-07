<?php
App::uses('AppModel', 'Model');
/**
 * Share Model
 *
 * @property ShareLog $ShareLog
 */
class Share extends AppModel
{

	//The Associations below have been created with all possible keys, those that are
	// not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array('Exchange' => array(
			'className' => 'Exchange',
			'foreignKey' => 'exchange_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		));

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'ShareLog' => array(
			'className' => 'ShareLog',
			'foreignKey' => 'share_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),

		'Watchlist' => array(
			'className' => 'Watchlist',
			'foreignKey' => 'share_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserStock' => array(
			'className' => 'UserStock',
			'foreignKey' => 'share_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/*
	 * Author: Alin
	 * Description: This function is used to whether the share exists or not
	 */
	function existShare($symbol, $exchange_id)
	{
		$exist_share = $this -> find('first', array(
			'conditions' => array(
				'Share.symbol' => $symbol,
				'Share.exchange_id' => $exchange_id
			),
			'fields' => array(
				'Share.id',
				'Share.exchange_id'
			),
			'recursive' => -1
		));
		return $exist_share;
	}

	/*
	 * Author: Alin
	 * Description: This function is used to save the data in shares table
	 */
	function saveShareData($data)
	{
		$this -> create();
		$this -> save($data);
	}

	/*
	 * Author: Alin
	 * Description: This function is used to update a record of a particule record in
	 * shares table
	 */
	function updateShareData($id, $data)
	{
		$this -> id = $id;
		$this -> save($data);
	}

	/*
	 * Author: Alin
	 * Description: This function is used to retrive the data from the databse table
	 */
	function fetchData($start, $no_of_record, $search)
	{

		$conditions = array();
		if ($search != '')
		{
			// Check for the exchange ids
			$exchange_ids = $this -> Exchange -> find('list', array(
				'conditions' => array('Exchange.name LIKE' => '%' . $search . '%'),
				'fields' => array('Exchange.id'),
				'recursive' => -1
			));
			// pr($exchange_ids); exit;

			$conditions[] = array('OR' => array(
					array('Share.symbol LIKE ' => '%' . $search . '%'),
					array('Share.exchange_id' => $exchange_ids)
				));
		}
		$this -> virtualFields = array(
			'id' => 'Share.id',
			'timestamp' => 'Share.timestamp',
			'symbol' => 'Share.symbol',
			'exchange_id' => 'Share.exchange_id',
			'exchange_name' => 'Exchange.name',
			'last_trade_price' => 'Share.last_trade_price',
			'todays_closing_price' => 'Share.todays_closing_price',
			'cumulative_volume' => 'Share.cumulative_volume',
			'last_trade_time' => 'Share.last_trade_time',
			'open_price' => 'Share.open_price',
			'days_high_price' => 'Share.days_high_price',
			'days_low_price' => 'Share.days_low_price',
			'previous_close_price' => 'Share.previous_close_price',
			'bid_price' => 'Share.bid_price',
			'ask_price' => 'Share.ask_price',
			'bid_size' => 'Share.bid_size',
			'ask_size' => 'Share.ask_size'
		);
		$shareData = $this -> find('all', array(
			'fields' => array(
				'id',
				'timestamp',
				'symbol',
				'exchange_id',
				'exchange_name',
				'last_trade_price',
				'todays_closing_price',
				'cumulative_volume',
				'last_trade_time',
				'open_price',
				'days_high_price',
				'days_low_price',
				'previous_close_price',
				'bid_price',
				'ask_price',
				'bid_size',
				'ask_size'
			),
			'conditions' => $conditions,
			'limit' => $no_of_record,
			'offset' => $start,
			/*'contain' => array('Exchange' => array('fields' => array(
			 'Exchange.name',
			 'Exchange.full_name'
			 )))*/
			'contain' => array('Exchange'),
			'recursive' => -1
		));

		$result = Set::classicExtract($shareData, '{n}.Share');

		if ($shareData)
		{
			return $shareData;
		}
		else
		{
			return false;
		}
	}

	function shareDetail($data)
	{
		$this -> virtualFields = array(
			'id' => 'Share.id',
			'timestamp' => 'Share.timestamp',
			'symbol' => 'Share.symbol',
			'exchange_id' => 'Share.exchange_id',
			'exchange_name' => 'Exchange.name',
			'last_trade_price' => 'Share.last_trade_price',
			'todays_closing_price' => 'Share.todays_closing_price',
			'cumulative_volume' => 'Share.cumulative_volume',
			'last_trade_time' => 'Share.last_trade_time',
			'open_price' => 'Share.open_price',
			'days_high_price' => 'Share.days_high_price',
			'days_low_price' => 'Share.days_low_price',
			'previous_close_price' => 'Share.previous_close_price',
			'bid_price' => 'Share.bid_price',
			'ask_price' => 'Share.ask_price',
			'bid_size' => 'Share.bid_size',
			'ask_size' => 'Share.ask_size'
		);
		$shareData = $this -> find('first', array(
			'fields' => array(
				'id',
				'timestamp',
				'symbol',
				'exchange_id',
				'exchange_name',
				'last_trade_price',
				'todays_closing_price',
				'cumulative_volume',
				'last_trade_time',
				'open_price',
				'days_high_price',
				'days_low_price',
				'previous_close_price',
				'bid_price',
				'ask_price',
				'bid_size',
				'ask_size'
			),
			'conditions' => array('Share.id' => $data['share_id']),
			'contain' => array('Exchange'),
			'recursive' => -1
		));

		if ($shareData)
		{
			return $shareData['Share'];
		}
		else
		{
			return false;
		}

	}

	function getWatchListDatas($data)
	{

		$this -> virtualFields = array(
			'share_id' => 'Share.id',
			'timestamp' => 'Share.timestamp',
			'symbol' => 'Share.symbol',
			'exchange_id' => 'Share.exchange_id',
			'exchange_name' => 'Exchange.name',
			'last_trade_price' => 'Share.last_trade_price',
			'todays_closing_price' => 'Share.todays_closing_price',
			'cumulative_volume' => 'Share.cumulative_volume',
			'last_trade_time' => 'Share.last_trade_time',
			'open_price' => 'Share.open_price',
			'days_high_price' => 'Share.days_high_price',
			'days_low_price' => 'Share.days_low_price',
			'previous_close_price' => 'Share.previous_close_price',
			'bid_price' => 'Share.bid_price',
			'ask_price' => 'Share.ask_price',
			'bid_size' => 'Share.bid_size',
			'ask_size' => 'Share.ask_size',
			//'watchlist_id' => 'Watchlist.id',
			'portfolio_id' => $data['portfolio_id']
		);
		$data = $this -> find('all', array(
			'fields' => array(
				'share_id',
				'timestamp',
				'symbol',
				'exchange_id',
				'exchange_name',
				'last_trade_price',
				'todays_closing_price',
				'cumulative_volume',
				'last_trade_time',
				'open_price',
				'days_high_price',
				'days_low_price',
				'previous_close_price',
				'bid_price',
				'ask_price',
				'bid_size',
				'ask_size',
				//'watchlist_id',
				'portfolio_id'
			),
			'conditions' => array('Portfolio.id' => $data['portfolio_id']),
			'group' => $data['portfolio_id'],
			'contain' => array(
				'Watchlist',
				'Exchange'
			),
			'recursive' => -1
		));
		$result = Set::classicExtract($data, '{n}.{s}');
		if ($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}

}
