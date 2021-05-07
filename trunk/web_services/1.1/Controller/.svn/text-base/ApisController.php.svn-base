<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ApisController extends AppController {

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
        'Contact',
        'Notification',
        'WatchlistPreload',
        'UserstockHistory',
        'Active',
        'Gainer',
        'Loser',
        'WatchlistMapping'
    );

    public function index() {
        if (!empty($_REQUEST['action'])) {
            switch ($_REQUEST['action']) {
                // For Normal Registration
                case 'register' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['username'] = (!empty($response['username'])) ? $response['username'] : '';
                    $data['job_title'] = (!empty($response['job_title'])) ? $response['job_title'] : '';
                    $data['email'] = (!empty($response['email'])) ? $response['email'] : '';
                    $data['password'] = (!empty($response['password'])) ? $response['password'] : '';
                    $data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
                    $data['push_note_token'] = (!empty($response['push_note_token'])) ? $response['push_note_token'] : '';
                    $data['image'] = (!empty($_REQUEST['image'])) ? $_REQUEST['image'] : '';
                    $result = $this->Api->register($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For Facebook Registration/Login
                case 'social_login' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['firstname'] = (!empty($response['firstname'])) ? $response['firstname'] : '';
                    $data['facebook_id'] = (!empty($response['facebook_id'])) ? $response['facebook_id'] : '';
                    $data['image'] = (!empty($_REQUEST['image'])) ? $_REQUEST['image'] : '';
                    $data['email'] = (!empty($response['email'])) ? $response['email'] : '';
                    $data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
                    $data['push_note_token'] = (!empty($response['push_note_token'])) ? $response['push_note_token'] : '';
                    $result = $this->Api->social_login($data);
                    $this->log($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For Login
                case 'login' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['email'] = (!empty($response['email'])) ? $response['email'] : '';
                    $data['password'] = (!empty($response['password'])) ? $response['password'] : '';
                    $data['device_type'] = (!empty($response['device_type'])) ? $response['device_type'] : '';
                    $data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
                    $data['push_note_token'] = (!empty($response['push_note_token'])) ? $response['push_note_token'] : '';
                    $result = $this->Api->login($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For Logout
                case 'logout' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
                    $result = $this->Api->logout($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For Forgot Password
                case 'forgot_password' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['userdata'] = (!empty($response['userdata'])) ? $response['userdata'] : '';
                    $result = $this->Api->forgot_password($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For Change Password
                case 'change_password' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['current_password'] = $response['current_password'];
                    $data['password'] = $response['password'];
                    $result = $this->Api->change_password($data);
                    $this->headerLayout();
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
                    $result = $this->Api->create_portfolio($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // Lists all the portfolio's of an user
                case 'portfolio_detail' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $result = $this->Api->portfolio_detail($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending the net amount of 'Game portfolio' and 'Portfolio 1 name'
                case 'show_portfolio_net_value' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
                    $result = $this->Api->show_portfolio_net_value($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For showing users list of portfolios (net amount and name of a particular
                // portfolio) and current leaders net amount and name of his portfolio
                case 'show_portfolio_list' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
                    $result = $this->Api->show_portfolio_list($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For showing the summation of the net value of all the portfolios
                case 'total_portfolio_net_value' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->total_portfolio_net_value($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For Updating(add/edit) Bio Data
                case 'bio' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['biodata'] = (!empty($response['biodata'])) ? $response['biodata'] : '';
                    $result = $this->Api->bio($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                //edit profile
                case 'edit_profile' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['image'] = (!empty($_REQUEST['image'])) ? $_REQUEST['image'] : '';
                    $data['biodata'] = (!empty($response['biodata'])) ? $response['biodata'] : '';
                    $data['job_title'] = (!empty($response['job_title'])) ? $response['job_title'] : '';
                    $result = $this->Api->edit_profile($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending list of games
                case 'game_list' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->game_list($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending list of premium games
                case 'premium_games' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->premium_games($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending share data page wise as per the search criteria
                case 'get_share_data' :
                    $response = json_decode($_REQUEST['params'], true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['page_no'] = (isset($response['page_no'])) ? $response['page_no'] : 1;
                    $data['search'] = (!empty($response['search'])) ? $response['search'] : '';
                    $data['no_of_records'] = 15;
                    $result = $this->Api->get_share_data($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For adding a share into watchlist
                case'add_watchlist' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $result = $this->Api->add_watchlist($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending the watchlist
                case 'show_watchlist' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $data['search'] = (!empty($response['search'])) ? $response['search'] : '';
                    $result = $this->Api->show_watchlist($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For guest user registration
                case 'check_guest' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
                    $result = $this->Api->check_guest($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For deleting all the existing data if user has uninstall the game and then re
                // installing it
                case 'install' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['device_id'] = (!empty($response['device_id'])) ? $response['device_id'] : '';
                    $result = $this->Api->install($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For editing profile image
                case 'upload_image' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['image'] = (!empty($_REQUEST['image'])) ? $_REQUEST['image'] : '';
                    $result = $this->Api->upload_image($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending bank data
                case 'show_bankdata' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->show_bankdata($data);
                    $this->headerLayout();
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
                    $result = $this->Api->buy_cash_trade($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For buying stocks
                case 'buy_stocks' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
                    $data['quantity'] = (!empty($response['quantity'])) ? $response['quantity'] : '';
                    $data['total_purchased_amount'] = (!empty($response['total_purchased_amount'])) ? $response['total_purchased_amount'] : '';
                    $result = $this->Api->buy_stocks($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For selling stocks
                case 'sell_stocks' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
                    $data['quantity'] = (!empty($response['quantity'])) ? $response['quantity'] : '';
                    $data['total_sold_amount'] = (!empty($response['total_sold_amount'])) ? $response['total_sold_amount'] : '';
                    $result = $this->Api->sell_stocks($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending the list of purchased stocks
                case 'user_stocks' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $result = $this->Api->user_stocks($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending the stock history
                case 'stock_history' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $result = $this->Api->stock_history($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending the list of pending stocks
                case 'pending_stocks' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $result = $this->Api->pending_stocks($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending FAQ data
                case 'faq_data' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->faq_data($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For saving feedback data
                case 'feedback_data' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['subject'] = (!empty($response['subject'])) ? $response['subject'] : '';
                    $data['comments'] = (!empty($response['comments'])) ? $response['comments'] : '';
                    $result = $this->Api->feedback_data($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For saving contact us detail
                case 'contactus_data' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['subject'] = (!empty($response['subject'])) ? $response['subject'] : '';
                    $data['queries'] = (!empty($response['queries'])) ? $response['queries'] : '';
                    $result = $this->Api->contactus_data($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For removing a share from the watch list
                case 'remove_from_watchlist' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['watchlist_id'] = (!empty($response['watchlist_id'])) ? $response['watchlist_id'] : '';
                    $result = $this->Api->remove_from_watchlist($data);
                    $this->headerLayout();
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
                    $result = $this->Api->friend_leaderboard($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For gloabal leader board
                case 'global_leaderboard' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['email'] = (!empty($response['email'])) ? $response['email'] : '';
                    $data['game_id'] = (!empty($response['game_id'])) ? $response['game_id'] : '';
                    $result = $this->Api->global_leaderboard($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For setting a portfolio active
                case 'set_active_portfolio' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $result = $this->Api->set_active_portfolio($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For setting a portfolio active
                case 'share_detail' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $data['share_id'] = (!empty($response['share_id'])) ? $response['share_id'] : '';
                    $result = $this->Api->share_detail($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For resetting portfolio
                case 'reset_portfolio' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['portfolio_id'] = (!empty($response['portfolio_id'])) ? $response['portfolio_id'] : '';
                    $result = $this->Api->reset_portfolio($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                // For sending all the notifications
                case 'notification_list' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $data['no_of_records'] = 15;
                    $data['page_no'] = (!empty($response['page_no'])) ? $response['page_no'] : 1;
                    $data['last_loaded_id'] = (!empty($response['last_loaded_id'])) ? $response['last_loaded_id'] : 0;
                    $data['top_id'] = (!empty($response['top_id'])) ? $response['top_id'] : 0;
                    $result = $this->Api->notification_list($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                //for piggy bagging notification
                case 'polling_count' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->polling_count($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                //for informative splash screen
                case 'splash_screen' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->splash_screen($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                //for sync new data
                case 'sync_data' :
                    $response = json_decode(stripslashes($_REQUEST['params']), true);
                    $data['user_id'] = (!empty($response['user_id'])) ? $response['user_id'] : '';
                    $data['access_token'] = (!empty($response['access_token'])) ? $response['access_token'] : '';
                    $result = $this->Api->sync_data($data);
                    $this->headerLayout();
                    echo json_encode($result);
                    break;
                
            }
        }
        $this->layout = "ajax";
        if (!isset($_REQUEST['stox_debug'])) {
            exit;
        }
    }

    function headerLayout() {
        @header("Pragma: no-cache");
        @header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
        @header('Content-Type: text/json');
    }

}
