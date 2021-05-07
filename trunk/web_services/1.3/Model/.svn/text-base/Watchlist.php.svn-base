<?php

App::uses('AppModel', 'Model');

/**
 * Watchlist Model
 *
 * @property Portfolio $Portfolio
 * @property Share $Share
 */
//class Watchlist extends AppModel {
//
//    //The Associations below have been created with all possible keys, those that are
//    // not needed can be removed
//    /**
//     * belongsTo associations
//     *
//     * @var array
//     */
//    public $belongsTo = array(
//        'Portfolio' => array(
//            'className' => 'Portfolio',
//            'foreignKey' => 'portfolio_id',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'dependent' => true,
//        ),
//        'Share' => array(
//            'className' => 'Share',
//            'foreignKey' => 'share_id',
//            'dependent' => true,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        )
//    );
//
//    /**
//     * @author Harsha Shirali
//     * @copyright Softway solutions
//     * @param array $data
//     * @uses This function is used to lists all the shares in watchlist of a portfolio as per $data
//     */
//    function getWatchListDatas($data) {
//        $conditions = array('Watchlist.portfolio_id' => $data['portfolio_id']);
//        if ($data['search'] != '') {
//            $conditions['Share.symbol'] = trim($data['search']);
//        }
//        $Watchlist_data = $this->find('all', array(
//            'fields' => array(
//                'share_id',
//                'portfolio_id',
//                'id'
//            ),
//            'conditions' => $conditions,
//            'contain' => array('Share' => array(
//                    'Exchange' => array('fields' => array(
//                            'Exchange.id',
//                            'Exchange.name',
//                            'Exchange.full_name'
//                        )),
//                    'fields' => array(
//                        'Share.id',
//                        'Share.last_trade_price',
//                        'Share.symbol_full_name',
//                        'Share.symbol',
//                        'Share.todays_closing_price',
//                        'Share.open_price',
//                        'Share.previous_close_price',
//                        'Share.days_high_price',
//                        'Share.days_low_price'
//                    )
//                )),
//        ));
//        $response_data = array();
//        if (!empty($Watchlist_data)) {
//            foreach ($Watchlist_data as $data) {
//                $data['Share']['watchlist_id'] = $data['Watchlist']['id'];
//                $data['Share']['exchange_id'] = $data['Share']['Exchange']['id'];
//                $data['Share']['exchange_name'] = $data['Share']['Exchange']['name'];
//                $data['Share']['exchange_full_name'] = $data['Share']['Exchange']['full_name'];
//                $data['Share']['share_id'] = $data['Share']['id'];
//                $data['Share']['full_name'] = $data['Share']['symbol_full_name'];
//                unset($data['Share']['symbol_full_name']);
//                unset($data['Share']['Exchange']);
//                unset($data['Share']['id']);
//                unset($data['Watchlist']);
//                $response_data[] = $data['Share'];
//            }
//        }
//        $result = Set::classicExtract($response_data, '{n}');
//        if ($result) {
//            return $result;
//        } else {
//            return false;
//        }
//    }
//
//    /**
//     * @author Harsha Shirali
//     * @copyright Softway solutions
//     * @param array $data
//     * @uses This function is used to save the watch-list data as per $data
//     */
//    public function saveWatchlistDatas($data) {
//        $this->create();
//        if ($this->save($data)) {
//            //find out coming profolio is normal or daytrade game
//            $conditions = array('Portfolio.id' => $data["portfolio_id"]);
//            $game_type_query = $this->Portfolio->find('first', array(
//                'conditions' => $conditions,
//                'fields' => array('Portfolio.game_id'),
//                'recursive' => -1
//            ));
//            $game_type = $game_type_query['Portfolio']['game_id'];
//            switch ($game_type) {
//                case 1:
//                    $this->getDayTradeGameAndStore($data);
//                    break;
//                case 2:
//                    $this->getDefaultProfolioAndStore($data);
//                    break;
//            }
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Ganesh
//     * @copyright Softway solutions
//     * @param array $data
//     * @uses This function is used to get the daytrade game of the user and add the same
//     * share to that daytrade game
//     */
//    public function getDayTradeGameAndStore($data) {
//        //find default portfolio
//        $conditions = array('Portfolio.game_id' => 1, 'Portfolio.user_id' => $data["user_id"]);
//        $portfolio_query = $this->Portfolio->find('first', array(
//            'conditions' => $conditions,
//            'fields' => array('Portfolio.id'),
//            'order' => array('Portfolio.created'),
//            'limit' => 1,
//            'recursive' => -1
//        ));
//        if ($portfolio_query["Portfolio"]["id"] === $data["portfolio_id"]) {
//            $day_trade_conditions = array('Portfolio.game_id' => 2, 'Portfolio.user_id' => $data["user_id"]);
//            $daytrade_query = $this->Portfolio->find('first', array(
//                'conditions' => $day_trade_conditions,
//                'fields' => array('Portfolio.id'),
//                'recursive' => -1
//            ));
//            if (!empty($daytrade_query)) {
//                $data["portfolio_id"] = $daytrade_query["Portfolio"]["id"];
//                $isShareIdExists = $this->checkShareExists($data);
//                if (empty($isShareIdExists)) {
//                    $this->create();
//                    $this->save($data);
//                }
//            }
//        }
//        return TRUE;
//    }
//
//    /**
//     * @author Ganesh
//     * @copyright Softway solutions
//     * @param array $data
//     * @uses This function is used to get the default portfolio of the user and add the same
//     * share to that portfolio
//     */
//    public function getDefaultProfolioAndStore($data) {
//        //get the default portfolio
//        $conditions = array('Portfolio.game_id' => 1, 'Portfolio.user_id' => $data["user_id"]);
//        $portfolio_query = $this->Portfolio->find('first', array(
//            'conditions' => $conditions,
//            'fields' => array('Portfolio.id'),
//            'order' => array('Portfolio.created'),
//            'limit' => 1,
//            'recursive' => -1
//        ));
//        if (!empty($portfolio_query)) {
//            $data["portfolio_id"] = $portfolio_query["Portfolio"]["id"];
//            $isShareIdExists = $this->checkShareExists($data);
//            if (empty($isShareIdExists)) {
//                $this->create();
//                $this->save($data);
//            }
//        }
//        return TRUE;
//    }
//
//    /**
//     * @author Harsha Shirali
//     * @copyright Softway solutions
//     * @param array $data
//     * @uses This function is used to check if a particular share exists in watchlist as per the $data
//     */
//    public function checkShareExists($data) {
//        $options = array(
//            'conditions' => array(
//                'portfolio_id' => $data['portfolio_id'],
//                'share_id' => $data['share_id'],
//            ),
//            'recursive' => -1
//        );
//        $data = $this->find('all', $options);
//        if ($data) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    /* Author: Alin
//     * Description: this function is used for deleting a record from the table
//     */
//
//    function deleteRecord($id) {
//        if ($this->delete($id))
//            return true;
//        else
//            return false;
//    }
//    
//    /* Author: Ganesh
//     * Description: this function is used for get share_id from watchlist based on portfolio id
//     */
//    function getWatchlistById($id) {
//        $conditions = array('Watchlist.portfolio_id' => $id);
//        $watchlist_query = $this->find('all', array(
//            'conditions' => $conditions,
//            'fields' => array('Watchlist.share_id'),
//            'recursive' => -1
//        ));
//        return $watchlist_query;
//    }
//    
//    /* Author: Ganesh
//     * Description: this function is used for delete all daytrade game watchlist which coming from $data array
//     */
//    public function deleteDayTradeGame($data) {
//        //find default portfolio
//        $conditions = array('Portfolio.game_id' => 1, 'Portfolio.user_id' => $data["user_id"]);
//        $portfolio_query = $this->Portfolio->find('first', array(
//            'conditions' => $conditions,
//            'fields' => array('Portfolio.id'),
//            'order' => array('Portfolio.created'),
//            'limit' => 1,
//            'recursive' => -1
//        ));
//        if ($portfolio_query["Portfolio"]["id"] === $data["portfolio_id"]) {
//            $day_trade_conditions = array('Portfolio.game_id' => 2, 'Portfolio.user_id' => $data["user_id"]);
//            $daytrade_query = $this->Portfolio->find('first', array(
//                'conditions' => $day_trade_conditions,
//                'fields' => array('Portfolio.id'),
//                'recursive' => -1
//            ));
//            if (!empty($daytrade_query)) {
//                $data["portfolio_id"] = $daytrade_query["Portfolio"]["id"];
//                $this->deleteAll(array('Watchlist.portfolio_id' => $daytrade_query["Portfolio"]["id"], 'Watchlist.share_id' => $data["share_id"]));
//            }
//        }
//        return TRUE;
//    }
//    
//    /* Author: Ganesh
//     * Description: this function is used for delete all default portfolio watchlist which coming from $data array
//     */
//    public function deleteDefaultProfolio($data) {
//        //get the default portfolio
//        $conditions = array('Portfolio.game_id' => 1, 'Portfolio.user_id' => $data["user_id"]);
//        $portfolio_query = $this->Portfolio->find('first', array(
//            'conditions' => $conditions,
//            'fields' => array('Portfolio.id'),
//            'order' => array('Portfolio.created'),
//            'limit' => 1,
//            'recursive' => -1
//        ));
//        if (!empty($portfolio_query)) {
//            $data["portfolio_id"] = $portfolio_query["Portfolio"]["id"];
//            $this->deleteAll(array('Watchlist.portfolio_id' => $portfolio_query["Portfolio"]["id"], 'Watchlist.share_id' => $data["share_id"]));
//        }
//        return TRUE;
//    }
//    
//    /* Author: Ganesh
//     * Description: this function is used for delete all daytrade watchlist ofthe user
//     */
//    public function deleteAllDayTradeWatchlist($data) {
//        //find default portfolio
//        $conditions = array('Portfolio.game_id' => 1, 'Portfolio.user_id' => $data["user_id"]);
//        $portfolio_query = $this->Portfolio->find('first', array(
//            'conditions' => $conditions,
//            'fields' => array('Portfolio.id'),
//            'order' => array('Portfolio.created'),
//            'limit' => 1,
//            'recursive' => -1
//        ));
//        if ($portfolio_query["Portfolio"]["id"] === $data["portfolio_id"]) {
//            $day_trade_conditions = array('Portfolio.game_id' => 2, 'Portfolio.user_id' => $data["user_id"]);
//            $daytrade_query = $this->Portfolio->find('first', array(
//                'conditions' => $day_trade_conditions,
//                'fields' => array('Portfolio.id'),
//                'recursive' => -1
//            ));
//            if (!empty($daytrade_query)) {
//                $data["portfolio_id"] = $daytrade_query["Portfolio"]["id"];
//                $this->deleteAll(array('Watchlist.portfolio_id' => $daytrade_query["Portfolio"]["id"]));
//            }
//        }
//        return TRUE;
//    }
//    
//    /* Author: Ganesh
//     * Description: this function is used for delete all default portfolio watchlist of the user
//     */
//    public function deleteAllDefaultProfolioWatchlist($data) {
//        //get the default portfolio
//        $conditions = array('Portfolio.game_id' => 1, 'Portfolio.user_id' => $data["user_id"]);
//        $portfolio_query = $this->Portfolio->find('first', array(
//            'conditions' => $conditions,
//            'fields' => array('Portfolio.id'),
//            'order' => array('Portfolio.created'),
//            'limit' => 1,
//            'recursive' => -1
//        ));
//        if (!empty($portfolio_query)) {
//            $data["portfolio_id"] = $portfolio_query["Portfolio"]["id"];
//            $this->deleteAll(array('Watchlist.portfolio_id' => $portfolio_query["Portfolio"]["id"]));
//        }
//        return TRUE;
//    }
//    
//    public function getShareIdByPortfolioId($portfolio_id){
//        $conditions = array("Watchlist.portfolio_id" => $portfolio_id);
//        $fields = array("Watchlist.portfolio_id", "Watchlist.share_id");
//        $values = $this->find("all", array("conditions" => $conditions, "fields" => $fields, "recursive" => -1));
//    
//        return $values;
//    }
//    
//    public function CheckAndStore($daytrade_portfolio_id, $share_id){
//        $conditions = array("Watchlist.portfolio_id" => $daytrade_portfolio_id, "Watchlist.share_id" => $share_id);
//        $find = $this->find('count', array("conditions" => $conditions));
//        
//        if($find == 0){
//            //store value
//            
//            $data["Watchlist"] = array();
//            $data["Watchlist"]["portfolio_id"] = $daytrade_portfolio_id;
//            $data["Watchlist"]["share_id"] = $share_id;
//            $this->create();
//            $this->save($data);
//        }
//    }
//}

class Watchlist extends AppModel {

    //The Associations below have been created with all possible keys, those that are
    // not needed can be removed
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Portfolio' => array(
            'className' => 'Portfolio',
            'foreignKey' => 'portfolio_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Share' => array(
            'className' => 'Share',
            'foreignKey' => 'share_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to lists all the shares in watchlist of a portfolio as per $data
     */

     function getWatchListDatas($data) {
        if ($data['search'] != '') {
            $conditions = array('Share.symbol like' => trim($data['search'])."%",'Watchlist.portfolio_id' => $data['portfolio_id']);
        }
		 else{
                $conditions = array('Watchlist.portfolio_id' => $data['portfolio_id']);
            }
        $Watchlist_data = $this->find('all', array(
            'fields' => array(
                'share_id',
                'portfolio_id',
                'id'
            ),
            'conditions' => $conditions,
            'contain' => array('Share' => array(
                    'Exchange' => array('fields' => array(
                            'Exchange.id',
                            'Exchange.name',
                            'Exchange.full_name'
                        )),
                    'fields' => array(
                        'Share.id',
                        'Share.last_trade_price',
                        'Share.symbol_full_name',
                        'Share.symbol',
                        'Share.todays_closing_price',
                        'Share.open_price',
                        'Share.previous_close_price',
                        'Share.days_high_price',
                        'Share.days_low_price'
                    )
                )),
        ));
        $response_data = array();
        if (!empty($Watchlist_data)) {
            foreach ($Watchlist_data as $data) {
                $data['Share']['watchlist_id'] = $data['Watchlist']['id'];
                $data['Share']['exchange_id'] = $data['Share']['Exchange']['id'];
                $data['Share']['exchange_name'] = $data['Share']['Exchange']['name'];
                $data['Share']['exchange_full_name'] = $data['Share']['Exchange']['full_name'];
                $data['Share']['share_id'] = $data['Share']['id'];
                $data['Share']['full_name'] = $data['Share']['symbol_full_name'];
                unset($data['Share']['symbol_full_name']);
                unset($data['Share']['Exchange']);
                unset($data['Share']['id']);
                unset($data['Watchlist']);
                $response_data[] = $data['Share'];
            }
        }
        $result = Set::classicExtract($response_data, '{n}');
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to save the watch-list data as per $data
     */
    public function saveWatchlistDatas($data) {
        if ($this->save($data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to check if a particular share exists in watchlist as per the $data
     */
    public function checkShareExists($data) {
        $options = array(
            'conditions' => array(
                'portfolio_id' => $data['portfolio_id'],
                'share_id' => $data['share_id'],
            ),
            'recursive' => -1
        );
        $data = $this->find('all', $options);
        if ($data) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Author: Alin
     * Description: this function is used for deleting a record from the table
     */

    function deleteRecord($id) {
        if ($this->delete($id))
            return true;
        else
            return false;
    }
    
    public function updateDaytradeId($daytrade_portfolio_id, $default_portfolio_id){
        $this->updateAll(
            array('Watchlist.portfolio_id' => $default_portfolio_id),
            array('Watchlist.portfolio_id' => $daytrade_portfolio_id)
        );
    }
    
    public function getShareIdByPfId($portfolio_id){
        $options = array(
            'conditions' => array(
                'Watchlist.portfolio_id' => $portfolio_id
            ),
            'fields'=> array(
              
              'Watchlist.share_id'  
            ),
            'recursive' => -1
        );
        $data = $this->find('all', $options);
        
        return $data;
    }
    
    public function deleteByPfIdShareId($share_id, $portfolio_id){
        $this->deleteAll(array('Watchlist.portfolio_id' => $portfolio_id, 'Watchlist.share_id' => $share_id));
    }
    
    public function updatePortfolioId($share_id, $daytrade_portfolio_id, $default_portfolio_id){
        $this->updateAll(
            array('Watchlist.portfolio_id' => $default_portfolio_id),
            array('Watchlist.share_id' => $share_id, 'Watchlist.portfolio_id' => $daytrade_portfolio_id)
        );
    }
	
	 public function checkShareExistsInWatchlist($data) {
	 	
		$this->virtualFields = array(
            'watchlist_id' => 'id',
            );
        $options = array(
        	 'fields' => array(
                'watchlist_id',
                ),
            'conditions' => array(
                'portfolio_id' => $data['portfolio_id'],
                'share_id' => $data['share_id'],
            ),
            'recursive' => -1
        );
        $data = $this->find('first', $options);
        if ($data) {
            return $data['Watchlist'];
        } else {
            return FALSE;
        }
    }
}