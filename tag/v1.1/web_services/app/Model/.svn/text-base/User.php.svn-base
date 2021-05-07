<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Portfolio $Portfolio
 * @property UserLog $UserLog
 * @property UserStock $UserStock
 */
class User extends AppModel
{

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'username';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'id' => array('alphanumeric' => array('rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			), ),
		'username' => array('notempty' => array(
				'rule' => array('notempty'),
				'message' => "Field can't be empty. Please enter valid user name ",
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			), ),
		'email' => array('email' => array(
				'rule' => array('email'),
				'message' => 'Please enter valid Email address',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			), ),
		'password' => array('notempty' => array('rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)),
	);

	//The Associations below have been created with all possible keys, those that are
	// not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Portfolio' => array(
			'className' => 'Portfolio',
			'foreignKey' => 'user_id',
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
		'UserLog' => array(
			'className' => 'UserLog',
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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

	public function checkEmailExists($email)
	{
		$user = $this -> find('first', array(
			'conditions' => array('email' => $email),
			'recursive' => -1
		));
		if ($user)
		{
			return $user;
		}
		else
		{
			return FALSE;
		}
	}

	public function checkFbUserNameExists($data)
	{
		$user = $this -> find('first', array(
			'conditions' => array('username' => $data['facebook_id']),
			'recursive' => -1
		));
		pr($user);
		exit();
		if ($user)
		{
			return $user;
		}
		else
		{
			return FALSE;
		}
	}

	/*public function checkShareIdExists($data) {

	 $userPwd = $this->find('first', array('conditions' => array('id' => $id,
	 'password' => $pwd), 'recursive' => -1));
	 if ($userPwd) {
	 return True;
	 } else {
	 return FALSE;
	 }

	 }*/

	public function getUserDetails($data)
	{
		$user = $this -> find('all', array(
			'conditions' => array('id' => $data['user_id']),
			'recursive' => -1
		));
		if ($user)
		{
			return $user;
		}
		else
		{
			return FALSE;
		}
	}

	public function checkUsernameExists($username)
	{
		$user = $this -> find('first', array(
			'conditions' => array('username' => $username),
			'recursive' => -1
		));
		if ($user)
		{
			return $user;
		}
		else
		{
			return FALSE;
		}
	}

	function updateChangePwdToken($data)
	{
		if ($this -> save($data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function updateBioToken($data)
	{

		$updateData = array(
			'id' => $data['user_id'],
			'biodata' => $data['biodata']
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

	function updateGuest($data)
	{
		//pr($data); exit();
		$updateData = array(
			'id' => $data['user_id'],
			'role' => 'User',
			'username' => $data['username'],
			'job_title' => $data['job_title'],
			'email' => $data['email'],
			'password' => $data['password'],
			'device_id' => NULL,
			'image' => $data['image'],
			'is_registered' => 'yes'
		);
		if ($this -> save($updateData))
		{
			//pr($updateData);exit();
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function fetchUserFields($data)
	{

		$options = array(
			'fields' => array(
				'job_title',
				'role',
				'biodata',
			),
			'conditions' => array('User.id' => $data['user_id']
				//'User.status' => 'active',
			),
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

	public function checkFacebookUserExists($facebook_id)
	{
		$user = $this -> find('first', array(
			'conditions' => array('facebook_id' => $facebook_id),
			'recursive' => -1
		));
		if ($user)
		{
			return $user;
		}
		else
		{
			return FALSE;
		}
	}

	function checkDataExists($requestData)
	{

		$userInfo = $this -> find('first', array('conditions' => array('OR' => array(
					array('User.email' => $requestData),
					array('User.username' => $requestData)
				))));

		return $userInfo;
	}

	function checkAndLogin($requestData = array())
	{

		$userInfo = $this -> find('first', array('conditions' => array('OR' => array(
					array(
						'User.email' => $requestData['email'],
						'User.password' => AuthComponent::password($requestData['password'])
					),
					array(
						'User.username' => $requestData['email'],
						'User.password' => AuthComponent::password($requestData['password'])
					)
				))));

		return $userInfo;
	}

	function checkFbLogin($requestData = array())
	{

		$userInfo = $this -> find('first', array('conditions' => array('OR' => array(
					array(
						'User.email' => $requestData['email'],
						'User.password' => AuthComponent::password($requestData['password'])
					),
					array(
						'User.username' => $requestData['username'],
						'User.password' => AuthComponent::password($requestData['password'])
					)
				))));

		return $userInfo;
	}

	function checkFbIdentifier($requestData = array())
	{

		$user_detail = $this -> User -> find('first', array('conditions' => array('facebook_id' => $requestData['facebook_id'], )));

		return $user_detail;
	}

	function updateUserLog($data)
	{
		$updateUserLog = $this -> UserLog -> updateAll(array('UserLog.status' => '\'LoggedOut\''), array('UserLog.access_token' => $data['access_token']));

		if ($updateUserLog)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function updateGuestUser($data)
	{
		$updateGuestUser = $this -> updateAll(array('role' => '\'User\''), array('username' => $data['username']), array('job_title' => $data['job_title']));

		if ($updateGuestUser)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/*public function checkBioTokenValid($data){
	 $data = array(
	 'User' => array(
	 'id'          =>    $data['user_id'],
	 'biodata'   =>    $data['biodata']
	 )
	 );

	 //  $data = $this->find('first', array('conditions' => array('User.id' =>
	 // $data['user_id']), 'recursive' => -1));
	 /*$updateUserLog = $this->User->updateAll(
	 array('User.biodata' => $data['biodata'])
	 );				$updateUserLog = $this->User->save($data);
	 if($updateUserLog){
	 return true;
	 }else{
	 return false;
	 }

	 }

	 function saveBio($data) {
	 $data = array('User' => array('User.id' => $data['user_id'],'User.biodata' =>
	 $data['biodata']), 'recursive' => -1);
	 $save = $this->User->save($data);
	 if ($save) {
	 return TRUE;
	 } else {
	 return FALSE;
	 }
	 }

	 /**
	 * Function to generate authEncryptPassword
	 * @author 	Pankaj Kumar jha
	 */
	function authPassword($pwd)
	{
		if (!empty($pwd))
		{
			return AuthComponent::password($pwd);
		}
	}

	function checkPasswordMatch($id, $pwd)
	{
		$userPwd = $this -> find('first', array(
			'conditions' => array(
				'id' => $id,
				'password' => $pwd
			),
			'recursive' => -1
		));
		if ($userPwd)
		{
			return True;
		}
		else
		{
			return FALSE;
		}
	}

	function updateUserPassword($data)
	{
		$data['id'] = $data['user_id'];
		$data['password'] = $data['password'];
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

	function updateImage($data)
	{
		// $data['id'] = $data['user_id'];

		$updateData = array(
			'id' => $data['user_id'],
			'image' => $data['image']['name']
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

	function saveLoginDatas($data)
	{
		$save = $this -> UserLog -> save($data);
		if ($save)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function saveFbLoginDatas($data)
	{
		$save = $this -> UserLog -> saveAll($data);
		if ($save)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function getUserId($data)
	{
		$options = array(
			'fields' => array('id', ),
			'conditions' => array('device_id' => $data['device_id'], ),
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

	function getSocialUserId($data)
	{

		$options = array(
			'fields' => array('id', ),
			'conditions' => array('facebook_id' => $data['facebook_id'], ),
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

	function checkGuest($data)
	{

		$updateData = array('device_id' => $data['device_id']);
		if ($this -> save($updateData))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function checkDeviceExists($data)
	{
		$user = $this -> find('first', array(
			'conditions' => array(
				'is_registered' => 'no',
				'device_id' => $data['device_id']
			),
			'recursive' => -1
		));
		if ($user)
		{
			return $user;
		}
		else
		{
			return FALSE;
		}
	}

	function isRegistered($data)
	{
		$user = $this -> find('first', array(
			'conditions' => array(
				'is_registered' => 'yes',
				'username' => $data['username'],
				'email' => $data['email']
			),
			'recursive' => -1
		));
		if ($user)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function isNotRegistered($data)
	{
		$user = $this -> find('first', array(
			'conditions' => array(
				'is_registered' => 'no',
				'device_id' => $data['device_id']
			),
			'recursive' => -1
		));
		if ($user)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function saveGuest($data)
	{
		$updateData = array('device_id' => $data['device_id']);
		//pr($data); exit();
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

	function updateGuestData($data)
	{
		//pr($data); exit();

		$updateData = array('id' => $data['user_id']);
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

	public function checkGuestDatas($data)
	{
		// pr($data);exit();
		$user = $this -> find('first', array(
			'conditions' => array(
				'is_registered' => 'no',
				'device_id' => $data['device_id']
			),
			'contains' => array('UserLog'),
			'recursive' => -1
		));
		//pr($user);exit();
		if ($user)
		{
			return $user;
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
	 * @uses This function is used for listing out the registered users
	 */
	function listRegisteredUsers()
	{
		$list = $this -> find('list', array(
			'conditions' => array(
				'User.status' => 'Active',
				'User.role' => 'User',
				'User.is_registered' => 'yes'
			),
			'fields' => array(
				'User.id',
				'User.email'
			),
			'recursive' => -1,
			'limit' => 500,
			'order' => 'User.modified DESC'
		));
		if ($list)
		{
			return $list;
		}
		else
		{
			return $list;
		}
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for listing the portfolios in the leader board
	 */
	function leaderPortfolios($users, $game_id)
	{
		$portfolios = $this -> find('all', array(
			'conditions' => array('User.id' => $users),
			'fields' => array(
				'User.id',
				'User.email',
				'User.username',
				'User.facebook_id',
				'User.image'
			),
			'contain' => array('Portfolio' => array(
					'conditions' => array('Portfolio.game_id' => $game_id),
					'UserStock' => array(
						'conditions' => array(
							'UserStock.status' => 'buy',
							'UserStock.is_pending' => 'no'
						),
						'fields' => array(
							'UserStock.id',
							'UserStock.user_id',
							'UserStock.portfolio_id',
							'UserStock.total_amount'
						)
					)
				)),
			'limit' => 300
		));

		if ($portfolios)
		{
			$portfoliosTotalAmount = $this -> _calculateTotalShareAmount($portfolios);
			return $portfoliosTotalAmount;

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
	 * @uses This function is used for calculating the highest net amount of user
	 */
	function highestNetAmountPortfolio($user_id, $game_id)
	{

		$portfolios = $this -> find('all', array(
			'conditions' => array('User.id' => $user_id),
			'fields' => array(
				'User.id',
				'User.email',
				'User.username',
				'User.facebook_id',
				'User.image'
			),
			'contain' => array('Portfolio' => array(
					'conditions' => array('Portfolio.game_id' => $game_id),
					'UserStock' => array(
						'conditions' => array(
							'UserStock.status' => 'buy',
							'UserStock.is_pending' => 'no'
						),
						'fields' => array(
							'UserStock.id',
							'UserStock.user_id',
							'UserStock.portfolio_id',
							'UserStock.total_amount'
						)
					)
				)),
		));

		if ($portfolios)
		{
			$totalAmount = $this -> _calculateTotalShareAmount($portfolios);

			foreach ($totalAmount as $key => $val)
			{
				if (isset($val['total_share_amount']))
				{
					$sortedData = $val['total_share_amount'];
					$key = array_search(max($sortedData), $sortedData);
					$portfolios_max_net_amount['user_id'] = $val['User']['id'];
					$portfolios_max_net_amount['email'] = $val['User']['email'];
					$portfolios_max_net_amount['username'] = $val['User']['username'];
					if ($val['User']['facebook_id'] == '')
					{
						$portfolios_max_net_amount['image'] = ABS_URL . 'files/uploads/' . $val['User']['image'];
					}
					else
					{
						$portfolios_max_net_amount['image'] = $val['User']['image'];
					}
					$portfolios_max_net_amount['portfolio_id'] = $val['Portfolio'][$key]['id'];
					$portfolios_max_net_amount['portfolio_name'] = $val['Portfolio'][$key]['portfolio_name'];
					$portfolios_max_net_amount['total_net_value'] = $sortedData[$key];
					$userData = array('data' => $portfolios_max_net_amount);

				}
			}
			return $userData;

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
	 * @uses This function is used calculating the summation of net value and total
	 * share value for each portfolios
	 */
	function _calculateTotalShareAmount($portfolios)
	{
		foreach ($portfolios as $key => $val)
		{
			if (isset($val['Portfolio']))
			{
				$total = 0;
				foreach ($val['Portfolio'] as $portfolioKey => $portfolioVal)
				{

					$total = $portfolioVal['net_value'];

					if (isset($portfolioVal['UserStock']))
					{
						foreach ($portfolioVal['UserStock'] as $UserStock)
						{
							$total += $UserStock['total_amount'];
						}
					}

					$portfolios[$key]['total_share_amount'][$portfolioKey] = $total;
				}

			}
		}

		return $portfolios;
	}

	public function getTotalPortfolioNetValue($data)
	{
		//$this -> virtualFields = array('net_value' =>
		// 'max(Portfolio.net_value)','amount' => 'max(UserStock.total_amount)' );
		$this -> virtualFields = array('total' => 'sum(DISTINCT Portfolio.net_value + UserStock.total_amount)');
		$options = array(
			'fields' => array('total'),
			'joins' => array(
				array(
					'conditions' => array('User.id = Portfolio.user_id'),
					'table' => 'portfolios',
					'alias' => 'Portfolio',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
				array(
					'conditions' => array('Portfolio.id = UserStock.portfolio_id'),
					'table' => 'user_stocks',
					'alias' => 'UserStock',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
			),
			'conditions' => array(
				'User.id' => $data['user_id'],
				'User.id = UserStock.user_id'
			),
			'group' => array('Portfolio.id', ),
			//'contain' => array('Portfolio','UserStock'),
			'order' => array('total' => 'desc', ),
			'limit' => '1',
			'recursive' => -1
		);
		$data = $this -> find('first', $options);
		//pr($data);
		//exit();
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function getMaxNetValue($data)
	{
		$this -> virtualFields = array('total' => 'sum(DISTINCT Portfolio.net_value + UserStock.total_amount)');
		$options = array(
			'fields' => array('total'),
			'joins' => array(
				array(
					'conditions' => array('User.id = Portfolio.user_id'),
					'table' => 'portfolios',
					'alias' => 'Portfolio',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
				array(
					'conditions' => array('Portfolio.id = UserStock.portfolio_id'),
					'table' => 'user_stocks',
					'alias' => 'UserStock',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
			),
			'conditions' => array(
				'User.id' => $data['user_id'],
				'User.id = UserStock.user_id'
			),
			'group' => array('Portfolio.id', ),
			//'contain' => array('Portfolio','UserStock'),
			'order' => array('total' => 'desc', ),
			'limit' => '1',
			'recursive' => -1
		);
		$data = $this -> find('first', $options);
		pr($data);
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

	public function individualPortfolioNetValue($data)
	{
		$this -> virtualFields = array('net_value' => 'sum(Portfolio.net_value + UserStock.total_amount)');
		$options = array(
			'fields' => array('net_value'),
			'joins' => array(
				array(
					'conditions' => array('User.id = Portfolio.user_id'),
					'table' => 'portfolios',
					'alias' => 'Portfolio',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
				array(
					'conditions' => array('Portfolio.user_id = UserStock.user_id'),
					'table' => 'user_stocks',
					'alias' => 'UserStock',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
			),
			'conditions' => array(
				'User.id' => $data['user_id'],
				'Portfolio.id' => $data['portfolio_id'],
				'User.id = UserStock.user_id'
			),

			//'contain' => array('Portfolio','UserStock'),
			'recursive' => -1
		);
		$data = $this -> find('first', $options);
		pr($data);
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

	public function getPortfolioList($data)
	{

		$this -> virtualFields = array(
	
			'portfolio_id' => 'Portfolio.id',
			'portfolio_name' => 'Portfolio.portfolio_name',
			'available_cash' => 'Portfolio.net_value',
			'portfolio_worth' => 'Portfolio.net_value',
			'start_money' => 'Portfolio.start_money',
			'total_count_of_stocks' => 0,
			'total_trades' => 'Portfolio.trades',
			'total_cash' => 'Portfolio.net_value',
		);
		$options = array(
			'fields' => array(

				'portfolio_id',
				'portfolio_name',
				'available_cash',
				'portfolio_worth',
				'start_money',
				'total_count_of_stocks',
				'total_trades',
				'total_cash',
				
			),
			'joins' => array(
				array(
					'conditions' => array('User.id = Portfolio.user_id'),
					'table' => 'portfolios',
					'alias' => 'Portfolio',
					'type' => 'left',
					'foreignKey' => FALSE,
				),
			/*	array(
					'conditions' => array('Portfolio.id = UserStock.portfolio_id'),
					'table' => 'user_stocks',
					'alias' => 'UserStock',
					'type' => 'right',
					'foreignKey' => FALSE,
				),*/
			),
			'conditions' => array('Portfolio.user_id' => $data['user_id'], ),
			'group' => array('Portfolio.id', ),
			'recursive' => -1
		);
		$data = $this -> find('all', $options);
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

	public function getAllPortfolioListing($data)
	{
		$this -> virtualFields = array(
			'portfolio_id' => 'Portfolio.id',
			'portfolio_name' => 'Portfolio.portfolio_name',
			'portfolio_worth' => 'Portfolio.net_value + sum(UserStock.total_amount)',
			'available_cash' => 'Portfolio.net_value',
			 'start_money' => 'Portfolio.start_money',
			'total_count_of_stocks' => 'count(UserStock.share_id)',
			'total_trades' => 'Portfolio.trades',
			'total_cash' => 'Portfolio.net_value',
		);
		$options = array(
			'fields' => array(
				'portfolio_id',
				'portfolio_name',
				'portfolio_worth',
				 'start_money',
				'total_count_of_stocks',
				'total_trades',
				'total_cash'

			),
			'joins' => array(
				array(
					'conditions' => array('User.id = Portfolio.user_id'),
					'table' => 'portfolios',
					'alias' => 'Portfolio',
					'type' => 'left',
					'foreignKey' => FALSE,
				),
				array(
					'conditions' => array('Portfolio.id = UserStock.portfolio_id'),
					'table' => 'user_stocks',
					'alias' => 'UserStock',
					'type' => 'left',
					'foreignKey' => FALSE,
				),
			),
			'conditions' => array('UserStock.user_id' => $data['user_id'], ),
			'group' => array('Portfolio.id', ),
			'recursive' => -1
		);
		$data = $this -> find('all', $options);
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

	public function getLeaderPortfolioValue($data)
	{

		$this -> virtualFields = array(
			'user_id' => 'User.id',
			'portfolio_id' => 'Portfolio.id',
			'portfolio_name' => 'Portfolio.portfolio_name',
			'total' => 'sum(DISTINCT Portfolio.net_value + UserStock.total_amount)'
		);
		$options = array(
			'fields' => array(
				'user_id',
				'portfolio_id',
				'portfolio_name',
				'total'
			),
			'joins' => array(
				array(
					'conditions' => array('User.id = Portfolio.user_id'),
					'table' => 'portfolios',
					'alias' => 'Portfolio',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
				array(
					'conditions' => array('Portfolio.id = UserStock.portfolio_id'),
					'table' => 'user_stocks',
					'alias' => 'UserStock',
					'type' => 'inner',
					'foreignKey' => FALSE,
				),
			),
			'conditions' => array(
				'User.id' => $data['user_id'],
				'User.id = UserStock.user_id',
				'Portfolio.is_paid' => 'yes'
			),
			'group' => array('Portfolio.id', ),
			//'contain' => array('Portfolio','UserStock'),
			'order' => array('total' => 'desc', ),
			'limit' => '1',
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

	public function getPortfolioStockDatas($data)
	{
		$user = $this -> query("select users.id as user_id, games.id as game_id, portfolios.id as portfolio_id , portfolios.portfolio_name as portfolio_name, (portfolios.net_value+sum(user_stocks.total_amount)) as current_net_amount, portfolios.start_money as portfolio_start_money, count(user_stocks.is_pending) as pending_transaction_count, count(user_stocks.share_id) as total_count_of_stocks from users inner join portfolios on portfolios.user_id = users.id inner join games on games.id = portfolios.game_id inner join user_stocks on portfolios.id = user_stocks.portfolio_id where user_stocks.user_id = ".$data['user_id']." group by portfolios.id");
		//$user = $this -> query("select users.id as user_id, portfolios.id as portfolio_id , (portfolios.net_value + user_stocks.total_amount) as current_net_amount group by portfolios.id");
		
		pr($user);exit();
		$result = Set::classicExtract($user, '{n}');
		if ($result)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}

	}

}
