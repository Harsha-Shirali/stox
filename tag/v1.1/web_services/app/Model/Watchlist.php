<?php
App::uses('AppModel', 'Model');
/**
 * Watchlist Model
 *
 * @property Portfolio $Portfolio
 * @property Share $Share
 */
class Watchlist extends AppModel
{

	//The Associations below have been created with all possible keys, those that are
	// not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Portfolio' => array(
			'className' => 'Portfolio',
			'foreignKey' => 'portfolio_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true,
		),
		'Share' => array(
			'className' => 'Share',
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

	public function getShareList2($data)
	{
		$options = array(
			'fields' => array('Share.symbol', ),
			'joins' => array( array(
					'conditions' => array('share_id' => 'Share.id'),
					'table' => 'shares',
					'alias' => 'Share',
					'type' => 'join',
				)),
			'conditions' => array(
				'user_id' => $data['user_id'],
				'portfolio_id' => $data['portfolio_id'],
			),
			'contain' => array('Share', )
		);
		$data = $this -> find('all', $options);
	}

	public function getShareList1($data)
	{
		$options = array(
			'fields' => array('Share.symbol', ),
			'joins' => array( array(
					'conditions' => array('Share.id' => '1', ),
					'table' => 'shares',
					'alias' => 'Share',
					'type' => 'join',
				), ),
			'conditions' => array(
				'portfolio_id' => '1',
				'user_id' => '1',
			),
			'contain' => array(
				'Share',
				'Portfolio',
			),
		);

		$data = $this -> find('all', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return false;
		}

	}

	//---------------------------------
	function getWatchListDatas($data)
	{

		$this -> virtualFields = array(
			'share_id' => 'Share.id',
			'timestamp' => 'Share.timestamp',
			'symbol' => 'Share.symbol',
			//'exchange_id' => 'Share.exchange_id',
			//'exchange_name' => 'Exchange.name',
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
			'watchlist_id' => 'Watchlist.id',
			'portfolio_id' => $data['portfolio_id']
	);
		$data = $this -> find('all', array(
			'fields' => array(
				'share_id',
				'timestamp',
				'symbol',
				//'exchange_id',
				// 'exchange_name',
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
				'watchlist_id',
				'portfolio_id'
			),
			'conditions' => array('Portfolio.id' => $data['portfolio_id'] ),
			/*'contain' => array('Share' => array('Exchange' => array('fields' => array(
							'name',
							'full_name'
						))),'Portfolio'),*/
						'contain'=>array('Share','Portfolio'),'recursive' => -1
		));
		 //to streamline the data as required by IOS webservices
        $response_data=array();
        if(!empty($data)){
            foreach($data as $record){
        		$response_data[]= $record['Watchlist'];       
            }
        }
		$result = Set::classicExtract($response_data, '{n}');
		if ($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}

	//---------------------------------
	public function saveWatchlistDatas($data)
	{
		if ($this -> save($data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}

	public function get_watchlist($data)
	{
		$options = array('conditions' => array(
				'user_id' => $data['user_id'],
				'portfolio_id' => $data['portfolio_id'],
			), );
		$data = $this -> find('all', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}

	}

	public function checkShareExists($data)
	{
		$options = array(
			'conditions' => array(
				'portfolio_id' => $data['portfolio_id'],
				'share_id' => $data['share_id'],
			),
		);
		$data = $this -> find('all', $options);
		if ($data)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}

	/* Author: Alin
	 * Description: this function is used for deleting a record from the table
	 */
	function deleteRecord($id)
	{
		if ($this -> delete($id))
			return true;
		else
			return false;
	}

}
