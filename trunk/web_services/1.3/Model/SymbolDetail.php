<?php

App::uses('AppModel', 'Model');

/**
 * SymbolDetail Model
 *
 */
class SymbolDetail extends AppModel {
    
    /*
     * Author: Alin
     * Description: This function is used to save the data in database table
     */
    function saveSymbolData($data) {
        $this->create();
        $this->save($data);
    }
    
    /*
     * Author: Alin
     * Description: This function is used to find the symbol is present or not 
     */
    function existSymbol($symbol, $exchange_id) {
        $exist_symbol = $this->find('first', array(
            'conditions' => array(
                'SymbolDetail.symbol' => $symbol,
                'SymbolDetail.exchange_name' => $exchange_id
            ),
            'fields' => array(
                'SymbolDetail.id',
                'SymbolDetail.exchange_name',
                'SymbolDetail.symbol_full_name'
            ),
            'recursive' => -1
        ));
        return $exist_symbol;
    }
    
    /*
     * Author: Alin
     * Description: This function is used to update the symbol data
     */
    function updateSymbolData($id, $data) {
        $this->id = $id;
        $this->save($data);
    }

}
