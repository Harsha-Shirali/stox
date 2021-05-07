<?php
App::uses('AppModel', 'Model');
/**
 * WatchlistMapping Model
 *
 */
class WatchlistMapping extends AppModel {
    
    public function isDaytradePresent($daytrade_portfolio_id){
        $conditions = array("WatchlistMapping.daytrade_portfolio_id"=>$daytrade_portfolio_id);
        $fields = array("WatchlistMapping.id", "WatchlistMapping.default_portfolio_id");
        $values = $this->find("all", array('conditions' => $conditions, 'fields' => $fields, 'recursive' => -1));
        
        return $values;        
    }
    
    public function isDefaultPresent($default_portfolio_id){
        $conditions = array("WatchlistMapping.default_portfolio_id"=>$default_portfolio_id);
        $fields = array("WatchlistMapping.id", "WatchlistMapping.daytrade_portfolio_id");
        $values = $this->find("all", array('conditions' => $conditions, 'fields' => $fields, 'recursive' => -1));
        
        return $values;        
    }
    
    public function storeMappings($data){
        $this->save($data);
    }
    
}
