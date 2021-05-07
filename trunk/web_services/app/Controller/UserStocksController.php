<?php
App::uses('AppController', 'Controller');
/**
 * UserStocks Controller
 *
 * @property UserStock $UserStock
 * @property sessionComponent $session
 * @property PaginatorComponent $Paginator
 */
class UserStocksController extends AppController {


/**
 * Components
 *
 * @var array
 */
	public $components = array('Session', 'Paginator');



/**
 * gamemaster_index method
 *
 * @return void
 */
	public function gamemaster_index() {
		$this->UserStock->recursive = 0;
		$conditions = '';
      //  $search = 'refine';
        $search = "";
        $username = true;
        $portfolio=false;
        $share=false;
        
        if(isset($this->params['named']['portfolio_id'])&& $this->params['named']['portfolio_id']!=""){
            $conditions[] = array('UserStock.portfolio_id'=>$this->params['named']['portfolio_id']);
        }
        
        if (!empty($this->request->query)) {
        	$username = trim($this->request->query['username']);
            $portfolio = trim($this->request->query['portfolio']);
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                if($username!=1 && $portfolio!=1 && $share!=1){
                	$conditions['OR'] = array('User.username LIKE' => '%' . $search . '%','Portfolio.portfolio_name LIKE' => '%' . $search . '%','Share.symbol LIKE' => '%' . $search . '%');
                }else{
                	if($username==1){
	                	$conditions['OR'][] = array('User.username LIKE' => '%' . $search . '%');
	                }
	                if($portfolio==1){
	                	$conditions['OR'][] = array('Portfolio.portfolio_name LIKE' => '%' . $search . '%');
	                }	
	                if($share==1){
	                	$conditions['OR'][] = array('Share.symbol LIKE' => '%' . $search . '%');
	                }
                }
                	
                //$search = 'Search';
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('userStocks', $this->Paginator->paginate());
        $this->set('search', $search);
        $this->set('username', $username);
        $this->set('portfolio', $portfolio);
        $this->set('share', $share);

		//$this->set('userStocks', $this->paginate());
	}

/**
 * gamemaster_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_view($id = null) {
		if (!$this->UserStock->exists($id)) {
			throw new NotFoundException(__('Invalid user stock'));
		}
		$options = array('conditions' => array('UserStock.' . $this->UserStock->primaryKey => $id));
		$this->set('userStock', $this->UserStock->find('first', $options));
	}

/**
 * gamemaster_add method
 *
 * @return void
 */
	public function gamemaster_add() {
		if ($this->request->is('post')) {
			$this->UserStock->create();
			if ($this->UserStock->save($this->request->data)) {
				$this->Session->setFlash(__('The user stock has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user stock could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		}
		$users = $this->UserStock->User->find('list');
		$shares = $this->UserStock->Share->find('list');
		$portfolios = $this->UserStock->Portfolio->find('list');
		$this->set(compact('users', 'shares', 'portfolios'));
	}

/**
 * gamemaster_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_edit($id = null) {
		if (!$this->UserStock->exists($id)) {
			throw new NotFoundException(__('Invalid user stock'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->UserStock->save($this->request->data)) {
				$this->Session->setFlash(__('The user stock has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user stock could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		} else {
			$options = array('conditions' => array('UserStock.' . $this->UserStock->primaryKey => $id));
			$this->request->data = $this->UserStock->find('first', $options);
		}
		$users = $this->UserStock->User->find('list',array('conditions'=>array('role'=>'User')));
		$shares = $this->UserStock->Share->find('list',array('fields'=>array('id','symbol')));
		$portfolios = $this->UserStock->Portfolio->find('list',array('fields'=>array('id','portfolio_name')));
		$this->set(compact('users', 'shares', 'portfolios'));
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
		$this->UserStock->id = $id;
		if (!$this->UserStock->exists()) {
			throw new NotFoundException(__('Invalid user stock'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->UserStock->delete()) {
			$this->Session->setFlash(__('User stock deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User stock was not deleted'),'default',array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}
}
