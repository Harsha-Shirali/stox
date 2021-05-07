<?php
App::uses('AppController', 'Controller');
/**
 * Faqs Controller
 *
 * @property Faq $Faq
 */
class FaqsController extends AppController {

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
			$this->Faq->recursive = 0;

			$conditions = array();
	      //  $search = 'refine';
	        $search = "";
	        if (!empty($this->request->query)) {


	            if (!empty($this->request->query['search'])) {
	                $search = trim($this->request->query['search']);
	                $conditions['OR'] = array('Faq.question LIKE' => '%' . $search . '%');


	                //$search = 'Search';
	            }
	        }
	        $this->Paginator->settings = array(
	            'conditions' => $conditions,
	            'limit' => 20
	        );
	        $this->set('faqs', $this->Paginator->paginate());
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
			if (!$this->Faq->exists($id)) {
				throw new NotFoundException(__('Invalid faq'));
			}
			$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
			$this->set('faq', $this->Faq->find('first', $options));
		}

	/**
	 * gamemaster_add method
	 *
	 * @return void
	 */
		public function gamemaster_add() {
			if ($this->request->is('post')) {
				$this->Faq->create();
				if ($this->Faq->save($this->request->data)) {
					$this->Session->setFlash(__('The faq has been saved'),'default', array('class'=>'success'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The faq could not be saved. Please, try again.'),'default', array('class'=>'fail'));
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
			if (!$this->Faq->exists($id)) {
				throw new NotFoundException(__('Invalid faq'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->Faq->save($this->request->data)) {
					$this->Session->setFlash(__('The faq has been saved'),'default', array('class'=>'success'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The faq could not be saved. Please, try again.'),'default', array('class'=>'fail'));
				}
			} else {
				$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
				$this->request->data = $this->Faq->find('first', $options);
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
			$this->Faq->id = $id;
			if (!$this->Faq->exists()) {
				throw new NotFoundException(__('Invalid faq'));
			}
			$this->request->onlyAllow('post', 'delete');
			if ($this->Faq->delete()) {
				$this->Session->setFlash(__('Faq deleted'),'default', array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Faq was not deleted'),'default', array('class'=>'fail'));
			$this->redirect(array('action' => 'index'));
		}







}
