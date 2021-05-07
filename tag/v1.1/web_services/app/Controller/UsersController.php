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
    $this->Auth->allow('admin_login','register');
}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$conditions = array('User.role ' =>  'User');
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
            'limit' => 20
        );
        $this->set('users', $this->Paginator->paginate());
        $this->set('search', $search);
		//$this->set('users', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
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
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
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
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
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
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
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
    	$this->redirect(array('admin'=>'true','controller' => 'users', 'action' => 'login'));
        
    }

    public function admin_login(){

    	 $this->layout='login';
         if($this->request->is('post')) {
         	$this->Auth->logout();
           if($this->Auth->login()){
           	 if($this->Auth->user('role')=='Admin'){
           	 	$this->redirect(array('controller' => 'users', 'action' => 'index'));
           	    $this->Session->setFlash('Login success');	
           	 }else{
           	 	$this->Session->setFlash('You are not authorized to access this page');
           	 	$this->redirect(array('admin'=>'true','controller' => 'users', 'action' => 'logout'));	

           	 }
           }else{
               $this->Session->setFlash('login failed, Invalid username or password');
           }
                   
        }
    }

    public function logout()
    {
    	$this->redirect(array('admin'=>'true','controller' => 'users', 'action' => 'logout'));
    }

    public function admin_logout()
    {
    	if($this->Auth->logout()){
    		 $this->redirect(array('admin'=>'true','controller' => 'users', 'action' => 'login'));
    	}
    	 
         
    }

    public function setnewpassword() {
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
        
        
        
}
