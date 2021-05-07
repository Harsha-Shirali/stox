<?php
App::uses('AppModel', 'Model');
/**
 * Faq Model
 *
 */
class Faq extends AppModel {

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
		'question' => array(
			/*'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'Please enter valid question',
				'allowEmpty' => false,
			    'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),*/
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Please enter question, fields can't be empty",
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'answer' => array(
			/*'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'Please enter valid answer',
				'allowEmpty' => false,
			    'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),*/
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Please enter answer, fields can't be empty",
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
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
        
/* Author: Alin
 * Description: this function is used for retriving the data
 */ 
        function getFaqDatas()
        {
        	$this->virtualFields = array(
		'faq_id' => 'Faq.id'
		
		);
            $data = $this->find('all', array('conditions'=>array('Faq.status'=>'active'),
                                             'fields' => array('faq_id','Faq.question','Faq.answer','Faq.status'),
                                             'recursive' => -1
                                            ));
            if($data){
                return $data;
            }else{
                return False;
            }
        }
}
