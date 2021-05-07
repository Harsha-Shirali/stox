<?php

App::uses('AppController', 'Controller');

/**
 * Contacts Controller
 *
 * @property Contact $Contact
 */
class ContactsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * gamemaster_index method
     * Admin method
     * @return void
     */
    public function gamemaster_index() {
        $this->Contact->recursive = 0;
        $conditions = array();
        $search = "";
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array('Contact.subject LIKE' => '%' . $search . '%');
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('contacts', $this->Paginator->paginate());
        $this->set('search', $search);
    }

    /**
     * gamemaster_view method
     * Admin method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function gamemaster_view($id = null) {
        if (!$this->Contact->exists($id)) {
            throw new NotFoundException(__('Invalid contact'));
        }
        $options = array('conditions' => array('Contact.' . $this->Contact->primaryKey => $id));
        $this->set('contact', $this->Contact->find('first', $options));
    }

    
    /**
     * gamemaster_delete method
     * Admin method
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function gamemaster_delete($id = null) {
        $this->Contact->id = $id;
        if (!$this->Contact->exists()) {
            throw new NotFoundException(__('Invalid contact'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Contact->delete()) {
            $this->Session->setFlash(__('Contact detail deleted'), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Contact detail was not deleted'), 'default', array('class' => 'fail'));
        $this->redirect(array('action' => 'index'));
    }

}
