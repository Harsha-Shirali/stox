<?php

App::uses('AppModel', 'Model');

/**
 * SymbolDetail Model
 *
 */
class SymbolDetail extends AppModel {

    function saveSymbolData($data) {
        $this->create();
        $this->save($data);
    }

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

    function updateSymbolData($id, $data) {
        $this->id = $id;
        $this->save($data);
    }

}
