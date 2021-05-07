<?php

App::uses('AppController', 'Controller');

/**
 * Gainers Controller
 *
 * @property Gainer $Gainer
 */
class GainersController extends AppController {
    
    var $uses = array('Gainer', 'Share');
    /*
     * Author: Ganesh
     * Description: This function is used for storing gainers feed datas
     * Uses: cron method
     */
    function get_gainers_data() {
        if ($_SERVER['HTTP_USER_AGENT'] == 'B10ckOut') {
            date_default_timezone_set('America/New_York');
            date_default_timezone_get();
            $currenttime = date('H:i:s');
            if (($currenttime >= '09:30:00' && $currenttime <= '16:30:00')) {
                $this->autoRender = false;
                $url1 = "http://feeds.financialcontent.com/CSVQuote?Account=stox&GetMarketIndex=CHANGEPERCENT:0:NASDAQ&Count=10&Fields=TICKER,EXCHANGE,NAME,PRICE,DAYCHANGE,DAYCHANGEPERCENT&RequireSymbol=1";
                $string1 = file_get_contents($url1);
                $url2 = "http://feeds.financialcontent.com/CSVQuote?Account=stox&GetMarketIndex=CHANGEPERCENT:0:NYSE&Count=10&Fields=TICKER,EXCHANGE,NAME,PRICE,DAYCHANGE,DAYCHANGEPERCENT&RequireSymbol=1";
                $string2 = file_get_contents($url2);
                $url3 = "http://feeds.financialcontent.com/CSVQuote?Account=stox&GetMarketIndex=CHANGEPERCENT:0:OTCBB&Count=10&Fields=TICKER,EXCHANGE,NAME,PRICE,DAYCHANGE,DAYCHANGEPERCENT&RequireSymbol=1";
                $string3 = file_get_contents($url3);
                if (!empty($string1) || !empty($string2) || !empty($string3)) {
                    $this->Gainer->deleteAllRows();
                }
                if (!empty($string1)) {
                    $formatted_array1 = $this->getFormattedDataArray($string1);
                    $this->_updateGainersTable($formatted_array1);
                }
                if (!empty($string2)) {
                    $formatted_array2 = $this->getFormattedDataArray($string2);
                    $this->_updateGainersTable($formatted_array2);
                }
                if (!empty($string3)) {
                    $formatted_array3 = $this->getFormattedDataArray($string3);
                    $this->_updateGainersTable($formatted_array3);
                }
            }
        }
        exit;
    }

    /*
     * Author: Ganesh
     * Description: This function is used for replace the \ in string to &888; and explode an array
     * This function returns a formatted array to get_gainers_data() method
     * Uses: Called in get_gainers_data() method
     */
    function getFormattedDataArray($str) {
        $replaced_str = str_replace("\,", "&888;", $str);
        $data_array = explode("\n", $replaced_str);
        array_pop($data_array);
        return $data_array;
    }
    
    /*
     * Author: Ganesh
     * Description: This function is used for storing feed values to the database
     * Uses: Called in get_gainers_data() method
     */
    function _updateGainersTable($content_data) {
        $exchange_id = array("NQ"=>"1", "NY"=>"2", "OB"=>"4");
        for ($i = 0; $i < count($content_data); $i++) {
            $data_array = explode(",", $content_data[$i]);
            $data = array();
            $data['Gainer']['symbol'] = $data_array[0];
            $share_id = $this->Share->getShareId($data_array[0], $exchange_id[$data_array[1]]);
            if(empty($share_id)){
                $share_id = 0;
            }else{
                $share_id = $share_id['Share']['id'];
            }
            $data['Gainer']['share_id'] = $share_id;
            $data['Gainer']['exchange_name'] = $data_array[1];
            $data['Gainer']['symbol_full_name'] = str_replace("&888;", ",", $data_array[2]);
            $data['Gainer']['price'] = $data_array[3];
            $data['Gainer']['day_change_price'] = $data_array[4];
            $data['Gainer']['day_change_percentage'] = $data_array[5];
            $this->Gainer->saveGainerData($data);
        }
    }

}
