<?php

App::uses('AppController', 'Controller');

/**
 * SymbolDetails Controller
 *
 * @property SymbolDetail $SymbolDetail
 */
class SymbolDetailsController extends AppController {

    public $components = array(
        'Paginator',
        'Session'
    );
    var $uses = array('Share', 'Exchange', 'SymbolDetail');

    function update_symbols() {
        $this->layout = '';
        if ($this->_importSymbolFeed()) {
            $this->_updateSymbolTable();
        }
        exit;
    }

    function _importSymbolFeed() {
        set_time_limit(0);
        ini_set("memory_limit", "750M");
        ini_set("max_execution_time", "-1");
        $this->layout = null;

        $feed_url = "http://feeds.financialcontent.com/CSVQuote?Account=stox&Fields=TICKER,EXCHANGE,NAME&RequireSymbol=1";

        $fp = fopen('files/symbol_list.csv', 'wb');
        if ($fp == FALSE) {
            echo "File not opened";
            exit;
        }
        $request = curl_init($feed_url);
        curl_setopt($request, CURLOPT_FILE, $fp);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_TIMEOUT, 3000);
        curl_exec($request);
        curl_close($request);
        fclose($fp);
        return true;
    }

    function _updateSymbolTable() {
        $fcontents = file(ABS_URL . "files/symbol_list.csv");
        $exchange_list = $this->Share->Exchange->exchangeList();
        if ($fcontents) {
            for ($i = 0; $i < sizeof($fcontents); $i++) {
                $line = trim($fcontents[$i]);
                $arr = explode(",", $line);
                $arr_temp = $arr;
                if (in_array($arr_temp[1], $exchange_list)) {
                    $data = array();
                    $data['SymbolDetail']['symbol'] = $arr_temp[0];
                    $data['SymbolDetail']['exchange_name'] = $arr_temp[1];
                    if ($data['SymbolDetail']['symbol'] != '') {
                        $data['SymbolDetail']['symbol_full_name'] = NULL;

                        for ($j = 2; $j < count($arr_temp); $j++) {
                            $data['SymbolDetail']['symbol_full_name'] .= $arr_temp[$j];
                        }

                        $exist_symbol = $this->SymbolDetail->existSymbol($arr_temp[0], $arr_temp[1]);
                        if ($exist_symbol) {
                            $this->SymbolDetail->updateSymbolData($exist_symbol['SymbolDetail']['id'], $data);
                        } else {
                            $this->SymbolDetail->saveSymbolData($data);
                        }
                    }
                }
            }
        }
    }

}
