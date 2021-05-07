<?php
App::uses('AppModel', 'Model');
/**
 * UserStock Model
 *
 * @property User $User
 * @property Share $Share
 * @property Portfolio $Portfolio
 */
class UserStock extends AppModel
{
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array('share_id' => array('notempty' => array('rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			), ), );
	//The Associations below have been created with all possible keys, those that are
	// not needed can be removed
	/**
	 * belongsTo associations
	 *
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true,
		),
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'share_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => false,
		),
		'Portfolio' => array(
			'className' => 'Portfolio',
			'foreignKey' => 'portfolio_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true,
		)
	);
	/* Author: Alin
	 * Description: this function is used for retriving purchased stocks
	 */
	function findPurchasedStocksList($data)
	{
		$stock_list = $this -> find('all', array(
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.status' => 'buy',
                                'UserStock.is_pending' => 'no'
			),
			'contain' => array('Share' => array('Exchange' => array('fields' => array(
                                                                                                    'Exchange.id',
                                                                                                    'Exchange.name',
                                                                                                    'Exchange.full_name'
                                                                                                        )
                                                                                ),
                                                            'fields' =>array('Share.id','Share.full_name','Share.symbol','Share.todays_closing_price',
                                                                'Share.open_price','Share.previous_close_price','Share.days_high_price','Share.days_low_price',
                                                                'Share.bid_price','Share.ask_price'
                                                                )
                                                            )
                                            ),
                        'fields' => array('UserStock.id','UserStock.share_id','UserStock.quantity','UserStock.total_amount')
                                    )
                        );

                $response_data=array();
               //print_r($stock_list);
                if(!empty($stock_list)){
                    foreach($stock_list as $data){
                        $data['Share']['quantity']=$data['UserStock']['quantity'];
                        $data['Share']['exchange_id']= $data['Share']['Exchange']['id'];
                        $data['Share']['exchange_name']= $data['Share']['Exchange']['name'];
                        $data['Share']['exchange_full_name']= $data['Share']['Exchange']['full_name'];
                        $data['Share']['share_id'] = $data ['Share']['id'];
                        //$data['Share']['user_stock_id'] = $data['UserStock']['id'];
                        unset($data['Share']['Exchange']);
                        unset($data['Share']['id']);

                        $response_data[]=$data['Share'];
                        //$response_data[]=array_merge($data['Share']);
                    }
                }
               // print_r($response_data);die();
                
		return $response_data;
	}

	/* Author: Alin
	 * Description: this function is used for retriving sold stocks
	 */
	function findStockHistoryList($data)
	{
		$stock_list = $this -> find('all', array(
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.status' => 'sell',
                                'UserStock.is_pending' => 'no'
			),
			'contain' => array('Share' => array('Exchange' => array('fields' => array(
							'Exchange.id',
							'Exchange.name',
							'Exchange.full_name'
						))))
		));
		return $stock_list;
	}

	/* Author: Alin
	 * Description: this function is used for retriving pending stocks
	 */
	function findPendingStocksList($data)
	{
		$stock_list = $this -> find('all', array(
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.is_pending' => 'yes'
			),
			'contain' => array('Share' => array('Exchange' => array('fields' => array(
							'Exchange.id',
							'Exchange.name',
							'Exchange.full_name'
						))))
		));
		return $stock_list;
	}

	public function getPendingTransactionsCount($data)
	{
		$this -> virtualFields = array('count' => 'count(UserStock.is_pending)', );
		$options = array(
			'fields' => array('count', ),
			'conditions' => array('UserStock.portfolio_id' => $data['portfolio_id'], 'UserStock.user_id' => $data['user_id'],'UserStock.is_pending' => 'yes'),
			'group' => array('UserStock.portfolio_id', ),
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	
	}

	function isStatusPending($data)
	{
		$data = $this -> find('first', array(
			'fields' => array('status', ),
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.is_pending' => 'yes'
			)
		));
		if ($data)
		{
			return TRUE;
		}
		else
		{
			return false;
		}
	}

	function isStatusBuy($data)
	{
		$data = $this -> find('first', array(
			'fields' => array('status', ),
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.status' => 'buy'
			)
		));
		if ($data)
		{
			return TRUE;
		}
		else
		{
			return false;
		}
	}

	public function pendingSum($data)
	{
		$this -> virtualFields = array('sum' => 'SUM(UserStock.total_amount)', );
		$options = array(
			'fields' => array('sum', ),
			'conditions' => array(
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.is_pending' => 'yes',
				'UserStock.user_id' => $data['user_id']
			),
			'group' => array('UserStock.user_id', ),
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function updateTotalAmount($data)
	{
		$this -> virtualFields = array('total_amount' => 'total_amount');
		$updateData = array(			
			'fields' => array('id'),
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.share_id' => $data['share_id'],
				'UserStock.status' => 'buy'
			)
		);
		
		$save = $this -> save($updateData);
		if ($save)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function checkBuying($data)
	{
		$this -> virtualFields = array('sum' => 'SUM(UserStock.total_amount)', );
		$options = array(
			'fields' => array('sum', ),
			'conditions' => array(
				//'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.status' => 'buy',
			),
			'group' => array(
				'UserStock.portfolio_id',
				'UserStock.share_id',
			),
		);
		$data = $this -> find('all', $options);
		//pr($data);exit();
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function saveBuyStox($data)
	{
		//pr($data);exit();
		$save = $this -> save($data);
		if ($save)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function getIndividualSumPortfolioAmount($data)
	{

		$this -> virtualFields = array('total' => 'sum(total_amount)', );
		$options = array(
			'fields' => array('total'),
			'conditions' => array('portfolio_id' => $data['portfolio_id'], ),
			'group' => array('portfolio_id', ),
			'recursive' => -1
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function getTotalPortfolioAmount($data)
	{

		$this -> virtualFields = array('total' => 'sum(total_amount)', );
		$options = array(
			'fields' => array('total'),
			'conditions' => array('UserStock.user_id' => $data['user_id'],'UserStock.status' => 'buy' ),
			'group' => array('user_id', ),
			'recursive' => -1
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function getGamePortfolioValue($data)
	{

		$this -> virtualFields = array('total' => 'sum(Portfolio.net_value + UserStock.total_amount)',
			//'maximum' => 'MAX(DISTINCT(sum(Portfolio.net_value +
			// UserStock.total_amount)))',
		);
		/*$options = array(
		 'fields' => array('UserStock.total'),
		 'conditions' => array('Portfolio.user_id' => $data['user_id'], ),
		 'group' => array('UserStock.user_id', ),
		 'contain' => array('Portfolio'),
		 'recursive' => -1,
		 );
		 $data = $this -> find('first', $options);*/

		$options = array('joins' => array(
				'fields' => array('UserStock.total'),
				array(
					'table' => 'users',
					'alias' => 'user',
					'type' => 'left',
					'foreignKey' => false,
					'conditions' => array('User.id = UserStock.user_id')
				),
				array(
					'table' => 'portfolios',
					'alias' => 'Portfolio',
					'type' => 'left',
					'foreignKey' => false,
					'conditions' => array('Portfolio.id = UserStock.portfolio_id')
				),
			));
		$data = $this -> find('all', $options);
		//pr($data);
		exit();
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function totalNoOfStocks($data)
	{
		$this -> virtualFields = array('count' => 'count(share_id)', );
		$options = array(
			'fields' => array('UserStock.count', ),
			'conditions' => array('portfolio_id' => $data['portfolio_id'], ),
			'group' => array('portfolio_id', ),
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function getAllPortfolioListing($data)
	{
		$this -> virtualFields = array(
			'user_id' => 'UserStock.user_id',
			'portfolio_id' => 'Portfolio.id',
			'portfolio_name' => 'Portfolio.portfolio_name',
			'current_net_value' => 'Portfolio.net_value + sum(UserStock.total_amount)',
			'previous_net_value' => 'Portfolio.previous_net_value',
			'pending_transaction_count' => 'count(UserStock.is_pending)',
			'total_count_of_stocks' => 'count(UserStock.share_id)',
			
		);
		$options = array(
			'fields' => array(
				'user_id',
				'portfolio_id',
				'current_net_value',
				'previous_net_value',
				'portfolio_name',
				'total_count_of_stocks',
				'pending_transaction_count'
				
			),
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
			),
			'group' => array('UserStock.user_id', ),
			'contain' => array('User','Portfolio'),
			'recursive' => -1
		);
		$data = $this -> find('all', $options);pr($data);exit();
		$result = Set::classicExtract($data, '{n}.User');
		if ($data)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}
	}

}
