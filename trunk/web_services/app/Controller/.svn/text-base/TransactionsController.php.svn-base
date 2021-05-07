<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 */
class TransactionsController extends AppController {



/**
 * Components
 *
 * @var array
 */
public $components = array('Paginator', 'Session');



/**
 * gamemaster_index method
 *
 * @return void
 */
	public function gamemaster_index() {
            
		$this->Transaction->recursive = 0;
		$conditions = '';
      //  $search = 'refine';
        $search = "";
        $username = true;
        $portfolio=false;
        
        
        if(isset($this->params['named']['portfolio_id'])&& $this->params['named']['portfolio_id']!=""){
            $conditions[] = array('Transaction.portfolio_id'=>$this->params['named']['portfolio_id']);
        }
        
        if (!empty($this->request->query)) {
        	$username = trim($this->request->query['username']);
            $portfolio = trim($this->request->query['portfolio']);
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                if($username!=1 && $portfolio!=1){
                	$conditions['OR'] = array('User.username LIKE' => '%' . $search . '%','Portfolio.portfolio_name LIKE' => '%' . $search . '%');
                }else{
                	if($username==1){
	                	$conditions['OR'][] = array('User.username LIKE' => '%' . $search . '%');
	                }
	                if($portfolio==1){
	                	$conditions['OR'][] = array('Portfolio.portfolio_name LIKE' => '%' . $search . '%');
	                }	
                }
                	
                //$search = 'Search';
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('transactions', $this->Paginator->paginate());
        $this->set('search', $search);
        $this->set('username', $username);
        $this->set('portfolio', $portfolio);
		//$this->set('transactions', $this->paginate());
	}

/**
 * gamemaster_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_view($id = null) {
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
		$this->set('transaction', $this->Transaction->find('first', $options));
	}

/**
 * gamemaster_add method
 *
 * @return void
 */
	public function gamemaster_add() {
		if ($this->request->is('post')) {
			$this->Transaction->create();
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		}
		$users = $this->Transaction->User->find('list',array('conditions'=>array('role'=>'User')));
		$portfolios = $this->Transaction->Portfolio->find('list',array('fields'=>array('id','portfolio_name')));
		$this->set(compact('users', 'portfolios'));
	}

/**
 * gamemaster_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_edit($id = null) {
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		} else {
			$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
			$this->request->data = $this->Transaction->find('first', $options);
		}
		$users = $this->Transaction->User->find('list',array('conditions'=>array('User.role'=>'User')));
		$portfolios = $this->Transaction->Portfolio->find('list',array('fields'=>array('id','portfolio_name')));
		$this->set(compact('users', 'portfolios'));
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
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('Transaction deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction was not deleted'),'default',array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}
}
