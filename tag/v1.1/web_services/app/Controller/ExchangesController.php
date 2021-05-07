<?php
App::uses('AppController', 'Controller');
/**
 * Exchanges Controller
 *
 * @property Exchange $Exchange
 */
class ExchangesController extends AppController {


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Exchange->recursive = 0;
		$this->set('exchanges', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Exchange->exists($id)) {
			throw new NotFoundException(__('Invalid exchange'));
		}
		$options = array('conditions' => array('Exchange.' . $this->Exchange->primaryKey => $id));
		$this->set('exchange', $this->Exchange->find('first', $options));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Exchange->exists($id)) {
			throw new NotFoundException(__('Invalid exchange'),'default', array('class'=>'fail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Exchange->save($this->request->data)) {
				$this->Session->setFlash(__('The exchange has been saved'),'default', array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$options = array('conditions' => array('Exchange.' . $this->Exchange->primaryKey => $id));
				$this->request->data = $this->Exchange->find('first', $options);
				$this->Session->setFlash(__('The exchange could not be saved. Please try again.'),'default', array('class'=>'fail'));
			}
		} else {
			$options = array('conditions' => array('Exchange.' . $this->Exchange->primaryKey => $id));
			$this->request->data = $this->Exchange->find('first', $options);
		}
	}


}
