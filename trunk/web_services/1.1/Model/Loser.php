<?php

App::uses('AppModel', 'Model');

/**
 * Loser Model
 *
 */
class Loser extends AppModel {
    
    /**
     * @author Ganesh
     * @param array $data
     * @uses This function is used to store all the feed data that coming in $data array
     */
    public function saveLoserData($data = array()) {
        if (!empty($data)) {
            $this->saveAll($data);
        }
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to clear the losers table
     */
    public function deleteAllRows() {
        $this->query("TRUNCATE losers;");
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to get all the datas from losers table
     */
    public function getLosersData() {
        $fields = array(
                    'Loser.symbol', 
                    'Loser.share_id', 
                    'Loser.exchange_name', 
                    'Loser.symbol_full_name',
                    'Loser.price',
                    'Loser.day_change_price',
                    'Loser.day_change_percentage'
                );
        $data = $this->find('all', array('fields'=>$fields));
        $loserDatas = array();
        foreach ($data as $values){
            array_push($loserDatas, $values["Loser"]);
        }
        return $loserDatas;
    }

}
