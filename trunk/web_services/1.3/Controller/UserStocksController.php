<?php

App::uses('AppController', 'Controller');

/**
 * UserStocks Controller
 *
 * @property UserStock $UserStock
 * @property sessionComponent $session
 * @property PaginatorComponent $Paginator
 */
class UserStocksController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session', 'Paginator');

    /**
     * gamemaster_index method
     * Admin method
     * @return void
     */
    public function gamemaster_index() {
        $this->UserStock->recursive = 0;
        $conditions = '';
        $search = "";
        $username = true;
        $portfolio = false;
        $share = false;
        if (isset($this->params['named']['portfolio_id']) && $this->params['named']['portfolio_id'] != "") {
            $conditions[] = array('UserStock.portfolio_id' => $this->params['named']['portfolio_id']);
        }
        if (!empty($this->request->query)) {
            $username = trim($this->request->query['username']);
            $portfolio = trim($this->request->query['portfolio']);
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                if ($username != 1 && $portfolio != 1 && $share != 1) {
                    $conditions['OR'] = array('User.username LIKE' => '%' . $search . '%', 'Portfolio.portfolio_name LIKE' => '%' . $search . '%', 'Share.symbol LIKE' => '%' . $search . '%');
                } else {
                    if ($username == 1) {
                        $conditions['OR'][] = array('User.username LIKE' => '%' . $search . '%');
                    }
                    if ($portfolio == 1) {
                        $conditions['OR'][] = array('Portfolio.portfolio_name LIKE' => '%' . $search . '%');
                    }
                    if ($share == 1) {
                        $conditions['OR'][] = array('Share.symbol LIKE' => '%' . $search . '%');
                    }
                }
            }
        }
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 20
        );
        $this->set('userStocks', $this->Paginator->paginate());
        $this->set('search', $search);
        $this->set('username', $username);
        $this->set('portfolio', $portfolio);
        $this->set('share', $share);
    }

    /**
     * gamemaster_view method
     * Admin method
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function gamemaster_view($id = null) {
        if (!$this->UserStock->exists($id)) {
            throw new NotFoundException(__('Invalid user stock'));
        }
        $options = array('conditions' => array('UserStock.' . $this->UserStock->primaryKey => $id));
        $this->set('userStock', $this->UserStock->find('first', $options));
    }

}
