<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
public $components = array('Paginator', 'Session');

	
public function beforeFilter() {
    parent::beforeFilter();
     $this->Auth->userModel = 'User';       
    $this->Auth->allow('gamemaster_login','register');
}


/**
 * gamemaster_index method
 *
 * @return void
 */
	public function gamemaster_index() {
		$this->User->recursive = 0;
		//$conditions = array('User.role' => array('User','Guest'));
                $conditions = array('User.role' => array('User'));
      //  $search = 'refine';
        $search = "";
        if (!empty($this->request->query)) {

            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array(
                						array('User.username LIKE' => '%' . $search . '%'),
										array('User.email LIKE' => '%' . $search . '%'));
                //$search = 'Search';
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'User.id desc'
        );
        $this->set('users', $this->Paginator->paginate());
        $this->set('search', $search);
		//$this->set('users', $this->paginate());
	}

/**
 * gamemaster_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		//$options = array('conditions' => array('User.' . $this->User->primaryKey => $id,'role !='=>'Admin'));
		//$this->set('user', $this->User->find('first', $options));
		$result = $this->User->find('first', array('conditions' => array('User.' . $this->User->primaryKey => $id),'contain'=>array('UserStock'=>array('Share'),'Portfolio'=>array('Game'),'UserLog')));
		//pr($result); exit;
		$this->set('user', $result);

	}

/**
 * gamemaster_add method
 *
 * @return void
 */
	public function gamemaster_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		}
	}

/**
 * gamemaster_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * gamemaster_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function gamemaster_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'),'default',array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}
        
        
    public function login()
    {
    	$this->redirect(array('gamemaster'=>'true','controller' => 'users', 'action' => 'login'));
        
    }

    public function gamemaster_login(){

    	 $this->layout='login';
         if($this->request->is('post')) {
         	$this->Auth->logout();
           if($this->Auth->login()){
           	 if($this->Auth->user('role')=='Admin'){
           	 	$this->redirect(array('controller' => 'users', 'action' => 'index'));
           	    $this->Session->setFlash('Login success');	
           	 }else{
           	 	$this->Session->setFlash('You are not authorized to access this page');
           	 	$this->redirect(array('gamemaster'=>'true','controller' => 'users', 'action' => 'logout'));	

           	 }
           }else{
               $this->Session->setFlash('login failed, Invalid username or password');
           }
                   
        }
    }

    public function logout()
    {
    	$this->redirect(array('gamemaster'=>'true','controller' => 'users', 'action' => 'logout'));
    }

    public function gamemaster_logout()
    {
    	if($this->Auth->logout()){
    		 $this->redirect(array('gamemaster'=>'true','controller' => 'users', 'action' => 'login'));
    	}
    	 
         
    }

    public function setnewpassword() {
    	$this->layout='front-end';
	if ($this->params['pass'][0]) {
	    $changePasswordSuffix = $this->params['pass'][0];
	    $decodeUrlString = base64_decode(strrev($this->params['pass'][0]));
	    $explodeTheString= explode('_', $decodeUrlString);
            $userId = $explodeTheString[0];
	    $options = array('conditions' => array('User.change_pwd_token' => $changePasswordSuffix, 'User.id' => $userId), 'fields' => array('User.id'), 'recursive' => 0);
	    $data = $this->User->find('first', $options);
		
	    if (empty($data)) {
		$this->Session->setFlash(__('Invalid URL!'));
	    } else {
	    	
		if ($this->request->is('post')) {
			
		    if ($this->request->data['User']['password'] === $this->request->data['User']['repassword']) {
			$this->request->data['User']['id'] = $userId;
			$this->request->data['User']['change_pwd_token'] = "";
			$this->request->data['User']['password'] = $this->User->authPassword(($this->request->data['User']['password']));
			if ($this->User->save($this->request->data)) {
			    unset($this->request->data);
			    $this->Session->setFlash(__('Congratulations! Your password has been changed.'));
			    //return $this->redirect(array('action' => 'index'));
			} else {
			    $this->Session->setFlash(__('Failed to change password'));
			}
		    } else {
			$this->Session->setFlash(__('Passwords do not match'));
		    }
		}
	    }
	}
    }

	public function createnewpassword() {
	if ($this->params['pass'][0]) {
	    $changePasswordSuffix = $this->params['pass'][0];
	    $decodeUrlString = base64_decode(strrev($this->params['pass'][0]));
	    $explodeTheString= explode('_', $decodeUrlString);
            $userId = $explodeTheString[0];
	    $options = array('conditions' => array('User.change_pwd_token' => $changePasswordSuffix, 'User.id' => $userId), 'fields' => array('User.id'), 'recursive' => 0);
	    $data = $this->User->find('first', $options);
		
	    if (empty($data)) {
		$this->Session->setFlash(__('Invalid URL!'));
	    } else {
	    	
		if ($this->request->is('post')) {
			
			if($this->request->data['User']['oldpassword'] == $this->User->authPassword(trim($data['password'])))
			{
		    if ($this->request->data['User']['password'] === $this->request->data['User']['repassword']) {
			$this->request->data['User']['id'] = $userId;
			$this->request->data['User']['change_pwd_token'] = "";
			$this->request->data['User']['password'] = $this->User->authPassword(md5($this->request->data['User']['password']));
			if ($this->User->save($this->request->data)) {
			    unset($this->request->data);
			    $this->Session->setFlash(__('Congratulations! Your password has been changed.'));
			    //return $this->redirect(array('action' => 'index'));
			} else {
			    $this->Session->setFlash(__('Failed to change password'));
			}
		    } else {
			$this->Session->setFlash(__('Passwords do not match'));
		    }
		}
	else {
		$this->Session->setFlash(__('Passwords do not match'));
			}
		}
		
	    }
	}
    }
    
    public function gamemaster_changepassword(){
        
        $id = $this->Auth->User('id');
        
        if ($this->request->is('post') && !empty($this->request->data)) {
            
            $loggeduserpassword = $this->User->find('first', array('conditions'=>array('User.id'=>$id), 'fields'=>array('User.password'), 'recursive'=>-1));
        
            $existingPassword = $loggeduserpassword['User']['password'];
            $oldpassword = AuthComponent::password($this->request->data['User']['old_password']);
            $newpassword = $this->request->data['User']['new_password'];
            $renewpassword = $this->request->data['User']['retype_password'];
            
            $this->User->set($this->request->data);
            
            if ($this->User->validates()) {
                
                if (!empty($renewpassword) && !empty($newpassword)) {
                    if ($oldpassword == $existingPassword) {
                        if ($newpassword == $renewpassword) {
                         
                                $changepassword['User']['id'] = $id;
                                $changepassword['User']['password'] = AuthComponent::password($this->request->data['User']['new_password']);
                              

                                if ($this->User->save($changepassword)) {
                                    $this->Session->setFlash('Your password has been changed successfully', 'default', array('class' => 'success'));                                    
                                } else {
                                    $this->Session->setFlash('Unable to change your password, Please try again later.', 'default', array('class' => 'message'));
                                }
                           
                        } else {
                            $this->Session->setFlash('New Password and Re-Type Password not match.', 'default', array('class' => 'message'));
                        }
                    } else {
                        $this->Session->setFlash('Old Password is not correct.', 'default', array('class' => 'message'));
                    }
                } else {

                    $this->Session->setFlash('Please fill all the fields', 'default', array('class' => 'message'));
                }
            } else {

                $this->Session->setFlash('Unable to change your password, Please try again later.', 'default', array('class' => 'message'));
            }
        }       
    }   
        
        
}
