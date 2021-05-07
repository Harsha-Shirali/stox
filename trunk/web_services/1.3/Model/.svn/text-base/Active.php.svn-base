<?php

App::uses('AppModel', 'Model');

/**
 * Active Model
 *
 */
class Active extends AppModel {
    
    /**
     * @author Ganesh
     * @param array $data
     * @uses This function is used to store all the feed data that coming in $data array
     */
    public function saveActiveData($data = array()) {
        if (!empty($data)) {
            $this->saveAll($data);
        }
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to clear the actives table
     */
    public function deleteAllRows() {
        $this->query("TRUNCATE actives;");
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to get all the datas from actives table
     */
    public function getActivesData() {
        $fields = array(
                    'Active.symbol', 
                    'Active.share_id', 
                    'Active.exchange_name', 
                    'Active.symbol_full_name',
                    'Active.price',
                    'Active.day_change_price',
                    'Active.day_change_percentage',
                    'Active.volume',
                    'Active.dollor_volume'
                );
        $data = $this->find('all', array('fields'=>$fields));
        $activeDatas = array();
        foreach ($data as $values){
            array_push($activeDatas, $values["Active"]);
        }
        return $activeDatas;
    }

}
