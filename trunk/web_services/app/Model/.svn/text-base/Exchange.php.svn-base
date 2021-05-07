<?php
App::uses('AppModel', 'Model');
/**
 * Exchange Model
 *
 */
class Exchange extends AppModel {

/**
 * 
 *
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'full_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Fields can't be empty, Please add valid full name",
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'exchange_id',
			'dependent' => false,
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
        
        
	/* Author: Alin
	 * Description: this function is used to check if an exchange exist
	 */  
	 function exchangeExist($code)
	 {
		$exist_exchange = $this->find('first', array('conditions'=>array(
																		'Exchange.name' => $code
																		),
												   'recursive' => -1,
												   'fields' => array('Exchange.id', 'Exchange.name')
												));
		return $exist_exchange;
	 }
	 
	 
	 /* Author: Alin
	 * Description: this function is used for saving the data
	 */ 
	 function saveExchangeData($data){
		 $this->create();
		 $this->save($data);
		 return $this->getLastInsertID();
	 }
         
         function exchangeList()
         {
             $result = $this->find('list', array('fields'=> array('Exchange.id','Exchange.name'), 'order'=>'Exchange.id ASC', 'recursive'=>-1));
             return $result;
         }
         
}
