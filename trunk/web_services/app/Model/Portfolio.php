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
		),
		'UserstockHistory' => array(
			'className' => 'UserstockHistory',
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save portfolio datas as per $data
	 */

	public function savePortfolioDatas($data)
	{
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives portfolio information for the portfolio id $id
	 */

	public function portfolioDetails($id)
	{

		$options = array(
			'conditions' => array('Portfolio.id' => $id, ),
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

	/*method commented as it relates to the guest user
	 *
	 * public function getGamePortfolioValue($data)
	 {

	 $this -> virtualFields = array('total' => 'sum(net_value)', );
	 $options = array(
	 'fields' => array('total', ),
	 'conditions' => array('user_id' => $data['user_id'],'id' =>
	$data['portfolio_id'] ),
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
	 }*/

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives net_value for the portfolio id $id
	 */

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

	/*commented as it relates to the guest user
	 *
	 * public function getTotalCash($data)
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
	 }*/

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives net_value for the portfolio id $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives trades of particular portfolio
	 */

	function getTradeValue($data)
	{
		$options = array(
			'fields' => array('Portfolio.trades'),
			'conditions' => array('Portfolio.id' => $data['portfolio_id']),
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
	 * @uses This function gives net_value for the portfolio id $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function updates portfolio default & previous net value for the
	 * portfolio as per $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives the sum of trades for a particular portfolio as per
	 * $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function gives the total_trades for a particular portfolio as per
	 * $data
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function checks if paid portfolio exists
	 */

	public function isPaidPortfolioExists($data)
	{
		$this -> virtualFields = array('count' => 'count(id)', );
		$options = array(
			'fields' => array('Portfolio.count', ),
			'conditions' => array(
				'Portfolio.game_id' => 2,
				'Portfolio.user_id' => $data['user_id'],
				'Portfolio.is_paid' => 'yes'
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function checks if free portfolio exists
	 */

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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function checks if portfolio exists for the user as per
	 * $requestData
	 */

	public function isPortfolioExists($requestData)
	{
		$options = array(
			'fields' => array('id'),
			'conditions' => array(
				'user_id' => $requestData['user_id'],
				'Portfolio.id' => $requestData['portfolio_id'],
			),
			'recursive' => -1
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function provides a total number of portfolios user has as per the
	 * $data
	 */

	public function totalPortfolioCount($data)
	{
		$this -> virtualFields = array('count' => 'count(id)', );
		$options = array(
			'fields' => array('Portfolio.count', ),
			'conditions' => array(
				'Portfolio.user_id' => $data['user_id'],
				'Portfolio.game_id' => 1
			),
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

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to check available trade and cash for a particular
	 * portfolio
	 */
	function totalTradeCashIndividualPortfolio($data)
	{

		$data = $this -> find('first', array(
			'conditions' => array(
				'Portfolio.id' => $data['portfolio_id'],
				'Portfolio.user_id' => $data['user_id']
			),
			'fields' => array(
				'Portfolio.trades',
				'Portfolio.net_value'
			),
			'recursive' => -1
		));
		if ($data)
		{
			return $data['Portfolio'];
		}
		else
		{
			return array();
		}

	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for resetting day trade game portfolios
	 */
	public function resetDayTrade()
	{

		$paidGamesData = $this -> Game -> premiumGameData();
		$paidGamesIds = array_keys($paidGamesData);

		if ($paidGamesIds)
		{
			$dayTradePortfolioList = $this -> find('all', array(
				'conditions' => array('Portfolio.game_id' => $paidGamesIds),
				'fields' => array(
					'Portfolio.id',
					'Portfolio.start_money',
					'Portfolio.start_trade',
					'Portfolio.trades',
					'Portfolio.game_id'
				),
				'recursive' => -1
			));

			if ($dayTradePortfolioList)
			{

				foreach ($dayTradePortfolioList as $key => $val)
				{

					if ($val['Portfolio']['trades'] < $paidGamesData[$val['Portfolio']['game_id']])
					{
						$trade = $paidGamesData[$val['Portfolio']['game_id']];
					}
					else
					{
						$trade = $val['Portfolio']['trades'];
					}

					$this -> updateAll(array(
						'Portfolio.net_value' => $val['Portfolio']['start_money'],
						'Portfolio.trades' => $trade
					), array('Portfolio.id' => $val['Portfolio']['id']));

					$this -> UserStock -> deleteAll(array('UserStock.portfolio_id' => $val['Portfolio']['id']), true);
					$this -> Watchlist -> deleteAll(array('Watchlist.portfolio_id' => $val['Portfolio']['id']), true);
					$this -> Transaction -> deleteAll(array('Transaction.portfolio_id' => $val['Portfolio']['id']), true);

				}

				return true;

			}
			else
			{
				return false;
			}
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
	 * @uses This function is used for resetting portfolio game portfolios
	 */
	public function resetPortfolioGame($data)
	{

		$portfolioData = $this -> find('first', array(
			'conditions' => array(
				'Portfolio.id' => $data['portfolio_id'],
				'Portfolio.user_id' => $data['user_id']
			),
			'fields' => array(
				'Portfolio.id',
				'Portfolio.portfolio_name',
				'Portfolio.start_money',
				'Portfolio.start_trade',
				'Portfolio.trades',
				'Portfolio.game_id',
                                'Portfolio.created'
			),
			'contain' => array('Game' => array('fields' => array(
						'Game.id',
						'Game.default_trades'
					)))
		));

		if ($portfolioData)
		{

			if ($portfolioData['Portfolio']['trades'] < $portfolioData['Game']['default_trades'])
			{
				$trade = $portfolioData['Game']['default_trades'];
			}
			else
			{
				$trade = $portfolioData['Portfolio']['trades'];
			}

			$this -> updateAll(array(
				'Portfolio.net_value' => $portfolioData['Portfolio']['start_money'],
				'Portfolio.trades' => $trade
			), array('Portfolio.id' => $portfolioData['Portfolio']['id']));
			$this -> UserStock -> deleteAll(array('UserStock.portfolio_id' => $portfolioData['Portfolio']['id']), true);
			$this -> Watchlist -> deleteAll(array('Watchlist.portfolio_id' => $portfolioData['Portfolio']['id']), true);
			$this -> Transaction -> deleteAll(array('Transaction.portfolio_id' => $portfolioData['Portfolio']['id']), true);

                        $todays_date = date('Y-m-d h:i:s');
                        $portfolio_percentage_change = $this->UserstockHistory->getPortfolioWorth($portfolioData['Portfolio']['id'],$portfolioData['Portfolio']['created'],$todays_date);
                        
			$portfolio_detail = array();
			$portfolio_detail['portfolio_id'] = $portfolioData['Portfolio']['id'];
			$portfolio_detail['portfolio_name'] = $portfolioData['Portfolio']['portfolio_name'];
			$portfolio_detail['start_money'] = $portfolioData['Portfolio']['start_money'];
			$portfolio_detail['available_cash'] = $portfolioData['Portfolio']['start_money'];
			$portfolio_detail['portfolio_worth'] = $portfolioData['Portfolio']['start_money'];
                        $portfolio_detail['portfolio_percentage_change'] = $portfolio_percentage_change;
			$portfolio_detail['available_trades'] = $trade;
			$portfolio_detail['portfolio_stock_count'] = 0;

			return $portfolio_detail;

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
	 * @uses This function is used for  auto resetting trades for normal portfolio
	 * game portfolios
	 */
	public function autoResetPortfolioGame()
	{

		$portfolioGamesData = $this -> Game -> portfolioGameData();
		$portfolioGamesIds = array_keys($portfolioGamesData);

		if ($portfolioGamesIds)
		{

			$portfolioList = $this -> find('all', array(
				'conditions' => array('Portfolio.game_id' => $portfolioGamesIds),
				'fields' => array(
					'Portfolio.id',
					'Portfolio.trades',
					'Portfolio.game_id'
				),
				'recursive' => -1
			));

			if ($portfolioList)
			{

				foreach ($portfolioList as $key => $val)
				{

					if ($val['Portfolio']['trades'] < $portfolioGamesData[$val['Portfolio']['game_id']])
					{
						$trade = $portfolioGamesData[$val['Portfolio']['game_id']];
					}
					else
					{
						$trade = $val['Portfolio']['trades'];
					}

					$this -> updateAll(array('Portfolio.trades' => $trade), array('Portfolio.id' => $val['Portfolio']['id']));

					

				}

				return true;

			}
			else
			{
				return false;
			}
		}
		else
		{

			return false;
		}

	}

}
