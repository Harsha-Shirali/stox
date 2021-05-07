<?php
App::uses('AppController', 'Controller');
/**
 * Games Controller
 *
 * @property Game $Game
 */
class GamesController extends AppController {

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
		$this->Game->recursive = 0;

		$conditions = array();
      //  $search = 'refine';
        $search = "";
        if (!empty($this->request->query)) {


            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array('Game.name LIKE' => '%' . $search . '%');


                //$search = 'Search';
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('games', $this->Paginator->paginate());
        $this->set('search', $search);

	//	$this->set('banks', $this->paginate());
	}

/**
 * gamemaster_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_view($id = null) {
		if (!$this->Game->exists($id)) {
			throw new NotFoundException(__('Invalid game'));
		}
		$options = array('conditions' => array('Game.' . $this->Game->primaryKey => $id));
		$this->set('game', $this->Game->find('first', $options));
	}

/**
 * gamemaster_add method
 *
 * @return void
 */
	public function gamemaster_add() {
		if ($this->request->is('post')) {
			$this->Game->create();
			if ($this->Game->save($this->request->data)) {
				$this->Session->setFlash(__('The game details has been saved'),'default', array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The game details could not be saved. Please, try again.'),'default', array('class'=>'fail'));
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
		if (!$this->Game->exists($id)) {
			throw new NotFoundException(__('Invalid game'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Game->save($this->request->data)) {
				$this->Session->setFlash(__('The game details has been saved'),'default', array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The game details could not be saved. Please, try again.'),'default', array('class'=>'fail'));
			}
		} else {
			$options = array('conditions' => array('Game.' . $this->Game->primaryKey => $id));
			$this->request->data = $this->Game->find('first', $options);
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
		$this->Game->id = $id;
		if (!$this->Game->exists()) {
			throw new NotFoundException(__('Invalid game'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Game->delete()) {
			$this->Session->setFlash(__('Game details deleted'),'default', array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Game details was not deleted'),'default', array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}
}
