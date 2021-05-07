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
     * gamemaster_index method
     * Admin method
     * @return void
     */
    public function gamemaster_index() {
        $this->Watchlist->recursive = 0;
        $conditions = '';
        $search = "";
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $conditions['OR'] = array(
                    array('Watchlist.username LIKE' => '%' . $search . '%'),
                    array('Watchlist.email LIKE' => '%' . $search . '%'));
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('watchlists', $this->Paginator->paginate());
        $this->set('search', $search);
    }

    /**
     * gamemaster_add method
     * Admin method
     * @return void
     */
    public function gamemaster_add() {
        if ($this->request->is('post')) {
            $this->Watchlist->create();
            if ($this->Watchlist->save($this->request->data)) {
                $this->Session->setFlash(__('The Watchlist has been saved'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Watchlist could not be saved. Please, try again.'), 'default', array('class' => 'fail'));
            }
        }
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
        $this->Watchlist->id = $id;
        if (!$this->Watchlist->exists()) {
            throw new NotFoundException(__('Invalid Watchlist'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Watchlist->delete()) {
            $this->Session->setFlash(__('Watchlist deleted'), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Watchlist was not deleted'), 'default', array('class' => 'fail'));
        $this->redirect(array('action' => 'index'));
    }
    
    
    public function make_common_watchlist(){
        $this->autoRender = false;
        $portfolio_list = $this->Watchlist->Portfolio->getDefaultPortfolioByUser();
        foreach($portfolio_list as $default_portfolio){            
            //get watchlist of the portfolio
            $watchlists = $this->Watchlist->getShareIdByPortfolioId($default_portfolio["Portfolio"]["id"]);
            if(!empty($watchlists)){
                //find out the daytradegame of the user
                
                $daytrade_game = $this->Watchlist->Portfolio->findDayTradeGameByUserId($default_portfolio["Portfolio"]["user_id"]);
                foreach($watchlists as $watchlist){
                    if(!empty($daytrade_game)){
                    foreach($daytrade_game as $game){
                        //check and store
                        $store = $this->Watchlist->CheckAndStore($game["Portfolio"]["id"], $watchlist["Watchlist"]["share_id"]);
                        
                    }
                    
                    }
                    
                }
                //exit;
//                if(!empty($daytrade_game)){
//                    pr($daytrade_game);
//                }
            }
        }
    }
    
    public function common_watchlist_daytrade(){
        $this->autoRender = false;
    
        $data = $this->Watchlist->Portfolio->findDayTradeGameByUserId(0);
        
        pr($data);
    }

}
