<?php

App::uses('AppModel', 'Model');

/**
 * Transaction Model
 *
 * @property User $User
 * @property Portfolio $Portfolio
 */
class Transaction extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'assets';

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
        'type' => array(
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
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
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

    /* Author: Alin
     * Description: this function is used for updating trades/cash
     */

    public function saveTransactionData($data) {
        $this->create();
        if ($data['type'] == 'trade') {
            $data['comments'] = 'Buying Trade';
        } else {
            $data['comments'] = 'Buying Cash';
        }
        if ($this->save($data)) {
            $assets = $data['assets'];
            if ($data['type'] == 'trade') {
                $this->Portfolio->updateAll(
                        array('Portfolio.trades' => 'Portfolio.trades + ' . $assets, 'Portfolio.start_trade' => 'Portfolio.start_trade + ' . $assets), array('Portfolio.id' => $data['portfolio_id'])
                );
            } else {
                $this->Portfolio->updateAll(
                        array('Portfolio.net_value' => 'Portfolio.net_value + ' . $assets, 'Portfolio.start_money' => 'Portfolio.start_money + ' . $assets,), array('Portfolio.id' => $data['portfolio_id'])
                );
            }
            $this->Portfolio->recursive = -1;
            $portfolio_data = $this->Portfolio->find('first', array(
                'conditions' => array('Portfolio.id' => $data['portfolio_id']),
                'fields' => array('Portfolio.id', 'Portfolio.portfolio_name', 'Portfolio.trades', 'Portfolio.net_value', 'Portfolio.start_money'),
                'contain' => array('UserStock' => array('conditions' => array('UserStock.is_pending' => 'no', 'UserStock.status' => 'buy', 'UserStock.quantity !=' => 0), 'fields' => array('SUM(UserStock.total_amount) as total_stock_cost')))
            ));
            $result = array();
            $result['id'] = $portfolio_data['Portfolio']['id'];
            $result['portfolio_name'] = $portfolio_data['Portfolio']['portfolio_name'];
            $result['available_trades'] = $portfolio_data['Portfolio']['trades'];
            $result['available_cash'] = $portfolio_data['Portfolio']['net_value'];
            if ($portfolio_data['UserStock']) {
                $result['portfolio_worth'] = $portfolio_data['Portfolio']['net_value'] + $portfolio_data['UserStock'][0]['UserStock'][0]['total_stock_cost'];
            } else {
                $result['portfolio_worth'] = $portfolio_data['Portfolio']['net_value'];
            }
            $result['net_value_change'] = $result['portfolio_worth'] - $portfolio_data['Portfolio']['start_money'];
            return $result;
        } else {
            return false;
        }
    }

    public function getPendingTransactions($data) {
        $this->virtualFields = array('count' => 'count(Transaction.status)',);
        $options = array(
            'fields' => array('count',),
            'conditions' => array('Transaction.portfolio_id' => $data['portfolio_id'], 'Transaction.user_id' => $data['user_id'], 'Transaction.status' => 'pending'),
            'group' => array('portfolio_id',),
        );
        $data = $this->find('first', $options);
        if ($data) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
