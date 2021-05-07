<?php
App::uses('AppController', 'Controller');
/**
 * Sharefeeds Controller
 *
 * @property Sharefeed $Sharefeed
 */
class SharefeedsController extends AppController {

    
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
    $this->_updateShareFeedsTable();   // function to update the data into the respective table
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
    
    $auth_url = "http://feeds.financialcontent.com/SnapshotV3?Account=softway-demo";
    
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
    $feed_url = "http://feeds.financialcontent.com/SnapshotV3?Account=softway-demo";
    
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
function _updateShareFeedsTable()
{    
        
    $fcontents = file(ABS_URL."files/stock_list.csv");
    //pr($fcontents); exit;
    for($i=0; $i<sizeof($fcontents); $i++) 
    {
        $line = trim($fcontents[$i]);
        $arr = explode(",", $line);
        $arr_temp = $arr;
        //pr($arr_temp);
        
        $data = array();
        $data['Sharefeed']['timestamp'] = $arr_temp[0];
        $data['Sharefeed']['symbol'] = $arr_temp[1];
        
        if($data['Sharefeed']['symbol'] !='')
        {
            $total_other_data = count($arr_temp) - 3;
            $data['Sharefeed']['last_trade_price'] = NULL;
            $data['Sharefeed']['todays_closing_price'] = NULL;
            $data['Sharefeed']['cumulative_volume'] = NULL;
            $data['Sharefeed']['last_trade_time'] = NULL;
            $data['Sharefeed']['open_price'] = NULL;
            $data['Sharefeed']['days_high_price'] = NULL;
            $data['Sharefeed']['days_low_price'] = NULL;
            $data['Sharefeed']['previous_close_price'] = NULL;
            $data['Sharefeed']['bid_price'] = NULL;
            $data['Sharefeed']['ask_price'] = NULL;
            $data['Sharefeed']['bid_size'] = NULL;
            $data['Sharefeed']['ask_size'] = NULL;
            // collecting the optional values
            //echo $total_other_data;
            for($j=3; $j<=$total_other_data; $j++)
            {
                if($arr_temp[$j] != '')
                {
                    $val_arr = explode("=", $arr_temp[$j]);
                    $val_arr[0] = trim($val_arr[0]);
                    //pr($val_arr);
                    if($val_arr[0] == 'P')
                    {
                        $data['Sharefeed']['last_trade_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'p')
                    {
                        $data['Sharefeed']['todays_closing_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'V')
                    {
                        $data['Sharefeed']['cumulative_volume'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'T')
                    {
                        $data['Sharefeed']['last_trade_time'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'O')
                    {
                        $data['Sharefeed']['open_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'H')
                    {
                        $data['Sharefeed']['days_high_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'L')
                    {
                        $data['Sharefeed']['days_low_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'C')
                    {
                        $data['Sharefeed']['previous_close_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'B')
                    {
                        $data['Sharefeed']['bid_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'A')
                    {
                        $data['Sharefeed']['ask_price'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'b')
                    {
                        $data['Sharefeed']['bid_size'] = $val_arr[1];
                    }

                    if($val_arr[0] == 'a')
                    {
                        $data['Sharefeed']['ask_size'] = $val_arr[1];
                    }


                }
            }
            //pr($data); exit;
            // check if the exchange exits. If it does not exist make entries to the database, else work on the sharefeed for the existing exchange
            $exist_exchange = $this->Sharefeed->Exchange->find('first', array('conditions'=>array(
                                                                                                    'Exchange.code' => $arr_temp[2]
                                                                                                    ),
                                                                               'recursive' => -1,
                                                                               'fields' => array('Exchange.id', 'Exchange.code')
                                                                            ));

            if($exist_exchange)
            {
                $exist_exchange_id = $exist_exchange['Exchange']['id'];
                $data['Sharefeed']['exchange_id'] = $exist_exchange_id;

                //check if the sharefeed exists for the exchange. If it exists update the data, else save directly
                $exist_feed = $this->Sharefeed->find('first', array( 'conditions' => array(
                                                                                        'Sharefeed.symbol' => $arr_temp[1],
                                                                                        'Sharefeed.exchange_id' => $exist_exchange_id
                                                                                        ),
                                                                     'fields' => array('Sharefeed.id','Sharefeed.exchange_id'),
                                                                     'recursive' =>-1
                ));

                if($exist_feed){
                    $this->Sharefeed->id = $exist_feed['Sharefeed']['id'];               
                    $this->Sharefeed->save($data);
                }else{
                    $this->Sharefeed->create();
                    $this->Sharefeed->save($data);
                }

            }
            else
            {
                $exchange_data = array();
                $exchange_data['Exchange']['code'] = $arr_temp[2];
                $this->Sharefeed->Exchange->create();
                $this->Sharefeed->Exchange->save($exchange_data);

                $last_insert_id = $this->Sharefeed->Exchange->getLastInsertID();
                $data['Sharefeed']['exchange_id'] = $last_insert_id;
                $this->Sharefeed->create();
                $this->Sharefeed->save($data);
            }
        
        }
    }
    
}


}
