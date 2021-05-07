<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ApisController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array(
		'Paginator',
		'Session',
		'Api',
		'Email'
	);
	var $uses = array(
		'User',
		'UserLog',
		'Game',
		'Share',
		'Portfolio',
		'Watchlist',
		'Bank',
		'Transaction',
		'UserStock',
		'Faq',
		'Feedback',
		'Contact'
	);

	/**
	 * index method
	 * type => estimations\users\clients\empolyees
	 * action => listing\auth\reports
	 * @return void
	 */
	public function index()
	{
		$this -> layout = "";
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			if (!empty($_REQUEST['action']))
			{
				switch ($_REQUEST['action'])
				{

					// For Normal Registration
					case 'register' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['username'] = (!empty($response['username'])) ? $response['username'] : '';
						$data['job_title'] = (!empty($response['job_title'])) ? $response['job_title'] : '';
						$data['email'] = (!empty($response['email'])) ? $response['email'] : '';
						$data['password'] = (!empty($response['password'])) ? $response['password'] : '';
						$data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
						$data['image'] = (!empty($_FILES['image'])) ? $_FILES['image'] : '';
						$result = $this -> Api -> register($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Facebook Registration/Login
					case 'social_login' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['firstname'] = (!empty($response['firstname'])) ? $response['firstname'] : '';
						$data['facebook_id'] = (!empty($response['facebook_id'])) ? $response['facebook_id'] : '';
						$data['image_link'] = (!empty($response['image_link'])) ? $response['image_link'] : '';
						$data['email'] = (!empty($response['email'])) ? $response['email'] : '';
						//$_REQUEST['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
						$result = $this -> Api -> social_login($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Login
					case 'login' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['email'] = (!empty($response['email'])) ? $response['email'] : '';
						$data['password'] = (!empty($response['password'])) ? $response['password'] : '';
						$data['device_type'] = (!empty($response['device_type'])) ? $response['device_type'] : '';
						$data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
						$result = $this -> Api -> login($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Logout
					case 'logout' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$result = $this -> Api -> logout($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Forgot Password
					case 'forgot_password' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['userdata'] = (!empty($response['userdata'])) ? $response['userdata'] : '';
						$result = $this -> Api -> forgot_password($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Change Password
					case 'change_password' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['current_password'] = $response['current_password'];
						$data['password'] = $response['password'];
						$result = $this -> Api -> change_password($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Creating Portfolio
					case 'create_portfolio' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
						$data['portfolio_name'] = (!empty($response['portfolio_name'])) ? $response['portfolio_name'] : '';
						$data['portfolio_start_money'] = (!empty($response['portfolio_start_money'])) ? $response['portfolio_start_money'] : '';
						$data['is_free'] = (!empty($response['is_free'])) ? $response['is_free'] : '';
						$result = $this -> Api -> create_portfolio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;
						
					case 'portfolio_detail' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$result = $this -> Api -> portfolio_detail($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the net amount of 'Game portfolio' and 'Portfolio 1 name'
					case 'show_portfolio_net_value' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
						$result = $this -> Api -> show_portfolio_net_value($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For showing users list of portfolios (net amount and name of a particular
					// portfolio) and current leaders net amount and name of his portfolio
					case 'show_portfolio_list' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
						$result = $this -> Api -> show_portfolio_list($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For showing the summation of the net value of all the portfolios
					case 'total_portfolio_net_value' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$result = $this -> Api -> total_portfolio_net_value($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Updating(add/edit) Bio Data
					case 'bio' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['biodata'] = (!empty($response['biodata'])) ? $response['biodata'] : '';
						$result = $this -> Api -> bio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending list of games
					case 'game_list' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';

						$result = $this -> Api -> game_list($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending list of premium games
					case 'premium_games' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$result = $this -> Api -> premium_games($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending share data page wise as per the search criteria
					case 'get_share_data' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['page_no'] = (isset($response['page_no'])) ? $response['page_no'] : 1;
						$data['search'] = (!empty($response['search'])) ? $response['search'] : '';
						$data['no_of_records'] = 15;
						$result = $this -> Api -> get_share_data($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For adding a share into watchlist
					case'add_watchlist' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$result = $this -> Api -> add_watchlist($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the watchlist
					case 'show_watchlist' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$result = $this -> Api -> show_watchlist($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For guest user registration
					case 'check_guest' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
						$result = $this -> Api -> check_guest($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For deleting all the existing data if user has uninstall the game and then re
					// installing it
					case 'install' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
						$result = $this -> Api -> install($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For editing profile image
					case 'upload_image' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						//pr($_FILES['image']);exit();
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['image'] = (!empty($_FILES['image'])) ? $_FILES['image'] : '';
						$result = $this -> Api -> upload_image($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending bank data
					case 'show_bankdata' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$result = $this -> Api -> show_bankdata($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For buying trades
					case 'buy_cash_trade' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$data['assets'] = (!empty($response['assets'])) ? $response['assets'] : '';
						$data['price_paid'] = (!empty($response['price_paid'])) ? $response['price_paid'] : '';
						$data['type'] = (!empty($response['type'])) ? $response['type'] : '';
						$result = $this -> Api -> buy_cash_trade($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;


					// For buying stocks
					case 'buying_stocks' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
						$data['quantity'] = (!empty($response['quantity'])) ? $response['quantity'] : '';
						$data['total_amount'] = (!empty($response['total_amount'])) ? $response['total_amount'] : '';
						$result = $this -> Api -> buying_stocks($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For selling stocks
					case 'sell_stocks' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
						$data['quantity'] = (!empty($response['quantity'])) ? $response['quantity'] : '';
						$data['total_amount'] = (!empty($response['total_amount'])) ? $response['total_amount'] : '';
						$result = $this -> Api -> sell_stocks($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the list of purchased stocks
					case 'user_stocks' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$result = $this -> Api -> user_stocks($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the stock history
					case 'stock_history' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$result = $this -> Api -> stock_history($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the list of pending stocks
					case 'pending_stocks' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$result = $this -> Api -> pending_stocks($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending FAQ data
					case 'faq_data' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$result = $this -> Api -> faq_data($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For saving feedback data
					case 'feedback_data' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['subject'] = (!empty($response['subject'])) ? $response['subject'] : '';
						$data['comments'] = (!empty($response['comments'])) ? $response['comments'] : '';
						$result = $this -> Api -> feedback_data($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For saving contact us detail
					case 'contactus_data' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['subject'] = (!empty($response['subject'])) ? $response['subject'] : '';
						$data['queries'] = (!empty($response['queries'])) ? $response['queries'] : '';
						$result = $this -> Api -> contactus_data($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For removing a share from the watch list
					case 'remove_from_watchlist' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['watchlist_id'] = (!empty($response['watchlist_id'])) ? $response['watchlist_id'] : '';
						$result = $this -> Api -> remove_from_watchlist($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For friend leader board
					case 'friend_leaderboard' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                                                $data['email'] = (!empty($response['email'])) ? $response['email'] : '';
                                                $data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
						$data['facebook_friends'] = (!empty($response['facebook_friends'])) ? $response['facebook_friends'] : '';
						$result = $this -> Api -> friend_leaderboard($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;
                                            
                                        // For gloabal leader board
					case 'global_leaderboard' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                                                $data['email'] = (!empty($response['email'])) ? $response['email'] : '';
                                                $data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
						$result = $this -> Api -> global_leaderboard($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;
                                            
                                        // For setting a portfolio active
					case 'set_active_portfolio' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                                                $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
						$result = $this -> Api -> set_active_portfolio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;    
                                            
                                        // For setting a portfolio active
					case 'share_detail' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                                                $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                                                $data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
						$result = $this -> Api -> share_detail($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;    
				}
			}

		}

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			if (!empty($_REQUEST['action']))
			{
				switch ($_REQUEST['action'])
				{

					// For Normal Registration
					case 'register' :
						$data['username'] = (!empty($_REQUEST['username'])) ? $_REQUEST['username'] : '';
						$data['job_title'] = (!empty($_REQUEST['job_title'])) ? $_REQUEST['job_title'] : '';
						$data['email'] = (!empty($_REQUEST['email'])) ? $_REQUEST['email'] : '';
						$data['password'] = (!empty($_REQUEST['password'])) ? $_REQUEST['password'] : '';
						$data['device_id'] = (!empty($_REQUEST['device_id'])) ? $_REQUEST['device_id'] : '';
						$result = $this -> Api -> register($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Facebook Registration/Login
					case 'social_login' :
						$data['firstname'] = (!empty($_REQUEST['firstname'])) ? $_REQUEST['firstname'] : '';
						$data['facebook_id'] = (!empty($_REQUEST['facebook_id'])) ? $_REQUEST['facebook_id'] : '';
						$data['email'] = (!empty($_REQUEST['email'])) ? $_REQUEST['email'] : '';
						$data['image_link'] = (!empty($response['image_link'])) ? $response['image_link'] : '';
						$data['device_id'] = (!empty($_REQUEST['device_id'])) ? $_REQUEST['device_id'] : '';
						$result = $this -> Api -> social_login($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Login
					case 'login' :
						$data['device_type'] = (!empty($_REQUEST['device_type'])) ? $_REQUEST['device_type'] : '';
						$data['email'] = (!empty($_REQUEST['email'])) ? $_REQUEST['email'] : '';
						$data['device_id'] = (!empty($_REQUEST['device_id'])) ? $_REQUEST['device_id'] : '';
						$data['password'] = (!empty($_REQUEST['password'])) ? $_REQUEST['password'] : '';
						$result = $this -> Api -> login($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Logout
					case 'logout' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> logout($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Forgot Password
					case 'forgot_password' :
						$data['userdata'] = (!empty($_REQUEST['userdata'])) ? $_REQUEST['userdata'] : '';
						$result = $this -> Api -> forgot_password($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For Change Password
					case 'change_password' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['current_password'] = $_REQUEST['current_password'];
						$data['password'] = $_REQUEST['password'];
						$result = $this -> Api -> change_password($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For updating Bio data
					case 'bio' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['biodata'] = (!empty($_REQUEST['biodata'])) ? $_REQUEST['biodata'] : '';
						$result = $this -> Api -> bio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For creating Portfolio
					case 'portfolio' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['game_id'] = (!empty($_REQUEST['game_id'])) ? $_REQUEST['game_id'] : '';
						$data['portfolio_name'] = (!empty($_REQUEST['portfolio_name'])) ? $_REQUEST['portfolio_name'] : '';
						$data['portfolio_start_money'] = (!empty($_REQUEST['portfolio_start_money'])) ? $_REQUEST['portfolio_start_money'] : '';
						$data['price'] = (!empty($_REQUEST['price'])) ? $_REQUEST['price'] : '';
						$result = $this -> Api -> portfolio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;
						
					case 'individual_portfolio' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['game_id'] = (!empty($_REQUEST['game_id'])) ? $_REQUEST['game_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$result = $this -> Api -> individual_portfolio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For showing the net amount of 'Game portfolio' and 'Portfolio 1 name'
					case 'show_portfolio_net_value' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> show_portfolio_net_value($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For showing users list of portfolios (net amount and name of a particular
					// portfolio) and current leaders net amount and name of his portfolio
					case 'show_portfolio_list' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> show_portfolio_list($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For showing the summation of the net value of all the portfolios
					case 'total_portfolio_net_value' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> total_portfolio_net_value($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For adding a share into watchlist
					case 'add_watchlist' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['share_id'] = (!empty($_REQUEST['share_id'])) ? $_REQUEST['share_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$result = $this -> Api -> add_watchlist($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For showing the list of shares in the watch list
					case 'show_watchlist' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';

						$result = $this -> Api -> show_watchlist($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For resetting the portfolio
					case 'reset_portfolio' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['game_id'] = (!empty($_REQUEST['game_id'])) ? $_REQUEST['game_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> reset_portfolio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the list of games
					case 'game_list' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> game_list($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For listing the premiun games
					case 'premium_games' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> premium_games($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the share data pages wise as per the search criteria
					case 'get_share_data' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['page_no'] = (!empty($_REQUEST['page_no'])) ? $_REQUEST['page_no'] : 1;
						$data['search'] = (!empty($_REQUEST['search'])) ? $_REQUEST['search'] : '';
						$data['no_of_records'] = 15;
						$result = $this -> Api -> get_share_data($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the bank data
					case 'show_bankdata' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
						$data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
						$result = $this -> Api -> show_bankdata($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For buying trades
					case 'buy_cash_trade' :
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$data['assets'] = (!empty($_REQUEST['assets'])) ? $_REQUEST['assets'] : '';
						$data['price_paid'] = (!empty($_REQUEST['price_paid'])) ? $_REQUEST['price_paid'] : '';
						$data['type'] = (!empty($_REQUEST['type'])) ? $_REQUEST['type'] : '';
						$result = $this -> Api -> buy_cash_trade($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;


					// For editing profile image
					case 'upload_image' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['image'] = (!empty($_FILES['image'])) ? $_FILES['image'] : '';
						$result = $this -> Api -> upload_image($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For guest user registration
					case 'check_guest' :
						$response = json_decode(stripslashes($_REQUEST['params']), true);
						$data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
						$result = $this -> Api -> check_guest($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For buying stocks
					case 'buying_stocks' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['game_id'] = (!empty($_REQUEST['game_id'])) ? $_REQUEST['game_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$data['share_id'] = (!empty($_REQUEST['share_id'])) ? $_REQUEST['share_id'] : '';
						$data['quantity'] = (!empty($_REQUEST['quantity'])) ? $_REQUEST['quantity'] : '';
						$data['total_amount'] = (!empty($_REQUEST['total_amount'])) ? $_REQUEST['total_amount'] : '';
						$result = $this -> Api -> buying_stocks($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the list of purchased stocks
					case 'user_stocks' :
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$result = $this -> Api -> user_stocks($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending stock history
					case 'stock_history' :
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$result = $this -> Api -> stock_history($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the list of pending stocks
					case 'pending_stocks' :
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$result = $this -> Api -> pending_stocks($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For sending the FAQ data
					case 'faq_data' :
						$_REQUEST['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$_REQUEST['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$result = $this -> Api -> faq_data($_REQUEST);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For saving feedback data
					case 'feedback_data' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['subject'] = (!empty($_REQUEST['subject'])) ? $_REQUEST['subject'] : '';
						$data['comments'] = (!empty($_REQUEST['comments'])) ? $_REQUEST['comments'] : '';
						$result = $this -> Api -> feedback_data($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For saving contact us data
					case 'contactus_data' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['subject'] = (!empty($_REQUEST['subject'])) ? $_REQUEST['subject'] : '';
						$data['queries'] = (!empty($_REQUEST['queries'])) ? $_REQUEST['queries'] : '';
						$result = $this -> Api -> contactus_data($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For removing a share from watch list
					case 'remove_from_watchlist' :
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['watchlist_id'] = (!empty($_REQUEST['watchlist_id'])) ? $_REQUEST['watchlist_id'] : '';
						$result = $this -> Api -> remove_from_watchlist($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;

					// For friend leader board
					case 'friend_leaderboard' :
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
                                                $data['email'] = (!empty($_REQUEST['email'])) ? $_REQUEST['email'] : '';
                                                $data['game_id'] = (!empty($_REQUEST['game_id'])) ? $_REQUEST['game_id'] : '';
						$data['facebook_friends'] = (!empty($_REQUEST['facebook_friends'])) ? $_REQUEST['facebook_friends'] : '';
						$result = $this -> Api -> friend_leaderboard($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;
                                            
                                         // For friend leader board
					case 'global_leaderboard' :
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
                                                $data['email'] = (!empty($_REQUEST['email'])) ? $_REQUEST['email'] : '';
                                                $data['game_id'] = (!empty($_REQUEST['game_id'])) ? $_REQUEST['game_id'] : '';
						$result = $this -> Api -> global_leaderboard($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;
                                            
                                       // For setting a portfolio active
					case 'set_active_portfolio' :
						$data['access_token'] = (!empty($_REQUEST['access_token'])) ? $_REQUEST['access_token'] : '';
						$data['user_id'] = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
                                                $data['portfolio_id'] = (!empty($_REQUEST['portfolio_id'])) ? $_REQUEST['portfolio_id'] : '';
						$result = $this -> Api -> set_active_portfolio($data);
						$this -> headerLayout();
						echo json_encode($result);
						break;     
				}
			}
		}
		exit ;
	}

	function headerLayout()
	{
		@header("Pragma: no-cache");
		@header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
		@header('Content-Type: text/json');
	}

}
