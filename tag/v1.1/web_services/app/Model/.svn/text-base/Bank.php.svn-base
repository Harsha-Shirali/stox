<?php
App::uses('AppModel', 'Model');
/**
 * Bank Model
 *
 */
class Bank extends AppModel {

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
		'assets' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Fields can't be empty, Please enter the assets",
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Fields can't be empty, Please select type from the list",
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'price' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				'message' => 'Please enter valid Price and it should be decimal',
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			
		),
	);


	public function getBankDatas($data) {
		$options = array(
			'fields' => array(
				'assets',
				'price',
				'type',
			)
		);
		$data = $this->find('all', $options);
		$result = Set::classicExtract($data, '{n}.Bank');
		    if ($result) {
		        return $result;
		    } else {
		            return FALSE;
		    }
	}

}
