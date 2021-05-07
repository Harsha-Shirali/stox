<?php
App::uses('AppController', 'Controller');
/**
 * Notifications Controller
 *
 * @property Notification $Notification
 */
class NotificationsController extends AppController {

/**
 * gamemaster_index method
 *
 * @return void
 */
	public function gamemaster_index() {
		$this->Notification->recursive = 0;
		$this->set('notifications', $this->paginate());
	}

/**
 * gamemaster_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function gamemaster_view($id = null) {
		if (!$this->Notification->exists($id)) {
			throw new NotFoundException(__('Invalid notification'));
		}
		$options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
		$this->set('notification', $this->Notification->find('first', $options));
	}

/**
 * gamemaster_add method
 *
 * @return void
 */
	public function gamemaster_add() {
		if ($this->request->is('post')) { 
                    $this->Notification->create();
                    if ($this->Notification->save($this->request->data)) {
                            //send notification to all the users
                            $msg = $this->request->data["Notification"]["message"];
                            $this->Notification->sendNotificationsToUsers($msg);
                            $this->Session->setFlash(__('The notification has been saved'), 'default', array('class'=>'success'));
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The notification could not be saved. Please, try again.'), 'default', array('class'=>'fail'));
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
//	public function gamemaster_edit($id = null) {
//		if (!$this->Notification->exists($id)) {
//			throw new NotFoundException(__('Invalid notification'));
//		}
//		if ($this->request->is('post') || $this->request->is('put')) {
//			if ($this->Notification->save($this->request->data)) {
//				$this->Session->setFlash(__('The notification has been saved'), 'default', array('class'=>'success'));
//				$this->redirect(array('action' => 'index'));
//			} else {
//				$this->Session->setFlash(__('The notification could not be saved. Please, try again.'), 'default', array('class'=>'fail'));
//			}
//		} else {
//			$options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
//			$this->request->data = $this->Notification->find('first', $options);
//		}
//	}

/**
 * gamemaster_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function gamemaster_delete($id = null) {
		$this->Notification->id = $id;
		if (!$this->Notification->exists()) {
			throw new NotFoundException(__('Invalid notification'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Notification->delete()) {
			$this->Session->setFlash(__('Notification deleted'), 'default', array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Notification was not deleted'), 'default', array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}

	public function debug() {
		$this->loadModel('User');
		$user = $this->User->findById($_REQUEST['id']);
		foreach ($user['UserLog'] as $values){
      if(!empty($values["push_note_token"])){
         App::import('Component', 'ApiComponent');
         $apiComponent = new ApiComponent();
         $deviceToken = $values["push_note_token"];
         if ($apiComponent->send_ios_notification($deviceToken, $_REQUEST['message'])) {
              $this->log("APPLE PUSH NOTIFICATION SEND FROM API COMPONENT");
              echo "<br /> sending to $deviceToken";
         }
      }
    }
    exit;
	}
}
