<?php
App::uses('AppModel', 'Model');
/**
 * Portfolio Model
 *
 * @property User $User
 * @property Game $Game
 */
class Portfolio extends AppModel
{
	//The Associations below have been created with all possible keys, those that are
	// not needed can be removed
	/**
	 * belongsTo associations
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
		'Game' => array(
			'className' => 'Game',
			'foreignKey' => 'game_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true,
		)
	);
	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'portfolio_id',
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
			'foreignKey' => 'portfolio_id',
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
		'Watchlist' => array(
			'className' => 'Watchlist',
			'foreignKey' => 'portfolio_id',
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
	public function checkPortfolioExists($requestData)
	{
		$options = array(
			'fields' => array('id'),
			'conditions' => array(
				'user_id' => $requestData['user_id'],
				'portfolio_id' => $requestData['portfolio_id'],
				'game_id' => $requestData['game_id']
			)
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

	public function savePortfolioDatas($data)
	{
		//pr($data); exit();
		$save = $this -> saveAll($data);

		if ($save)
		{
			return $save;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function portfolioDetails($id)
	{
		
		$options = array(
			'conditions' => array(
				'Portfolio.id' => $id,
			),
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

		$this -> virtualFields = array('total' => 'sum(net_value)', );
		$options = array(
			'fields' => array('total', ),
			'conditions' => array('user_id' => $data['user_id'], ),
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

	public function getIndividualPortfolioValue($data)
	{

		$this -> virtualFields = array('net_value' => 'net_value', );
		$options = array(
			'fields' => array('net_value', ),
			'conditions' => array('id' => $data['portfolio_id'], ),
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
	
	public function getPortfolioListing($data)
	{
		$this -> virtualFields = array(
			'portfolio_id' => 'Portfolio.id',
			'portfolio_name' => 'Portfolio.portfolio_name',
			'current_net_value' => 'Portfolio.net_value + sum(UserStock.total_amount)',
			'previous_net_value' => 'Portfolio.previous_net_value',
			'pending_transaction_count' => 'count(UserStock.is_pending)',
			'total_count_of_stocks' => 'count(UserStock.share_id)',
			
		);
		$options = array(
			'fields' => array(
				'portfolio_id',
				'current_net_value',
				'previous_net_value',
				'portfolio_name',
				'total_count_of_stocks',
				'pending_transaction_count'
	
			),
			'conditions' => array(
				'user_id' => $data['user_id'],
			),
			'contain'=>array('UserStock'),
			'recursive' => -1
		);
		$data = $this -> find('all', $options);
		pr($data); exit();
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function getPortfolioDatas($data)
	{
		//pr($data); exit();
		$this -> virtualFields = array('portfolio_id' => 'Portfolio.id');
		$options = array(
			'fields' => array(
				'portfolio_id',
				'net_value',
				'portfolio_name',
			),
			'conditions' => array(
				'user_id' => $data['user_id'],
				'game_id' => $data['game_id'],
				'id' => $data['portfolio_id']
			),
			'recursive' => -1
		);
		$data = $this -> find('all', $options);
		//pr($data); exit();
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function getPortfolioList($data)
	{
		//pr($data); exit();
		$this -> virtualFields = array('portfolio_id' => 'Portfolio.id');
		$options = array(
			'fields' => array(
				'portfolio_id',
				'net_value',
				'portfolio_name',
			),
			'conditions' => array(
				'user_id' => $data['user_id']
			),
			'recursive' => -1
		);
		$data = $this -> find('all', $options);
		//pr($data); exit();
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function getLeaderPortfolioValue($data)
	{
		$this -> virtualFields = array(
			'current_leader_value' => 'MAX(DISTINCT net_value)',
			'portfolio_id' => 'Portfolio.id'
		);
		$options = array(
			'fields' => array(
				'portfolio_id',
				'portfolio_name',
				'current_leader_value',
			),
			'conditions' => array('is_paid' => 'yes', ),
			'group' => array('user_id', ),
			'order' => array('current_leader_value' => 'desc', ),
			'limit' => '1',
			'recursive' => -1
		);
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

	public function getHighestPortfolioValue($data)
	{
		$this -> virtualFields = array(
			'maximum' => 'MAX(DISTINCT net_value)',
			'portfolio_id' => 'Portfolio.id'
		);
		$options = array(
			'fields' => array(
				'maximum',
				'portfolio_id'
			),
			'conditions' => array('user_id' => $data['user_id'], ),
			'group' => array('user_id', ),
			'order' => array('maximum' => 'desc', ),
			'limit' => '1',
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

	public function getTotalPortfolioValue($data)
	{

		$this -> virtualFields = array('total' => 'SUM(net_value)');
		$options = array(
			'fields' => array(
				'maximum',
				'portfolio_id'
			),
			'conditions' => array('user_id' => $data['user_id'], ),
			'group' => array('user_id', ),
			'order' => array('maximum' => 'desc', ),
			'limit' => '1',
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

	public function getTotalCash($data)
	{
		$this -> virtualFields = array('total_cash' => 'SUM(net_value)');
		$options = array(
			'fields' => array('total_cash', ),
			'conditions' => array('user_id' => $data['user_id'], ),
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

	public function getIndividualPortfolioCash($data)
	{
		$this -> virtualFields = array('total_cash' => 'SUM(net_value)');
		$options = array(
			'fields' => array('total_cash', ),
			'conditions' => array('user_id' => $data['user_id'], ),
			'group' => array('user_id', ),
			'recursive' => -1
		);
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

	function resetPortfolio($data)
	{
		$updateData = array(
			'id' => $data['portfolio_id'],
			'net_value' => $data['net_value'],
			'trades' => $data['trades']
		);
		if ($this -> save($updateData))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function getNetValue($data)
	{
		$options = array(
			'fields' => array('Portfolio.net_value'),
			'conditions' => array('Portfolio.id' => $data['portfolio_id']),
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

	function getTradeValue($data)
	{
		$options = array(
			'fields' => array('Portfolio.trades'),
			'conditions' => array('Portfolio.id' => $data['portfolio_id']),
			'recursive' => -1
		);
		$data = $this -> find('first', $options);
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

	function updateTrades($data)
	{
		$updateData = array(
			'id' => $data['portfolio_id'],
			'trades' => $data['tradeValue']
		);
		if ($this -> save($updateData))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function updatePortfolioDefaultValue($data)
	{
		$updateData = array(
			'id' => $data['portfolio_id'],
			'net_value' => $data['default_net_value'],
			'previous_net_value' => $data['previous_net_value']
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

	public function getTotalTradeValue($data)
	{
		$this -> virtualFields = array('total_trades' => 'SUM(trades)', );
		$options = array(
			'fields' => array('total_trades', ),
			'conditions' => array('user_id' => $data['user_id'], ),
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

	public function getIndividualTrades($data)
	{
		$this -> virtualFields = array('total_trades' => 'trades', );
		$options = array(
			'fields' => array('total_trades', ),
			'conditions' => array('id' => $data['portfolio_id'], ),
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

	public function isPaidPortfolioExists($data)
	{
		$this -> virtualFields = array('count' => 'count(id)', );
		$options = array(
			'fields' => array('Portfolio.count', ),
			'conditions' => array(
				'Portfolio.game_id' => 2,
				'Portfolio.user_id' => $data['user_id'],
				'Portfolio.is_paid' => 'yes'
			),'recursive' => -1
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

	public function isFreePortfolioExists($data)
	{
		$options = array(
			'fields' => array('Portfolio.id'),
			'conditions' => array(
				'Game.id' => $data['game_id'],
				'Game.status' => 'active',
				'Portfolio.user_id' => $data['user_id'],
				'Portfolio.is_paid' => 'no'
			),
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function portfolioTrial($data)
	{
		//$this -> virtualFields = array('net_amount' => 'sum(Portfolio.net_value) ');
		$options = array(
			'fields' => array(
				'sum(Portfolio.net_value) as total',
				'sum(UserStock.total_amount) as amount'
			),
			'joins' => array( array(
					'conditions' => array('Portfolio.id = UserStock.portfolio_id'),
					'table' => 'user_stocks',
					'alias' => 'UserStock',
					'type' => 'inner',
					'foreignKey' => TRUE,
				), ),
			'conditions' => array('UserStock.user_id' => $data['user_id'], ),
			//'contain' => array('UserStock','User'),
			'group' => array('UserStock.user_id'),
			'recursive' => -1
		);
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

	public function isPortfolioExists($requestData)
	{
		$options = array(
			'fields' => array('id'),
			'conditions' => array(
				'user_id' => $requestData['user_id'],
				'Portfolio.id' => $requestData['portfolio_id'],
			)
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
	
	public function isPortfolio($requestData)
	{
		$options = array(
			'conditions' => array(
				'user_id' => $requestData['user_id']
			)
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

	function setActivePortfolio($id)
	{
		$this -> id = $id;
		$this -> saveField('is_active', 'yes');
		$this -> virtualFields = array(
			'portfolio_id' => 'Portfolio.id',
			'total_cash' => 'Portfolio.net_value',
			'total_trades' => 'Portfolio.trades'
		);
		$this -> UserStock -> virtualFields = array('total_amount' => 'sum(UserStock.total_amount) ');
		$findData = $this -> find('first', array(
			'conditions' => array('Portfolio.id' => $id),
			'fields' => array(
				'Portfolio.game_id',
				'Portfolio.portfolio_id',
				'Portfolio.portfolio_name',
				'Portfolio.total_cash',
				'Portfolio.total_trades'
			),
			'contain' => array('UserStock' => array(
					'conditions' => array('UserStock.status' => 'buy'),
					'fields' => array('UserStock.total_amount')
				))
		));

		if ($findData)
		{
			if (!empty($findData['UserStock']))
			{
				$findData['Portfolio']['net_value'] = $findData['Portfolio']['total_cash'] + $findData['UserStock'][0]['total_amount'];
			}
			else
			{
				$findData['Portfolio']['net_value'] = $findData['Portfolio']['total_cash'];
			}

			$portfolioData = $findData['Portfolio'];
			return $portfolioData;
		}
		else
		{
			return false;
		}
	}

	public function totalPortfolioCount($data)
	{
		$this -> virtualFields = array('count' => 'count(id)', );
		$options = array(
			'fields' => array('Portfolio.count', ),
			'conditions' => array('Portfolio.user_id' => $data['user_id'], ),
			'group' => array('Portfolio.user_id', ),
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
        
        function totalTradeCashIndividualPortfolio($data)
        {
            
            $data = $this->find('first', array(
                                                'conditions' => array(
                                                                    'Portfolio.id'=> $data['portfolio_id'],
                                                                    'Portfolio.user_id' => $data['user_id']
                                                                    ),
                                                'fields'=> array('Portfolio.trades', 'Portfolio.net_value'),
                                                'recursive' => -1
               
            ));
             if($data){
                 return $data['Portfolio'];
             }else{
                 return array();
             }
             
        }
        
	

}
