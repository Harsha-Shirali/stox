<?php
App::uses('AppController', 'Controller');
/**
 * Shares Controller
 *
 * @property Share $Share
 */
class SharesController extends AppController {

    /**
* 
*
* @author Alin
* @copyright Softway solutions
* @package default
* @uses This function is used to import the csv file data and save into the 'sharefeed' database table 
*/
    
function update_stocks()
{
    $this->layout = '';
    echo date('h:i:s');
    $this->_importStockFeed();  // function to inport the csv data
    $this->_updateSharesTable();   // function to update the data into the respective table
    echo '\n'.date('h:i:s');
    echo '\nData Saved';
    exit;
}

/**
* 
*
* @author Alin
* @copyright Softway solutions
* @package default
* @uses This function is used to import the csv file data from the service URL 'http://feeds.financialcontent.com/SnapshotV3?Account=softway-demo'
*/
function _importStockFeed()
{
    set_time_limit(0);
    ini_set("memory_limit","750M");
    ini_set("max_execution_time","-1");
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
    curl_close ($request);

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
        curl_close ($request); // close curl object
        fclose($fp); //close file;
        
       // echo "File Imported";
    
}

/**
* 
*
* @author Alin
* @copyright Softway solutions
* @package default
* @uses This function is used to save the imported data to respective table.
*/
function _updateSharesTable()
{    
        
    $fcontents = file(ABS_URL."files/stock_list.csv");
    //pr($fcontents); exit;
    if($fcontents)
    {
        for($i=0; $i<sizeof($fcontents); $i++) 
        {
            $line = trim($fcontents[$i]);
            $arr = explode(",", $line);
            $arr_temp = $arr;
            //pr($arr_temp);
            $valid_exchanges = array('NQ', 'NY', 'AM', 'OB', 'OP', 'MF', 'PHL', 'PBT', 'OPRA', 'BON', 'ABO', 'DJI', 'DWI', 'IX', 'FOREX');
            if(in_array($arr_temp[2], $valid_exchanges))
            {
                $data = array();
                $data['Share']['timestamp'] = $arr_temp[0];
                $data['Share']['symbol'] = $arr_temp[1];

                if($data['Share']['symbol'] !='')
                {
                    $total_other_data = count($arr_temp) - 3;
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
                    // collecting the optional values
                    //echo $total_other_data;
                    for($j=3; $j<=$total_other_data; $j++)
                    {
                        if($arr_temp[$j] != '')
                        {
                            $val_arr = explode("=", $arr_temp[$j]);
                            $val_arr[0] = trim($val_arr[0]);
                            //pr($val_arr);
                            switch ($val_arr[0]){

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
                                    if(ctype_upper($val_arr[0])){
                                        $data['Share']['last_trade_price'] = $val_arr[1];
                                    }
                                    break;

                                case 'p' : 
                                    if(ctype_lower($val_arr[0])){
                                        $data['Share']['todays_closing_price'] = $val_arr[1];
                                    }
                                    break;

                                case 'V' :
                                    if(ctype_upper($val_arr[0])){
                                        $data['Share']['cumulative_volume'] = $val_arr[1];
                                    }
                                    break;


                            }

                        }
                    }
                    //pr($data); exit;
                    // check if the exchange exits. If it does not exist make entries to the database, else work on the sharefeed for the existing exchange
                    $exist_exchange = $this->Share->Exchange->exchangeExist($arr_temp[2]);


                    if($exist_exchange)
                    {
                        $exist_exchange_id = $exist_exchange['Exchange']['id'];
                        $data['Share']['exchange_id'] = $exist_exchange_id;

                        //check if the share exists for the exchange. If it exists update the data, else save directly
                        $exist_share = $this->Share->existShare($arr_temp[1],$exist_exchange_id);


                        if($exist_share){
                            $this->Share->updateShareData($exist_share['Share']['id'], $data);

                        }else{
                            $this->Share->saveShareData($data);
                        }

                    }
                    else
                    {
                        $exchange_data = array();
                        $exchange_data['Exchange']['name'] = $arr_temp[2];
                        $last_insert_id = $this->Share->Exchange->saveExchangeData($exchange_data); 
                        $data['Share']['exchange_id'] = $last_insert_id;
                        $this->Share->saveShareData($data);
                    }

                }
            
            }
        }
    }
    
}

function direct_update() {
	//$start_time = (new DateTime())->getTimestamp();
    $start_time = date('Y-m d h:i:s');
    ini_set("max_execution_time","-1");
	$database_name = 'stox';
	$views = $this->Share->query('SHOW FULL TABLES IN '. $database_name .' WHERE TABLE_TYPE LIKE "VIEW";');
	foreach($views as &$view) {
		$view = $view['TABLE_NAMES']['Tables_in_' . $database_name];
	}
	set_time_limit(0);
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
		$view_name = 'shares_view_' . $exchange['id'];
		if(in_array($view_name, $views) == false) {
			$id = $exchange['id'];
			$this->Share->query("create view shares_view_$id as select symbol, exchange_id, id, timestamp from shares where exchange_id = $id;");
			$views[] = $view_name;
		}
	}
	$count = 0;
	$previous_result = '';
	$result = null;
	while (($result = fread($file, 512000))) {
		$result = explode("\n", $result);
		$result[0] = $previous_result . $result[0];
		$count = count($result) - 1;
		$previous_result = $result[$count];
		for ($i = 0 ; $i < $count ; $i ++) {
			$this->parse_row($result[$i], $hashExchanges);
		}
	}
	// $row = $result[$count];
	// $this->parse_row($result[$count], $hashExchanges);
	fclose($file);
	//$end_time = (new DateTime())->getTimestamp();
        $end_time = date('Y-m d h:i:s');
	echo "total_time: " . ($end_time - $start_time);
}

private function parse_row($row, &$exchanges) {
	$row = explode(',', $row);
	$data = array();
    $data['timestamp'] = $row[0];
    $data['symbol'] = $row[1];
	$count = count($row);
	for ($i = 3; $i < $count ; $i++) {
		$field = explode('=', $row[$i]);
		if(count($field) > 1 && array_key_exists($field[0], $this->key_maps))
			$data[$this->key_maps[$field[0]]] = $field[1];
	}
	if (array_key_exists($row[2], $exchanges)) {
		$data['exchange_id'] = $id = $exchanges[$row[2]];
		$symbol = $row[1];
		$share = $this->Share->query("select symbol, exchange_id, timestamp, id from shares_view_$id as Share where exchange_id=$id and symbol='$symbol' limit 1");

		if(!empty($share)) {
			$data['id'] = $share[0]['Share']['id'];
			if ($data['timestamp'] == $share[0]['Share']['timestamp'])
				return;
		}
	} else {
		$exchange = array();
        $exchange['name'] = $row[2];
        if ($row[2] != '' && $this->Share->Exchange->save($exchange_data)) {
			$data['exchange_id'] = $id = $this->Share->Exchange->id;
			$this->Share->query("create view shares_view_$id as select symbol, exchange_id, id, timestamp from shares where exchange_id = $id;");
		}
	}
	$this->Share->save($data);
}
}
