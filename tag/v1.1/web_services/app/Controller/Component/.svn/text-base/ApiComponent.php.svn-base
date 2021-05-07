<?php
class ApiComponent extends Object
{
	function initialize(Controller $controller)
	{
	}

	function beforeRender($controller)
	{
	}

	function beforeRedirect($controller)
	{
	}

	function shutdown($controller)
	{
	}

	function startup($controller)
	{
		App::uses('Component', 'Auth', 'Email');
		$this -> Auth = $controller -> Auth;
		$this -> Session = $controller -> Session;
		$this -> User = $controller -> User;
		$this -> UserLog = $controller -> UserLog;
		$this -> Game = $controller -> Game;
		$this -> Portfolio = $controller -> Portfolio;
		$this -> Share = $controller -> Share;
		$this -> Bank = $controller -> Bank;
		$this -> Watchlist = $controller -> Watchlist;
		$this -> Transaction = $controller -> Transaction;
		$this -> UserStock = $controller -> UserStock;
		$this -> Faq = $controller -> Faq;
		$this -> Feedback = $controller -> Feedback;
		$this -> Contact = $controller -> Contact;
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for login as per $data and the User log will
	 * be maintained for successful login
	 */
	function login($data = array())
	{
		@session_start();
		$isAuthenticatedUser = $this -> User -> checkAndLogin($data);
		$updateData = array();
		$finalData = null;
		if (!empty($isAuthenticatedUser))
		{
			$this -> request -> data['User']['email'] = trim($data['email']);
			$this -> request -> data['User']['password'] = $this -> User -> authPassword(trim($data['password']));
			if ($this -> Auth -> login($this -> request -> data['User']))
			{
				$roles = array(2 => 'User');
				$finalData = $this -> Auth -> User();
				if (is_array($finalData))
				{
					$access_token = md5($isAuthenticatedUser['User']['id'] . time());
					$updateData['User']['id'] = $isAuthenticatedUser['User']['id'];
					$updateData['UserLog']['user_id'] = $isAuthenticatedUser['User']['id'];
					$updateData['UserLog']['status'] = 'LoggedIn';
					$updateData['UserLog']['access_token'] = $access_token;
					if ($this -> User -> saveLoginDatas($updateData))
					{
						$finalData['user_id'] = $isAuthenticatedUser['User']['id'];
						$finalData['username'] = $isAuthenticatedUser['User']['username'];
						$fetchUser = $this -> User -> getUserDetails($finalData);
						$finalData['job_title'] = $fetchUser[0]['User']['job_title'];
						$finalData['role'] = $fetchUser[0]['User']['role'];
						$finalData['bio'] = $fetchUser[0]['User']['biodata'];
						if ($finalData['bio'] == NULL)
							$finalData['bio'] = "";
						$finalData['access_token'] = $access_token;
						$status = TRUE;
						$game_list = $this -> Game -> displayGametype($finalData);

						$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
						$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
						$body = array(
							'UserData' => $finalData,
							'GameData' => $game_list,
							'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
							'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
						);
						$message = "Logged in Successfully";
						unset($finalData['password']);
					}
					else
					{
						$body = null;
						$status = FALSE;
						$message = "Login failed!";
					}
				}
				else
				{
					$body = null;
					$status = FALSE;
					$message = "Incorrect Email or Password";
				}
			}
			else
			{
				$body = null;
				$message = "Email could not be logged in.";
				$status = FALSE;
			}
		}
		else
		{
			$body = null;
			$message = "Incorrect Email Username or Password";
			$status = FALSE;
		}

		return $result = array(

			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for logout as per $data and the User log will
	 * be maintained for logout
	 */
	function logout($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			//pr($data);exit();
			if ($this -> User -> updateUserLog($data))
			{
				$this -> Session -> destroy();
				$body = null;
				$status = TRUE;
				$message = "Logout Successfully!";
			}
			else
			{
				$body = null;
				$status = False;
				$message = "Logout Failed!";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token not valid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for updating the biodata of the User as per
	 * $data
	 */
	function bio($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			if ($this -> User -> updateBioToken($data))
			{
				$body = null;
				$status = TRUE;
				$message = "Biodata updated Successfully!";
			}
			else
			{
				$body = null;
				$status = TRUE;
				$message = "Failed! Biodata not updated";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token not valid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for displaying the games list for the User as
	 * per $data
	 */
	function game_list($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			if ($game = $this -> Game -> displayGametype($data))
			{

				$body = $game;
				$status = TRUE;
				$message = "Game List";
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Failed! Game List could not be shown";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token not valid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for displaying the premium games list for the
	 * User as per $data
	 */
	function premium_games($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			if ($content = $this -> Game -> listOfPremiumGames($data))
			{
				$body = $content;
				$status = TRUE;
				$message = "Game List";
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Failed! Game List could not be shown";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token not valid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for creating the portfolio for the User as
	 * per $data
	 */
	//	function portfolio($data)
	//	{
	//		if ($this -> UserLog -> checkAccessTokenValid($data))
	//		{
	//			$defaultCash = $this -> Game -> getGameDetails($data);
	//			if ($data['portfolio_start_money'] <=
	// $defaultCash['Game']['default_net_value'])
	//			{
	//				$gameType = $this -> Game -> getGameType($data);
	//				$isPaidPortfolioExists = $this -> Portfolio ->
	// isPaidPortfolioExists($data);
	//				if ($gameType['Game']['type'] == 'paid')
	//				{
	//					if (empty($isPaidPortfolioExists))
	//					{
	//						if (!empty($data['price']))
	//						{
	//							$updateData = $this -> __save_paid_portfolio($data);
	//							$updateData['Portfolio']['is_paid'] = 'yes';
	//							if ($this -> Portfolio -> savePortfolioDatas($updateData))
	//							{
	//								$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
	//								$totalCashValue = $this -> Portfolio -> getTotalCash($data);
	//								$portContents = array(
	//									$totalTradeValue,
	//									$totalCashValue
	//								);
	//								$id = $this -> Portfolio -> id;
	//								$portfolioDetails = $this -> Portfolio -> portfolioDetails($id);
	//
	//								$contents = array(
	//									'portfolio_id' => $this -> Portfolio -> id,
	//									'game_id' => $data['game_id'],
	//									'previous_net_amount' =>
	// $portfolioDetails['Portfolio']['previous_net_value'],
	//									'current_net_amount' => $portfolioDetails['Portfolio']['net_value'],
	//									'total_trades' => $totalTradeValue['Portfolio']['total_trades'],
	//									'total_cash' => $totalCashValue['Portfolio']['total_cash']
	//								);
	//								$body = $contents;
	//								$status = TRUE;
	//								$message = "Paid portfolio created successfully!";
	//							}
	//							else
	//							{
	//								$body = null;
	//								$status = FALSE;
	//								$message = "Failed! Portfolio could not be created";
	//							}
	//						}
	//						else
	//						{
	//							$body = null;
	//							$status = FALSE;
	//							$message = "This portfolio must be a paid one!";
	//						}
	//					}
	//					else
	//					{
	//						$body = null;
	//						$status = FALSE;
	//						$message = "This game allows only one portfolio!";
	//					}
	//				}
	//				else
	//				{
	//					$isFreePortfolioExists = $this -> Portfolio ->
	// isFreePortfolioExists($data);
	//					if (empty($data['price']))
	//					{
	//						if (empty($isFreePortfolioExists))
	//						{
	//							$updateData = $this -> __save_free_portfolio($data);
	//							if ($this -> Portfolio -> savePortfolioDatas($updateData))
	//							{
	//								$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
	//								$totalCashValue = $this -> Portfolio -> getTotalCash($data);
	//								$portContents = array(
	//									$totalTradeValue,
	//									$totalCashValue
	//								);
	//								$id = $this -> Portfolio -> id;
	//								$portfolioDetails = $this -> Portfolio -> portfolioDetails($id);
	//								$contents = array(
	//									'portfolio_id' => $this -> Portfolio -> id,
	//									'game_id' => $data['game_id'],
	//									'previous_net_amount' =>
	// $portfolioDetails['Portfolio']['previous_net_value'],
	//									'current_net_amount' => $portfolioDetails['Portfolio']['net_value'],
	//									'total_trades' => $totalTradeValue['Portfolio']['total_trades'],
	//									'total_cash' => $totalCashValue['Portfolio']['total_cash']
	//								);
	//								$body = $contents;
	//								$status = TRUE;
	//								$message = "Free portfolio created successfully!";
	//							}
	//							else
	//							{
	//								$body = null;
	//								$status = FALSE;
	//								$message = "Failed! Free Portfolio could not be created";
	//							}
	//						}
	//						else
	//						{
	//							$body = null;
	//							$status = FALSE;
	//							$message = "This portfolio must be a paid one!";
	//						}
	//					}
	//					else
	//					{
	//						$updateData = $this -> __save_paid_portfolio($data);
	//						$updateData['Portfolio']['is_paid'] = 'yes';
	//						if ($this -> Portfolio -> savePortfolioDatas($updateData))
	//						{
	//							$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
	//							$totalCashValue = $this -> Portfolio -> getTotalCash($data);
	//							$portContents = array(
	//								$totalTradeValue,
	//								$totalCashValue
	//							);
	//							$id = $this -> Portfolio -> id;
	//							$portfolioDetails = $this -> Portfolio -> portfolioDetails($id);
	//
	//							$contents = array(
	//								'portfolio_id' => $this -> Portfolio -> id,
	//								'game_id' => $data['game_id'],
	//								'previous_net_amount' =>
	// $portfolioDetails['Portfolio']['previous_net_value'],
	//								'current_net_amount' => $portfolioDetails['Portfolio']['net_value'],
	//								'total_trades' => $totalTradeValue['Portfolio']['total_trades'],
	//								'total_cash' => $totalCashValue['Portfolio']['total_cash']
	//							);
	//							$body = $contents;
	//							$status = True;
	//							$message = "Paid portfolio created successfully!";
	//						}
	//						else
	//						{
	//							$body = null;
	//							$status = FALSE;
	//							$message = "Failed! Paid Portfolio could not be created";
	//						}
	//					}
	//				}
	//			}
	//			else
	//			{
	//				$body = null;
	//				$status = FALSE;
	//				$message = "Portfolio couldnt be created! Start money exceeds the limit";
	//			}
	//		}
	//		else
	//		{
	//			$body = null;
	//			$status = FALSE;
	//			$message = "Access token not valid";
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}

	// here is the modified code for create portfolio

	function create_portfolio($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$updateData = $this -> __save_free_portfolio($data);
			if ($updateData)
			{
				if ($this -> Portfolio -> savePortfolioDatas($updateData))
				{

					$id = $this -> Portfolio -> id;
					$portfolioDetails = $this -> Portfolio -> portfolioDetails($id);
					$contents = array(
						'portfolio_id' => $this -> Portfolio -> id,
						'portfolio_name' => $portfolioDetails['Portfolio']['portfolio_name'],
						'start_money' => $portfolioDetails['Portfolio']['start_money'],
						'available_cash' => $portfolioDetails['Portfolio']['net_value'],
						'portfolio_worth' => $portfolioDetails['Portfolio']['net_value'],
						'total_trades' => $portfolioDetails['Portfolio']['trades'],
						'total_cash' => $portfolioDetails['Portfolio']['net_value'],
						'total_count_of_stocks' => "0",
					);
					$body = $contents;
					$status = TRUE;
					$message = "Portfolio created successfully!";
				}
				else
				{
					$body = null;
					$status = FALSE;
					$message = "Error";
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Max start money exceeded";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token not valid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function has been used in 'portfolio' method for saving the
	 * portfolio for the User as per $data
	 * @return array $updateData which returns the saved portfolio data
	 */
	function __save_free_portfolio($data = array())
	{
		$gameValue = $this -> Game -> getGameDetails($data);
		if ($data['portfolio_start_money'] < $gameValue['Game']['default_net_value'])
		{
			$updateData['Portfolio']['user_id'] = trim($data['user_id']);
			$updateData['Portfolio']['game_id'] = trim($data['game_id']);
			$updateData['Portfolio']['portfolio_name'] = trim($data['portfolio_name']);
			$updateData['Portfolio']['net_value'] = $data['portfolio_start_money'];
			$updateData['Portfolio']['start_money'] = $data['portfolio_start_money'];
			$updateData['Portfolio']['trades'] = trim($gameValue['Game']['default_trades']);
			if (trim($data['is_free'] == 0))
			{
				$updateData['Portfolio']['is_paid'] = 'yes';
			}
			else
			{
				$updateData['Portfolio']['is_paid'] = 'no';
			}
			return $updateData;
		}
		else
		{
			return false;
		}
	}

	function __save_paid_portfolio($data = array())
	{
		$updateData['Portfolio']['user_id'] = trim($data['user_id']);
		$updateData['Portfolio']['game_id'] = trim($data['game_id']);
		$updateData['Portfolio']['portfolio_name'] = trim($data['portfolio_name']);
		$gameValue = $this -> Game -> getGameDetails($data);
		$updateData['Portfolio']['net_value'] = trim($gameValue['Game']['default_net_value']);
		$updateData['Portfolio']['trades'] = trim($gameValue['Game']['default_trades']);
		return $updateData;
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for showing the Game Portfolio Value and
	 * Highest Portfolio Value for the User as per $data
	 */
	function show_portfolio_net_value($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$gamePortfolioValue = $this -> Portfolio -> getGamePortfolioValue($data);
			$getSumPortfolioAmount = $this -> UserStock -> getSumPortfolioAmount($data);
			$userTotalAmount = $gamePortfolioValue['Portfolio']['total'] + $getSumPortfolioAmount['UserStock']['total'];
			$HighestPortfolioValue = $this -> User -> testMaxNetValue($data);
			$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
			$totalCashValue = $this -> Portfolio -> getTotalCash($data);
			$portContents = array(
				$totalTradeValue,
				$totalCashValue
			);
			$contents = array(
				'portfolio_id' => $this -> Portfolio -> id,
				'access_token' => trim($data['access_token']),
				'GamePortfolioValue' => $userTotalAmount,
				'HighestPortfolioValue' => trim($HighestPortfolioValue['User']['total']),
				'user_id' => $data['user_id'],
				'access_token' => $data['access_token'],
				'total_trades' => $totalTradeValue[0]['Portfolio']['total_trades'],
				'total_cash' => $totalCashValue[0]['Portfolio']['total_cash']
			);

			$body = $contents;
			$status = True;
			$message = "Success!";
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for displaying the Game Portfolio Value and
	 * Highest Portfolio Value for the User as per $data
	 */
	function show_portfolio_list($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$portfolioExists = $this -> Portfolio -> isPortfolio($data);
			if(!empty($portfolioExists))
			{
			if($getPortfolioList = $this -> User -> getAllPortfolioListing($data))
			{
			$gameResult = Set::classicExtract($getPortfolioList, '{n}');
			$body = $gameResult;
			$status = True;
			$message = "Success!";
				
			}
			else if(empty($getPortfolioList))
			{
			$getIndividualPortfolioList = $this -> User ->getPortfolioList($data);
			$gameIndividualResult = Set::classicExtract($getIndividualPortfolioList, '{n}');
			
			$body = $gameIndividualResult;
			$status = True;
			$message = "Success!";
				
			}
		
		}
			else
		{
			$body = null;
			$status = FALSE;
			$message = "Portfolio doesnt exists!!";
		}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for displaying the sum of all the portfolio
	 * net values of a user as total Portfolio Value as per $data
	 */
	function total_portfolio_net_value($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$gamePortfolioValue = $this -> Portfolio -> getGamePortfolioValue($data);
			$getSumPortfolioAmount = $this -> UserStock -> getSumPortfolioAmount($data);
			$userTotalAmount = $gamePortfolioValue['Portfolio']['total'] + $getSumPortfolioAmount['UserStock']['total'];

			$contents = array(
				'user_id' => trim($data['user_id']),
				'access_token' => trim($data['access_token']),
				'TotalPortfolioValue' => $userTotalAmount
			);
			//pr($contents); exit();
			$body = $contents;
			$status = True;
			$message = "Success!";
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for resetting the portfolio for the User as
	 * per $data
	 */
	function reset_portfolio($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$gameValue = $this -> Game -> getGameDetails($data);
			//pr($gameValue); exit();
			//$updateData['Portfolio']['net_value'] =
			// trim($gameValue[0]['Game']['default_net_value']);
			//$updateData['Portfolio']['trades'] =
			// trim($gameValue[0]['Game']['default_trades']);
			$contents = array(
				'net_value' => trim($gameValue[0]['Game']['default_net_value']),
				'trades' => trim($gameValue[0]['Game']['default_trades']),
				'portfolio_id' => $data['portfolio_id']
			);
			if ($this -> Portfolio -> resetPortfolio($contents))
			{
				$body = null;
				$status = TRUE;
				$message = "Portfolio reset Successfully!";
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Portfolio not reset";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token not valid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for adding a particular share to the
	 * portfolio's watchlist of the User as per $data
	 register
	 * 	 */
	function add_watchlist($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$updateData['Watchlist']['user_id'] = trim($data['user_id']);
			$updateData['Watchlist']['share_id'] = trim($data['share_id']);
			$updateData['Watchlist']['portfolio_id'] = trim($data['portfolio_id']);
			$portfolioExists = $this -> Portfolio -> isPortfolioExists($data);
			$isShareIdExists = $this -> Watchlist -> checkShareExists($data);
			if (!empty($portfolioExists))
			{
				if (empty($isShareIdExists))
				{
					if ($this -> Watchlist -> saveWatchlistDatas($data))
					{
						$contents = array(
							'user_id' => trim($data['user_id']),
							'watchlist_id' => $this -> Watchlist -> id,
							'Portfolio_id' => trim($data['portfolio_id']),
							'share_id' => trim($data['share_id'])
						);
						//pr($contents); exit();
						$body = $contents;
						$status = True;
						$message = "Share has been added to the Watch list successfully";
					}
					else
					{
						$body = null;
						$status = FALSE;
						$message = "Share has not been added to the Watch list";
					}
				}
				else
				{
					$body = null;
					$status = FALSE;
					$message = "Share is already in the Watch List";
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Portfolio does not exist for the user";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for displaying the Portfolio's watchlist of
	 * the particular User as per $data
	 */
	function show_watchlist($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			if ($getWatchlist = $this -> Watchlist -> getWatchListDatas($data))
			{
				$body = $getWatchlist;
				$status = True;
				$message = "Success!";
			}
			else
			{
				$body = NULL;
				$status = FALSE;
				$message = "Watchlist does not exist!";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for adding a guest user based on the device
	 * id as per $data
	 */
	function check_guest($data)
	{
		// $this->User->create();
		$isDeviceExists = $this -> User -> checkDeviceExists($data);
		//pr($data); exit();
		if (!($isDeviceExists))
		{
			//pr($data); exit();
			// $this->User->create();
			if ($saveGuestDatas = $this -> User -> saveall($data))
			{
				//pr($data); exit();
				$body = $data;
				$status = TRUE;
				$message = "SUCESS!";
			}
			else
			{
				$body = NULL;
				$status = FALSE;
				$message = "Error! User couldnt be saved";
			}
			$contents = array(
				'user_id' => $this -> User -> id,
				'device_id' => $data['device_id']
			);
			$isUserId = $this -> User -> id;
			$data['access_token'] = md5($data['device_id'] . time());
			$updateData['UserLog']['user_id'] = $isUserId;
			$updateData['UserLog']['access_token'] = $data['access_token'];
			$updateData['UserLog']['device_id'] = trim($data['device_id']);
			if ($this -> UserLog -> saveall($updateData))
			{
				$contents = array(
					'user_id' => $this -> User -> id,
					'device_id' => $data['device_id'],
					'access_token' => $data['access_token'],
				);
				$body = $contents;
				$status = TRUE;
				$message = "SUCESS!";
			}
			else
			{
				$body = NULL;
				$status = TRUE;
				$message = "Error! user log could not be saved";
			}
		}
		else
		{
			$guest = $this -> User -> checkGuestDatas($data);
			$guestAccess = $this -> UserLog -> checkGuestAccess($guest);
			//pr($guestAccess);exit();
			$contents = array(
				'user_id' => $guestAccess['UserLog']['user_id'],
				'device_id' => $guestAccess['UserLog']['device_id'],
				'access_token' => $guestAccess['UserLog']['access_token'],
			);
			$body = $contents;
			$status = TRUE;
			$message = "SUCCESS!";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function register($data)
	{
		$isDeviceExists = $this -> User -> checkDeviceExists($data['device_id']);
		$isRegistered = $this -> User -> isRegistered($data);
		$isNotRegistered = $this -> User -> isNotRegistered($data);
		if (!empty($isNotRegistered))
		{
			$guestData = $this -> User -> checkDeviceExists($data);
			$isEmailUnique = $this -> User -> checkEmailExists($data['email']);
			$isUsernameUnique = $this -> User -> checkUsernameExists($data['username']);
			$message = null;
			if (empty($isEmailUnique) && empty($isUsernameUnique))
			{
				$dataForAutoLogin['password'] = $data['password'];
				$dataForAutoLogin['email'] = $data['email'];
				$dataForAutoLogin['user_id'] = $guestData['User']['id'];
				$dataForAutoLogin['username'] = $data['username'];
				$dataForAutoLogin['device_id'] = null;
				$dataForAutoLogin['job_title'] = $data['job_title'];
				$dataForAutoLogin['password'] = $this -> User -> authPassword($data['password']);
				$dataForAutoLogin['role'] = 'User';
				$dataForAutoLogin['is_registered'] = 'yes';
				if (!empty($data['image']))
				{
					$filename = $data['image']['name'];
					$folder_url = WWW_ROOT . 'files/uploads/';
					$rel_url = 'files/uploads';
					$data['image']['url'] = $rel_url;
					if (!file_exists($folder_url . '/' . $filename))
					{
						// create full filename
						$full_url = $folder_url . '/' . $filename;
						$url = $rel_url . '/' . $filename;
						$data['image']['name'] = $filename;
						// upload the file
						$success = move_uploaded_file($data['image']['tmp_name'], $url);
					}
					else
					{
						// create unique filename and upload file
						ini_set('date.timezone', 'Europe/London');
						$now = date('Y-m-d-His');
						$full_url = $folder_url . '/' . $now . $filename;
						$url = $rel_url . '/' . $now . $filename;
						$data['image']['name'] = $now . $filename;
						$success = move_uploaded_file($data['image']['tmp_name'], $url);
					}
					//echo($data['image']['name']); exit();
					$dataForAutoLogin['image'] = $data['image']['name'];
				}
				else
				{
					$dataForAutoLogin['image'] = "profile_default.jpg";
				}
				if ($this -> User -> updateGuest($dataForAutoLogin))
				{
					$contents = array(
						'email' => $data['email'],
						'user_id' => $this -> User -> id,
						'role' => 'User',
					);
					$contents['password'] = $data['password'];
					$contents['device_id'] = null;
					$contents['username'] = $data['username'];
					$userLoggedData = $this -> __user_login($contents);
					$status = TRUE;
					$finalData = array(
						"user_id" => $contents['user_id'],
						"username" => $data['username'],
						"email" => $contents['email'],
						"job_title" => $data['job_title'],
						"role" => "user",
						"access_token" => $userLoggedData['access_token']
					);
					$game_list = $this -> Game -> displayGametype($finalData);
					$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
					$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
					$body = array(
						'UserData' => $finalData,
						'GameData' => $game_list,
						'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
						'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
					);

					$message = $userLoggedData['message'];
				}
				else
				{
					$message = "Registration failed!";
					$status = FALSE;
					$body = null;
					//$notification = null;
				}
			}
			else
			if (!empty($isUsernameUnique))
			{
				//$notification = null;
				$message = "This username is already in use.";
				$status = FALSE;
				$body = null;
			}
			else
			{
				$message = "This Email Address is already in use.";
				$status = FALSE;
				$body = null;
			}
		}
		else
		{
			$isEmailUnique = $this -> User -> checkEmailExists($data['email']);
			$isUsernameUnique = $this -> User -> checkUsernameExists($data['username']);
			$message = null;
			if (empty($isEmailUnique) && empty($isUsernameUnique))
			{
				$dataForAutoLogin['password'] = $data['password'];
				$dataForAutoLogin['email'] = $data['email'];
				$dataForAutoLogin['username'] = $data['username'];
				$dataForAutoLogin['device_id'] = NULL;
				$dataForAutoLogin['job_title'] = $data['job_title'];
				$dataForAutoLogin['password'] = $this -> User -> authPassword($data['password']);
				$dataForAutoLogin['role'] = 'User';
				$dataForAutoLogin['is_registered'] = 'yes';
				if (!empty($data['image']))
				{
					$filename = $data['image']['name'];
					$folder_url = WWW_ROOT . 'files/uploads/';
					$rel_url = 'files/uploads';
					$data['image']['url'] = $rel_url;
					if (!file_exists($folder_url . '/' . $filename))
					{
						// create full filename
						$full_url = $folder_url . '/' . $filename;
						$url = $rel_url . '/' . $filename;
						$data['image']['name'] = $filename;
						// upload the file
						$success = move_uploaded_file($data['image']['tmp_name'], $url);
					}
					else
					{
						// create unique filename and upload file
						ini_set('date.timezone', 'Europe/London');
						$now = date('Y-m-d-His');
						$full_url = $folder_url . '/' . $now . $filename;
						$url = $rel_url . '/' . $now . $filename;
						$data['image']['name'] = $now . $filename;
						$success = move_uploaded_file($data['image']['tmp_name'], $url);
					}
					//echo($data['image']['name']); exit();
					$dataForAutoLogin['image'] = $data['image']['name'];
				}
				else
				{
					$dataForAutoLogin['image'] = "profile_default.jpg";
				}
				$this -> User -> create();
				if ($this -> User -> save($dataForAutoLogin))
				{
					$contents = array(
						'email' => $data['email'],
						'user_id' => $this -> User -> id,
						'role' => 'User',
					);
					//$this->sendMail('user_register', $data['email'],
					// Configure::read('site.support_email'), 'Thank you for registration with STOX',
					// $contents);
					$contents['password'] = $data['password'];
					$contents['device_id'] = null;
					$contents['username'] = $data['username'];
					$userLoggedData = $this -> __user_login($contents);
					$status = TRUE;
					$finalData = array(
						"user_id" => $contents['user_id'],
						"username" => $data['username'],
						"email" => $contents['email'],
						"job_title" => $data['job_title'],
						"role" => "user",
						"access_token" => $userLoggedData['access_token']
					);
					$game_list = $this -> Game -> displayGametype($finalData);
					$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
					$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
					$body = array(
						'UserData' => $finalData,
						'GameData' => $game_list,
						'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
						'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
					);

					$message = $userLoggedData['message'];
				}
				else
				{
					$message = "Registration failed!";
					$status = FALSE;
					$body = null;
					//$notification = null;
				}
			}
			else
			if (!empty($isUsernameUnique))
			{
				//$notification = null;
				$message = "This username is already in use.";
				$status = FALSE;
				$body = null;
			}
			else
			{
				$message = "This Email Address is already in use.";
				$status = FALSE;
				$body = null;
			}
			//return $result = array('body' => $body, 'status' => $status, 'message' =>
			// $message);
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function forgot_password($data = array())
	{
		$cleanData = trim($data['userdata']);
		$isEmailIsThereOrNot = $this -> User -> checkDataExists($cleanData);
		//$isEmailIsThereOrNot = $this->User->checkDataExists($cleanData);
		$finalData = null;
		if (empty($isEmailIsThereOrNot))
		{
			$message = "The email or username does not exist.";
			$status = FALSE;
		}
		else
		{
			$changePwdToken['change_pwd_token'] = strrev(base64_encode($isEmailIsThereOrNot['User']['id'] . "_" . $isEmailIsThereOrNot['User']['email']));
			$changePwdToken['id'] = $isEmailIsThereOrNot['User']['id'];
			$contents = array(
				'email' => $isEmailIsThereOrNot['User']['email'],
				'url' => Configure::read('site.url') . $changePwdToken['change_pwd_token'],
			);
			if ($this -> User -> updateChangePwdToken($changePwdToken))
			{
				$this -> sendMail('forgot_password', $isEmailIsThereOrNot['User']['email'], Configure::read('site.support_email'), 'Reset your stox password', $contents);
				$message = " An email has been sent to your registered email id.";
				$status = TRUE;
			}
			else
			{
				$finalData = null;
				$message = "Oops!! Something went wrong. Please try again later";
				$status = FALSE;
			}
		}
		return $result = array(
			'body' => $finalData,
			'status' => $status,
			'message' => $message
		);
	}

	function show_bankdata($data)
	{
		//pr($data);exit();
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			if ($bankData = $this -> Bank -> getBankDatas($data))
			{
				//$result = Set::classicExtract($game, '{n}');
				$body = Set::classicExtract($bankData, '{n}.BankData');
				$status = True;
				$message = "Success!";
			}
			else
			{
				$body = null;
				$status = False;
				$message = "Error! Data can not be displayed";
			}
			if ($content = $this -> Game -> listOfPremiumGames($data))
			{
				$body = $content;
				$status = TRUE;
				$message = "Game List";
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Failed! Game List could not be shown";
			}
			$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
			//pr($totalTradeValue); exit();
			$totalCashValue = $this -> Portfolio -> getTotalCash($data);
			$portContents = array(
				'total_trades' => $totalTradeValue['Portfolio']['total_trades'],
				'total_cash' => $totalCashValue['Portfolio']['total_cash']
			);
			//pr($contents); exit();

			$status = True;
			$message = "Success!";
			$contents = array(
				'BankData' => $bankData,
				//	'PremiumGameData' => $content,
				'TradeCashData' => $portContents
			);
			$body = $contents;
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function change_password($data = array())
	{
		$notification = $message = null;
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$data['current_password'] = $this -> User -> authPassword($data['current_password']);
			$data['password'] = $this -> User -> authPassword($data['password']);
			$isPasswordMatch = $this -> User -> checkPasswordMatch($data['user_id'], $data['current_password']);
			if ($isPasswordMatch)
			{
				//$notification = $this->notification($data);
				$userPassword = $this -> User -> updateUserPassword($data);
				if ($userPassword)
				{
					$body = '';
					$status = True;
					$message = "Password has been changed successfully!";
				}
				else
				{
					$body = null;
					$status = FALSE;
					$message = "Password change failed!";
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Password mismatch!";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Invalid Current Password!!!";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function sendMail($template = null, $to_email = null, $from_email = null, $subject = null, $contents = array())
	{
		$from_email = Configure::read('site.support_email');
		$email = new CakeEmail();
		$result = $email -> template($template, 'default') -> emailFormat('html') -> to($to_email) -> from($from_email) -> subject($subject) -> viewVars($contents);
		if ($email -> send('default'))
		{
			return true;
		}
		return false;
	}

	/**
	 * Register method for Web/Mobile
	 *
	 * @return data
	 */
	function __user_login($data = array())
	{
		$finalData = null;
		$this -> request -> data['User']['email'] = trim($data['email']);
		$this -> request -> data['User']['password'] = trim($data['password']);
		if ($this -> Auth -> login($this -> request -> data['User']))
		{
			$finalData = $this -> Auth -> User();

			if (is_array($finalData))
			{
				//$access_token = md5($this->Auth->User('id') . time());
				$data['access_token'] = md5($this -> Auth -> User('id') . time());
				$data['status'] = 'LoggedIn';
				//$data['device_id']=null;
				//$updateData['User']['id'] = $this -> Auth -> User('id');
				//$updateData['User']['device_id'] = trim($data['device_id']);
				//$updateData['UserLog']['user_id'] = $this -> Auth -> User('id');
				//$updateData['UserLog']['access_token'] = $data['access_token'];
				//$updateData['UserLog']['device_id'] = null;

				if ($this -> UserLog -> saveLoginDatas($data))
				{
					$finalData['access_token'] = $data['access_token'];
					unset($finalData['password']);

				}
			}
		}
		return array(
			"access_token" => $data['access_token'],
			"message" => "Logged in Successfully"
		);
		//return array("message" => "SUCCESS!");
	}

	/*
	 * Method to get the share data page wise
	 */
	function get_share_data($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$current_page_no = $data['page_no'];
			if ($current_page_no > 0)
			{
				$no_of_records = $data['no_of_records'];
				$start_offset = ($current_page_no * $no_of_records) - $no_of_records;
				$search = $data['search'];
				$share_data = array();
				$share_data = $this -> Share -> fetchData($start_offset, $no_of_records, $search);
				$result = Set::classicExtract($share_data, '{n}.Share');
				if ($share_data)
				{
					$share_data = $result;
					$status = True;
					$message = "Share Data";
				}
				else
				{
					$share_data = null;
					$status = False;
					$message = "Error!!!";
				}
			}
			else
			{
				$share_data = null;
				$status = False;
				$message = "Page number should not be 0 or less";
			}
		}
		else
		{
			$share_data = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(

			'body' => $share_data,
			'status' => $status,
			'message' => $message
		);
	}

	//----------------------------------
	function guestRegister($data = array())
	{
		//echo($data['email']); exit();
		$isEmailUnique = $this -> User -> checkEmailExists($data['email']);
		$isUsernameUnique = $this -> User -> checkUsernameExists($data['username']);
		//	$isFacebookUserUnique =
		// $this->User->checkFacebookUserExists($data['facebook_id']);
		//$notification = null;
		$message = null;
		if (empty($isEmailUnique) && empty($isUsernameUnique))
		{
			$dataForAutoLogin['password'] = $data['password'];
			$dataForAutoLogin['email'] = $data['email'];
			$dataForAutoLogin['username'] = $data['username'];
			$dataForAutoLogin['device_id'] = $data['device_id'];
			$dataForAutoLogin['job_title'] = $data['job_title'];
			$dataForAutoLogin['password'] = $this -> User -> authPassword($data['password']);
			$dataForAutoLogin['role'] = 'User';
			if (!empty($data['image']))
			{
				$filename = $data['image']['name'];
				$folder_url = WWW_ROOT . 'files/uploads/';
				$rel_url = 'files/uploads';
				$data['image']['url'] = $rel_url;
				if (!file_exists($folder_url . '/' . $filename))
				{
					// create full filename
					$full_url = $folder_url . '/' . $filename;
					$url = $rel_url . '/' . $filename;
					$data['image']['name'] = $filename;
					// upload the file
					$success = move_uploaded_file($data['image']['tmp_name'], $url);
				}
				else
				{
					// create unique filename and upload file
					ini_set('date.timezone', 'Europe/London');
					$now = date('Y-m-d-His');
					$full_url = $folder_url . '/' . $now . $filename;
					$url = $rel_url . '/' . $now . $filename;
					$data['image']['name'] = $now . $filename;
					$success = move_uploaded_file($data['image']['tmp_name'], $url);
				}
				//echo($data['image']['name']); exit();
				$dataForAutoLogin['image'] = $data['image']['name'];
			}
			else
			{
				$dataForAutoLogin['image'] = "profile_default.jpg";
			}
			$this -> User -> create();
			if ($this -> User -> save($dataForAutoLogin))
			{
				$contents = array(
					'email' => $data['email'],
					'user_id' => $this -> User -> id,
					'role' => 'User',
				);
				//$this->sendMail('user_register', $data['email'],
				// Configure::read('site.support_email'), 'Thank you for registration with STOX',
				// $contents);
				$contents['password'] = $data['password'];
				$contents['device_id'] = $data['device_id'];
				$contents['username'] = $data['username'];
				$userLoggedData = $this -> __user_login($contents);
				$status = TRUE;
				$body = array(
					"user_id" => $contents['user_id'],
					"username" => $data['username'],
					"email" => $contents['email'],
					"job_title" => $data['job_title'],
					"role" => "user",
					"access_token" => $userLoggedData['access_token']
				);
				$message = $userLoggedData['message'];
			}
			else
			{
				$message = "Registration failed!";
				$status = FALSE;
				$body = null;
				//$notification = null;
			}
		}
		else
		if (!empty($isUsernameUnique))
		{
			//$notification = null;
			$message = "This username is already in use.";
			$status = FALSE;
			$body = null;
		}
		else
		{
			$message = "This Email Address is already in use.";
			$status = FALSE;
			$body = null;
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	//----------------------------------
	function upload_image($data)
	{
		if (!empty($data['image']['name']))
		{
			if ($this -> UserLog -> checkAccessTokenValid($data))
			{
				$filename = $_FILES['image']['name'];
				$folder_url = WWW_ROOT . 'files/uploads';
				$rel_url = 'files/uploads';
				$_FILES['image']['url'] = $rel_url;
				if (!file_exists($folder_url . '/' . $filename))
				{
					// create full filename
					$full_url = $folder_url . '/' . $filename;
					$url = $rel_url . '/' . $filename;
					$data['image']['name'] = $filename;
					//pr($full_url); exit();
					// upload the file
					$success = move_uploaded_file($data['image']['tmp_name'], $full_url);
					//pr($success); exit();
				}
				else
				{
					$full_url = $folder_url . '/' . $filename . $data['user_id'];
					$url = $rel_url . '/' . $filename . $data['user_id'];
					$data['image']['name'] = $filename . $data['user_id'];
					$success = move_uploaded_file($data['image']['tmp_name'], $url);
					//pr($success); exit();
				}
				// if upload was successful
				if ($success)
				{
					$result = $this -> User -> updateImage($data);
					$body = $result;
					$status = False;
					$message = "Image has been updated successfully!!!";
				}
				else
				{
					$body = null;
					$status = False;
					$message = "Failed!! Image not updated";
				}
				//-----------------}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Access token invalid";
			}
		}
		else
		{
			$data['image']['name'] = 'profile_default.jpg';
			$result = $this -> User -> updateImage($data);
			$body = $result;
			$status = False;
			$message = "Empty Image!! Default image has been set.";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for buying cash/trade
	 */
	function buy_cash_trade($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$data['price'] = $data['price_paid'];
			$transaction = $this -> Transaction -> saveTransactionData($data);
			if ($transaction)
			{
				$body = $transaction;
				$status = True;
				$message = "Data has been saved successfully";
			}
			else
			{
				$status = False;
				$message = "Data has not been saved";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Invalid access token";

		}

		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function social_login($data = array())
	{
		$isEmailUnique = $this -> User -> checkEmailExists($data['email']);
		$isUsernameUnique = $data['firstname'] . $data['facebook_id'];
		$isFacebookUserUnique = $this -> User -> checkFacebookUserExists($data['facebook_id']);
		if (empty($isFacebookUserUnique) && empty($isEmailUnique) && empty($isUserNameUnique))
		{
			$body = null;
			$status = TRUE;
			$dataPassword['password'] = $data['facebook_id'];
			$dataForAutoLogin['password'] = $this -> User -> authPassword($dataPassword['password']);
			$dataForAutoLogin['email'] = $data['email'];
			$dataForAutoLogin['username'] = $data['firstname'] . $data['facebook_id'];
			$dataForAutoLogin['device_id'] = NULL;
			$dataForAutoLogin['image'] = $data['image_link'];
			$dataForAutoLogin['facebook_id'] = $data['facebook_id'];
			$dataForAutoLogin['is_registered'] = 'yes';
			$dataForAutoLogin['role'] = 'User';

			$data['role'] = 'User';
			$this -> User -> create();
			if ($this -> User -> save($dataForAutoLogin))
			{
				$contents = array(
					'email' => $data['email'],
					'user_id' => $this -> User -> id,
					'role' => 'User',
				);

				$contents['password'] = $dataForAutoLogin['password'];
				$contents['device_id'] = NULL;
				$contents['username'] = $dataForAutoLogin['username'];

				$userLoggedData = $this -> __user_login($contents);
				$status = TRUE;
				$finalData = array(
					"user_id" => $contents['user_id'],
					"username" => $contents['username'],
					"email" => $contents['email'],
					"role" => "user",
					"access_token" => $userLoggedData['access_token']
				);
				$game_list = $this -> Game -> displayGametype($finalData);
				$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
				$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
				$body = array(
					'UserData' => $finalData,
					'GameData' => $game_list,
					'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
					'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
				);
				$message = $userLoggedData['message'];
			}
			else
			{
				$message = "ERROR: FB Registration failed!";
				$status = FALSE;
				$body = null;
				//$notification = null;
			}
			return $result = array(
				'body' => $body,
				'status' => $status,
				'message' => $message
			);
		}
		else
		if (!empty($isFacebookUserUnique) && empty($isEmailUnique))
		{
			$finalData = null;
			$body = null;
			$status = FALSE;
			return array(
				'body' => $body,
				'status' => $status,
				"access_token" => $finalData['access_token'],
				"message" => "Error!! Your registered Facebook Email Id has been changed!"
			);
		}
		else
		if (empty($isFacebookUserUnique) && !empty($isEmailUnique))
		{
			$finalData = null;
			$body = null;
			$status = FALSE;
			return array(
				'body' => $body,
				'status' => $status,
				"access_token" => $finalData['access_token'],
				"message" => "Error!! Your EmailId is already registered, Login with your EmailId/Password!"
			);
		}
		else
		{
			$finalData = null;
			$body = null;
			$status = TRUE;
			$data['password'] = $this -> User -> authPassword($data['facebook_id']);
			$isAuthenticatedUser = $this -> User -> checkAndLogin($data);
			$this -> request -> data['User']['email'] = trim($data['email']);
			$this -> request -> data['User']['password'] = trim($data['password']);
			//pr($data); exit();
			if ($this -> Auth -> login($this -> request -> data['User']))
			{
				$finalData = $this -> Auth -> User();
				if (is_array($finalData))
				{
					$access_token = md5($this -> Auth -> User('id') . time());
					$updateData['User']['id'] = $this -> Auth -> User('id');
					$updateData['User']['device_id'] = NULL;

					//$updateData['User']['email'] = trim($data['email']);
					$updateData['User']['facebook_id'] = trim($data['facebook_id']);
					$updateData['User']['image'] = trim($data['image_link']);
					$updateData['UserLog']['user_id'] = $this -> Auth -> User('id');
					$updateData['UserLog']['access_token'] = $access_token;
					$updateData['UserLog']['device_id'] = NULL;

					$userId = $this -> User -> getSocialUserId($data);
					//$portfolioCount = $this -> Portfolio -> totalPortfolioCount($userId);
					$userLogData['user_id'] = $userId['User']['id'];
					$userLogData['status'] = 'LoggedIn';
					$userLogData['access_token'] = $access_token;
					$userSaveLog = $this -> UserLog -> saveLoginDatas($userLogData);
					$finalData = array(
						//"user_id" => $this -> User -> id,
						"user_id" => $userId['User']['id'],
						"email" => $data['email'],
						"role" => "user",
						"access_token" => $updateData['UserLog']['access_token'],
					);

					$game_list = $this -> Game -> displayGametype($finalData);
					$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
					$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
					$body = array(
						'UserData' => $finalData,
						'GameData' => $game_list,
						'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
						'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
					);
				}

			}

			return array(
				'body' => $body,
				'status' => $status,
				"message" => "Logged in Successfully"
			);
		}
	}

	function buying_stocks($data)
	{
		date_default_timezone_set('US/Eastern');
		date_default_timezone_get();
		$currenttime = date('h:i:s');
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$currenttime = 9;
			if (($currenttime >= 9 && $currenttime <= 18))
			{
				$isStatusPending = $this -> UserStock -> isStatusPending($data);
				$isStatusBuy = $this -> UserStock -> isStatusBuy($data);
				$getNetValue = $this -> Portfolio -> getNetValue($data);
				$getTradeValue = $this -> Portfolio -> getTradeValue($data);
				$DefaultNetValue = $getNetValue['Portfolio']['net_value'];
				$DefaultTradeValue = $getTradeValue['Portfolio']['trades'];
				if (!empty($isStatusPending))
				{
					$checkPending = $this -> UserStock -> pendingSum($data);
					$PendingSum = $checkPending['UserStock']['sum'];
					$DefaultNetValue = $DefaultNetValue - $PendingSum;
				}
				if ($getTradeValue['Portfolio']['trades'] > 0)
				{
					if ($DefaultNetValue > $data['total_amount'])
					{
						$currentValue = $DefaultNetValue - $data['total_amount'];

						$getShareQuantity = $this -> Portfolio -> getShareQuantity($data);
						$data['previous_net_value'] = $getNetValue[0]['Portfolio']['net_value'];
						$data['default_net_value'] = $currentValue;
						if ($this -> Portfolio -> updatePortfolioDefaultValue($data))
						{
							$message = "SUCCESS! Portfolio Default value Updated";
							$body = NULL;
							$status = TRUE;
						}
						else
						{
							$message = "ERROR! Could not be Updated";
							$body = NULL;
							$status = FALSE;
						}
						$dataStox['user_id'] = $data['user_id'];
						$dataStox['share_id'] = $data['share_id'];
						$dataStox['portfolio_id'] = $data['portfolio_id'];
						$dataStox['status'] = 'buy';
						$dataStox['quantity'] = $data['quantity'];
						$dataStox['total_amount'] = $data['total_amount'];
						$this -> UserStock -> create();
						if ($this -> UserStock -> saveBuyStox($dataStox))
						{
							$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
							$totalCashValue = $this -> Portfolio -> getTotalCash($data);
							$portContents = array(
								$totalTradeValue,
								$totalCashValue
							);
							$contents = array(
								'id' => $this -> Portfolio -> id,
								'user_id' => $data['user_id'],
								'access_token' => $data['access_token'],
								'total_trades' => $totalTradeValue[0]['Portfolio']['total_trades'],
								'total_cash' => $totalCashValue[0]['Portfolio']['total_cash']
							);
							$data['tradeValue'] = $getTradeValue['Portfolio']['trades'] - 1;
							if ($this -> Portfolio -> updateTrades($data))
							{
								$message = "Trade value has been updated";
								$body = NULL;
								$status = TRUE;
							}
							else
							{
								$message = "ERROR!:Trade value has not been updated";
								$body = NULL;
								$status = TRUE;
							}
							$message = "SUCCESS! Buy STOX updated";
							$body = $contents;
							$status = TRUE;
						}
						else
						{
							$message = "ERROR! STOX not updated";
							$body = NULL;
							$status = FALSE;
						}
					}
					else
					{
						$message = "Failed! You do not have enough net value to buy!";
						$body = NULL;
						$status = FALSE;
					}
				}
				else
				{
					$message = "Failed! You do not have enough trades to buy!";
					$body = NULL;
					$status = FALSE;
				}
			}
			//---------------------
			else
			{
				$dataStox['user_id'] = $data['user_id'];
				$dataStox['share_id'] = $data['share_id'];
				$dataStox['portfolio_id'] = $data['portfolio_id'];
				$dataStox['is_pending'] = 'yes';
				$dataStox['quantity'] = $data['quantity'];
				$dataStox['total_amount'] = $data['total_amount'];
				$this -> UserStock -> create();
				if ($this -> UserStock -> saveBuyStox($dataStox))
				{
					$message = "SUCCESS! Pending STOX updated";
					$body = NULL;
					$status = TRUE;
				}
				else
				{
					$message = "ERROR! Pending STOX not updated";
					$body = NULL;
					$status = FALSE;
				}
				$message = "Markets are closed now!";
				$body = NULL;
				$status = FALSE;
			}
		}
		else
		{
			$message = "Access Token Invalid!";
			$body = NULL;
			$status = FALSE;
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function buying_stocks_trial($data)
	{
		date_default_timezone_set('US/Eastern');
		date_default_timezone_get();
		$currenttime = date('h:i:s');
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$currenttime = 9;
			if (($currenttime >= 9 && $currenttime <= 18))
			{
				$isStatusPending = $this -> UserStock -> isStatusPending($data);
				$isStatusBuy = $this -> UserStock -> isStatusBuy($data);
				$getNetValue = $this -> Portfolio -> getNetValue($data);
				$getTradeValue = $this -> Portfolio -> getTradeValue($data);
				$DefaultNetValue = $getNetValue['Portfolio']['net_value'];
				$DefaultTradeValue = $getTradeValue['Portfolio']['trades'];
				if (!empty($isStatusPending))
				{
					$checkPending = $this -> UserStock -> pendingSum($data);
					$PendingSum = $checkPending['UserStock']['sum'];
					$DefaultNetValue = $DefaultNetValue - $PendingSum;
				}
				if ($getTradeValue['Portfolio']['trades'] > 0)
				{
					if ($DefaultNetValue > $data['total_amount'])
					{
						$currentValue = $DefaultNetValue - $data['total_amount'];
						$getShareQuantity = $this -> Portfolio -> getShareQuantity($data);
						$data['previous_net_value'] = $getNetValue['Portfolio']['net_value'];
						$data['default_net_value'] = $currentValue;
						if ($this -> Portfolio -> updatePortfolioDefaultValue($data))
						{

							$message = "SUCCESS! Portfolio Default value Updated";
							$body = NULL;
							$status = TRUE;
						}
						else
						{
							$message = "ERROR! Could not be Updated";
							$body = NULL;
							$status = FALSE;
						}
						$updateTotalAmount = $this -> UserStock -> updateTotalAmount($data);
						$dataStox['user_id'] = $data['user_id'];
						$dataStox['share_id'] = $data['share_id'];
						$dataStox['portfolio_id'] = $data['portfolio_id'];
						$dataStox['status'] = 'buy';
						$dataStox['quantity'] = $data['quantity'];
						$dataStox['total_amount'] = $data['total_amount'];
						$this -> UserStock -> create();
						if ($this -> UserStock -> saveBuyStox($dataStox))
						{
							$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
							$totalCashValue = $this -> Portfolio -> getTotalCash($data);
							$portContents = array(
								$totalTradeValue,
								$totalCashValue
							);
							$contents = array(
								'id' => $this -> Portfolio -> id,
								'user_id' => $data['user_id'],
								'access_token' => $data['access_token'],
								'total_trades' => $totalTradeValue[0]['Portfolio']['total_trades'],
								'total_cash' => $totalCashValue[0]['Portfolio']['total_cash']
							);
							$data['tradeValue'] = $getTradeValue['Portfolio']['trades'] - 1;
							if ($this -> Portfolio -> updateTrades($data))
							{
								$message = "Trade value has been updated";
								$body = NULL;
								$status = TRUE;
							}
							else
							{
								$message = "ERROR!:Trade value has not been updated";
								$body = NULL;
								$status = TRUE;
							}
							$message = "SUCCESS! Buy STOX updated";
							$body = $contents;
							$status = TRUE;
						}
						else
						{
							$message = "ERROR! STOX not updated";
							$body = NULL;
							$status = FALSE;
						}
					}
					else
					{
						$message = "Failed! You do not have enough net value to buy!";
						$body = NULL;
						$status = FALSE;
					}
				}
				else
				{
					$message = "Failed! You do not have enough trades to buy!";
					$body = NULL;
					$status = FALSE;
				}
			}
			//---------------------
			else
			{
				$dataStox['user_id'] = $data['user_id'];
				$dataStox['share_id'] = $data['share_id'];
				$dataStox['portfolio_id'] = $data['portfolio_id'];
				$dataStox['is_pending'] = 'yes';
				$dataStox['quantity'] = $data['quantity'];
				$dataStox['total_amount'] = $data['total_amount'];
				$this -> UserStock -> create();
				if ($this -> UserStock -> saveBuyStox($dataStox))
				{
					$message = "SUCCESS! Pending STOX updated";
					$body = NULL;
					$status = TRUE;
				}
				else
				{
					$message = "ERROR! Pending STOX not updated";
					$body = NULL;
					$status = FALSE;
				}
				$message = "Markets are closed now!";
				$body = NULL;
				$status = FALSE;
			}
		}
		else
		{
			$message = "Access Token Invalid!";
			$body = NULL;
			$status = FALSE;
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function sell_stocks($data)
	{
		date_default_timezone_set('US/Eastern');
		date_default_timezone_get();
		$currenttime = date('h:i:s');
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$currenttime = 9;
			if (($currenttime >= 9 && $currenttime <= 18))
			{
				$isStatusPending = $this -> UserStock -> isStatusPending($data);
				$isStatusBuy = $this -> UserStock -> isStatusBuy($data);
				//pr($data);exit();
				$getNetValue = $this -> Portfolio -> getNetValue($data);
				$DefaultNetValue = $getNetValue[0]['Portfolio']['net_value'];
				//pr($DefaultNetValue);exit();
				$currentValue = $DefaultNetValue + $data['total_amount'];
				$data['previous_net_value'] = $getNetValue[0]['Portfolio']['net_value'];
				$data['default_net_value'] = $currentValue;
				if ($this -> Portfolio -> updatePortfolioDefaultValue($data))
				{
					$message = "SUCCESS! Portfolio Default value Updated";
					$body = NULL;
					$status = TRUE;
				}
				else
				{
					$message = "ERROR!Portfolio Default value couldnt Update";
					$body = NULL;
					$status = FALSE;
				}
				$dataStox['user_id'] = $data['user_id'];
				$dataStox['share_id'] = $data['share_id'];
				$dataStox['portfolio_id'] = $data['portfolio_id'];
				$dataStox['status'] = 'sell';
				$dataStox['quantity'] = $data['quantity'];
				$dataStox['total_amount'] = $data['total_amount'];
				$this -> UserStock -> create();
				if ($this -> UserStock -> saveBuyStox($dataStox))
				{
					$message = "SUCCESS! Sell STOX updated";
					$body = NULL;
					$status = TRUE;
					//pr($CurrentNetValue);echo 'here';exit();
				}
				else
				{
					$message = "ERROR! Sell STOX not updated";
					$body = NULL;
					$status = FALSE;
				}
			}
			//---------------------
			else
			{
				$dataStox['user_id'] = $data['user_id'];
				$dataStox['share_id'] = $data['share_id'];
				$dataStox['portfolio_id'] = $data['portfolio_id'];
				$dataStox['is_pending'] = 'yes';
				$dataStox['quantity'] = $data['quantity'];
				$dataStox['total_amount'] = $data['total_amount'];
				$this -> UserStock -> create();
				if ($this -> UserStock -> saveBuyStox($dataStox))
				{
					$message = "SUCCESS! Pending STOX updated";
					$body = NULL;
					$status = TRUE;
					//pr($CurrentNetValue);echo 'here';exit();
				}
				else
				{
					$message = "ERROR! Pending STOX not updated";
					$body = NULL;
					$status = FALSE;
				}
				$message = "Markets are closed now!";
				$body = NULL;
				$status = FALSE;
			}
		}
		else
		{
			$message = "Access Token Invalid!";
			$body = NULL;
			$status = FALSE;
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is send the list of purchased stock for a portfolio
	 */
	function user_stocks($data)
	{
		$body = null;
		if (!empty($data))
		{
			if ($this -> UserLog -> checkAccessTokenValid($data))
			{
				$stock_list = $this -> UserStock -> findPurchasedStocksList($data);
				if (count($stock_list) > 0)
				{
					$body = $stock_list;
					$status = True;
					$message = "Successfully fetched";
				}
				elseif (count($stock_list) == 0)
				{
					$body = $stock_list;
					$status = True;
					$message = "No Share Available";
				}
				else
				{
					$status = False;
					$message = "Error";
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Invalid access token";
			}
		}
		else
		{
			$status = False;
			$message = "No param passed";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is send the list of sold stock for a portfolio
	 */
	function stock_history($data)
	{
		$body = null;
		if (!empty($data))
		{
			if ($this -> UserLog -> checkAccessTokenValid($data))
			{
				$stock_list = $this -> UserStock -> findStockHistoryList($data);
				if (count($stock_list) > 0)
				{
					$body = $stock_list;
					$status = True;
					$message = "Success";
				}
				else
				if (count($stock_list) == 0)
				{
					$body = $stock_list;
					$status = True;
					$message = "No data";
				}
				else
				{
					$status = False;
					$message = "Error";
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Invalid access token";
			}
		}
		else
		{
			$status = False;
			$message = "No param passed";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is send the list of pending stock for a portfolio
	 */
	function pending_stocks($data)
	{
		$body = null;
		if (!empty($data))
		{
			if ($this -> UserLog -> checkAccessTokenValid($data))
			{
				$stock_list = $this -> UserStock -> findPendingStocksList($data);
				if (count($stock_list) > 0)
				{
					$body = $stock_list;
					$status = True;
					$message = "Success";
				}
				else
				if (count($stock_list) == 0)
				{
					$body = $stock_list;
					$status = True;
					$message = "No data";
				}
				else
				{
					$status = False;
					$message = "Error";
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "Invalid access token";
			}
		}
		else
		{
			$status = False;
			$message = "No param passed";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to send FAQ data
	 */
	function faq_data($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$faqData = $this -> Faq -> getFaqDatas();
			if ($faqData)
			{
				$body = $faqData;
				$status = True;
				$message = "Success!";
			}
			else
			{
				$body = null;
				$status = False;
				$message = "Error!";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save feedback form data
	 */
	function feedback_data($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$feedbackData = $this -> Feedback -> saveFeedbackData($data);
			if ($feedbackData)
			{
				$body = null;
				$status = True;
				$message = "Success!";
			}
			else
			{
				$body = null;
				$status = False;
				$message = "Error!";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save contact us form data
	 */
	function contactus_data($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$contactUsData = $this -> Contact -> saveContactUsData($data);
			if ($contactUsData)
			{
				$body = null;
				$status = True;
				$message = "Success!";
			}
			else
			{
				$body = null;
				$status = False;
				$message = "Error!";
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	function install($data)
	{
		//pr($data); exit();
		// $this->User->create();
		$isDeviceExists = $this -> User -> checkDeviceExists($data);
		//pr($isDeviceExists); exit();
		if (!empty($isDeviceExists))
		{
			//pr($data); exit();pr($id); exit();
			$id = $this -> User -> getUserId($data);
			// pr($id); exit();
			if ($deleteGuestDatas = $this -> User -> delete($id['User']['id'], true))
			{
				//pr($data); exit();
				$contents = array(
					'device_id' => $data['device_id'],
					'user_id' => $id['User']['id'],
				);
				$body = $contents;
				$status = TRUE;
				$message = "SUCESS! Guest user has been deleted";
				//Pr($message);exit();
			}
			else
			{
				$body = NULL;
				$status = FALSE;
				$message = "Error! Guest User couldnt be deleted";
			}
			if ($saveGuestDatas = $this -> User -> saveall($data))
			{
				//pr($data); exit();
				$body = $data;
				$status = TRUE;
				$message = "SUCESS!";
			}
			else
			{
				$body = NULL;
				$status = FALSE;
				$message = "Error! User couldnt be saved";
			}
			$contents = array(
				'user_id' => $this -> User -> id,
				'device_id' => $data['device_id']
			);
			$isUserId = $this -> User -> id;
			$data['access_token'] = md5($data['device_id'] . time());
			$updateData['UserLog']['user_id'] = $isUserId;
			$updateData['UserLog']['access_token'] = $data['access_token'];
			$updateData['UserLog']['device_id'] = trim($data['device_id']);
			if ($this -> UserLog -> saveall($updateData))
			{
				$contents = array(
					'user_id' => $this -> User -> id,
					'device_id' => $data['device_id'],
					'access_token' => $data['access_token'],
				);
				$body = $contents;
				$status = TRUE;
				$message = "SUCESS!";
			}
			else
			{
				$body = NULL;
				$status = TRUE;
				$message = "Error! user log could not be saved";
			}
		}
		else
		{
			if ($saveGuestDatas = $this -> User -> saveall($data))
			{
				//pr($data); exit();
				$body = $data;
				$status = TRUE;
				$message = "SUCESS!";
			}
			else
			{
				$body = NULL;
				$status = FALSE;
				$message = "Error! User couldnt be saved";
			}
			$contents = array(
				'user_id' => $this -> User -> id,
				'device_id' => $data['device_id']
			);
			$isUserId = $this -> User -> id;
			$data['access_token'] = md5($data['device_id'] . time());
			$updateData['UserLog']['user_id'] = $isUserId;
			$updateData['UserLog']['access_token'] = $data['access_token'];
			$updateData['UserLog']['device_id'] = trim($data['device_id']);
			if ($this -> UserLog -> saveall($updateData))
			{
				$contents = array(
					'user_id' => $this -> User -> id,
					'device_id' => $data['device_id'],
					'access_token' => $data['access_token'],
				);
				$body = $contents;
				$status = TRUE;
				$message = "SUCESS!";
			}
			else
			{
				$body = NULL;
				$status = TRUE;
				$message = "Error! user log could not be saved";
			}
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to remove a share from watch list
	 */
	function remove_from_watchlist($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$recordId = $data['watchlist_id'];
			if ($deleteWatchlist = $this -> Watchlist -> delete($data['watchlist_id']))
			{
				$body = NULL;
				$status = TRUE;
				$message = "SUCCESS! removed successfully";
				//Pr($message);exit();
			}
			/*$has_deleted = $this -> Watchlist -> deleteRecord($recordId);
			 if ($has_deleted)
			 {
			 $body = null;
			 $status = True;
			 $message = "Removed succesfully";
			 }*/
			else
			{
				$body = null;
				$status = False;
				$message = "Error!";
			}
		}
		else
		{
			$body = null;
			$status = False;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for sending friends leader board data
	 */
	function friend_leaderboard($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$data['facebook_friends'][] = $data['email'];
			$facebook_friends = $data['facebook_friends'];

			$registered_users = $this -> User -> listRegisteredUsers();
			$users_friends = array();
			$users_friends = array_intersect($registered_users, $facebook_friends);

			if ($users_friends)
			{
				$users_friends = array_keys($users_friends);

				$portfolios = $this -> User -> leaderPortfolios($users_friends, $data['game_id']);

				$portfolios_max_net_amount = array();
				$i = 0;
				$leaderBoard = array();
				$userData = array();
				if ($portfolios)
				{
					foreach ($portfolios as $key => $val)
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
							$portfolios_max_net_amount['portfolio_name'] = $val['Portfolio'][$key]['po
							rtfolio_name'];
							$portfolios_max_net_amount['total_net_value'] = $sortedData[$key];
							$leaderBoard[] = array('data' => $portfolios_max_net_amount);
							$i++;

							if ($val['User']['email'] == $data['email'])
							{
								$userData = array('data' => $portfolios_max_net_amount);
							}
						}
					}

					if (!empty($leaderBoard))
					{
						//sorting the result as per the total_net_value
						function totalNetValueDescSort($item1, $item2)
						{
							if ($item1['data']['total_net_value'] == $item2['data']['total_net_value'])
								return 0;
							return ($item1['data']['total_net_value'] < $item2['data']['total_net_value']) ? 1 : -1;
						}

						usort($leaderBoard, 'totalNetValueDescSort');

						$isPresent = in_array($userData, $leaderBoard);
						if ($isPresent)
						{
							$key = array_search($userData, $leaderBoard);
							$userData['data']['rank'] = $key + 1;
						}
						else
						{
							$userData = array();
							$userData = $this -> User -> highestNetAmountPortfolio($data['user_id'], $data['game_id']);
							//pr($userData); exit;
							if ($userData)
							{
								$rand = rand(1, 200);
								$userData['data']['rank'] = 300 + $rand;
							}
							else
							{

								$userData['data'] = "No data";
							}
						}

						//get record of 15 users
						$leaderBoard = array_slice($leaderBoard, 0, 15);

						$body = array(
							'leaderBoard' => $leaderBoard,
							'userRank' => $userData
						);
						$status = True;
						$message = "Success";
					}
					else
					{
						$body = null;
						$status = False;
						$message = "No Data";
					}

				}
				else
				{

					$body = null;
					$status = False;
					$message = "No Data";
				}

			}
			else
			{
				$body = null;
				$status = False;
				$message = "No Data";
			}

		}
		else
		{
			$body = null;
			$status = False;
			$message = "Access token invalid";

		}

		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);

	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for sending global (all users) leader board data
	 */
	function global_leaderboard($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{

			$registered_users = $this -> User -> listRegisteredUsers();

			if ($registered_users)
			{
				$registered_users = array_keys($registered_users);

				$portfolios = $this -> User -> leaderPortfolios($registered_users, $data['game_id']);

				$portfolios_max_net_amount = array();
				$i = 0;
				$leaderBoard = array();
				$userData = array();
				if ($portfolios)
				{
					foreach ($portfolios as $key => $val)
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
							$leaderBoard[] = array('data' => $portfolios_max_net_amount);
							$i++;

							if ($val['User']['email'] == $data['email'])
							{
								$userData = array('data' => $portfolios_max_net_amount);
							}
						}
					}

					if (!empty($leaderBoard))
					{
						//sorting the result as per the total_net_value
						function totalNetValueDescSort($item1, $item2)
						{
							if ($item1['data']['total_net_value'] == $item2['data']['total_net_value'])
								return 0;
							return ($item1['data']['total_net_value'] < $item2['data']['total_net_value']) ? 1 : -1;
						}

						usort($leaderBoard, 'totalNetValueDescSort');

						$isPresent = in_array($userData, $leaderBoard);
						if ($isPresent)
						{
							$key = array_search($userData, $leaderBoard);
							$userData['data']['rank'] = $key + 1;
						}
						else
						{
							$userData = array();
							$userData = $this -> User -> highestNetAmountPortfolio($data['user_id'], $data['game_id']);
							//pr($userData); exit;
							if ($userData)
							{
								$rand = rand(1, 200);
								$userData['data']['rank'] = 300 + $rand;
							}
							else
							{

								$userData['data'] = "No data";
							}
						}

						//get record of 15 users
						$leaderBoard = array_slice($leaderBoard, 0, 15);

						$body = array(
							'leaderBoard' => $leaderBoard,
							'userRank' => $userData
						);
						$status = True;
						$message = "Success";
					}
					else
					{
						$body = null;
						$status = False;
						$message = "No Data";
					}

				}
				else
				{

					$body = null;
					$status = False;
					$message = "No Data";
				}

			}
			else
			{
				$body = null;
				$status = False;
				$message = "No Data";
			}

		}
		else
		{
			$body = null;
			$status = False;
			$message = "Access token invalid";

		}

		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);

	}

	function portfolio_detail($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$getIndividualPortfolioValue = $this -> Portfolio -> getIndividualPortfolioValue($data);
			$getIndividualSumPortfolioAmount = $this -> UserStock -> getIndividualSumPortfolioAmount($data);
			$userTotalAmount = $getIndividualPortfolioValue['Portfolio']['net_value'] + $getIndividualSumPortfolioAmount['UserStock']['total'];
			$getIndividualTrades = $this -> Portfolio -> getIndividualTrades($data);
			$totalNoOfStocks = $this -> UserStock -> totalNoOfStocks($data);
			$pendingTransactions = $this -> UserStock -> getPendingTransactionsCount($data);
			$contents = array(
				'user_id' => $data['user_id'],
				'portfolio_id' => $data['portfolio_id'],
				'access_token' => trim($data['access_token']),
				'Portfolio_net_value' => trim($userTotalAmount),
				'Remaining_trades' => trim($getIndividualTrades['Portfolio']['total_trades']),
				'total_no_stocks' => trim($totalNoOfStocks['UserStock']['count']),
				'pending_transaction' => trim($pendingTransactions['UserStock']['count'])
			);

			$body = $contents;
			$status = True;
			$message = "Success!";
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for setting a portfolio as active
	 */
	function set_active_portfolio($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			//pr($data); exit;

			$ActivePortfolio = $this -> Portfolio -> setActivePortfolio($data['portfolio_id']);
			if ($ActivePortfolio)
			{
				$body['user_id'] = $data['user_id'];
				$body['access_token'] = $data['access_token'];
				$body['ActivePortfolio'] = $ActivePortfolio;
				$status = true;
				$message = "Current Portfolio Set";
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "No data";
			}

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);

	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for sending the detail of a particular share
	 */
	function share_detail($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{

			$shareDetail = $this -> Share -> shareDetail($data);
			if ($shareDetail)
			{
				$portfolioDetail = $this -> Portfolio -> totalTradeCashIndividualPortfolio($data);

				$body['Share'] = $shareDetail;
				$body['Portfolio'] = $portfolioDetail;
				$status = FALSE;
				$message = "Suceess! share data";
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = "No Data";
			}

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = "Access token invalid";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

}
?>
