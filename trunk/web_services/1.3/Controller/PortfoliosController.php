<?php

App::uses('AppController', 'Controller');

/**
 * Portfolios Controller
 *
 * @property Portfolio $Portfolio
 */
class PortfoliosController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'portfolio_name';

    /**
     * gamemaster_index method
     * Admin method
     * @return void
     */
    public function gamemaster_index() {
        $this->Portfolio->recursive = 0;
        $conditions = array('User.role !=' => 'Admin');
        $search = "";
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array('Portfolio.portfolio_name LIKE' => '%' . $search . '%');
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('portfolios', $this->Paginator->paginate());
        $this->set('search', $search);
    }

    /**
     * gamemaster_view method
     * Admin method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function gamemaster_view($id = null) {
        if (!$this->Portfolio->exists($id)) {
            throw new NotFoundException(__('Invalid portfolio'));
        }
        $result = $this->Portfolio->find('first', array('conditions' => array('Portfolio.' . $this->Portfolio->primaryKey => $id), 'contain' => array('UserStock' => array('Share'), 'User', 'Game', 'Transaction', 'Watchlist' => array('Share'))));
        $this->set('portfolio', $result);
    }

    /*
     * Author: Alin
     * Description: This function is used to auto reset day trade game portfolios
     * Uses: Cron method
     */

    public function reset_daytradegame() {
        if ($_SERVER['HTTP_USER_AGENT'] == 'B10ckOut') {
            $this->layout = '';
            $response = $this->Portfolio->resetDayTrade();
            if ($response) {
                echo 'Successfull';
            } else {
                echo 'Failed';
            }
        }
        exit;
    }

    /*
     * Author: Alin
     * Description: This function is used for auto resetting trades for portfolio game portfolios
     * Uses: Cron method
     */

    public function autoReset_portfolioGame() {
        if ($_SERVER['HTTP_USER_AGENT'] == 'B10ckOut') {
            $this->layout = '';
            $response = $this->Portfolio->autoResetPortfolioGame();
            if ($response) {
                echo 'Successfull';
            } else {
                echo 'Failed';
            }
        }
        exit;
    }

    /*
     * Author: Ganesh
     * Description: This function is used for sending daily notifications to the users after 
     * finishing the daytrade game
     * Uses: Cron method
     */

    public function daytrade_notification() {
        if ($_SERVER['HTTP_USER_AGENT'] == 'B10ckOut') {
            $this->autoRender = false;
            //get all the user playing daytradegame
            $users_list = $this->Portfolio->getDayTradeUsers();
            foreach ($users_list as $dayTradeDetail) {
                //Check user is playing daytrade game
                $portfolio_id = $dayTradeDetail["Portfolio"]["id"];
                $isPortfolioExist = $this->Portfolio->UserstockHistory->getDetailsByPortfolio($portfolio_id);
                if (!empty($isPortfolioExist)) {
                    //calculate the profit and loss
                    $calc_query = $this->Portfolio->UserstockHistory->getDaytradeResult($portfolio_id);
                    $start_money = $dayTradeDetail["Portfolio"]["start_money"];
                    $net_value = $dayTradeDetail["Portfolio"]["net_value"];
                    $sum_total_shares = $calc_query[0][0]["total_price"];
                    $cal_profit_or_loss = ($net_value + $sum_total_shares) - $start_money;
                    $result = round($cal_profit_or_loss, 2);
                    $msg = "";
                    if ($result === 0) {
                        $msg = Configure::read('site.notification_equal_message');
                    } elseif ($result > 0) {
                        $config_msg = Configure::read('site.notification_profit_message');
                        $msg = str_replace("$", "$" . $result, $config_msg);
                    } elseif ($result < 0) {
                        $config_msg = Configure::read('site.notication_loss_message');
                        $msg = str_replace("$", "$" . abs($result), $config_msg);
                    }
                    //find the user logged in device
                    $user_id = $dayTradeDetail["Portfolio"]["user_id"];
                    $userDevices = $this->Portfolio->User->getPushnoteTokenByUser($user_id);
                    $this->Portfolio->sendDaytradeNotifications($userDevices, $msg);
                }
            }
        }
        exit;
    }

}
