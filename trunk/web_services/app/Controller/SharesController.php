<?php

App::uses('AppController', 'Controller');

/**
 * Shares Controller
 *
 * @property Share $Share
 */
class SharesController extends AppController {

    public $components = array('Paginator', 'Session');
	var $uses = array('Share','Exchange','SymbolDetail');

    var $exchange_views = array();
    /**
     * 
     *
     * @author Alin
     * @copyright Softway solutions
     * @package default
     * @uses This function is used to import the csv file data and save into the 'sharefeed' database table 
     */
    function update_stocks() {
       echo  $start_time = date('Y-m d h:i:s');
        $this->layout = '';

        if ($this->_importStockFeed()) {  // function to inport the csv data
            $this->_updateSharesTable();
        }
      echo   $end_time = date('Y-m d h:i:s');exit();
      //  $this->echo_elasped_time($end_time, $start_time);
        //echo "<br />Records Verified: " . $count;
    }

    /**
     * 
     *
     * @author Alin
     * @copyright Softway solutions
     * @package default
     * @uses This function is used to import the csv file data from the service URL 'http://feeds.financialcontent.com/SnapshotV3?Account=softway-demo'
     */
    function _importStockFeedNEW() {
        set_time_limit(0);
        ini_set("memory_limit", "1024M");
        ini_set("max_execution_time", "-1");
        $this->layout = null;
		//phpinfo();
        $feed_url = "http://feeds.financialcontent.com/SnapshotV3?Account=stox";// live URL
        
        //prepare to save response as file.
        $fp = fopen('files/stock_list.csv', 'wb');
        
        if ($fp == FALSE) {
            echo "File not opened";
            exit;
        }
       // $this->log('DATE'.time());
        //create HTTP GET request with curl
        $request = curl_init($feed_url); // initiate curl object
        curl_setopt($request, CURLOPT_FILE, $fp); //Ask cURL to write the contents to a file
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_TIMEOUT, 3000); //set timeout to 5 mins
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
       $contents= curl_exec($request); // execute curl post
       // $this->log('FILE CREATEd');
        
        curl_close($request); // close curl object
        fclose($fp); //close file;
        
        return true;
    }
     function _importStockFeedCurrent() {
        set_time_limit(0);
        ini_set("memory_limit", "750M");
        ini_set("max_execution_time", "-1");
        $this->layout = null;
  
        $feed_url = "http://feeds.financialcontent.com/SnapshotV3?Account=stox";// live URL
        
        //prepare to save response as file.
        $fp = fopen('files/stock_list.csv', 'wb');
        if ($fp == FALSE) {
            echo "File not opened";
            exit;
        }
        //create HTTP GET request with curl
        $request = curl_init($feed_url); // initiate curl object
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($request, CURLOPT_FILE, $fp); //Ask cURL to write the contents to a file
        curl_exec($request); // execute curl post
        curl_close($request); // close curl object
        fclose($fp); //close file;
        
       }
    
    
    function _importStockFeed() {
        set_time_limit(0);
        ini_set("memory_limit", "750M");
        ini_set("max_execution_time", "-1");
        $this->layout = null;
//    $auth_url = "http://feeds.financialcontent.com/SnapshotV3?Account=softway-demo";   // test URL
        $auth_url = "http://feeds.financialcontent.com/SnapshotV3?Account=stox";            // live URL
        //create HTTP POST request with curl:
        // you can find documentation on curl options at http://www.php.net/curl_setopt
        $request = curl_init($auth_url); // initiate curl object
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
//            if(ISPROXY == true){
//                    curl_setopt($ch, CURLOPT_PROXY, PROXYSERVER);
//                    curl_setopt($ch, CURLOPT_PROXYPORT, PROXYPORT);
//                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, PROXYAUTH);	
//            }
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
        $auth_ticket = curl_exec($request); // execute curl post and store results in $auth_ticket
        curl_close($request);
        //echo $auth_ticket;
        //prepare HTTP request for data
        // $feed_url = "http://feeds.financialcontent.com/SnapshotV3?Account=softway-demo";  // test URL
        $feed_url = "http://feeds.financialcontent.com/SnapshotV3?Account=stox";            // live URL
        //prepare to save response as file.
        $fp = fopen('files/stock_list.csv', 'wb');
        if ($fp == FALSE) {
            echo "File not opened";
            exit;
        }
        //create HTTP GET request with curl
        $request = curl_init($feed_url); // initiate curl object
        curl_setopt($request, CURLOPT_FILE, $fp); //Ask cURL to write the contents to a file
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_TIMEOUT, 3000); //set timeout to 5 mins
        curl_exec($request); // execute curl post
        curl_close($request); // close curl object
        fclose($fp); //close file;
        // echo "File Imported";
        return true;
    }

    function _updateSharesTable() {
        $fcontents = file(ABS_URL . "files/stock_list.csv");
        $exchange_list = $this->Share->Exchange->exchangeList();
       // $this->log(ABS_URL);
       // $this->log($fcontents );
        if ($fcontents) {
			
            for ($i = 0; $i < sizeof($fcontents); $i++) {
                $line = trim($fcontents[$i]);
                $arr = explode(",", $line);
                $arr_temp = $arr;
                if (in_array($arr_temp[2], $exchange_list)) {
                    $data = array();
                    $data['Share']['timestamp'] = $arr_temp[0];
                    $data['Share']['symbol'] = $arr_temp[1];
                    if ($data['Share']['symbol'] != '') {
                        //$total_other_data = count($arr_temp) - 3;
                        $data['Share']['last_trade_price'] = NULL;
                        $data['Share']['todays_closing_price'] = NULL;
                        $data['Share']['cumulative_volume'] = NULL;
                        $data['Share']['last_trade_time'] = NULL;
                        $data['Share']['open_price'] = NULL;
                        $data['Share']['days_high_price'] = NULL;
                        $data['Share']['days_low_price'] = NULL;
                        $data['Share']['previous_close_price'] = NULL;
                        $data['Share']['bid_price'] = NULL;
                        $data['Share']['ask_price'] = NULL;
                        $data['Share']['bid_size'] = NULL;
                        $data['Share']['ask_size'] = NULL;
                        	//$this->log("$i");
                        // collecting the optional values
                        //echo $total_other_data;
                        for ($j = 3; $j < count($arr_temp); $j++) {
                            if ($arr_temp[$j] != '') {
                                $val_arr = explode("=", $arr_temp[$j]);
                                $val_arr[0] = trim($val_arr[0]);
                                //pr($val_arr);
                                switch ($val_arr[0]) {
                                    case 'T' :
                                        $data['Share']['last_trade_time'] = $val_arr[1];
                                        break;
                                    case 'O' :
                                        $data['Share']['open_price'] = $val_arr[1];
                                        break;
                                    case 'H' :
                                        $data['Share']['days_high_price'] = $val_arr[1];
                                        break;
                                    case 'L' :
                                        $data['Share']['days_low_price'] = $val_arr[1];
                                        break;
                                    case 'C' :
                                        $data['Share']['previous_close_price'] = $val_arr[1];
                                        break;
                                    case 'B' :
                                        $data['Share']['bid_price'] = $val_arr[1];
                                        break;
                                    case 'A' :
                                        $data['Share']['ask_price'] = $val_arr[1];
                                        break;
                                    case 'b' :
                                        $data['Share']['bid_size'] = $val_arr[1];
                                        break;
                                    case 'a' :
                                        $data['Share']['ask_size'] = $val_arr[1];
                                        break;
                                    case 'P' :
                                        if (ctype_upper($val_arr[0])) {
                                            $data['Share']['last_trade_price'] = $val_arr[1];
                                        }
                                        break;
                                    case 'p' :
                                        if (ctype_lower($val_arr[0])) {
                                            $data['Share']['todays_closing_price'] = $val_arr[1];
                                        }
                                        break;
                                    case 'V' :
                                        if (ctype_upper($val_arr[0])) {
                                            $data['Share']['cumulative_volume'] = $val_arr[1];
                                        }
                                        break;
                                }
                            }
                        }
                        $exchange_key = array_search($arr_temp[2], $exchange_list);
                        $data['Share']['exchange_id'] = $exchange_key;
						
                        $exist_symbol = $this->SymbolDetail->existSymbol($arr_temp[1],$arr_temp[2]);
			
                        $data['Share']['symbol_full_name'] = "";
                        if(isset($exist_symbol['SymbolDetail'])){
                            $data['Share']['symbol_full_name'] = $exist_symbol['SymbolDetail']['symbol_full_name'];
                        }
                        //check if the share exists for the exchange. If it exists update the data, else save directly
                        $exist_share = $this->Share->existShare($arr_temp[1], $exchange_key);
                        if ($exist_share) {
							//$this->log('inside existShare');
                            $this->Share->updateShareData($exist_share['Share']['id'], $data);
                        } else {
							//$this->log('inside saveShareData');
                            $this->Share->saveShareData($data);
                        }
                    }
                }
            }
        }
    }
    
   

    /**
     * gamemaster_add method
     *
     * @return void
     */
    public function gamemaster_addpreload() {
        $this->Share->recursive = 0;
        //  $search = 'refine';
        if (!empty($this->request->query)) {
            $search = "";
            $shares = array();
            $conditions = array();
            if (!empty($this->request->query['search'])) {
                $search = trim($this->request->query['search']);
                $exchange_ids = $this->Share->Exchange->find('list', array(
                    'conditions' => array('Exchange.name LIKE' => '%' . $search . '%'),
                    'fields' => array('Exchange.id'),
                    'recursive' => -1
                ));
                // pr($exchange_ids); exit;
                $conditions[] = array('OR' => array(
                        array('Share.symbol LIKE ' => $search . '%'),
                        array('Share.exchange_id' => $exchange_ids)
                ));
                //$search = 'Search';
                $this->Paginator->settings = array(
                    'conditions' => $conditions,
                    'fields' => array('Share.id', 'Share.symbol'),
                    'limit' => 20
                );
                //$shares =  $this->Paginator->paginate(); 
                $this->set('shares', $this->Paginator->paginate());
                $this->set('search', $search);
            }
        }
    }

    public function gamemaster_add($id) {
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->WatchlistPreload->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'fail'));
            }
        }
    }

    public function gamemaster_delete($id = null) {
        $this->Game->id = $id;
        if (!$this->Game->exists()) {
            throw new NotFoundException(__('Invalid game'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Game->delete()) {
            $this->Session->setFlash(__('Game details deleted'), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Game details was not deleted'), 'default', array('class' => 'fail'));
        $this->redirect(array('action' => 'index'));
    }

    function direct_update() {
        ini_set("memory_limit", "1024M");
        ini_set("max_execution_time","-1");
        set_time_limit(0);
        $start_time = date('Y-m d h:i:s UTC');
        $database_name = $this->Share->getDataSource()->config['database'];
        $this->exchange_views = $this->Share->query('SHOW FULL TABLES IN '. $database_name .' WHERE TABLE_TYPE LIKE "VIEW";');
        foreach($this->exchange_views as &$view) {
            $view = $view['TABLE_NAMES']['Tables_in_' . $database_name];
        }
        $file = fopen(FEED_URL, 'r');
            
        $this->current_time = 0;
        $this->key_maps = array('T' => 'last_trade_time', 'O' => 'open_price', 'H' => 'days_high_price', 
                            'L' => 'days_low_price', 'C' => 'previous_close_price', 'B' => 'bid_price', 
                            'A' => 'ask_price', 'b' => 'bid_size', 'a' => 'ask_size', 'P' => 'last_trade_price',
                            'V' => 'cumulative_volume', 'p' => 'todays_closing_price');
        $exchanges = $this->Share->query('select id, name from exchanges as Exchange');
            
        $hashExchanges = array();
        foreach($exchanges as $exchange) {
            $exchange = $exchange['Exchange'];
            $hashExchanges[$exchange['name']] = $exchange['id'];
            $this->create_view($exchange['id']);
        }
            
        $count = 0;
        $updated = 0;
        $previous_result = '';
        $result = null;
        while (($result = fgets($file))) {
            $count++;
            $updated += $this->process_row($result, $hashExchanges);
        }
        fclose($file);
        $end_time = date('Y-m d h:i:s UTC');
        $this->echo_elasped_time($end_time, $start_time);
        echo "<br />Records Verified: " . $count;
        echo "<br />Records Updated: " . $updated;
    }

    private function echo_elasped_time($end_time, $start_time) {
        $difference = strtotime( $end_time ) - strtotime( $start_time );
        $result = floor( $difference / 60 ) . ':' . (floor($difference) % 60) ;
        echo "Total Time: " . $result;
    }
    
    private function process_row($row, &$exchanges) {
    	$row = explode(',', $row);
    	$data = array();
        $data['timestamp'] = $row[0];
        $data['symbol'] = $row[1];
    	$count = count($row);
    	for ($i = 3; $i < $count ; $i++) {
    		$field = explode('=', $row[$i]);
    		if(count($field) > 1 && isset($this->key_maps[$field[0]]))
    			$data[$this->key_maps[$field[0]]] = $field[1];
    	}
    	if (isset($exchanges[$row[2]])) {
    		$data['exchange_id'] = $id = $exchanges[$row[2]];
    		$symbol = $row[1];
            $share = $this->Share->query("select symbol, exchange_id, timestamp, id from shares_view_$id as Share where exchange_id=$id and symbol='$symbol' limit 1");
            if(!empty($share)) {
    			$data['id'] = $share[0]['Share']['id'];
    			if ($data['timestamp'] == $share[0]['Share']['timestamp'])
    				return 0;
    		}
    	} else {
    		$exchange = array('name'=>$row[2]);
            $exchange['name'] = $row[2];
            if ($row[2] != '' && $this->Share->Exchange->save($exchange)) {
    			$data['exchange_id'] = $this->Share->Exchange->id;
                $this->create_view($this->Share->Exchange->id);
    		}
            $exchange = null;
    	}
    	$this->Share->save($data);
        return 1;
    }

    private function create_view($view_id) {
        $view_name = 'shares_view_' . $view_id;
        if(in_array($view_name, $this->exchange_views) == false) {
            $id = $exchange['id'];
            $this->Share->query("create view shares_view_$id as select symbol, exchange_id, id, timestamp from shares where exchange_id = $id;");
            $this->exchange_views[] = $view_name;
        }
    }
}
