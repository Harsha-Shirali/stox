<?php

App::uses('AppModel', 'Model');

/**
 * Gainer Model
 *
 */
class Gainer extends AppModel {
    
    /**
     * @author Ganesh
     * @param array $data
     * @uses This function is used to store all the feed data that coming in $data array
     */
    public function saveGainerData($data = array()) {
        if (!empty($data)) {
            $this->saveAll($data);
        }
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to clear the gainers table
     */
    public function deleteAllRows() {
        $this->query("TRUNCATE gainers;");
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to get all the datas from gainers table
     */
    public function getGainersData() {
        $fields = array(
                    'Gainer.symbol', 
                    'Gainer.share_id', 
                    'Gainer.exchange_name', 
                    'Gainer.symbol_full_name',
                    'Gainer.price',
                    'Gainer.day_change_price',
                    'Gainer.day_change_percentage'
                );
        $data = $this->find('all', array('fields'=>$fields));
        $gainersDatas = array();
        foreach ($data as $values){
            array_push($gainersDatas, $values["Gainer"]);
        }
        return $gainersDatas;
    }

}
