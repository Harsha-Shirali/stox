<?php
App::uses('AppController', 'Controller');
/**
 * WatchlistPreloads Controller
 *
 * @property WatchlistPreload $WatchlistPreload
 */
class WatchlistPreloadsController extends AppController {

public $components = array('Paginator', 'Session');

	public function gamemaster_index() {
		$this->WatchlistPreload->recursive = 0;
		
        $this->Paginator->settings = array(
            'fields' => array('WatchlistPreload.id','WatchlistPreload.share_id','Share.id','Share.symbol'),
            'limit' => 20,
            'order' => 'WatchlistPreload.id desc'
        );
        $this->set('WatchlistPreloads', $this->Paginator->paginate());
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
		$this->WatchlistPreload->id = $id;
		if (!$this->WatchlistPreload->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->WatchlistPreload->delete()) {
			$this->Session->setFlash(__('Data deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Data has not been deleted'),'default',array('class'=>'fail'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function gamemaster_add($id) {
		$shareData['WatchlistPreload']['share_id'] = $id;
		$this->WatchlistPreload->share_id = $id;
		if ($this->request->is('post')  || $this->request->is('put')) {
			$this->WatchlistPreload->create();
			if ($this->WatchlistPreload->save($shareData)) {
				$this->Session->setFlash(__('The user has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default',array('class'=>'fail'));
			}
		}
	}

	
	
}
