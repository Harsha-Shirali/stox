<?php

App::uses('AppModel', 'Model');

/**
 * UserstockHistory Model
 *
 * @property UserStock $UserStock
 * @property Share $Share
 * @property User $User
 * @property Portfolio $Portfolio
 */
class UserstockHistory extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_stock_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'share_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'delta_quantity' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'price' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'portfolio_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'UserStock' => array(
            'className' => 'UserStock',
            'foreignKey' => 'user_stock_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Share' => array(
            'className' => 'Share',
            'foreignKey' => 'share_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Portfolio' => array(
            'className' => 'Portfolio',
            'foreignKey' => 'portfolio_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    function saveData($data) {
        if (isset($data['id'])) {
            unset($data['id']);
        }
        $this->id = null;
        $this->save($data);
    }

    public function getHoldings($portfolio_id) {
        $this->Portfolio->recursive = -1;
        // $portfolio = $this->Portfolio->findById($portfolio_id);
        // $portfolio = $portfolio['Portfolio'];
        // $start_money = $portfolio['start_money'];
        // $net_value = $portfolio['net_value'];
        /*
          $params = array(
          'conditions' => array(
          'UserstockHistory.portfolio_id' => $portfolio_id,
          'UserstockHistory.created <' => $start_date
          ),
          'fields' => array(
          'UserstockHistory.share_id, UserstockHistory.delta_quantity, if(delta_quantity < 0, -price, price) as delta_price'
          ),
          'recursive' => -1
          );
          $previous_transactions = $this->find('all', $params); */
        /*
          If we have to exclude the gain because of online payment, then we just have to deduct the money bought from end_price
          and we'll be able to calculate the growth. However I believe the current way of calculating the growth percentage is accurate.
          'share_id_0' => array('share_id' => '0', 'quantity' => 1, 'withdrawn' => 0, 'start_price' => $start_money, 'end_price' => $net_value)
         */
        $holdings = array();
        $total_holding = 0;
        $unique_share_id = array();
        /*
          Given that we don't know the stock price at any given point in time and that we'll always calculate from the begining,
          we will never come to the below loop and the query above will always return an empty set. Hence, I'm commenting these lines for now
         */
        /* foreach($previous_transactions as $transaction) {
          $price = $transaction[0]['delta_price'];
          $transaction = $transaction['UserstockHistory'];
          $key = 'share_id_' . $transaction['share_id'];
          if (isset($holdings[$key])) {
          $holding = &$holdings[$key];
          $holding['quantity'] += $transaction['delta_quantity'];
          $holding['start_price'] += $price;
          $total_holding += $price;
          } else {
          $holdings[$key] = array();
          $holding = &$holdings[$key];
          $holding['share_id'] = $transaction['share_id'];
          $unique_share_id[] = $holding['share_id'];
          $holding['quantity'] = $transaction['delta_quantity'];
          $holding['start_price'] = $price;
          $total_holding += $price;
          $holding['withdrawn'] = 0;
          }
          } */
        $params = array(
            'conditions' => array(
                'UserstockHistory.portfolio_id' => $portfolio_id
            ),
            'fields' => array(
                'UserstockHistory.share_id, UserstockHistory.delta_quantity, UserstockHistory.price'
            ),
            'recursive' => -1
        );
        $transactions = $this->find('all', $params);
        foreach ($transactions as $transaction) {
            $transaction = $transaction['UserstockHistory'];
            $key = 'share_id_' . $transaction['share_id'];
            if (isset($holdings[$key])) {
                $holding = &$holdings[$key];
                $holding['quantity'] += $transaction['delta_quantity'];
                if ($transaction['delta_quantity'] > 0) {
                    $total_holding += $transaction['price'];
                    $holding['start_price'] += $transaction['price'];
                } else {
                    $holding['withdrawn'] += $transaction['price'];
                }
            } else {
                $holdings[$key] = array();
                $holding = &$holdings[$key];
                $holding['share_id'] = $transaction['share_id'];
                $unique_share_id[] = $holding['share_id'];
                $holding['quantity'] = $transaction['delta_quantity'];
                if ($transaction['delta_quantity'] > 0) {
                    $total_holding += $transaction['price'];
                    $holding['start_price'] = $transaction['price'];
                    $holding['withdrawn'] = 0;
                } else {
                    // TODO: Throw error saying data is invalid and can't be possible
                }
            }
        }
        $params = array(
            'conditions' => array(
                'Share.id' => $unique_share_id
            ),
            'fields' => array('id', 'last_trade_price', 'days_high_price', 'days_low_price'),
            'recursive' => -1
        );
        $shares_raw = $this->Share->find('all', $params);
        $shares = array(/* 'share_0' => array('id' => 0, 'last_trade_price' => $holdings['share_id_0']['end_price']) */);
        foreach ($shares_raw as &$share) {
            $shares['share_' . $share['Share']['id']] = &$share['Share'];
            if ($share['Share']['last_trade_price'] == null || $share['Share']['last_trade_price'] == 0) {
                $share['Share']['last_trade_price'] = ($share['Share']['days_high_price'] + $share['Share']['days_low_price']) / 2;
            }
        }
        $shares_raw = null;
        foreach ($holdings as &$holding) {
            $share = $shares['share_' . $holding['share_id']];
            $holding['end_price'] = $holding['quantity'] * $share['last_trade_price'];
            $holding['difference'] = $holding['end_price'] + $holding['withdrawn'] - $holding['start_price'];
            $holding['sum_part'] = $holding['difference'] / $total_holding;
        }
        return $holdings;
    }

    public function getShareWorthUserStocks($portfolio_id, $share_id) {
        $holdings = $this->getHoldings($portfolio_id);
        $shares = array();
        foreach ($holdings as $key => &$holding) {
            $shares[str_replace('share_id_', '', $key)] = round($holding['difference'], 2);
            $shares[$key."_percentage"] = round($holding['difference'] / $holding['start_price'] * 100, 2) . "%";
        }
        return $shares;
    }

    public function getShareWorth($portfolio_id) {
        $holdings = $this->getHoldings($portfolio_id);
        $shares = array();
        foreach ($holdings as $key => &$holding) {
            $shares[str_replace('share_id_', '', $key)] = round($holding['difference'] / $holding['start_price'] * 100, 2) . '%';
        }
        return $shares;
    }

    /*
      Deprecating sending start and end date as we don't have data to compute with such flexibility
     */

    public function getPortfolioWorth($portfolio_id, $start_date = '', $end_date = '') {
        $holdings = $this->getHoldings($portfolio_id);
        $sum = 0;
        foreach ($holdings as &$holding) {
            $sum += $holding['sum_part'];
        }
        return round($sum * 100, 2) . '%';
    }

    public function getDetailsByPortfolio($portfolio_id) {
        $conditions = array("UserstockHistory.portfolio_id" => $portfolio_id);
        $portfolio_detail = $this->find("all", array(
            "conditions" => $conditions
        ));
        return $portfolio_detail;
    }

    public function getDaytradeResult($portfolio_id) {
        $result = $this->query("SELECT portfolio_id, SUM(total_price) as total_price FROM (SELECT portfolio_id, `share_id`, SUM(`delta_quantity`) * shares.last_trade_price as total_price FROM `userstock_histories` INNER JOIN shares on shares.id=userstock_histories.share_id and `portfolio_id`=$portfolio_id group by share_id) t group by `portfolio_id`;");
        return $result;
    }

}
