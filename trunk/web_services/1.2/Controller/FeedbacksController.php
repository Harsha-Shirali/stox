<?php

App::uses('AppController', 'Controller');

/**
 * Feedbacks Controller
 *
 * @property Feedback $Feedback
 */
class FeedbacksController extends AppController {

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
        $this->Feedback->recursive = 0;
        $conditions = array();
        $search = "";
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array('Feedback.subject LIKE' => '%' . $search . '%');
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 10
        );
        $this->set('feedbacks', $this->Paginator->paginate());
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
        if (!$this->Feedback->exists($id)) {
            throw new NotFoundException(__('Invalid bank'));
        }
        $options = array('conditions' => array('Feedback.' . $this->Feedback->primaryKey => $id));
        $this->set('feedback', $this->Feedback->find('first', $options));
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
        $this->Feedback->id = $id;
        if (!$this->Feedback->exists()) {
            throw new NotFoundException(__('Invalid faq'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Feedback->delete()) {
            $this->Session->setFlash(__('Feedback deleted'), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Feedback was not deleted'), 'default', array('class' => 'fail'));
        $this->redirect(array('action' => 'index'));
    }

}
