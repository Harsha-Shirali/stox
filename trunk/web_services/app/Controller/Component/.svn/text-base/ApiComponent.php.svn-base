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
		$this -> Notification = $controller -> Notification;
		$this -> WatchlistPreload = $controller -> WatchlistPreload;
		$this -> UserstockHistory = $controller -> UserstockHistory;
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
		if (!empty($data['email']) && !empty($data['password']))
		{
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
						$updateData['UserLog']['device_id'] = $data['device_id'];
						$updateData['UserLog']['push_note_token'] = $data['push_note_token'];
						$updateData['UserLog']['access_token'] = $access_token;
						if ($this -> User -> saveLoginDatas($updateData))
						{
							$finalData['user_id'] = $isAuthenticatedUser['User']['id'];
							$finalData['username'] = $isAuthenticatedUser['User']['username'];
							$finalData['email'] = $isAuthenticatedUser['User']['email'];
							$finalData['job_title'] = $isAuthenticatedUser['User']['job_title'];
							$finalData['role'] = $isAuthenticatedUser['User']['role'];
							$finalData['image'] = Configure::read('site.image_path') . $isAuthenticatedUser['User']['image'];
							$finalData['bio'] = $isAuthenticatedUser['User']['biodata'];
							$finalData['access_token'] = $access_token;
							$finalData['reset_portfolio_price'] = '0.99';
							$finalData['create_portfolio_price'] = '0.99';
							$finalData['reset_product_name'] = 'TSXResetPortfolio';
							$finalData['create_product_name'] = 'TSXNewPortfolio';

							if ($finalData['bio'] == NULL)
								$finalData['bio'] = "";

							$status = TRUE;
							$game_list = $this -> Game -> displayGametype($finalData);
							$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
							$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
							$data["last_notification_time"] = $this -> User -> getLastNotificationTime($finalData);
							$lastNotificationTime = $this -> Notification -> polling_count($data);
							$body = array(
								'UserData' => $finalData,
								'GameData' => $game_list,
								'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
								'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
								'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
							);
							$message = Configure::read('site.login_message1');
							unset($finalData['password']);
						}
						else
						{
							$body = null;
							$status = FALSE;
							$message = Configure::read('site.login_message2');
						}
					}
					else
					{
						$body = null;
						$status = FALSE;
						$message = Configure::read('site.login_message3');
					}
				}
				else
				{
					$body = null;
					$message = Configure::read('site.login_message4');
					$status = FALSE;
				}
			}
			else
			{
				$body = null;
				$message = Configure::read('site.login_message5');
				$status = FALSE;
			}
		}
		else
		{
			$body = null;
			$status = False;
			$message = Configure::read('site.login_message6');
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

			if ($this -> UserLog -> updateUserLog($data))
			{
				$this -> Session -> destroy();
				$body = null;
				$status = TRUE;
				$message = Configure::read('site.logout_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.logout_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message = Configure::read('site.bio_message1');
			}
			else
			{
				$body = null;
				$status = TRUE;
				$message = Configure::read('site.bio_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
	 * @uses This function will be used for editing the User Profile as per the
	 * $data and the image, job_title, biodata will be updated
	 */

	function edit_profile($data)
	{

		if ($userDetail = $this -> UserLog -> checkAccessTokenValid($data))
		{
			$data['username'] = $userDetail['User']['username'];
			if (!empty($data['image']))
			{
				$data['image'] = $this -> create_image($data);
			}
			else
			{
				$data['image'] = 'profile_default.jpg';
			}
			$result = $this -> User -> updateProfile($data);
			if ($result)
			{
				$body = array(
					"user_id" => $data['user_id'],
					"access_token" => $data['access_token'],
					"image" => Configure::read('site.image_path') . $data['image'],
					"job_title" => $data['job_title'],
					"biodata" => $data['biodata'],
				);
				$body = $body;
				$status = TRUE;
				$message = Configure::read('site.editProfile_message1');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.editProfile_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message = Configure::read('site.gameList_message1');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.gameList_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message = Configure::read('site.premiumGames_message1');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.premiumGames_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
			if ($data['portfolio_start_money'] > 0)
			{
				$updateData = $this -> __save_free_portfolio($data);

				if ($updateData)
				{
					if ($this -> Portfolio -> savePortfolioDatas($updateData))
					{

						$id = $this -> Portfolio -> id;
						$updateWatchlistData = $this -> __save_default_watchlist($id);
						$portfolioDetails = $this -> Portfolio -> portfolioDetails($id);
						$contents = array(
							'portfolio_id' => $this -> Portfolio -> id,
							'portfolio_name' => $portfolioDetails['Portfolio']['portfolio_name'],
							'start_money' => $portfolioDetails['Portfolio']['start_money'],
							'available_cash' => $portfolioDetails['Portfolio']['net_value'],
							'portfolio_worth' => $portfolioDetails['Portfolio']['net_value'],
							'available_trades' => $portfolioDetails['Portfolio']['trades'],
							'portfolio_percentage_change' => "0%",
							'portfolio_stock_count' => "0",
							'net_value_change'=>($portfolioDetails['Portfolio']['start_money']-$portfolioDetails['Portfolio']['net_value'])
						);
						$body = $contents;
						$status = TRUE;
						$message = Configure::read('site.createPortfolio_message1');
					}
					else
					{
						$body = null;
						$status = FALSE;
						$message = Configure::read('site.createPortfolio_message2');
					}
				}
				else
				{
					$body = null;
					$status = FALSE;
					$message = Configure::read('site.createPortfolio_message3');
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.createPortfolio_message4');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
	function __save_free_portfolio($data)
	{
		$gameValue = $this -> Game -> getGameDetails($data);
		if ($data['portfolio_start_money'] <= $gameValue['Game']['default_net_value'])
		{
			$updateData['Portfolio']['user_id'] = trim($data['user_id']);
			$updateData['Portfolio']['game_id'] = trim($data['game_id']);
			$updateData['Portfolio']['portfolio_name'] = trim($data['portfolio_name']);
			$updateData['Portfolio']['net_value'] = $data['portfolio_start_money'];
			$updateData['Portfolio']['start_money'] = $data['portfolio_start_money'];
			$updateData['Portfolio']['trades'] = trim($gameValue['Game']['default_trades']);
			$updateData['Portfolio']['start_trade'] = trim($gameValue['Game']['default_trades']);
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

	function __save_default_watchlist($data)
	{
		$shareData = $this -> WatchlistPreload -> getPreloadWatchlist($data);
		$i = 0;
		foreach ($shareData as $key => $value)
		{
			$watchlist = array();
			$watchlist['p']['share_id'] = $shareData[$i]['share_id'];
			$watchlist['p']['portfolio_id'] = $data;
			$response[] = $watchlist['p'];
			$i++;
		}
		$result = $this -> Watchlist -> saveAll($response);
		if ($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}

	//	function __save_paid_portfolio($data = array())
	//	{
	//		$updateData['Portfolio']['user_id'] = trim($data['user_id']);
	//		$updateData['Portfolio']['game_id'] = trim($data['game_id']);
	//		$updateData['Portfolio']['portfolio_name'] = trim($data['portfolio_name']);
	//		$gameValue = $this -> Game -> getGameDetails($data);
	//		$updateData['Portfolio']['net_value'] =
	// trim($gameValue['Game']['default_net_value']);
	//		$updateData['Portfolio']['trades'] =
	// trim($gameValue['Game']['default_trades']);
	//		return $updateData;
	//	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for showing the Game Portfolio Value and
	 * Highest Portfolio Value for the User as per $data
	 */
	//	function show_portfolio_net_value($data)
	//	{
	//		if ($this -> UserLog -> checkAccessTokenValid($data))
	//		{
	//			$gamePortfolioValue = $this -> Portfolio -> getGamePortfolioValue($data);
	//			$getSumPortfolioAmount = $this -> UserStock -> getSumPortfolioAmount($data);
	//			$userTotalAmount = $gamePortfolioValue['Portfolio']['total'] +
	// $getSumPortfolioAmount['UserStock']['total'];
	//			$HighestPortfolioValue = $this -> User -> testMaxNetValue($data);
	//			$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
	//			$totalCashValue = $this -> Portfolio -> getTotalCash($data);
	//			$portContents = array(
	//				$totalTradeValue,
	//				$totalCashValue
	//			);
	//			$contents = array(
	//				'portfolio_id' => $this -> Portfolio -> id,
	//				'access_token' => trim($data['access_token']),
	//				'GamePortfolioValue' => $userTotalAmount,
	//				'HighestPortfolioValue' => trim($HighestPortfolioValue['User']['total']),
	//				'user_id' => $data['user_id'],
	//				'access_token' => $data['access_token'],
	//				'total_trades' => $totalTradeValue[0]['Portfolio']['total_trades'],
	//				'total_cash' => $totalCashValue[0]['Portfolio']['total_cash']
	//			);
	//
	//			$body = $contents;
	//			$status = True;
	//			$message = "Success!";
	//		}
	//		else
	//		{
	//			$body = null;
	//			$status = FALSE;
	//			$message = "Access token invalid";
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function lists all the portfolio's of a particular user
	 * with portfolio_worth and total_numbet_of_stocks as per the data $data
	 */
	function show_portfolio_list($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$getPortfolioList = $this -> User -> finalPortfolioList($data);
			$body = $getPortfolioList;
			$status = TRUE;
			$message = Configure::read('site.show_portfolio_list_message1');

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
	//	function total_portfolio_net_value($data)
	//	{
	//		if ($this -> UserLog -> checkAccessTokenValid($data))
	//		{
	//			$gamePortfolioValue = $this -> Portfolio -> getGamePortfolioValue($data);
	//			$getSumPortfolioAmount = $this -> UserStock ->
	// getIndividualSumPortfolioAmount($data);
	//			$userTotalAmount = $gamePortfolioValue['Portfolio']['total'] +
	// $getSumPortfolioAmount['UserStock']['total'];
	//
	//			$contents = array(
	//				'user_id' => trim($data['user_id']),
	//				'access_token' => trim($data['access_token']),
	//				'TotalPortfolioValue' => $userTotalAmount
	//			);
	//			//pr($contents); exit();
	//			$body = $contents;
	//			$status = True;
	//			$message = "Success!";
	//		}
	//		else
	//		{
	//			$body = null;
	//			$status = FALSE;
	//			$message = "Access token invalid";
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}

	/**
	 * @author Alin
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used for resetting portfolio
	 * per $data
	 */
	function reset_portfolio($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			$portfolio_data = $this -> Portfolio -> resetPortfolioGame($data);

			if ($portfolio_data)
			{
				$body = $portfolio_data;
				$status = TRUE;
				$message = Configure::read('site.resetPortfolio_message1');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.resetPortfolio_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
						$body = null;
						$status = True;
						$message = Configure::read('site.addWatchlist_message1');
					}
					else
					{
						$body = null;
						$status = FALSE;
						$message = Configure::read('site.addWatchlist_message2');
					}
				}
				else
				{
					$body = null;
					$status = FALSE;
					$message = Configure::read('site.addWatchlist_message3');
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.addWatchlist_message4');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message = Configure::read('site.showWatchlist_message1');
			}
			else
			{
				$body = NULL;
				$status = FALSE;
				$message = Configure::read('site.showWatchlist_message2');
			}

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
	//	function check_guest($data)
	//	{
	//		// $this->User->create();
	//		$isDeviceExists = $this -> User -> checkDeviceExists($data);
	//		//pr($data); exit();
	//		if (!($isDeviceExists))
	//		{
	//			//pr($data); exit();
	//			// $this->User->create();
	//			if ($saveGuestDatas = $this -> User -> saveall($data))
	//			{
	//				//pr($data); exit();
	//				$body = $data;
	//				$status = TRUE;
	//				$message = "SUCESS!";
	//			}
	//			else
	//			{
	//				$body = NULL;
	//				$status = FALSE;
	//				$message = "Error! User couldnt be saved";
	//			}
	//			$contents = array(
	//				'user_id' => $this -> User -> id,
	//				'device_id' => $data['device_id']
	//			);
	//			$isUserId = $this -> User -> id;
	//			$data['access_token'] = md5($data['device_id'] . time());
	//			$updateData['UserLog']['user_id'] = $isUserId;
	//			$updateData['UserLog']['access_token'] = $data['access_token'];
	//			$updateData['UserLog']['device_id'] = trim($data['device_id']);
	//			if ($this -> UserLog -> saveall($updateData))
	//			{
	//				$contents = array(
	//					'user_id' => $this -> User -> id,
	//					'device_id' => $data['device_id'],
	//					'access_token' => $data['access_token'],
	//				);
	//				$body = $contents;
	//				$status = TRUE;
	//				$message = "SUCESS!";
	//			}
	//			else
	//			{
	//				$body = NULL;
	//				$status = TRUE;
	//				$message = "Error! user log could not be saved";
	//			}
	//		}
	//		else
	//		{
	//			$guest = $this -> User -> checkGuestDatas($data);
	//			$guestAccess = $this -> UserLog -> checkGuestAccess($guest);
	//			//pr($guestAccess);exit();
	//			$contents = array(
	//				'user_id' => $guestAccess['UserLog']['user_id'],
	//				'device_id' => $guestAccess['UserLog']['device_id'],
	//				'access_token' => $guestAccess['UserLog']['access_token'],
	//			);
	//			$body = $contents;
	//			$status = TRUE;
	//			$message = "SUCCESS!";
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}

	function register($data)
	{
		// keeping these commented code here, so that I can talk to Harsha for not using
		// more individual queries.
		//Because  $isDeviceExists is not used any where in this Function
		//$isDeviceExists = $this -> User -> checkDeviceExists($data['device_id']);
		$isNotRegistered = $this -> User -> isNotRegistered($data);
		if (!empty($isNotRegistered))
		{
			//$guestData = $this -> User -> checkDeviceExists($data);
			$isEmailUnique = $this -> User -> checkEmailExists($data['email']);
			$isUsernameUnique = $this -> User -> checkUsernameExists($data['username']);
			$message = null;
			$currenttime = date("Y-m-d H:i:s");
			if (empty($isEmailUnique) && empty($isUsernameUnique))
			{
				$dataForAutoLogin['password'] = $data['password'];
				$dataForAutoLogin['email'] = $data['email'];
				$dataForAutoLogin['user_id'] = $guestData['User']['id'];
				$dataForAutoLogin['username'] = $data['username'];
				$dataForAutoLogin['device_id'] = null;
				$dataForAutoLogin['image'] = $data['image'];
				$dataForAutoLogin['job_title'] = $data['job_title'];
				$dataForAutoLogin['password'] = $this -> User -> authPassword($data['password']);
				$dataForAutoLogin['role'] = 'User';
				$dataForAutoLogin['is_registered'] = 'yes';
				$dataForAutoLogin['last_notification_time'] = $currenttime;
				if (!empty($data['image']))
				{
					$dataForAutoLogin['image'] = $this -> create_image($dataForAutoLogin);
				}
				else
				{
					$dataForAutoLogin['image'] = 'profile_default.jpg';
				}
				if ($this -> User -> updateGuest($dataForAutoLogin))
				{
					$contents = array(
						'email' => $data['email'],
						'user_id' => $this -> User -> id,
						'role' => 'User',
					);
					$contents['password'] = $data['password'];
					$contents['device_id'] = $data['device_id'];
					$contents['push_note_token'] = $data['push_note_token'];
					$contents['username'] = $data['username'];
					$userLoggedData = $this -> __user_login($contents);
					$status = TRUE;
					$finalData = array(
						"user_id" => $contents['user_id'],
						"username" => $data['username'],
						"email" => $contents['email'],
						"job_title" => $data['job_title'],
						"role" => "user",
						"access_token" => $userLoggedData['access_token'],
						"image" => Configure::read('site.image_path') . $dataForAutoLogin['image'],
						"reset_portfolio_price" => '0.99',
						"create_portfolio_price" => '0.99',
						"reset_product_name" => 'TSXResetPortfolio',
						"create_product_name" => 'TSXNewPortfolio'
					);
					$game_list = $this -> Game -> displayGametype($finalData);
					$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
					$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
					$data["last_notification_time"] = $this -> User -> getLastNotificationTime($contents);
					$lastNotificationTime = $this -> Notification -> polling_count($data);
					$body = array(
						'UserData' => $finalData,
						'GameData' => $game_list,
						'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
						'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
						'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
					);

					$message = $userLoggedData['message'];
				}
				else
				{
					$message = Configure::read('site.register_message1');
					$status = FALSE;
					$body = null;
				}
			}
			else
			if (!empty($isUsernameUnique))
			{
				$message = Configure::read('site.register_message2');
				$status = FALSE;
				$body = null;
			}
			else
			{
				$message = Configure::read('site.register_message3');
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
				$dataForAutoLogin['image'] = $data['image'];
				$dataForAutoLogin['is_registered'] = 'yes';
				$currenttime = date("Y-m-d H:i:s");
				$dataForAutoLogin['last_notification_time'] = $currenttime;
				if (!empty($data['image']))
				{

					$dataForAutoLogin['image'] = $this -> create_image($dataForAutoLogin);
				}
				else
				{
					$dataForAutoLogin['image'] = 'profile_default.jpg';
				}
				$this -> User -> create();
				if ($this -> User -> save($dataForAutoLogin))
				{
					$contents = array(
						'email' => $data['email'],
						'user_id' => $this -> User -> id,
						'role' => 'User',
					);
					$contents['password'] = $data['password'];
					$contents['device_id'] = $data['device_id'];
					$contents['push_note_token'] = $data['push_note_token'];
					$contents['username'] = $data['username'];
					$userLoggedData = $this -> __user_login($contents);
					$status = TRUE;
					$finalData = array(
						"user_id" => $contents['user_id'],
						"username" => $data['username'],
						"email" => $contents['email'],
						"job_title" => $data['job_title'],
						"role" => "user",
						"access_token" => $userLoggedData['access_token'],
						"image" => Configure::read('site.image_path') . $dataForAutoLogin['image'],
						"reset_portfolio_price" => '0.99',
						"create_portfolio_price" => '0.99',
						"reset_product_name" => 'TSXResetPortfolio',
						"create_product_name" => 'TSXNewPortfolio'
					);
					$game_list = $this -> Game -> displayGametype($finalData);
					$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
					$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
					$data["last_notification_time"] = $this -> User -> getLastNotificationTime($contents);
					$lastNotificationTime = $this -> Notification -> polling_count($data);
					$body = array(
						'UserData' => $finalData,
						'GameData' => $game_list,
						'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
						'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
						'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
					);

					$message = $userLoggedData['message'];
				}
				else
				{
					$message = Configure::read('site.register_message1');
					$status = FALSE;
					$body = null;
				}
			}
			else
			if (!empty($isUsernameUnique))
			{
				$message = Configure::read('site.register_message2');
				$status = FALSE;
				$body = null;
			}
			else
			{
				$message = Configure::read('site.register_message3');
				$status = FALSE;
				$body = null;
			}

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
	 * @uses This function will be used for uploading an image as per the $data a
	 */

	function __upload_image($data)
	{
		if (!empty($data['image']))
		{
			$imageType = in_array($data['image']['type'], array(
				"image/jpeg",
				"image/png",
				"image/gif",
				"image/jpg"
			));
			if (!empty($imageType))
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

				return $dataForAutoLogin['image'] = $data['image']['name'];
			}
			return false;
		}
		return false;

	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for converting from byte-code to an image for a
	 * particular User
	 * and it uploads an image to the files/uploads folder with username as a
	 * filename for uniqueness
	 * updates the image
	 */

	function create_image($data)
	{
		$username = $data['username'];
		$username .= '.jpeg';
		$image = $data['image'];
		$folder_url = WWW_ROOT . 'files/uploads';
		$data = base64_decode($image);
		if (!empty($data))
		{
			if ($im = @imagecreatefromstring($data))
			{
				header('Content-Type: image/jpeg');
				imagejpeg($im, $folder_url . '/' . $username);
				imagedestroy($im);
				return $username;
			}
			else
			if (error_reporting() === 0)
			{
				// This copes with @ being used to suppress errors
				// continue script execution, skipping standard PHP error handler
				return false;
			}
			return false;
		}
		return false;
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function will be used to set new password for the user when he
	 * forgets the password
	 * by sending a link via mail
	 */

	function forgot_password($data = array())
	{
		$cleanData = trim($data['userdata']);
		$isEmailIsThereOrNot = $this -> User -> checkDataExists($cleanData);
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
				'username' => $isEmailIsThereOrNot['User']['username'],
				'admin_email' => Configure::read('site.admin_email')
			);
			if ($this -> User -> updateChangePwdToken($changePwdToken))
			{
				$this -> sendMail('forgot_password', $isEmailIsThereOrNot['User']['email'], Configure::read('site.support_email'), 'Reset your stox password', $contents);
				$message = Configure::read('site.forgotPassword_message1');
				$status = TRUE;
			}
			else
			{
				$finalData = null;
				$message = Configure::read('site.forgotPassword_message2');
				$status = FALSE;
			}
		}
		return $result = array(
			'body' => $finalData,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function lists the bank data displaying assets, price and type
	 */

	function show_bankdata($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			if ($bankData = $this -> Bank -> getBankDatas($data))
			{
				$body = Set::classicExtract($bankData, '{n}.BankData');
				$status = True;
				$message = Configure::read('site.showBankData_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.showBankData_message2');
			}
			if ($content = $this -> Game -> listOfPremiumGames($data))
			{
				$body = $content;
				$status = TRUE;
				$message = Configure::read('site.showBankData_message3');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.showBankData_message4');
			}

			$status = True;
			$message = Configure::read('site.showBankData_message1');
			$contents = array('BankData' => $bankData);
			$body = $contents;
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
	 * @uses This function is used to change the password for the user as per the
	 * $data
	 */

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
					$message = Configure::read('site.changePassword_message1');
				}
				else
				{
					$body = null;
					$status = FALSE;
					$message = Configure::read('site.changePassword_message2');
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.changePassword_message3');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.changePassword_message4');
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
	 * @uses This function is used for sending mail as per the $data
	 */

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
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function saves the user log data as per $data when he logs in
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
				$data['access_token'] = md5($this -> Auth -> User('id') . time());
				$data['status'] = 'LoggedIn';
				if ($this -> UserLog -> saveLoginDatas($data))
				{
					$finalData['access_token'] = $data['access_token'];
					unset($finalData['password']);
				}
			}
		}
		return array(
			"access_token" => $data['access_token'],
			"message" => Configure::read('site.login_message1')
		);
	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for getting the share data page wise
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
					$message = Configure::read('site.get_share_data_message1');
				}
				else
				{
					$share_data = null;
					$status = False;
					$message = Configure::read('site.get_share_data_message2');
				}
			}
			else
			{
				$share_data = null;
				$status = False;
				$message = Configure::read('site.get_share_data_message3');
			}
		}
		else
		{
			$share_data = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
		}
		return $result = array(

			'body' => $share_data,
			'status' => $status,
			'message' => $message
		);
	}

	//----------------------------------
	//	function guestRegister($data = array())
	//	{
	//		//echo($data['email']); exit();
	//		$isEmailUnique = $this -> User -> checkEmailExists($data['email']);
	//		$isUsernameUnique = $this -> User -> checkUsernameExists($data['username']);
	//		//	$isFacebookUserUnique =
	//		// $this->User->checkFacebookUserExists($data['facebook_id']);
	//		//$notification = null;
	//		$message = null;
	//		if (empty($isEmailUnique) && empty($isUsernameUnique))
	//		{
	//			$dataForAutoLogin['password'] = $data['password'];
	//			$dataForAutoLogin['email'] = $data['email'];
	//			$dataForAutoLogin['username'] = $data['username'];
	//			$dataForAutoLogin['device_id'] = $data['device_id'];
	//			$dataForAutoLogin['job_title'] = $data['job_title'];
	//			$dataForAutoLogin['password'] = $this -> User ->
	// authPassword($data['password']);
	//			$dataForAutoLogin['role'] = 'User';
	//			if (!empty($data['image']))
	//			{
	//				$filename = $data['image']['name'];
	//				$folder_url = WWW_ROOT . 'files/uploads/';
	//				$rel_url = 'files/uploads';
	//				$data['image']['url'] = $rel_url;
	//				if (!file_exists($folder_url . '/' . $filename))
	//				{
	//					// create full filename
	//					$full_url = $folder_url . '/' . $filename;
	//					$url = $rel_url . '/' . $filename;
	//					$data['image']['name'] = $filename;
	//					// upload the file
	//					$success = move_uploaded_file($data['image']['tmp_name'], $url);
	//				}
	//				else
	//				{
	//					// create unique filename and upload file
	//					ini_set('date.timezone', 'Europe/London');
	//					$now = date('Y-m-d-His');
	//					$full_url = $folder_url . '/' . $now . $filename;
	//					$url = $rel_url . '/' . $now . $filename;
	//					$data['image']['name'] = $now . $filename;
	//					$success = move_uploaded_file($data['image']['tmp_name'], $url);
	//				}
	//				//echo($data['image']['name']); exit();
	//				$dataForAutoLogin['image'] = $data['image']['name'];
	//			}
	//			else
	//			{
	//				$dataForAutoLogin['image'] = "profile_default.jpg";
	//			}
	//			$this -> User -> create();
	//			if ($this -> User -> save($dataForAutoLogin))
	//			{
	//				$contents = array(
	//					'email' => $data['email'],
	//					'user_id' => $this -> User -> id,
	//					'role' => 'User',
	//				);
	//				//$this->sendMail('user_register', $data['email'],
	//				// Configure::read('site.support_email'), 'Thank you for registration with
	// STOX',
	//				// $contents);
	//				$contents['password'] = $data['password'];
	//				$contents['device_id'] = $data['device_id'];
	//				$contents['username'] = $data['username'];
	//				$userLoggedData = $this -> __user_login($contents);
	//				$status = TRUE;
	//				$body = array(
	//					"user_id" => $contents['user_id'],
	//					"username" => $data['username'],
	//					"email" => $contents['email'],
	//					"job_title" => $data['job_title'],
	//					"role" => "user",
	//					"access_token" => $userLoggedData['access_token']
	//				);
	//				$message = $userLoggedData['message'];
	//			}
	//			else
	//			{
	//				$message = "Registration failed!";
	//				$status = FALSE;
	//				$body = null;
	//				//$notification = null;
	//			}
	//		}
	//		else
	//		if (!empty($isUsernameUnique))
	//		{
	//			//$notification = null;
	//			$message = "This username is already in use.";
	//			$status = FALSE;
	//			$body = null;
	//		}
	//		else
	//		{
	//			$message = "This Email Address is already in use.";
	//			$status = FALSE;
	//			$body = null;
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for uploading an image for the user by converting
	 * byte code to an image
	 */
	function upload_image($data)
	{

		if ($userDetail = $this -> UserLog -> checkAccessTokenValid($data))
		{
			$data['username'] = $userDetail['User']['username'];
			if (!empty($data['image']))
			{
				$data['image'] = $this -> create_image($data);
			}
			else
			{
				$data['image'] = 'profile_default.jpg';
			}
			if ($result = $this -> User -> updateImage($data))
			{
				$body = array(
					"user_id" => $data['user_id'],
					"access_token" => $data['access_token'],
					"image" => Configure::read('site.image_path') . $data['image'],
				);
				$body = $body;
				$status = False;
				$message = Configure::read('site.upload_image_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.upload_image_message2');
			}

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message = Configure::read('site.buy_cash_trade_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.buy_cash_trade_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');

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
	 * @uses This function is used for login through Facebook for User as per the
	 * $data and the User log will
	 * be maintained for successful login
	 */

	function social_login($data = array())
	{
		$isEmailUnique = $this -> User -> checkEmailExists($data['email']);
		$isFacebookUserUnique = $this -> User -> checkFacebookUserExists($data['facebook_id']);
		if (empty($isFacebookUserUnique) && empty($isEmailUnique) && empty($isUserNameUnique))
		{
			$body = null;
			$status = TRUE;
			$currenttime = date("Y-m-d H:i:s");
			$dataPassword['password'] = $data['facebook_id'];
			$dataForAutoLogin['password'] = $this -> User -> authPassword($dataPassword['password']);
			$dataForAutoLogin['email'] = $data['email'];
			$dataForAutoLogin['username'] = $data['firstname'] . $data['facebook_id'];
			$dataForAutoLogin['device_id'] = NULL;
			$dataForAutoLogin['image'] = $data['image'];
			$dataForAutoLogin['facebook_id'] = $data['facebook_id'];
			$dataForAutoLogin['is_registered'] = 'yes';
			$dataForAutoLogin['role'] = 'User';
			$dataForAutoLogin['last_notification_time'] = $currenttime;
			if (!empty($data['image']))
			{
				$dataForAutoLogin['image'] = $this -> create_image($dataForAutoLogin);
			}
			else
			{
				$dataForAutoLogin['image'] = 'profile_default.jpg';
			}
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
				$contents['device_id'] = $data['device_id'];
				$contents['push_note_token'] = $data['push_note_token'];
				$contents['username'] = $data['firstname'];

				$userLoggedData = $this -> __user_login($contents);
				$status = TRUE;
				$finalData = array(
					"user_id" => $contents['user_id'],
					"username" => $contents['username'],
					"email" => $contents['email'],
					"role" => "user",
					"access_token" => $userLoggedData['access_token'],
					"image" => Configure::read('site.image_path') . $dataForAutoLogin['image'],
					"reset_portfolio_price" => '0.99',
					"create_portfolio_price" => '0.99',
					"reset_product_name" => 'TSXResetPortfolio',
					"create_product_name" => 'TSXNewPortfolio'
				);
				$game_list = $this -> Game -> displayGametype($finalData);
				$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
				$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
				$data["last_notification_time"] = $this -> User -> getLastNotificationTime($contents);
				$lastNotificationTime = $this -> Notification -> polling_count($data);
				$body = array(
					'UserData' => $finalData,
					'GameData' => $game_list,
					'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
					'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
					'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
				);
				$message = $userLoggedData['message'];
			}
			else
			{
				$message = Configure::read('site.social_login_message1');
				$status = FALSE;
				$body = null;
			}
			return $result = array(
				'body' => $body,
				'status' => $status,
				'message' => $message
			);
		}
		else
		if (empty($isFacebookUserUnique) && !empty($isEmailUnique))
		{
			$finalData = null;
			$body = null;
			$status = TRUE;
			$data['user_id'] = $isEmailUnique['User']['id'];
			$facebookIdUpdate = $this -> User -> updateFacebookData($data);
			if ($facebookIdUpdate)
			{
				$data['password'] = $this -> User -> authPassword($isEmailUnique['User']['password']);
				$this -> request -> data['User']['email'] = trim($isEmailUnique['User']['email']);
				$this -> request -> data['User']['password'] = trim($data['password']);
				if ($this -> Auth -> login($this -> request -> data['User']))
				{
					$finalData = $this -> Auth -> User();
					if (is_array($finalData))
					{
						$access_token = md5($this -> Auth -> User('id') . time());
						$updateData['User']['id'] = $this -> Auth -> User('id');
						$updateData['User']['device_id'] = NULL;
						$updateData['User']['facebook_id'] = trim($data['facebook_id']);
						$updateData['User']['image'] = trim($data['image']);
						$updateData['UserLog']['user_id'] = $this -> Auth -> User('id');
						$updateData['UserLog']['access_token'] = $access_token;
						$updateData['UserLog']['device_id'] = NULL;
						//$userInfo = $this -> User -> getSocialUserId($isEmailUnique);
						$userLogData['user_id'] = $isEmailUnique['User']['id'];
						$userLogData['status'] = 'LoggedIn';
						$userLogData['device_id'] = $data['device_id'];
						$userLogData['push_note_token'] = $data['push_note_token'];
						$userLogData['access_token'] = $access_token;
						$userSaveLog = $this -> UserLog -> saveLoginDatas($userLogData);
						$finalData = array(
							"user_id" => $isEmailUnique['User']['id'],
							"username" => $data['firstname'],
							"email" => $data['email'],
							"role" => "user",
							"access_token" => $updateData['UserLog']['access_token'],
							"image" => Configure::read('site.image_path') . $isEmailUnique['User']['image'],
							"reset_portfolio_price" => '0.99',
							"create_portfolio_price" => '0.99',
							"reset_product_name" => 'TSXResetPortfolio',
							"create_product_name" => 'TSXNewPortfolio'
						);
						$game_list = $this -> Game -> displayGametype($finalData);
						$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
						$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
						$data["last_notification_time"] = $this -> User -> getLastNotificationTime($userLogData);
						$lastNotificationTime = $this -> Notification -> polling_count($data);
						$body = array(
							'UserData' => $finalData,
							'GameData' => $game_list,
							'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
							'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
							'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
						);
					}

				}
			}
			else
			{
				$finalData = null;
				$body = null;
				$status = FALSE;
				return array(
					'body' => $body,
					'status' => $status,
					"message" => Configure::read('site.social_login_message2')
				);
			}

			return array(
				'body' => $body,
				'status' => $status,
				"message" => Configure::read('site.login_message1')
			);
		}
		else
		{
			$finalData = null;
			$body = null;
			$status = TRUE;
			$data['password'] = $this -> User -> authPassword($data['facebook_id']);
			$this -> request -> data['User']['email'] = trim($data['email']);
			$this -> request -> data['User']['password'] = trim($data['password']);
			if ($this -> Auth -> login($this -> request -> data['User']))
			{
				$finalData = $this -> Auth -> User();
				if (is_array($finalData))
				{
					$access_token = md5($this -> Auth -> User('id') . time());
					$updateData['User']['id'] = $this -> Auth -> User('id');
					$updateData['User']['device_id'] = NULL;
					$updateData['User']['facebook_id'] = trim($data['facebook_id']);
					$updateData['User']['image'] = trim($data['image']);
					$updateData['UserLog']['user_id'] = $this -> Auth -> User('id');
					$updateData['UserLog']['access_token'] = $access_token;
					$updateData['UserLog']['device_id'] = NULL;
					$userInfo = $this -> User -> getSocialUserId($data);
					$userLogData['user_id'] = $userInfo['User']['id'];
					$userLogData['status'] = 'LoggedIn';
					$userLogData['device_id'] = $data['device_id'];
					$userLogData['push_note_token'] = $data['push_note_token'];
					$userLogData['access_token'] = $access_token;
					$userSaveLog = $this -> UserLog -> saveLoginDatas($userLogData);
					$finalData = array(
						"user_id" => $userInfo['User']['id'],
						"username" => $data['firstname'],
						"email" => $data['email'],
						"role" => "user",
						"access_token" => $updateData['UserLog']['access_token'],
						"image" => Configure::read('site.image_path') . $userInfo['User']['image'],
						"reset_portfolio_price" => '0.99',
						"create_portfolio_price" => '0.99',
						"reset_product_name" => 'TSXResetPortfolio',
						"create_product_name" => 'TSXNewPortfolio'
					);
					$game_list = $this -> Game -> displayGametype($finalData);
					$portfolioCount = $this -> Portfolio -> totalPortfolioCount($finalData);
					$dayTradeExists = $this -> Portfolio -> isPaidPortfolioExists($finalData);
					$data["last_notification_time"] = $this -> User -> getLastNotificationTime($userLogData);
					$lastNotificationTime = $this -> Notification -> polling_count($data);
					$body = array(
						'UserData' => $finalData,
						'GameData' => $game_list,
						'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
						'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
						'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
					);
				}

			}

			return array(
				'body' => $body,
				'status' => $status,
				"message" => Configure::read('site.login_message1')
			);
		}
	}

	//	function buying_stocks($data)
	//	{
	//		date_default_timezone_set('US/Eastern');
	//		date_default_timezone_get();
	//		$currenttime = date('h:i:s');
	//		if ($this -> UserLog -> checkAccessTokenValid($data))
	//		{
	//			$currenttime = 9;
	//			if (($currenttime >= 9 && $currenttime <= 18))
	//			{
	//				$isStatusPending = $this -> UserStock -> isStatusPending($data);
	//				$isStatusBuy = $this -> UserStock -> isStatusBuy($data);
	//				$getNetValue = $this -> Portfolio -> getNetValue($data);
	//				$getTradeValue = $this -> Portfolio -> getTradeValue($data);
	//				$DefaultNetValue = $getNetValue['Portfolio']['net_value'];
	//				$DefaultTradeValue = $getTradeValue['Portfolio']['trades'];
	//				if (!empty($isStatusPending))
	//				{
	//					$checkPending = $this -> UserStock -> pendingSum($data);
	//					$PendingSum = $checkPending['UserStock']['sum'];
	//					$DefaultNetValue = $DefaultNetValue - $PendingSum;
	//				}
	//				if ($getTradeValue['Portfolio']['trades'] > 0)
	//				{
	//					if ($DefaultNetValue > $data['total_amount'])
	//					{
	//						$currentValue = $DefaultNetValue - $data['total_amount'];
	//
	//						$getShareQuantity = $this -> Portfolio -> getShareQuantity($data);
	//						$data['previous_net_value'] = $getNetValue[0]['Portfolio']['net_value'];
	//						$data['default_net_value'] = $currentValue;
	//						if ($this -> Portfolio -> updatePortfolioDefaultValue($data))
	//						{
	//							$message = "SUCCESS! Portfolio Default value Updated";
	//							$body = NULL;
	//							$status = TRUE;
	//						}
	//						else
	//						{
	//							$message = "ERROR! Could not be Updated";
	//							$body = NULL;
	//							$status = FALSE;
	//						}
	//						$dataStox['user_id'] = $data['user_id'];
	//						$dataStox['share_id'] = $data['share_id'];
	//						$dataStox['portfolio_id'] = $data['portfolio_id'];
	//						$dataStox['status'] = 'buy';
	//						$dataStox['quantity'] = $data['quantity'];
	//						$dataStox['total_amount'] = $data['total_amount'];
	//						$this -> UserStock -> create();
	//						if ($this -> UserStock -> saveBuyStox($dataStox))
	//						{
	//							$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
	//							$totalCashValue = $this -> Portfolio -> getTotalCash($data);
	//							$portContents = array(
	//								$totalTradeValue,
	//								$totalCashValue
	//							);
	//							$contents = array(
	//								'id' => $this -> Portfolio -> id,
	//								'user_id' => $data['user_id'],
	//								'access_token' => $data['access_token'],
	//								'total_trades' => $totalTradeValue[0]['Portfolio']['total_trades'],
	//								'total_cash' => $totalCashValue[0]['Portfolio']['total_cash']
	//							);
	//							$data['tradeValue'] = $getTradeValue['Portfolio']['trades'] - 1;
	//							if ($this -> Portfolio -> updateTrades($data))
	//							{
	//								$message = "Trade value has been updated";
	//								$body = NULL;
	//								$status = TRUE;
	//							}
	//							else
	//							{
	//								$message = "ERROR!:Trade value has not been updated";
	//								$body = NULL;
	//								$status = TRUE;
	//							}
	//							$message = "SUCCESS! Buy STOX updated";
	//							$body = $contents;
	//							$status = TRUE;
	//						}
	//						else
	//						{
	//							$message = "ERROR! STOX not updated";
	//							$body = NULL;
	//							$status = FALSE;
	//						}
	//					}
	//					else
	//					{
	//						$message = "Failed! You do not have enough net value to buy!";
	//						$body = NULL;
	//						$status = FALSE;
	//					}
	//				}
	//				else
	//				{
	//					$message = "Failed! You do not have enough trades to buy!";
	//					$body = NULL;
	//					$status = FALSE;
	//				}
	//			}
	//			//---------------------
	//			else
	//			{
	//				$dataStox['user_id'] = $data['user_id'];
	//				$dataStox['share_id'] = $data['share_id'];
	//				$dataStox['portfolio_id'] = $data['portfolio_id'];
	//				$dataStox['is_pending'] = 'yes';
	//				$dataStox['quantity'] = $data['quantity'];
	//				$dataStox['total_amount'] = $data['total_amount'];
	//				$this -> UserStock -> create();
	//				if ($this -> UserStock -> saveBuyStox($dataStox))
	//				{
	//					$message = "SUCCESS! Pending STOX updated";
	//					$body = NULL;
	//					$status = TRUE;
	//				}
	//				else
	//				{
	//					$message = "ERROR! Pending STOX not updated";
	//					$body = NULL;
	//					$status = FALSE;
	//				}
	//				$message = "Markets are closed now!";
	//				$body = NULL;
	//				$status = FALSE;
	//			}
	//		}
	//		else
	//		{
	//			$message = "Access Token Invalid!";
	//			$body = NULL;
	//			$status = FALSE;
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}
	//
	//	function buying_stocks_trial($data)
	//	{
	//		date_default_timezone_set('US/Eastern');
	//		date_default_timezone_get();
	//		$currenttime = date('h:i:s');
	//		if ($this -> UserLog -> checkAccessTokenValid($data))
	//		{
	//			$currenttime = 9;
	//			if (($currenttime >= 9 && $currenttime <= 18))
	//			{
	//				$isStatusPending = $this -> UserStock -> isStatusPending($data);
	//				$isStatusBuy = $this -> UserStock -> isStatusBuy($data);
	//				$getNetValue = $this -> Portfolio -> getNetValue($data);
	//				$getTradeValue = $this -> Portfolio -> getTradeValue($data);
	//				$DefaultNetValue = $getNetValue['Portfolio']['net_value'];
	//				$DefaultTradeValue = $getTradeValue['Portfolio']['trades'];
	//				if (!empty($isStatusPending))
	//				{
	//					$checkPending = $this -> UserStock -> pendingSum($data);
	//					$PendingSum = $checkPending['UserStock']['sum'];
	//					$DefaultNetValue = $DefaultNetValue - $PendingSum;
	//				}
	//				if ($getTradeValue['Portfolio']['trades'] > 0)
	//				{
	//					if ($DefaultNetValue > $data['total_amount'])
	//					{
	//						$currentValue = $DefaultNetValue - $data['total_amount'];
	//						$getShareQuantity = $this -> Portfolio -> getShareQuantity($data);
	//						$data['previous_net_value'] = $getNetValue['Portfolio']['net_value'];
	//						$data['default_net_value'] = $currentValue;
	//						if ($this -> Portfolio -> updatePortfolioDefaultValue($data))
	//						{
	//
	//							$message = "SUCCESS! Portfolio Default value Updated";
	//							$body = NULL;
	//							$status = TRUE;
	//						}
	//						else
	//						{
	//							$message = "ERROR! Could not be Updated";
	//							$body = NULL;
	//							$status = FALSE;
	//						}
	//						$updateTotalAmount = $this -> UserStock -> updateTotalAmount($data);
	//						$dataStox['user_id'] = $data['user_id'];
	//						$dataStox['share_id'] = $data['share_id'];
	//						$dataStox['portfolio_id'] = $data['portfolio_id'];
	//						$dataStox['status'] = 'buy';
	//						$dataStox['quantity'] = $data['quantity'];
	//						$dataStox['total_amount'] = $data['total_amount'];
	//						$this -> UserStock -> create();
	//						if ($this -> UserStock -> saveBuyStox($dataStox))
	//						{
	//							$totalTradeValue = $this -> Portfolio -> getTotalTradeValue($data);
	//							$totalCashValue = $this -> Portfolio -> getTotalCash($data);
	//							$portContents = array(
	//								$totalTradeValue,
	//								$totalCashValue
	//							);
	//							$contents = array(
	//								'id' => $this -> Portfolio -> id,
	//								'user_id' => $data['user_id'],
	//								'access_token' => $data['access_token'],
	//								'total_trades' => $totalTradeValue[0]['Portfolio']['total_trades'],
	//								'total_cash' => $totalCashValue[0]['Portfolio']['total_cash']
	//							);
	//							$data['tradeValue'] = $getTradeValue['Portfolio']['trades'] - 1;
	//							if ($this -> Portfolio -> updateTrades($data))
	//							{
	//								$message = "Trade value has been updated";
	//								$body = NULL;
	//								$status = TRUE;
	//							}
	//							else
	//							{
	//								$message = "ERROR!:Trade value has not been updated";
	//								$body = NULL;
	//								$status = TRUE;
	//							}
	//							$message = "SUCCESS! Buy STOX updated";
	//							$body = $contents;
	//							$status = TRUE;
	//						}
	//						else
	//						{
	//							$message = "ERROR! STOX not updated";
	//							$body = NULL;
	//							$status = FALSE;
	//						}
	//					}
	//					else
	//					{
	//						$message = "Failed! You do not have enough net value to buy!";
	//						$body = NULL;
	//						$status = FALSE;
	//					}
	//				}
	//				else
	//				{
	//					$message = "Failed! You do not have enough trades to buy!";
	//					$body = NULL;
	//					$status = FALSE;
	//				}
	//			}
	//			//---------------------
	//			else
	//			{
	//				$dataStox['user_id'] = $data['user_id'];
	//				$dataStox['share_id'] = $data['share_id'];
	//				$dataStox['portfolio_id'] = $data['portfolio_id'];
	//				$dataStox['is_pending'] = 'yes';
	//				$dataStox['quantity'] = $data['quantity'];
	//				$dataStox['total_amount'] = $data['total_amount'];
	//				$this -> UserStock -> create();
	//				if ($this -> UserStock -> saveBuyStox($dataStox))
	//				{
	//					$message = "SUCCESS! Pending STOX updated";
	//					$body = NULL;
	//					$status = TRUE;
	//				}
	//				else
	//				{
	//					$message = "ERROR! Pending STOX not updated";
	//					$body = NULL;
	//					$status = FALSE;
	//				}
	//				$message = "Markets are closed now!";
	//				$body = NULL;
	//				$status = FALSE;
	//			}
	//		}
	//		else
	//		{
	//			$message = "Access Token Invalid!";
	//			$body = NULL;
	//			$status = FALSE;
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}

	/**
	 * @author Alin Begum
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to buy share for a particular portfolio
	 */

	function buy_stocks($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			date_default_timezone_set('America/New_York');
			date_default_timezone_get();
			$currenttime = date('H:i:s');
			if (($currenttime >= '09:30:00' && $currenttime <= '16:30:00'))
			{
				$availableTradeCash = $this -> Portfolio -> totalTradeCashIndividualPortfolio($data);
				if ($availableTradeCash)
				{
					if ($availableTradeCash['trades'] <= 0 || $availableTradeCash['net_value'] < $data['total_purchased_amount'])
					{
						$message = Configure::read('site.buy_stocks_message1');
						$body = NULL;
						$status = FALSE;

					}
					else
					{

						$data['cost_price'] = $data['total_purchased_amount'];
						$data['cost_per_price'] = $data['total_purchased_amount'] / $data['quantity'];
						$data['status'] = 'buy';
						$data['total_amount'] = $data['total_purchased_amount'];
						$saveUserStock = $this -> UserStock -> saveUserStockData($data);

						$message = Configure::read('site.buy_stocks_message2');
						$body = $saveUserStock;
						$status = True;

					}

				}
				else
				{
					$message = Configure::read('site.buy_stocks_message3');
					$body = NULL;
					$status = FALSE;
				}
			}
			else
			{
				$message = Configure::read('site.buy_stocks_message4');
				$body = NULL;
				$status = FALSE;
			}
		}
		else
		{
			$message = Configure::read('site.invalid_error_msg');
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
	 * @uses This function is used to sale share for a particular portfolio
	 */

	function sell_stocks($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			date_default_timezone_set('America/New_York');
			date_default_timezone_get();
			$currenttime = date('H:i:s');
			if (($currenttime >= '09:30:00' && $currenttime <= '16:30:00'))
			{
				$availableTrade = $this -> Portfolio -> getIndividualTrades($data);
				if ($availableTrade['Portfolio']['total_trades'] <= 0)
				{
					$message = Configure::read('site.sell_stocks_message1');
					$body = NULL;
					$status = FALSE;

				}
				else
				{
					$availableStock = $this -> UserStock -> availableStock($data);
					if ($availableStock)
					{
						if ($availableStock['quantity'] >= $data['quantity'])
						{
							$data['cost_price'] = $data['total_sold_amount'];
							$data['cost_per_price'] = $data['total_sold_amount'] / $data['quantity'];
							$data['status'] = 'sell';
							$data['total_amount'] = $data['total_sold_amount'];
							$data['stock_detail'] = $availableStock;
							$saveSellStockData = $this -> UserStock -> saveSellStockData($data);

							$message = Configure::read('site.sell_stocks_message2');
							$body = $saveSellStockData;
							$status = True;

						}
						else
						{
							$message = Configure::read('site.sell_stocks_message3');
							$body = NULL;
							$status = FALSE;
						}

					}
					else
					{
						$message = Configure::read('site.sell_stocks_message4');
						$body = NULL;
						$status = FALSE;
					}

				}
			}
			else
			{
				$message = Configure::read('site.sell_stocks_message5');
				$body = NULL;
				$status = FALSE;
			}
		}
		else
		{
			$message = Configure::read('site.invalid_error_msg');
			$body = NULL;
			$status = FALSE;
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	//	function sell_stocks($data)
	//	{
	//		date_default_timezone_set('US/Eastern');
	//		date_default_timezone_get();
	//		$currenttime = date('h:i:s');
	//		if ($this -> UserLog -> checkAccessTokenValid($data))
	//		{
	//			$currenttime = 9;
	//			if (($currenttime >= 9 && $currenttime <= 18))
	//			{
	//				$isStatusPending = $this -> UserStock -> isStatusPending($data);
	//				$isStatusBuy = $this -> UserStock -> isStatusBuy($data);
	//				//pr($data);exit();
	//				$getNetValue = $this -> Portfolio -> getNetValue($data);
	//				$DefaultNetValue = $getNetValue[0]['Portfolio']['net_value'];
	//				//pr($DefaultNetValue);exit();
	//				$currentValue = $DefaultNetValue + $data['total_amount'];
	//				$data['previous_net_value'] = $getNetValue[0]['Portfolio']['net_value'];
	//				$data['default_net_value'] = $currentValue;
	//				if ($this -> Portfolio -> updatePortfolioDefaultValue($data))
	//				{
	//					$message = "SUCCESS! Portfolio Default value Updated";
	//					$body = NULL;
	//					$status = TRUE;
	//				}
	//				else
	//				{
	//					$message = "ERROR!Portfolio Default value couldnt Update";
	//					$body = NULL;
	//					$status = FALSE;
	//				}
	//				$dataStox['user_id'] = $data['user_id'];
	//				$dataStox['share_id'] = $data['share_id'];
	//				$dataStox['portfolio_id'] = $data['portfolio_id'];
	//				$dataStox['status'] = 'sell';
	//				$dataStox['quantity'] = $data['quantity'];
	//				$dataStox['total_amount'] = $data['total_amount'];
	//				$this -> UserStock -> create();
	//				if ($this -> UserStock -> saveBuyStox($dataStox))
	//				{
	//					$message = "SUCCESS! Sell STOX updated";
	//					$body = NULL;
	//					$status = TRUE;
	//					//pr($CurrentNetValue);echo 'here';exit();
	//				}
	//				else
	//				{
	//					$message = "ERROR! Sell STOX not updated";
	//					$body = NULL;
	//					$status = FALSE;
	//				}
	//			}
	//			//---------------------
	//			else
	//			{
	//				$dataStox['user_id'] = $data['user_id'];
	//				$dataStox['share_id'] = $data['share_id'];
	//				$dataStox['portfolio_id'] = $data['portfolio_id'];
	//				$dataStox['is_pending'] = 'yes';
	//				$dataStox['quantity'] = $data['quantity'];
	//				$dataStox['total_amount'] = $data['total_amount'];
	//				$this -> UserStock -> create();
	//				if ($this -> UserStock -> saveBuyStox($dataStox))
	//				{
	//					$message = "SUCCESS! Pending STOX updated";
	//					$body = NULL;
	//					$status = TRUE;
	//					//pr($CurrentNetValue);echo 'here';exit();
	//				}
	//				else
	//				{
	//					$message = "ERROR! Pending STOX not updated";
	//					$body = NULL;
	//					$status = FALSE;
	//				}
	//				$message = "Markets are closed now!";
	//				$body = NULL;
	//				$status = FALSE;
	//			}
	//		}
	//		else
	//		{
	//			$message = "Access Token Invalid!";
	//			$body = NULL;
	//			$status = FALSE;
	//		}
	//		return $result = array(
	//			'body' => $body,
	//			'status' => $status,
	//			'message' => $message
	//		);
	//	}

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
					$message = Configure::read('site.user_stocks_message1');
				}
				elseif (count($stock_list) == 0)
				{
					$body = $stock_list;
					$status = True;
					$message = Configure::read('site.user_stocks_message2');
				}
				else
				{
					$status = False;
					$message = Configure::read('site.user_stocks_message3');
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.invalid_error_msg');
			}
		}
		else
		{
			$status = False;
			$message = Configure::read('site.user_stocks_message5');
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
					$message = Configure::read('site.stock_history_message1');
				}
				else
				if (count($stock_list) == 0)
				{
					$body = $stock_list;
					$status = True;
					$message = Configure::read('site.stock_history_message2');
				}
				else
				{
					$status = False;
					$message = Configure::read('site.stock_history_message3');
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.invalid_error_msg');
			}
		}
		else
		{
			$status = False;
			$message = Configure::read('site.stock_history_message5');
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
					$message = Configure::read('site.pending_stocks_message1');
				}
				else
				if (count($stock_list) == 0)
				{
					$body = $stock_list;
					$status = True;
					$message = Configure::read('site.pending_stocks_message2');
				}
				else
				{
					$status = False;
					$message = Configure::read('site.pending_stocks_message3');
				}
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.invalid_error_msg');
			}
		}
		else
		{
			$status = False;
			$message = Configure::read('site.pending_stocks_message5');
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
				$message = Configure::read('site.faq_data_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.faq_data_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message = Configure::read('site.faq_data_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.faq_data_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message =  Configure::read('site.contactus_data_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.contactus_data_message2');
			}
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
	 * @uses This function deletes the guest user data before installing if exists
	 */

	function install($data)
	{
		$isDeviceExists = $this -> User -> checkDeviceExists($data);
		if (!empty($isDeviceExists))
		{
			$id = $this -> User -> getUserId($data);
			if ($deleteGuestDatas = $this -> User -> delete($id['User']['id'], true))
			{
				$contents = array(
					'device_id' => $data['device_id'],
					'user_id' => $id['User']['id'],
				);
				$body = $contents;
				$status = TRUE;
				$message = "SUCESS! Guest user has been deleted";
			}
			else
			{
				$body = NULL;
				$status = FALSE;
				$message = "Error! Guest User couldnt be deleted";
			}
			if ($saveGuestDatas = $this -> User -> saveall($data))
			{
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
				$message = Configure::read('site.remove_from_watchlist_message1');
			}
			else
			{
				$body = null;
				$status = False;
				$message = Configure::read('site.remove_from_watchlist_message2');
			}
		}
		else
		{
			$body = null;
			$status = False;
			$message = Configure::read('site.invalid_error_msg');
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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to get the details of an individual portfolio
	 */

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
			$message = Configure::read('site.portfolio_detail_message1');
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
			$ActivePortfolio = $this -> Portfolio -> setActivePortfolio($data['portfolio_id']);
			if ($ActivePortfolio)
			{
				$body['user_id'] = $data['user_id'];
				$body['access_token'] = $data['access_token'];
				$body['ActivePortfolio'] = $ActivePortfolio;
				$status = true;
				$message = Configure::read('site.set_active_portfolio_message1');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.set_active_portfolio_message2');
			}

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
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
				$message = Configure::read('site.share_detail_message1');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.share_detail_message2');
			}

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Ganesh
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for sending all the notifications
	 */
	function notification_list($data)
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			//                        $getUserCreatedDatetime =
			// $this->User->getUserCreatedDatetime($data);
			//                        if($getUserCreatedDatetime){
			//                            $data["user_created_date"] =
			// $getUserCreatedDatetime["User"]["created"];
			//                        }else{
			//                            $data["user_created_date"] = 0;
			//                        }

			$response = $this -> Notification -> getAllNotifications($data);
			$this -> User -> SaveLastAcessTimeDate($data);
			if (!empty($response))
			{
				$body = $response;
				$status = TRUE;
				$message = Configure::read('site.notification_list_message1');
			}
			else
			{
				$body = null;
				$status = FALSE;
				$message = Configure::read('site.notification_list_message2');
			}

		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Ganesh
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used for sending piggy bag notifications
	 */
	function polling_count($data = array())
	{
		if ($this -> UserLog -> checkAccessTokenValid($data))
		{
			//get user last_notification_time
			$data["last_notification_time"] = $this -> User -> getLastNotificationTime($data);
			$body['notification'] = $this -> Notification -> polling_count($data);
			$status = TRUE;
			$message = Configure::read('site.polling_count_message1');
		}
		else
		{
			$body = null;
			$status = FALSE;
			$message = Configure::read('site.invalid_error_msg');
			//"deleteaccount:Your account has been deleted from other device. Please register
			// again!!!";
		}
		return $result = array(
			'body' => $body,
			'status' => $status,
			'message' => $message
		);
	}

	/**
	 * @author Ganesh
	 * @copyright Softway solutions
	 * @param array $deviceToken and $msg
	 * @uses This function is used for sending push notifications to user
	 */
	function send_ios_notification($deviceToken, $msg)
	{
		$apnsHost = 'gateway.push.apple.com';
		//$apnsHost = 'gateway.sandbox.push.apple.com';
		//$apnsHost = 'sandbox.push.apple.com';
		$apnsPort = 2195;
		//$deviceToken =
		// '89f7268f0c4e70a8746ea8958ff092004c6b57b99fabb8fda35731a68a43fbe5';

		// PEM file location
		$apnsCert = WWW_ROOT . 'files/pemfiles/STOX.pem';

		$streamContext = stream_context_create();
		stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
		$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);

		if ($apns)
		{

			$payload = '{"aps" : { "alert" : "' . $msg . '","badge":' . 1 . ', "sound" : "default"}}';
			$messg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;

			if (fwrite($apns, $messg))
				$this -> log(Configure::read('site.send_ios_notification_message'));
			fclose($apns);
		}
	}

}
?>
