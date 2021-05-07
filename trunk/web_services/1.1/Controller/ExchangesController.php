<?php

App::uses('AppController', 'Controller');

/**
 * Exchanges Controller
 *
 * @property Exchange $Exchange
 */
class ExchangesController extends AppController {

    /**
     * gamemaster_index method
     * Admin method
     * @return void
     */
    public function gamemaster_index() {
        $this->Exchange->recursive = 0;
        $this->set('exchanges', $this->paginate());
    }

    /**
     * gamemaster_view method
     * Admin method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function gamemaster_view($id = null) {
        if (!$this->Exchange->exists($id)) {
            throw new NotFoundException(__('Invalid exchange'));
        }
        $options = array('conditions' => array('Exchange.' . $this->Exchange->primaryKey => $id));
        $this->set('exchange', $this->Exchange->find('first', $options));
    }

    /**
     * gamemaster_edit method
     * Admin method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function gamemaster_edit($id = null) {
        if (!$this->Exchange->exists($id)) {
            throw new NotFoundException(__('Invalid exchange'), 'default', array('class' => 'fail'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Exchange->save($this->request->data)) {
                $this->Session->setFlash(__('The exchange has been saved'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $options = array('conditions' => array('Exchange.' . $this->Exchange->primaryKey => $id));
                $this->request->data = $this->Exchange->find('first', $options);
                $this->Session->setFlash(__('The exchange could not be saved. Please try again.'), 'default', array('class' => 'fail'));
            }
        } else {
            $options = array('conditions' => array('Exchange.' . $this->Exchange->primaryKey => $id));
            $this->request->data = $this->Exchange->find('first', $options);
        }
    }

}
