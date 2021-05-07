<?php
App::uses('AppModel', 'Model');
/**
 * UserLog Model
 *
 * @property User $User
 */
class UserLog extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'user_id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'access_token' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'device_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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
			'order' => '',
			'dependent' => true
		)
	);
        
       public function checkAccessTokenValid1($data){ 
            if(!empty($data['access_token'])){
            	
                $data = $this->find('first', array('conditions' => array(
              'UserLog.user_id' => $data['user_id'], 'UserLog.access_token' => $data['access_token'],'or' => array(
			'UserLog.status' => 'LoggedIn', 'UserLog.status' => 'Guest'))));
              if($data){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
	   
	     public function checkAccessTokenValid($data){ 
            if(!empty($data['access_token'])){
            	
                $data = $this->find('first', array('conditions' => array(
              'UserLog.user_id' => $data['user_id'], 'UserLog.access_token' => $data['access_token'])));
              if($data){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
	   
	  public function checkGuestAccess($data){
          
            	//pr($data); exit();
                $data = $this->find('first', array(
                  'fields' => array(
		'user_id',
		'access_token',
		'device_id',
	),
                
                'conditions' => array('UserLog.user_id' => $data['User']['id'])));
                if($data){
                    return $data;
                }else{
                    return false;
                }
           
        }
	   
	   function saveLoginDatas($data)
	{

		$updateData = array(
			'user_id' => $data['user_id'],
			'status' => 'LoggedIn',
			'access_token' => $data['access_token'],
		);
		$save = $this -> save($updateData);
		if ($save)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	  
	   
	   
	   
	   
}
