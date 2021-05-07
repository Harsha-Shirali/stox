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
        public function saveTransactionData($data){
            $this->create();
            if($data['type'] == 'trade'){
                $data['comments'] = 'Buying Trade';
            }else{
                    $data['comments'] = 'Buying Cash';
            }
            
            if($this->save($data)){
                $assets = $data['assets'];
                if($data['type'] == 'trade'){
                    $this->Portfolio->updateAll(
                                array('Portfolio.trades' =>  'Portfolio.trades + '.$assets),
                                array('Portfolio.id' => $data['portfolio_id'])
                            );
                }else{
                    $this->Portfolio->updateAll(
                                array('Portfolio.net_value' =>  'Portfolio.net_value + '.$assets),
                                array('Portfolio.id' => $data['portfolio_id'])
                            );
                }
                
                $this->Portfolio->recursive = -1;
                return $this->Portfolio->findById($data['portfolio_id'], array('Portfolio.id','Portfolio.portfolio_name','Portfolio.net_value','Portfolio.trades'));
                
            }else{
                return false;
            }
    
    }

	public function getPendingTransactions($data)
	{
		$this -> virtualFields = array('count' => 'count(Transaction.status)', );
		$options = array(
			'fields' => array('count', ),
			'conditions' => array('Transaction.portfolio_id' => $data['portfolio_id'], 'Transaction.user_id' => $data['user_id'],'Transaction.status' => 'pending'),
			'group' => array('portfolio_id', ),
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
        
        
}
