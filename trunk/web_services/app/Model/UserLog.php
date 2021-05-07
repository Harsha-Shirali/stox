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

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to check for a valid user 
	 */
	   
	     public function checkAccessTokenValid($data){ 
//			$this->log('******START********');
//			$this->log($data);
//			$this->log('******END********');
            if(!empty($data['access_token'])){ 	
                $data = $this->find('first', array('conditions' => array(
              'UserLog.user_id' => $data['user_id'], 'UserLog.access_token' => $data['access_token'])));
              if($data){
                    return $data;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
	   
	/* commented as its related to a guest user 
	 * 
	 * public function checkGuestAccess($data){
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
           
        }*/
        
   /**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save user logs
	 */
	   
	   function saveLoginDatas($data)
	{

		$updateData = array(
			'user_id' => $data['user_id'],
			'status' => 'LoggedIn',
			'device_id' => $data['device_id'],
			'access_token' => $data['access_token'],
			'push_note_token'=> $data['push_note_token']
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
	
	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to update the access_token of the user
	 */
	  
	  	function updateUserLog($data)
	{
		$updateUserLog = $this -> updateAll(array(
			'status' => '\'LoggedOut\'',
		),array('access_token' => $data['access_token']));

		if ($updateUserLog)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
   
}
