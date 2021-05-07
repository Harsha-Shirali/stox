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
        
         public $hasMany = array(
		'UserstockHistory' => array(
			'className' => 'UserstockHistory',
			'foreignKey' => 'user_stock_id',
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
				'UserStock.is_pending' => 'no',
				'UserStock.quantity !=' => 0
			),
			'contain' => array('Share' => array(
					'Exchange' => array('fields' => array(
							'Exchange.id',
							'Exchange.name',
							'Exchange.full_name'
						)),
					'fields' => array(
						'Share.id',
						'Share.symbol_full_name',
						'Share.symbol',
						'Share.last_trade_price',
						'Share.todays_closing_price',
						'Share.open_price',
						'Share.previous_close_price',
						'Share.days_high_price',
						'Share.days_low_price',
						'Share.bid_price',
						'Share.ask_price'
					)
				)),
			'fields' => array(
				'UserStock.id',
				'UserStock.share_id',
				'UserStock.quantity',
				'UserStock.total_amount'
			),
			'order' => array('UserStock.created DESC'),
		));

		$response_data = array();
		//print_r($stock_list);
		if (!empty($stock_list))
		{
			foreach ($stock_list as $data)
			{
				$data['Share']['quantity'] = $data['UserStock']['quantity'];
				$data['Share']['exchange_id'] = $data['Share']['Exchange']['id'];
				$data['Share']['exchange_name'] = $data['Share']['Exchange']['name'];
				$data['Share']['exchange_full_name'] = $data['Share']['Exchange']['full_name'];
				$data['Share']['share_id'] = $data['Share']['id'];
				$data['Share']['full_name'] = $data['Share']['symbol_full_name'];
				//$data['Share']['user_stock_id'] = $data['UserStock']['id'];
				unset($data['Share']['Exchange']);
				unset($data['Share']['id']);

				$response_data[] = $data['Share'];
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to get the count of pending transactions for a
	 * particular portfolio as per $data
	 */

	public function getPendingTransactionsCount($data)
	{
		$this -> virtualFields = array('count' => 'count(UserStock.is_pending)', );
		$options = array(
			'fields' => array('count', ),
			'conditions' => array(
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.user_id' => $data['user_id'],
				'UserStock.is_pending' => 'yes'
			),
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to get the status of pending transactions for a
	 * particular portfolio as per $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to get the status of a particular portfolio as per
	 * $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to get the sum of total_amount of stocks for a
	 * particular portfolio
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to get the sum of total_amount of stocks for a
	 * particular portfolio
	 * as per the $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save buy stocks as per the $data
	 * as per the $data
	 */

	public function saveBuyStox($data)
	{
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives the sum of total_amount of stocks for a particular
	 * portfolio as per the $data
	 */

	public function getIndividualSumPortfolioAmount($data)
	{

		$this -> virtualFields = array('total' => 'sum(total_amount)', );
		$options = array(
			'fields' => array('total'),
			'conditions' => array(
				'portfolio_id' => $data['portfolio_id'],
				'status' => 'buy'
			),
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives the portfolio_worth of particular portfolio as per
	 * the $data
	 */

	public function getGamePortfolioValue($data)
	{

		$this -> virtualFields = array('total' => 'sum(Portfolio.net_value + UserStock.total_amount)', );

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
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives the count of stocks for a particular portfolio
	 */

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

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save share data while buying share for a
	 * particular portfolio
	 */

	function saveUserStockData($data)
        {
            $isDataExist = $this->find('first', array('conditions'=>array(
                                                                          'UserStock.user_id'=> $data['user_id'],
                                                                          'UserStock.portfolio_id' => $data['portfolio_id'],
                                                                          'UserStock.share_id' => $data['share_id'],
                                                                          'UserStock.status' => 'buy',
                                                                          'UserStock.is_pending' => 'no'
                                                                        ),
                                                        'recursive'=>-1
                                                        )
                                        );
            $stock_data = 0;
            
            if($isDataExist)
            {
                $this->updateAll(
                            array(
                                    'UserStock.cost_price' =>  'UserStock.cost_price + '.$data['total_purchased_amount'],
                                    'UserStock.cost_per_price' =>  $data['cost_per_price'],
                                    'UserStock.quantity' =>  'UserStock.quantity + '.$data['quantity'],
                                    'UserStock.total_amount' =>  'UserStock.total_amount + '.$data['total_purchased_amount'],
                                ),
                            array('UserStock.id' => $isDataExist['UserStock']['id'])
                            );
                $stock_data = $this->find('first', array('conditions'=> array('UserStock.id' => $isDataExist['UserStock']['id']),
                                                         'fields' => array('UserStock.id','UserStock.user_id','UserStock.share_id','UserStock.portfolio_id','UserStock.cost_price','UserStock.quantity'),
                                                         'recursive' =>-1
                                                        )
                                        );
                        
            }else{
                $this->id = null;
                $this->save($data);
                $stock_data = $this->find('first', array('conditions'=> array('UserStock.id' => $this->id),
                                                         'fields' => array('UserStock.id','UserStock.user_id','UserStock.share_id','UserStock.portfolio_id','UserStock.cost_price','UserStock.quantity'),
                                                         'recursive' =>-1
                                                        )
                                        );
            }
            
            $stock_data['UserStock']['user_stock_id'] = $stock_data['UserStock']['id'];
            $stock_data['UserStock']['price'] = $data['total_purchased_amount'];
            $stock_data['UserStock']['delta_quantity'] = $data['quantity'];
            
            $this->UserstockHistory->saveData($stock_data['UserStock']);
            
            $this->Portfolio->updateAll(
                                array(
                                    'Portfolio.net_value' =>  'Portfolio.net_value - '.$data['total_purchased_amount'],
                                    'Portfolio.trades' =>  'Portfolio.trades-1',
                                    ),
                                array('Portfolio.id' => $data['portfolio_id'])
                            );
            
            
            
            $portfolio_data = $this->Portfolio->find('first', array(
                                                                    'conditions'=> array('Portfolio.id'=>$data['portfolio_id'] ),
                                                                    'fields' => array('Portfolio.id','Portfolio.trades','Portfolio.net_value','Portfolio.start_money', 'Portfolio.created'),
                                                                    'contain' => array('UserStock'=> array('conditions'=> array('UserStock.is_pending' => 'no','UserStock.status'=>'buy','UserStock.quantity !=' => 0),'fields' => array('SUM(UserStock.total_amount) as total_stock_cost', 'SUM(UserStock.quantity) as total_stock_count')))
                                                                    ));
            $todays_date = date('Y-m-d h:i:s');
            $portfolio_percentage_change = $this->UserstockHistory->getPortfolioWorth($portfolio_data['Portfolio']['id'],$portfolio_data['Portfolio']['created'],$todays_date);
            
            $result = array();
            $result['portfolio_id'] = $portfolio_data['Portfolio']['id'];
            $result['available_trades'] = $portfolio_data['Portfolio']['trades'];
            $result['available_cash'] = $portfolio_data['Portfolio']['net_value'];
            if($portfolio_data['UserStock']){
                $result['portfolio_worth'] = $portfolio_data['Portfolio']['net_value']+$portfolio_data['UserStock'][0]['UserStock'][0]['total_stock_cost'];
                $result['portfolio_stock_count'] = $portfolio_data['UserStock'][0]['UserStock'][0]['total_stock_count'];
            }else{
                $result['portfolio_worth'] = $portfolio_data['Portfolio']['net_value'];
                $result['portfolio_stock_count'] = 0;
            }
            $result['portfolio_percentage_change'] = $portfolio_percentage_change;
            $result['quantity'] = $stock_data['UserStock']['quantity'];
            $result['net_value_change'] = $result['portfolio_worth']-$portfolio_data['Portfolio']['start_money'];
            
            return $result;
        }

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to get available share for a particular share id
	 */
	function availableStock($data)
	{
		$availableStock = $this -> find('first', array(
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.share_id' => $data['share_id'],
				'UserStock.status' => 'buy',
				'UserStock.is_pending' => 'no',
				'UserStock.quantity !=' => 0
			),
			'recursive' => -1
		));
		if ($availableStock)
		{
			return $availableStock['UserStock'];
		}
		else
		{
			return false;
		}
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save share data while selling share for a
	 * particular portfolio
	 */
	function saveSellStockData($data)
	{
		//pr($data); exit;
		$isDataExist = $this -> find('first', array(
			'conditions' => array(
				'UserStock.user_id' => $data['user_id'],
				'UserStock.portfolio_id' => $data['portfolio_id'],
				'UserStock.share_id' => $data['share_id'],
				'UserStock.status' => 'sell',
				'UserStock.is_pending' => 'no'
			),
			'recursive' => -1
		));
		if ($isDataExist)
		{
			$this -> updateAll(array(
				'UserStock.cost_price' => 'UserStock.cost_price + ' . $data['total_sold_amount'],
				'UserStock.cost_per_price' => $data['cost_per_price'],
				'UserStock.quantity' => 'UserStock.quantity + ' . $data['quantity'],
				'UserStock.total_amount' => 'UserStock.total_amount + ' . $data['total_sold_amount'],
			), array('UserStock.id' => $isDataExist['UserStock']['id']));
                        
                        $user_stock_id = $isDataExist['UserStock']['id'];

		}
		else
		{
			$this -> id = null;
			$this -> save($data);
                        $user_stock_id = $this -> id;

		}

		$this -> updateAll(array(
			'UserStock.cost_price' => 'UserStock.cost_price - ' . $data['total_sold_amount'],
			'UserStock.cost_per_price' => $data['cost_per_price'],
			'UserStock.quantity' => 'UserStock.quantity - ' . $data['quantity'],
			'UserStock.total_amount' => 'UserStock.total_amount - ' . $data['total_sold_amount'],
		), array('UserStock.id' => $data['stock_detail']['id']));

		$this -> Portfolio -> updateAll(array(
			'Portfolio.net_value' => 'Portfolio.net_value + ' . $data['total_sold_amount'],
			'Portfolio.trades' => 'Portfolio.trades-1',
		), array('Portfolio.id' => $data['portfolio_id']));
                
                
                $stock_data['UserStock']['user_stock_id'] = $user_stock_id;
                $stock_data['UserStock']['share_id'] = $data['share_id'];
                $stock_data['UserStock']['user_id'] = $data['user_id'];
                $stock_data['UserStock']['price'] = $data['total_sold_amount'];
                $stock_data['UserStock']['delta_quantity'] = '-'.$data['quantity'];
                $stock_data['UserStock']['portfolio_id'] = $data['portfolio_id'];
                $this->UserstockHistory->saveData($stock_data['UserStock']);
                
		$portfolio_data = $this -> Portfolio -> find('first', array(
			'conditions' => array('Portfolio.id' => $data['portfolio_id']),
			'fields' => array(
				'Portfolio.id',
				'Portfolio.trades',
				'Portfolio.net_value',
                                'Portfolio.start_money',
                                'Portfolio.created'
			),
			'contain' => array('UserStock' => array(
					'conditions' => array(
						'UserStock.is_pending' => 'no',
						'UserStock.status' => 'buy',
						'UserStock.quantity !=' => 0
					),
					'fields' => array(
						'SUM(UserStock.total_amount) as total_stock_cost',
						'SUM(UserStock.quantity) as total_stock_count'
					)
				))
		));
                
                $todays_date = date('Y-m-d h:i:s');
                $portfolio_percentage_change = $this->UserstockHistory->getPortfolioWorth($portfolio_data['Portfolio']['id'],$portfolio_data['Portfolio']['created'],$todays_date);
                
		$result = array();
		$result['portfolio_id'] = $portfolio_data['Portfolio']['id'];
		$result['available_trades'] = $portfolio_data['Portfolio']['trades'];
		$result['available_cash'] = $portfolio_data['Portfolio']['net_value'];
		if ($portfolio_data['UserStock'])
		{
			$result['portfolio_worth'] = $portfolio_data['Portfolio']['net_value'] + $portfolio_data['UserStock'][0]['UserStock'][0]['total_stock_cost'];
			$result['portfolio_stock_count'] = $portfolio_data['UserStock'][0]['UserStock'][0]['total_stock_count'];
		}
		else
		{
			$result['portfolio_worth'] = $portfolio_data['Portfolio']['net_value'];
			$result['portfolio_stock_count'] = 0;
		}
                $result['portfolio_percentage_change'] = $portfolio_percentage_change;
		$result['quantity'] = $data['stock_detail']['quantity'] - $data['quantity'];
                $result['net_value_change'] = $result['portfolio_worth']-$portfolio_data['Portfolio']['start_money'];
		return $result;

	}

}
