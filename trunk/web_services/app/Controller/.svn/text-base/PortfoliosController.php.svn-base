<?php
App::uses('AppController', 'Controller');
/**
 * Portfolios Controller
 *
 * @property Portfolio $Portfolio
 */
class PortfoliosController extends AppController {


/**
 * Components
 *
 * @var array
 */
public $components = array('Paginator', 'Session');

/**
 * Display field
 *
 * @var string
 */
public $displayField = 'portfolio_name';



/**
 * gamemaster_index method
 *
 * @return void
 */
	public function gamemaster_index() {
		$this->Portfolio->recursive = 0;
		$conditions = array('User.role !=' =>  'Admin');
      //  $search = 'refine';
        $search = "";
        if (!empty($this->request->query)) {

            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array('Portfolio.portfolio_name LIKE' => '%' . $search . '%');
                //$search = 'Search';
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('portfolios', $this->Paginator->paginate());
        $this->set('search', $search);
		//$this->set('portfolios', $this->paginate());
	}

/**
 * gamemaster_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_view($id = null) {
		if (!$this->Portfolio->exists($id)) {
			throw new NotFoundException(__('Invalid portfolio'));
		}
		//$options = array('conditions' => array('Portfolio.' . $this->Portfolio->primaryKey => $id));
		//$this->set('portfolio', $this->Portfolio->find('first', $options));
		
		// getting all required content from database and assign to the variable $result
		$result = $this->Portfolio->find('first', array('conditions' => array('Portfolio.' . $this->Portfolio->primaryKey => $id),'contain'=>array('UserStock'=>array('Share'),'User','Game','Transaction','Watchlist'=>array('Share'))));
		// Some of the stock amount and the status is buy and assigned to $result['stock_sum']
		$this->set('portfolio', $result);
	}

/**
 * gamemaster_add method
 *
 * @return void
 */
	public function gamemaster_add() {
		if ($this->request->is('post')) {
			$this->Portfolio->create();
			if ($this->Portfolio->save($this->request->data)) {
				$this->Session->setFlash(__('The portfolio has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The portfolio could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		}
		$users = $this->Portfolio->User->find('list',array('conditions'=>array('User.role'=>'User')));
		$games = $this->Portfolio->Game->find('list');
		$this->set(compact('users', 'games'));
	}

/**
 * gamemaster_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_edit($id = null) {
		if (!$this->Portfolio->exists($id)) {
			throw new NotFoundException(__('Invalid portfolio'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Portfolio->save($this->request->data)) {
				$this->Session->setFlash(__('The portfolio has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The portfolio could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		} else {
			$options = array('conditions' => array('Portfolio.' . $this->Portfolio->primaryKey => $id));
			$this->request->data = $this->Portfolio->find('first', $options);
		}
		$users = $this->Portfolio->User->find('list',array('conditions'=>array('User.role'=>'User')));
		$games = $this->Portfolio->Game->find('list');
		$this->set(compact('users', 'games'));
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
		$this->Portfolio->id = $id;
		if (!$this->Portfolio->exists()) {
			throw new NotFoundException(__('Invalid portfolio'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Portfolio->delete()) {
			$this->Session->setFlash(__('Portfolio deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Portfolio was not deleted'),'default',array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}
        
        /*
	 * Author: Alin
	 * Description: This function is used to auto reset day trade game portfolios
	 */
        
        public function reset_daytradegame()
        {
            
            $this->layout = '';
            $response = $this->Portfolio->resetDayTrade();
            
            if($response){
                echo 'Successfull';
            }else{
                echo 'Failed';
            }
            
            exit;
            
        }
        
        /*
	 * Author: Alin
	 * Description: This function is used for auto resetting trades for portfolio game portfolios
	 */
        public function autoReset_portfolioGame()
        {
            
            $this->layout = '';
            $response = $this->Portfolio->autoResetPortfolioGame();
            
            if($response){
                echo 'Successfull';
            }else{
                echo 'Failed';
            }
            
            exit;
            
        }
}
