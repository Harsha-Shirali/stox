<?php
App::uses('AppController', 'Controller');
/**
 * Watchlists Controller
 *
 * @property Watchlist $Watchlist
 */
class WatchlistsController extends AppController {

/**
 * Components
 *
 * @var array
 */
public $components = array('Paginator', 'Session');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Watchlist->recursive = 0;
		$conditions = '';
      //  $search = 'refine';
        $search = "";
        if (!empty($this->request->query)) {

            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array(
                						array('Watchlist.username LIKE' => '%' . $search . '%'),
										array('Watchlist.email LIKE' => '%' . $search . '%'));
                //$search = 'Search';
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('watchlists', $this->Paginator->paginate());
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
		if (!$this->Watchlist->exists($id)) {
			throw new NotFoundException(__('Invalid Watchlist'));
		}
		$options = array('conditions' => array('Watchlist.' . $this->Watchlist->primaryKey => $id));
		$this->set('watchlist', $this->Watchlist->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Watchlist->create();
			if ($this->Watchlist->save($this->request->data)) {
				$this->Session->setFlash(__('The Watchlist has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Watchlist could not be saved. Please, try again.'),'default',array('class'=>'fail'));
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
		if (!$this->Watchlist->exists($id)) {
			throw new NotFoundException(__('Invalid Watchlist'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Watchlist->save($this->request->data)) {
				$this->Session->setFlash(__('The Watchlist has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Watchlist could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		} else {
			$options = array('conditions' => array('Watchlist.' . $this->Watchlist->primaryKey => $id));
			$this->request->data = $this->Watchlist->find('first', $options);
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
		$this->Watchlist->id = $id;
		if (!$this->Watchlist->exists()) {
			throw new NotFoundException(__('Invalid Watchlist'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Watchlist->delete()) {
			$this->Session->setFlash(__('Watchlist deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Watchlist was not deleted'),'default',array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}
}
