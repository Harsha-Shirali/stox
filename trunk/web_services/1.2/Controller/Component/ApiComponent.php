<?php

class ApiComponent extends Object {

    function initialize(Controller $controller) {
        
    }

    function beforeRender($controller) {
        
    }

    function beforeRedirect($controller) {
        
    }

    function shutdown($controller) {
        
    }

    function startup($controller) {
        App::uses('Component', 'Auth', 'Email');
        $this->Auth = $controller->Auth;
        $this->Session = $controller->Session;
        $this->User = $controller->User;
        $this->UserLog = $controller->UserLog;
        $this->Game = $controller->Game;
        $this->Portfolio = $controller->Portfolio;
        $this->Share = $controller->Share;
        $this->Bank = $controller->Bank;
        $this->Watchlist = $controller->Watchlist;
        $this->Transaction = $controller->Transaction;
        $this->UserStock = $controller->UserStock;
        $this->Faq = $controller->Faq;
        $this->Feedback = $controller->Feedback;
        $this->Contact = $controller->Contact;
        $this->Notification = $controller->Notification;
        $this->WatchlistPreload = $controller->WatchlistPreload;
        $this->UserstockHistory = $controller->UserstockHistory;
        $this->Active = $controller->Active;
        $this->Gainer = $controller->Gainer;
        $this->Loser = $controller->Loser;
        $this->WatchlistMapping = $controller->WatchlistMapping;
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for login as per $data and the User log will
     * be maintained for successful login
     * web service method
     */
    function login($data = array()) {
        @session_start();
        if (!empty($data['email']) && !empty($data['password'])) {
            $isAuthenticatedUser = $this->User->checkAndLogin($data);
            $updateData = array();
            $finalData = null;
            if (!empty($isAuthenticatedUser)) {
                $this->request->data['User']['email'] = trim($data['email']);
                $this->request->data['User']['password'] = $this->User->authPassword(trim($data['password']));
                if ($this->Auth->login($this->request->data['User'])) {
                    $roles = array(2 => 'User');
                    $finalData = $this->Auth->User();
                    if (is_array($finalData)) {
                        $access_token = md5($isAuthenticatedUser['User']['id'] . time());
                        $updateData['User']['id'] = $isAuthenticatedUser['User']['id'];
                        $updateData['UserLog']['user_id'] = $isAuthenticatedUser['User']['id'];
                        $updateData['UserLog']['status'] = 'LoggedIn';
                        $updateData['UserLog']['device_id'] = $data['device_id'];
                        $updateData['UserLog']['push_note_token'] = $data['push_note_token'];
                        $updateData['UserLog']['access_token'] = $access_token;
                        if ($this->User->saveLoginDatas($updateData)) {
                            $finalData['user_id'] = $isAuthenticatedUser['User']['id'];
                            $finalData['username'] = $isAuthenticatedUser['User']['username'];
                            $finalData['email'] = $isAuthenticatedUser['User']['email'];
                            $finalData['job_title'] = $isAuthenticatedUser['User']['job_title'];
                            $finalData['role'] = $isAuthenticatedUser['User']['role'];
                            $finalData['image'] = Configure::read('site.image_path') . $isAuthenticatedUser['User']['image'];
                            $finalData['bio'] = $isAuthenticatedUser['User']['biodata'];
                            $finalData['access_token'] = $access_token;
                            $finalData['reset_portfolio_price'] = '0.99';
                            $finalData['create_portfolio_price'] = '0.99';
                            $finalData['reset_product_name'] = 'TSXResetPortfolio';
                            $finalData['create_product_name'] = 'TSXNewPortfolio';
                            if ($finalData['bio'] == NULL)
                                $finalData['bio'] = "";
                            $status = TRUE;
                            $game_list = $this->Game->displayGametype($finalData);
                            $portfolioCount = $this->Portfolio->totalPortfolioCount($finalData);
                            $dayTradeExists = $this->Portfolio->isPaidPortfolioExists($finalData);
                            $data["last_notification_time"] = $this->User->getLastNotificationTime($finalData);
                            $lastNotificationTime = $this->Notification->polling_count($data);
                            $body = array(
                                'UserData' => $finalData,
                                'GameData' => $game_list,
                                'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
                                'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
                                'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
                            );
                            $message = Configure::read('site.login_message1');
                            unset($finalData['password']);
                        }
                        else {
                            $body = null;
                            $status = FALSE;
                            $message = Configure::read('site.login_message2');
                        }
                    } else {
                        $body = null;
                        $status = FALSE;
                        $message = Configure::read('site.login_message3');
                    }
                } else {
                    $body = null;
                    $message = Configure::read('site.login_message4');
                    $status = FALSE;
                }
            } else {
                $body = null;
                $message = Configure::read('site.login_message5');
                $status = FALSE;
            }
        } else {
            $body = null;
            $status = False;
            $message = Configure::read('site.login_message6');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for logout as per $data and the User log will
     * be maintained for logout
     * web service method
     */
    function logout($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            if ($this->UserLog->updateUserLog($data)) {
                $this->Session->destroy();
                $body = null;
                $status = TRUE;
                $message = Configure::read('site.logout_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.logout_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for updating the biodata of the User as per
     * $data
     * web service method
     */
    function bio($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            if ($this->User->updateBioToken($data)) {
                $body = null;
                $status = TRUE;
                $message = Configure::read('site.bio_message1');
            } else {
                $body = null;
                $status = TRUE;
                $message = Configure::read('site.bio_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for editing the User Profile as per the
     * $data and the image, job_title, biodata will be updated
     * web service method
     */
    function edit_profile($data) {
        if ($userDetail = $this->UserLog->checkAccessTokenValid($data)) {
            $data['username'] = $userDetail['User']['username'];
            if (!empty($data['image'])) {
                $data['image'] = $this->create_image($data);
            } else {
                $data['image'] = 'profile_default.jpg';
            }
            $result = $this->User->updateProfile($data);
            if ($result) {
                $body = array(
                    "user_id" => $data['user_id'],
                    "access_token" => $data['access_token'],
                    "image" => Configure::read('site.image_path') . $data['image'],
                    "job_title" => $data['job_title'],
                    "biodata" => $data['biodata'],
                );
                $body = $body;
                $status = TRUE;
                $message = Configure::read('site.editProfile_message1');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.editProfile_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for displaying the games list for the User as
     * per $data
     * web service method
     */
    function game_list($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            if ($game = $this->Game->displayGametype($data)) {
                $body = $game;
                $status = TRUE;
                $message = Configure::read('site.gameList_message1');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.gameList_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for displaying the premium games list for the
     * User as per $data
     * web service method
     */
    function premium_games($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            if ($content = $this->Game->listOfPremiumGames($data)) {
                $body = $content;
                $status = TRUE;
                $message = Configure::read('site.premiumGames_message1');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.premiumGames_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for creating the portfolio for the User as
     * per $data
     * web service method
     * old code of create portfolio 1.1
     */
//    function create_portfolio($data) {
//        if ($this->UserLog->checkAccessTokenValid($data)) {
//            if ($data['portfolio_start_money'] > 0) {
//                $updateData = $this->__save_free_portfolio($data);
//                if ($updateData) {
//                    if ($this->Portfolio->savePortfolioDatas($updateData)) {
//                        $id = $this->Portfolio->id;
//                        //$updateWatchlistData = $this->__save_default_watchlist($id, $data);
//                        $updateWatchlistData = $this->__save_default_watchlist($id);
//                        $portfolioDetails = $this->Portfolio->portfolioDetails($id);
//                        $contents = array(
//                            'portfolio_id' => $this->Portfolio->id,
//                            'portfolio_name' => $portfolioDetails['Portfolio']['portfolio_name'],
//                            'start_money' => $portfolioDetails['Portfolio']['start_money'],
//                            'available_cash' => $portfolioDetails['Portfolio']['net_value'],
//                            'portfolio_worth' => $portfolioDetails['Portfolio']['net_value'],
//                            'available_trades' => $portfolioDetails['Portfolio']['trades'],
//                            'portfolio_percentage_change' => "0%",
//                            'portfolio_stock_count' => "0",
//                            'net_value_change' => ($portfolioDetails['Portfolio']['start_money'] - $portfolioDetails['Portfolio']['net_value'])
//                        );
//                        $body = $contents;
//                        $status = TRUE;
//                        $message = Configure::read('site.createPortfolio_message1');
//                    } else {
//                        $body = null;
//                        $status = FALSE;
//                        $message = Configure::read('site.createPortfolio_message2');
//                    }
//                } else {
//                    $body = null;
//                    $status = FALSE;
//                    $message = Configure::read('site.createPortfolio_message3');
//                }
//            } else {
//                $body = null;
//                $status = FALSE;
//                $message = Configure::read('site.createPortfolio_message4');
//            }
//        } else {
//            $body = null;
//            $status = FALSE;
//            $message = Configure::read('site.invalid_error_msg');
//        }
//        return $result = array(
//            'body' => $body,
//            'status' => $status,
//            'message' => $message
//        );
//    }
    
    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for creating the portfolio for the User as
     * per $data
     * web service method
     */
    function create_portfolio($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            if ($data['portfolio_start_money'] > 0) {
                $updateData = $this->__save_free_portfolio($data);
                if ($updateData) {
                    if ($this->Portfolio->savePortfolioDatas($updateData)) {
                        $id = $this->Portfolio->id;
                        $allow_proload_wathclist_sync = true;
                        //mapping with default portfolio and daytrade portfolio
                        if($this->Portfolio->isDefaultPortfolio($id, $data["user_id"]) || $data["game_id"] == 2){
                            
                            //storing values in mapping table
                            //$this->WatchlistMapping->storeMappings($id, $data);
                            if($data["game_id"] == 1){                               
                                
                                $data["WatchlistMapping"] = array();
                                $daytrade_portfolio_id = $this->Portfolio->getDayTradePortfolioByUserId($data["user_id"]);
                                
                                if($daytrade_portfolio_id == 0){
                                    $allow_proload_wathclist_sync = true;
                                    $data["WatchlistMapping"]["default_portfolio_id"] = $id;
                                    $data["WatchlistMapping"]["daytrade_portfolio_id"] = $daytrade_portfolio_id;
                                }else{
                                    $mapping_data = $this->WatchlistMapping->isDaytradePresent($daytrade_portfolio_id);
                                    $data["WatchlistMapping"]["id"] = $mapping_data[0]["WatchlistMapping"]["id"];
                                    $data["WatchlistMapping"]["default_portfolio_id"] = $id;
                                    $data["WatchlistMapping"]["daytrade_portfolio_id"] = $daytrade_portfolio_id;
                                
                                    $allow_proload_wathclist_sync = false;
                                    //update wathclist table with new portfolio id
                                    $this->Watchlist->updateDaytradeId($daytrade_portfolio_id, $id);
                                }
                                
                               
                            }else if($data["game_id"] == 2){
                                
                                $data["WatchlistMapping"] = array();
                                $default_portfolio_id = $this->Portfolio->getDefaultPortfolioByUserId($data["user_id"]);
                               
                                if($default_portfolio_id == 0){
                                    $allow_proload_wathclist_sync = true;
                                    $data["WatchlistMapping"]["default_portfolio_id"] = $default_portfolio_id;
                                    $data["WatchlistMapping"]["daytrade_portfolio_id"] = $id;
                                }else{
                                    $allow_proload_wathclist_sync = false;
                                    $mapping_data = $this->WatchlistMapping->isDefaultPresent($default_portfolio_id);
                                    $data["WatchlistMapping"]["id"] = $mapping_data[0]["WatchlistMapping"]["id"];
                                    $data["WatchlistMapping"]["default_portfolio_id"] = $default_portfolio_id;
                                    $data["WatchlistMapping"]["daytrade_portfolio_id"] = $id;
                                }                                
                                
                                
                            }
                            $this->WatchlistMapping->storeMappings($data);
                        }
                        
                        //$updateWatchlistData = $this->__save_default_watchlist($id, $data);
                        if($allow_proload_wathclist_sync){
                            $updateWatchlistData = $this->__save_default_watchlist($id);
                        }
                        $portfolioDetails = $this->Portfolio->portfolioDetails($id);
                        $contents = array(
                            'portfolio_id' => $this->Portfolio->id,
                            'portfolio_name' => $portfolioDetails['Portfolio']['portfolio_name'],
                            'start_money' => $portfolioDetails['Portfolio']['start_money'],
                            'available_cash' => $portfolioDetails['Portfolio']['net_value'],
                            'portfolio_worth' => $portfolioDetails['Portfolio']['net_value'],
                            'available_trades' => $portfolioDetails['Portfolio']['trades'],
                            'portfolio_percentage_change' => "0%",
                            'portfolio_stock_count' => "0",
                            'net_value_change' => ($portfolioDetails['Portfolio']['start_money'] - $portfolioDetails['Portfolio']['net_value'])
                        );
                        $body = $contents;
                        $status = TRUE;
                        $message = Configure::read('site.createPortfolio_message1');
                    } else {
                        $body = null;
                        $status = FALSE;
                        $message = Configure::read('site.createPortfolio_message2');
                    }
                } else {
                    $body = null;
                    $status = FALSE;
                    $message = Configure::read('site.createPortfolio_message3');
                }
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.createPortfolio_message4');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function has been used in 'portfolio' method for saving the
     * portfolio for the User as per $data
     * @return array $updateData which returns the saved portfolio data
     * web service method
     */
    function __save_free_portfolio($data) {
        $gameValue = $this->Game->getGameDetails($data);
        if ($data['portfolio_start_money'] <= $gameValue['Game']['default_net_value']) {
            $updateData['Portfolio']['user_id'] = trim($data['user_id']);
            $updateData['Portfolio']['game_id'] = trim($data['game_id']);
            $updateData['Portfolio']['portfolio_name'] = trim($data['portfolio_name']);
            $updateData['Portfolio']['net_value'] = $data['portfolio_start_money'];
            $updateData['Portfolio']['start_money'] = $data['portfolio_start_money'];
            $updateData['Portfolio']['trades'] = trim($gameValue['Game']['default_trades']);
            $updateData['Portfolio']['start_trade'] = trim($gameValue['Game']['default_trades']);
            if (trim($data['is_free'] == 0)) {
                $updateData['Portfolio']['is_paid'] = 'yes';
            } else {
                $updateData['Portfolio']['is_paid'] = 'no';
            }
            return $updateData;
        } else {
            return false;
        }
    }

    /*function __save_default_watchlist($data, $arrayData) {
        $shareData = $this->WatchlistPreload->getPreloadWatchlist($data);
        $i = 0;
        foreach ($shareData as $key => $value) {
            $watchlist = array();
            $watchlist['p']['share_id'] = $shareData[$i]['share_id'];
            $watchlist['p']['portfolio_id'] = $data;
            $response[] = $watchlist['p'];
            $i++;
        }
        $result = $this -> Watchlist -> saveAll($response);
        if ($result)
        {
            if($arrayData["game_id"] === "2" ){
                //find default portfolio               
                $conditions = array('Portfolio.game_id' => 1, 'Portfolio.user_id' => $arrayData["user_id"]);
                $portfolio_query = $this->Portfolio->find('first', array(
                    'conditions' => $conditions,
                    'fields' => array('Portfolio.id'),
                    'order' => array('Portfolio.created'),
                    'limit' => 1,
                    'recursive' => -1
                ));
                $default_portfolio_id = $portfolio_query["Portfolio"]["id"];
                $getAllSharesPortfolio = $this->Watchlist->getWatchlistById($default_portfolio_id);
                $detailData = array();
                foreach($getAllSharesPortfolio as $share){
                    $detailData["share_id"] = $share["Watchlist"]["share_id"];
                    $detailData["portfolio_id"] = $data;
                    $checkExist = $this->Watchlist->checkShareExists($detailData);
                    if (empty($checkExist)) {
                        $this->Watchlist->create();
                        $this->Watchlist->save($detailData);
                    }
                }
                
                $getAllSharesDayTrade = $this->Watchlist->getWatchlistById($data);
                $watchlist_detail_data = array();
                foreach($getAllSharesDayTrade as $day_trade_share){
                    $watchlist_detail_data["share_id"] = $day_trade_share["Watchlist"]["share_id"];
                    $watchlist_detail_data["portfolio_id"] = $default_portfolio_id;
                    $checkExist = $this->Watchlist->checkShareExists($watchlist_detail_data);
                    if (empty($checkExist)) {
                        $this->Watchlist->create();
                        $this->Watchlist->save($watchlist_detail_data);
                    }
                }
            }
            return $result;
        } else {
            return false;
        }
    }*/
    function __save_default_watchlist($data) {
        $shareData = $this->WatchlistPreload->getPreloadWatchlist($data);
        $i = 0;
        foreach ($shareData as $key => $value) {
            $watchlist = array();
            $watchlist['p']['share_id'] = $shareData[$i]['share_id'];
            $watchlist['p']['portfolio_id'] = $data;
            $response[] = $watchlist['p'];
            $i++;
        }
        $result = $this->Watchlist->saveAll($response);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function lists all the portfolio's of a particular user
     * with portfolio_worth and total_numbet_of_stocks as per the data $data
     * web service method
     */
    function show_portfolio_list($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $this->sync_data($data);
            $getPortfolioList = $this->User->finalPortfolioList($data);
            $body = $getPortfolioList;
            $status = TRUE;
            $message = Configure::read('site.show_portfolio_list_message1');
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for resetting portfolio
     * per $data
     * web service method
     */
    function reset_portfolio($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $portfolio_data = $this->Portfolio->resetPortfolioGame($data);
            if ($portfolio_data) {
                $body = $portfolio_data;
                $status = TRUE;
                $message = Configure::read('site.resetPortfolio_message1');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.resetPortfolio_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for adding a particular share to the
     * portfolio's watchlist of the User as per $data
      register
     * web service method
     * 	 */
    function add_watchlist($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $updateData['Watchlist']['user_id'] = trim($data['user_id']);
            $updateData['Watchlist']['share_id'] = trim($data['share_id']);
            $updateData['Watchlist']['portfolio_id'] = trim($data['portfolio_id']);
            $portfolioExists = $this->Portfolio->isPortfolioExists($data);
            $isShareIdExists = $this->Watchlist->checkShareExists($data);
            if (!empty($portfolioExists)) {
                $isMappedPresents = false;
                //check for default portfolio and daytradegame
                $checkDaytradePortfolio = $this->Portfolio->getDayTradePortfolioByUserId($data["user_id"]);
                if($checkDaytradePortfolio == $data["portfolio_id"]){
                    $getMappingDefaultPortfolio = $this->WatchlistMapping->isDaytradePresent($data["portfolio_id"]);
                    $default_portfolio_id = $getMappingDefaultPortfolio[0]["WatchlistMapping"]["default_portfolio_id"];
                    if($default_portfolio_id!=0){
                        $data["portfolio_id"] = $default_portfolio_id;
                        $isMappedPresents = $this->Watchlist->checkShareExists($data);
                    }
                }
                    
                if (empty($isShareIdExists) && empty($isMappedPresents)) {
                    if ($this->Watchlist->saveWatchlistDatas($data)) {
                        $body = null;
                        $status = True;
                        $message = Configure::read('site.addWatchlist_message1');
                    } else {
                        $body = null;
                        $status = FALSE;
                        $message = Configure::read('site.addWatchlist_message2');
                    }
                } else {
                    $body = null;
                    $status = FALSE;
                    $message = Configure::read('site.addWatchlist_message3');
                }
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.addWatchlist_message4');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for displaying the Portfolio's watchlist of
     * the particular User as per $data
     * web service method
     */
    function show_watchlist($data) {
        $checkIsDaytrade = $this->Portfolio->getDayTradePortfolioByUserId($data["user_id"]);
        
        if($checkIsDaytrade == $data["portfolio_id"]){
            //get mapping default portfolio id
            $map_values = $this->WatchlistMapping->isDaytradePresent($data["portfolio_id"]);
            $default_portfolio_id = $map_values[0]["WatchlistMapping"]["default_portfolio_id"];
            if($default_portfolio_id != 0){
                $data["portfolio_id"] = $default_portfolio_id;
            }
        }
        
        if ($this->UserLog->checkAccessTokenValid($data)) {
            if ($getWatchlist = $this->Watchlist->getWatchListDatas($data)) {
                $body = $getWatchlist;
                $status = True;
                $message = Configure::read('site.showWatchlist_message1');
            } else {
                $body = NULL;
                $status = FALSE;
                $message = Configure::read('site.showWatchlist_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    function register($data) {
        $isNotRegistered = $this->User->isNotRegistered($data);
        if (!empty($isNotRegistered)) {
            $isEmailUnique = $this->User->checkEmailExists($data['email']);
            $isUsernameUnique = $this->User->checkUsernameExists($data['username']);
            $message = null;
            $currenttime = date("Y-m-d H:i:s");
            if (empty($isEmailUnique) && empty($isUsernameUnique)) {
                $dataForAutoLogin['password'] = $data['password'];
                $dataForAutoLogin['email'] = $data['email'];
                $dataForAutoLogin['user_id'] = $guestData['User']['id'];
                $dataForAutoLogin['username'] = $data['username'];
                $dataForAutoLogin['device_id'] = null;
                $dataForAutoLogin['image'] = $data['image'];
                $dataForAutoLogin['job_title'] = $data['job_title'];
                $dataForAutoLogin['password'] = $this->User->authPassword($data['password']);
                $dataForAutoLogin['role'] = 'User';
                $dataForAutoLogin['is_registered'] = 'yes';
                $dataForAutoLogin['last_notification_time'] = $currenttime;
                if (!empty($data['image'])) {
                    $dataForAutoLogin['image'] = $this->create_image($dataForAutoLogin);
                } else {
                    $dataForAutoLogin['image'] = 'profile_default.jpg';
                }
                if ($this->User->updateGuest($dataForAutoLogin)) {
                    $contents = array(
                        'email' => $data['email'],
                        'user_id' => $this->User->id,
                        'role' => 'User',
                    );
                    $contents['password'] = $data['password'];
                    $contents['device_id'] = $data['device_id'];
                    $contents['push_note_token'] = $data['push_note_token'];
                    $contents['username'] = $data['username'];
                    $userLoggedData = $this->__user_login($contents);
                    $status = TRUE;
                    $finalData = array(
                        "user_id" => $contents['user_id'],
                        "username" => $data['username'],
                        "email" => $contents['email'],
                        "job_title" => $data['job_title'],
                        "role" => "user",
                        "access_token" => $userLoggedData['access_token'],
                        "image" => Configure::read('site.image_path') . $dataForAutoLogin['image'],
                        "reset_portfolio_price" => '0.99',
                        "create_portfolio_price" => '0.99',
                        "reset_product_name" => 'TSXResetPortfolio',
                        "create_product_name" => 'TSXNewPortfolio'
                    );
                    $game_list = $this->Game->displayGametype($finalData);
                    $portfolioCount = $this->Portfolio->totalPortfolioCount($finalData);
                    $dayTradeExists = $this->Portfolio->isPaidPortfolioExists($finalData);
                    $data["last_notification_time"] = $this->User->getLastNotificationTime($contents);
                    $lastNotificationTime = $this->Notification->polling_count($data);
                    $body = array(
                        'UserData' => $finalData,
                        'GameData' => $game_list,
                        'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
                        'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
                        'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
                    );
                    $message = $userLoggedData['message'];
                } else {
                    $message = Configure::read('site.register_message1');
                    $status = FALSE;
                    $body = null;
                }
            } else
            if (!empty($isUsernameUnique)) {
                $message = Configure::read('site.register_message2');
                $status = FALSE;
                $body = null;
            } else {
                $message = Configure::read('site.register_message3');
                $status = FALSE;
                $body = null;
            }
        } else {
            $isEmailUnique = $this->User->checkEmailExists($data['email']);
            $isUsernameUnique = $this->User->checkUsernameExists($data['username']);
            $message = null;
            if (empty($isEmailUnique) && empty($isUsernameUnique)) {
                $dataForAutoLogin['password'] = $data['password'];
                $dataForAutoLogin['email'] = $data['email'];
                $dataForAutoLogin['username'] = $data['username'];
                $dataForAutoLogin['device_id'] = NULL;
                $dataForAutoLogin['job_title'] = $data['job_title'];
                $dataForAutoLogin['password'] = $this->User->authPassword($data['password']);
                $dataForAutoLogin['role'] = 'User';
                $dataForAutoLogin['image'] = $data['image'];
                $dataForAutoLogin['is_registered'] = 'yes';
                $currenttime = date("Y-m-d H:i:s");
                $dataForAutoLogin['last_notification_time'] = $currenttime;
                if (!empty($data['image'])) {
                    $dataForAutoLogin['image'] = $this->create_image($dataForAutoLogin);
                } else {
                    $dataForAutoLogin['image'] = 'profile_default.jpg';
                }
                $this->User->create();
                if ($this->User->save($dataForAutoLogin)) {
                    $contents = array(
                        'email' => $data['email'],
                        'user_id' => $this->User->id,
                        'role' => 'User',
                    );
                    $contents['password'] = $data['password'];
                    $contents['device_id'] = $data['device_id'];
                    $contents['push_note_token'] = $data['push_note_token'];
                    $contents['username'] = $data['username'];
                    $userLoggedData = $this->__user_login($contents);
                    $status = TRUE;
                    $finalData = array(
                        "user_id" => $contents['user_id'],
                        "username" => $data['username'],
                        "email" => $contents['email'],
                        "job_title" => $data['job_title'],
                        "role" => "user",
                        "access_token" => $userLoggedData['access_token'],
                        "image" => Configure::read('site.image_path') . $dataForAutoLogin['image'],
                        "reset_portfolio_price" => '0.99',
                        "create_portfolio_price" => '0.99',
                        "reset_product_name" => 'TSXResetPortfolio',
                        "create_product_name" => 'TSXNewPortfolio'
                    );
                    $game_list = $this->Game->displayGametype($finalData);
                    $portfolioCount = $this->Portfolio->totalPortfolioCount($finalData);
                    $dayTradeExists = $this->Portfolio->isPaidPortfolioExists($finalData);
                    $data["last_notification_time"] = $this->User->getLastNotificationTime($contents);
                    $lastNotificationTime = $this->Notification->polling_count($data);
                    $body = array(
                        'UserData' => $finalData,
                        'GameData' => $game_list,
                        'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
                        'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
                        'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
                    );
                    $message = $userLoggedData['message'];
                } else {
                    $message = Configure::read('site.register_message1');
                    $status = FALSE;
                    $body = null;
                }
            } else
            if (!empty($isUsernameUnique)) {
                $message = Configure::read('site.register_message2');
                $status = FALSE;
                $body = null;
            } else {
                $message = Configure::read('site.register_message3');
                $status = FALSE;
                $body = null;
            }
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used for uploading an image as per the $data a
     * web service method
     */
    function __upload_image($data) {
        if (!empty($data['image'])) {
            $imageType = in_array($data['image']['type'], array(
                "image/jpeg",
                "image/png",
                "image/gif",
                "image/jpg"
            ));
            if (!empty($imageType)) {
                $filename = $data['image']['name'];
                $folder_url = WWW_ROOT . 'files/uploads/';
                $rel_url = 'files/uploads';
                $data['image']['url'] = $rel_url;
                if (!file_exists($folder_url . '/' . $filename)) {
                    // create full filename
                    $full_url = $folder_url . '/' . $filename;
                    $url = $rel_url . '/' . $filename;
                    $data['image']['name'] = $filename;
                    // upload the file
                    $success = move_uploaded_file($data['image']['tmp_name'], $url);
                } else {
                    // create unique filename and upload file
                    ini_set('date.timezone', 'Europe/London');
                    $now = date('Y-m-d-His');
                    $full_url = $folder_url . '/' . $now . $filename;
                    $url = $rel_url . '/' . $now . $filename;
                    $data['image']['name'] = $now . $filename;
                    $success = move_uploaded_file($data['image']['tmp_name'], $url);
                }
                return $dataForAutoLogin['image'] = $data['image']['name'];
            }
            return false;
        }
        return false;
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for converting from byte-code to an image for a
     * particular User
     * and it uploads an image to the files/uploads folder with username as a
     * filename for uniqueness
     * updates the image
     */
    function create_image($data) {
        $username = $data['username'];
        $username = str_replace(' ', '', $username);
        $username .= '.jpeg';
        $image = $data['image'];
        $folder_url = WWW_ROOT . 'files/uploads';
        $data = base64_decode($image);
        if (!empty($data)) {
            if ($im = @imagecreatefromstring($data)) {
                header('Content-Type: image/jpeg');
                imagejpeg($im, $folder_url . '/' . $username);
                imagedestroy($im);
                return $username;
            } else
            if (error_reporting() === 0) {
                // This copes with @ being used to suppress errors
                // continue script execution, skipping standard PHP error handler
                return false;
            }
            return false;
        }
        return false;
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used to set new password for the user when he
     * forgets the password
     * by sending a link via mail
     * web service method
     */
    function forgot_password($data = array()) {
        $cleanData = trim($data['userdata']);
        $isEmailIsThereOrNot = $this->User->checkDataExists($cleanData);
        $finalData = null;
        if (empty($isEmailIsThereOrNot)) {
            $message = "The email or username does not exist.";
            $status = FALSE;
        } else {
            $changePwdToken['change_pwd_token'] = strrev(base64_encode($isEmailIsThereOrNot['User']['id'] . "_" . $isEmailIsThereOrNot['User']['email']));
            $changePwdToken['id'] = $isEmailIsThereOrNot['User']['id'];
            $contents = array(
                'email' => $isEmailIsThereOrNot['User']['email'],
                'url' => Configure::read('site.url') . $changePwdToken['change_pwd_token'],
                'username' => $isEmailIsThereOrNot['User']['username'],
                'admin_email' => Configure::read('site.admin_email')
            );
            if ($this->User->updateChangePwdToken($changePwdToken)) {
                $this->sendMail('forgot_password', $isEmailIsThereOrNot['User']['email'], Configure::read('site.support_email'), 'Reset your stox password', $contents);
                $message = Configure::read('site.forgotPassword_message1');
                $status = TRUE;
            } else {
                $finalData = null;
                $message = Configure::read('site.forgotPassword_message2');
                $status = FALSE;
            }
        }
        return $result = array(
            'body' => $finalData,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function lists the bank data displaying assets, price and type
     * web service method
     */
    function show_bankdata($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            if ($bankData = $this->Bank->getBankDatas($data)) {
                $body = Set::classicExtract($bankData, '{n}.BankData');
                $status = True;
                $message = Configure::read('site.showBankData_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.showBankData_message2');
            }
            if ($content = $this->Game->listOfPremiumGames($data)) {
                $body = $content;
                $status = TRUE;
                $message = Configure::read('site.showBankData_message3');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.showBankData_message4');
            }
            $status = True;
            $message = Configure::read('site.showBankData_message1');
            $contents = array('BankData' => $bankData);
            $body = $contents;
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to change the password for the user as per the
     * $data
     * web service method
     */
    function change_password($data = array()) {
        $notification = $message = null;
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $data['current_password'] = $this->User->authPassword($data['current_password']);
            $data['password'] = $this->User->authPassword($data['password']);
            $isPasswordMatch = $this->User->checkPasswordMatch($data['user_id'], $data['current_password']);
            if ($isPasswordMatch) {
                //$notification = $this->notification($data);
                $userPassword = $this->User->updateUserPassword($data);
                if ($userPassword) {
                    $body = '';
                    $status = True;
                    $message = Configure::read('site.changePassword_message1');
                } else {
                    $body = null;
                    $status = FALSE;
                    $message = Configure::read('site.changePassword_message2');
                }
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.changePassword_message3');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.changePassword_message4');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for sending mail as per the $data
     */
    function sendMail($template = null, $to_email = null, $from_email = null, $subject = null, $contents = array()) {
        $from_email = Configure::read('site.support_email');
        $email = new CakeEmail();
        $result = $email->template($template, 'default')->emailFormat('html')->to($to_email)->from($from_email)->subject($subject)->viewVars($contents);
        if ($email->send('default')) {
            return true;
        }
        return false;
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function saves the user log data as per $data when he logs in
     */
    function __user_login($data = array()) {
        $finalData = null;
        $this->request->data['User']['email'] = trim($data['email']);
        $this->request->data['User']['password'] = trim($data['password']);
        if ($this->Auth->login($this->request->data['User'])) {
            $finalData = $this->Auth->User();
            if (is_array($finalData)) {
                $data['access_token'] = md5($this->Auth->User('id') . time());
                $data['status'] = 'LoggedIn';
                if ($this->UserLog->saveLoginDatas($data)) {
                    $finalData['access_token'] = $data['access_token'];
                    unset($finalData['password']);
                }
            }
        }
        return array(
            "access_token" => $data['access_token'],
            "message" => Configure::read('site.login_message1')
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for getting the share data page wise
     * web service method
     */
    function get_share_data($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $current_page_no = $data['page_no'];
            if ($current_page_no > 0) {
                $no_of_records = $data['no_of_records'];
                $start_offset = ($current_page_no * $no_of_records) - $no_of_records;
                $search = trim($data['search']);
                $share_data = array();
                $share_data = $this->Share->fetchData($start_offset, $no_of_records, $search);
                $result = Set::classicExtract($share_data, '{n}.Share');
                if ($share_data) {
                    $share_data = $result;
                    $status = True;
                    $message = Configure::read('site.get_share_data_message1');
                } else {
                    $share_data = null;
                    $status = False;
                    $message = Configure::read('site.get_share_data_message2');
                }
            } else {
                $share_data = null;
                $status = False;
                $message = Configure::read('site.get_share_data_message3');
            }
        } else {
            $share_data = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $share_data,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for uploading an image for the user by converting
     * byte code to an image
     * web service method
     */
    function upload_image($data) {
        if ($userDetail = $this->UserLog->checkAccessTokenValid($data)) {
            $data['username'] = $userDetail['User']['username'];
            if (!empty($data['image'])) {
                $data['image'] = $this->create_image($data);
            } else {
                $data['image'] = 'profile_default.jpg';
            }
            if ($result = $this->User->updateImage($data)) {
                $body = array(
                    "user_id" => $data['user_id'],
                    "access_token" => $data['access_token'],
                    "image" => Configure::read('site.image_path') . $data['image'],
                );
                $body = $body;
                $status = False;
                $message = Configure::read('site.upload_image_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.upload_image_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for buying cash/trade
     * web service method
     */
    function buy_cash_trade($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $data['price'] = $data['price_paid'];
            $transaction = $this->Transaction->saveTransactionData($data);
            if ($transaction) {
                $body = $transaction;
                $status = True;
                $message = Configure::read('site.buy_cash_trade_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.buy_cash_trade_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for login through Facebook for User as per the
     * $data and the User log will
     * be maintained for successful login
     * web service method
     */
    function social_login($data = array()) {
        $isEmailUnique = $this->User->checkEmailExists($data['email']);
        $isFacebookUserUnique = $this->User->checkFacebookUserExists($data['facebook_id']);
        if (empty($isFacebookUserUnique) && empty($isEmailUnique) && empty($isUserNameUnique)) {
            $body = null;
            $status = TRUE;
            $currenttime = date("Y-m-d H:i:s");
            $dataPassword['password'] = $data['facebook_id'];
            $dataForAutoLogin['password'] = $this->User->authPassword($dataPassword['password']);
            $dataForAutoLogin['email'] = $data['email'];
            $dataForAutoLogin['username'] = $data['firstname'] . $data['facebook_id'];
            $dataForAutoLogin['device_id'] = NULL;
            $dataForAutoLogin['image'] = $data['image'];
            $dataForAutoLogin['facebook_id'] = $data['facebook_id'];
            $dataForAutoLogin['is_registered'] = 'yes';
            $dataForAutoLogin['role'] = 'User';
            $dataForAutoLogin['last_notification_time'] = $currenttime;
            if (!empty($data['image'])) {
                $dataForAutoLogin['image'] = $this->create_image($dataForAutoLogin);
            } else {
                $dataForAutoLogin['image'] = 'profile_default.jpg';
            }
            $data['role'] = 'User';
            $this->User->create();
            if ($this->User->save($dataForAutoLogin)) {
                $contents = array(
                    'email' => $data['email'],
                    'user_id' => $this->User->id,
                    'role' => 'User',
                );
                $contents['password'] = $dataForAutoLogin['password'];
                $contents['device_id'] = $data['device_id'];
                $contents['push_note_token'] = $data['push_note_token'];
                $contents['username'] = $data['firstname'];
                $userLoggedData = $this->__user_login($contents);
                $status = TRUE;
                $finalData = array(
                    "user_id" => $contents['user_id'],
                    "username" => $contents['username'],
                    "email" => $contents['email'],
                    "role" => "user",
                    "access_token" => $userLoggedData['access_token'],
                    "image" => Configure::read('site.image_path') . $dataForAutoLogin['image'],
                    "reset_portfolio_price" => '0.99',
                    "create_portfolio_price" => '0.99',
                    "reset_product_name" => 'TSXResetPortfolio',
                    "create_product_name" => 'TSXNewPortfolio'
                );
                $game_list = $this->Game->displayGametype($finalData);
                $portfolioCount = $this->Portfolio->totalPortfolioCount($finalData);
                $dayTradeExists = $this->Portfolio->isPaidPortfolioExists($finalData);
                $data["last_notification_time"] = $this->User->getLastNotificationTime($contents);
                $lastNotificationTime = $this->Notification->polling_count($data);
                $body = array(
                    'UserData' => $finalData,
                    'GameData' => $game_list,
                    'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
                    'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
                    'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
                );
                $message = $userLoggedData['message'];
            } else {
                $message = Configure::read('site.social_login_message1');
                $status = FALSE;
                $body = null;
            }
            return $result = array(
                'body' => $body,
                'status' => $status,
                'message' => $message
            );
        } else
        if (empty($isFacebookUserUnique) && !empty($isEmailUnique)) {
            $finalData = null;
            $body = null;
            $status = TRUE;
            $data['user_id'] = $isEmailUnique['User']['id'];
            $facebookIdUpdate = $this->User->updateFacebookData($data);
            if ($facebookIdUpdate) {
                $data['password'] = $this->User->authPassword($isEmailUnique['User']['password']);
                $this->request->data['User']['email'] = trim($isEmailUnique['User']['email']);
                $this->request->data['User']['password'] = trim($data['password']);
                if ($this->Auth->login($this->request->data['User'])) {
                    $finalData = $this->Auth->User();
                    if (is_array($finalData)) {
                        $access_token = md5($this->Auth->User('id') . time());
                        $updateData['User']['id'] = $this->Auth->User('id');
                        $updateData['User']['device_id'] = NULL;
                        $updateData['User']['facebook_id'] = trim($data['facebook_id']);
                        $updateData['User']['image'] = trim($data['image']);
                        $updateData['UserLog']['user_id'] = $this->Auth->User('id');
                        $updateData['UserLog']['access_token'] = $access_token;
                        $updateData['UserLog']['device_id'] = NULL;
                        $userLogData['user_id'] = $isEmailUnique['User']['id'];
                        $userLogData['status'] = 'LoggedIn';
                        $userLogData['device_id'] = $data['device_id'];
                        $userLogData['push_note_token'] = $data['push_note_token'];
                        $userLogData['access_token'] = $access_token;
                        $userSaveLog = $this->UserLog->saveLoginDatas($userLogData);
                        $finalData = array(
                            "user_id" => $isEmailUnique['User']['id'],
                            "username" => $data['firstname'],
                            "email" => $data['email'],
                            "role" => "user",
                            "access_token" => $updateData['UserLog']['access_token'],
                            "image" => Configure::read('site.image_path') . $isEmailUnique['User']['image'],
                            "reset_portfolio_price" => '0.99',
                            "create_portfolio_price" => '0.99',
                            "reset_product_name" => 'TSXResetPortfolio',
                            "create_product_name" => 'TSXNewPortfolio'
                        );
                        $game_list = $this->Game->displayGametype($finalData);
                        $portfolioCount = $this->Portfolio->totalPortfolioCount($finalData);
                        $dayTradeExists = $this->Portfolio->isPaidPortfolioExists($finalData);
                        $data["last_notification_time"] = $this->User->getLastNotificationTime($userLogData);
                        $lastNotificationTime = $this->Notification->polling_count($data);
                        $body = array(
                            'UserData' => $finalData,
                            'GameData' => $game_list,
                            'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
                            'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
                            'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
                        );
                    }
                }
            } else {
                $finalData = null;
                $body = null;
                $status = FALSE;
                return array(
                    'body' => $body,
                    'status' => $status,
                    "message" => Configure::read('site.social_login_message2')
                );
            }
            return array(
                'body' => $body,
                'status' => $status,
                "message" => Configure::read('site.login_message1')
            );
        } else {
            $finalData = null;
            $body = null;
            $status = TRUE;
            $data['password'] = $this->User->authPassword($data['facebook_id']);
            $this->request->data['User']['email'] = trim($data['email']);
            $this->request->data['User']['password'] = trim($data['password']);
            if ($this->Auth->login($this->request->data['User'])) {
                $finalData = $this->Auth->User();
                if (is_array($finalData)) {
                    $access_token = md5($this->Auth->User('id') . time());
                    $updateData['User']['id'] = $this->Auth->User('id');
                    $updateData['User']['device_id'] = NULL;
                    $updateData['User']['facebook_id'] = trim($data['facebook_id']);
                    $updateData['User']['image'] = trim($data['image']);
                    $updateData['UserLog']['user_id'] = $this->Auth->User('id');
                    $updateData['UserLog']['access_token'] = $access_token;
                    $updateData['UserLog']['device_id'] = NULL;
                    $userInfo = $this->User->getSocialUserId($data);
                    $userLogData['user_id'] = $userInfo['User']['id'];
                    $userLogData['status'] = 'LoggedIn';
                    $userLogData['device_id'] = $data['device_id'];
                    $userLogData['push_note_token'] = $data['push_note_token'];
                    $userLogData['access_token'] = $access_token;
                    $userSaveLog = $this->UserLog->saveLoginDatas($userLogData);
                    $finalData = array(
                        "user_id" => $userInfo['User']['id'],
                        "username" => $data['firstname'],
                        "email" => $data['email'],
                        "role" => "user",
                        "access_token" => $updateData['UserLog']['access_token'],
                        "image" => Configure::read('site.image_path') . $userInfo['User']['image'],
                        "reset_portfolio_price" => '0.99',
                        "create_portfolio_price" => '0.99',
                        "reset_product_name" => 'TSXResetPortfolio',
                        "create_product_name" => 'TSXNewPortfolio'
                    );
                    $game_list = $this->Game->displayGametype($finalData);
                    $portfolioCount = $this->Portfolio->totalPortfolioCount($finalData);
                    $dayTradeExists = $this->Portfolio->isPaidPortfolioExists($finalData);
                    $data["last_notification_time"] = $this->User->getLastNotificationTime($userLogData);
                    $lastNotificationTime = $this->Notification->polling_count($data);
                    $body = array(
                        'UserData' => $finalData,
                        'GameData' => $game_list,
                        'PortfolioCount' => intval($portfolioCount['Portfolio']['count']),
                        'DayTradeGameExists' => intval($dayTradeExists['Portfolio']['count']),
                        'UnreadNotificationCount' => $lastNotificationTime['unread_notification_count']
                    );
                }
            }
            return array(
                'body' => $body,
                'status' => $status,
                "message" => Configure::read('site.login_message1')
            );
        }
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to buy share for a particular portfolio
     * web service method
     */
    function buy_stocks($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            date_default_timezone_set('America/New_York');
            date_default_timezone_get();
            $currenttime = date('H:i:s');
            if (($currenttime >= '09:30:00' && $currenttime <= '16:30:00')) {
                $availableTradeCash = $this->Portfolio->totalTradeCashIndividualPortfolio($data);
                if ($availableTradeCash) {
                    if ($availableTradeCash['trades'] <= 0 || $availableTradeCash['net_value'] < $data['total_purchased_amount']) {
                        $message = Configure::read('site.buy_stocks_message1');
                        $body = NULL;
                        $status = FALSE;
                    } else {
                        $data['cost_price'] = $data['total_purchased_amount'];
                        $data['cost_per_price'] = $data['total_purchased_amount'] / $data['quantity'];
                        $data['status'] = 'buy';
                        $data['total_amount'] = $data['total_purchased_amount'];
                        $saveUserStock = $this->UserStock->saveUserStockData($data);
                        $message = Configure::read('site.buy_stocks_message2');
                        $body = $saveUserStock;
                        $status = True;
                    }
                } else {
                    $message = Configure::read('site.buy_stocks_message3');
                    $body = NULL;
                    $status = FALSE;
                }
            } else {
                $message = Configure::read('site.buy_stocks_message4');
                $body = NULL;
                $status = FALSE;
            }
        } else {
            $message = Configure::read('site.invalid_error_msg');
            $body = NULL;
            $status = FALSE;
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to sale share for a particular portfolio
     * web service method
     */
    function sell_stocks($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            date_default_timezone_set('America/New_York');
            date_default_timezone_get();
            $currenttime = date('H:i:s');
            if (($currenttime >= '09:30:00' && $currenttime <= '16:30:00')) {
                $availableTrade = $this->Portfolio->getIndividualTrades($data);
                
                if ($availableTrade['Portfolio']['total_trades'] <= 0) {
                    $message = Configure::read('site.sell_stocks_message1');
                    $body = NULL;
                    $status = FALSE;
                } else {
                    $availableStock = $this->UserStock->availableStock($data);
                    if ($availableStock) {
                        if ($availableStock['quantity'] >= $data['quantity']) {
                            $data['cost_price'] = $data['total_sold_amount'];
                            $data['cost_per_price'] = $data['total_sold_amount'] / $data['quantity'];
                            $data['status'] = 'sell';
                            $data['total_amount'] = $data['total_sold_amount'];
                            $data['stock_detail'] = $availableStock;
                            $saveSellStockData = $this->UserStock->saveSellStockData($data);
                            $message = Configure::read('site.sell_stocks_message2');
                            $body = $saveSellStockData;
                            $status = True;
                        } else {
                            $message = Configure::read('site.sell_stocks_message3');
                            $body = NULL;
                            $status = FALSE;
                        }
                    } else {
                        $message = Configure::read('site.sell_stocks_message4');
                        $body = NULL;
                        $status = FALSE;
                    }
                }
            } else {
                $message = Configure::read('site.sell_stocks_message5');
                $body = NULL;
                $status = FALSE;
            }
        } else {
            $message = Configure::read('site.invalid_error_msg');
            $body = NULL;
            $status = FALSE;
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is send the list of purchased stock for a portfolio
     * web service method
     */
    function user_stocks($data) {
        $body = null;
        if (!empty($data)) {
            if ($this->UserLog->checkAccessTokenValid($data)) {
                $stock_list = $this->UserStock->findPurchasedStocksList($data);
                if (count($stock_list) > 0) {
                    $body = $stock_list;
                    $status = True;
                    $message = Configure::read('site.user_stocks_message1');
                } elseif (count($stock_list) == 0) {
                    $body = $stock_list;
                    $status = True;
                    $message = Configure::read('site.user_stocks_message2');
                } else {
                    $status = False;
                    $message = Configure::read('site.user_stocks_message3');
                }
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.invalid_error_msg');
            }
        } else {
            $status = False;
            $message = Configure::read('site.user_stocks_message5');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is send the list of sold stock for a portfolio
     * web service method
     */
    function stock_history($data) {
        $body = null;
        if (!empty($data)) {
            if ($this->UserLog->checkAccessTokenValid($data)) {
                $stock_list = $this->UserStock->findStockHistoryList($data);
                if (count($stock_list) > 0) {
                    $body = $stock_list;
                    $status = True;
                    $message = Configure::read('site.stock_history_message1');
                } else
                if (count($stock_list) == 0) {
                    $body = $stock_list;
                    $status = True;
                    $message = Configure::read('site.stock_history_message2');
                } else {
                    $status = False;
                    $message = Configure::read('site.stock_history_message3');
                }
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.invalid_error_msg');
            }
        } else {
            $status = False;
            $message = Configure::read('site.stock_history_message5');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is send the list of pending stock for a portfolio
     * web service method
     */
    function pending_stocks($data) {
        $body = null;
        if (!empty($data)) {
            if ($this->UserLog->checkAccessTokenValid($data)) {
                $stock_list = $this->UserStock->findPendingStocksList($data);
                if (count($stock_list) > 0) {
                    $body = $stock_list;
                    $status = True;
                    $message = Configure::read('site.pending_stocks_message1');
                } else
                if (count($stock_list) == 0) {
                    $body = $stock_list;
                    $status = True;
                    $message = Configure::read('site.pending_stocks_message2');
                } else {
                    $status = False;
                    $message = Configure::read('site.pending_stocks_message3');
                }
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.invalid_error_msg');
            }
        } else {
            $status = False;
            $message = Configure::read('site.pending_stocks_message5');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to send FAQ data
     * web service method
     */
    function faq_data($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $faqData = $this->Faq->getFaqDatas();
            if ($faqData) {
                $body = $faqData;
                $status = True;
                $message = Configure::read('site.faq_data_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.faq_data_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to save feedback form data
     * web service method
     */
    function feedback_data($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $feedbackData = $this->Feedback->saveFeedbackData($data);
            if ($feedbackData) {
                $body = null;
                $status = True;
                $message = Configure::read('site.faq_data_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.faq_data_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to save contact us form data
     */
    function contactus_data($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $contactUsData = $this->Contact->saveContactUsData($data);
            if ($contactUsData) {
                $body = null;
                $status = True;
                $message = Configure::read('site.contactus_data_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.contactus_data_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function deletes the guest user data before installing if exists
     * web service method
     */
    function install($data) {
        $isDeviceExists = $this->User->checkDeviceExists($data);
        if (!empty($isDeviceExists)) {
            $id = $this->User->getUserId($data);
            if ($deleteGuestDatas = $this->User->delete($id['User']['id'], true)) {
                $contents = array(
                    'device_id' => $data['device_id'],
                    'user_id' => $id['User']['id'],
                );
                $body = $contents;
                $status = TRUE;
                $message = "SUCESS! Guest user has been deleted";
            } else {
                $body = NULL;
                $status = FALSE;
                $message = "Error! Guest User couldnt be deleted";
            }
            if ($saveGuestDatas = $this->User->saveall($data)) {
                $body = $data;
                $status = TRUE;
                $message = "SUCESS!";
            } else {
                $body = NULL;
                $status = FALSE;
                $message = "Error! User couldnt be saved";
            }
            $contents = array(
                'user_id' => $this->User->id,
                'device_id' => $data['device_id']
            );
            $isUserId = $this->User->id;
            $data['access_token'] = md5($data['device_id'] . time());
            $updateData['UserLog']['user_id'] = $isUserId;
            $updateData['UserLog']['access_token'] = $data['access_token'];
            $updateData['UserLog']['device_id'] = trim($data['device_id']);
            if ($this->UserLog->saveall($updateData)) {
                $contents = array(
                    'user_id' => $this->User->id,
                    'device_id' => $data['device_id'],
                    'access_token' => $data['access_token'],
                );
                $body = $contents;
                $status = TRUE;
                $message = "SUCESS!";
            } else {
                $body = NULL;
                $status = TRUE;
                $message = "Error! user log could not be saved";
            }
        } else {
            if ($saveGuestDatas = $this->User->saveall($data)) {
                $body = $data;
                $status = TRUE;
                $message = "SUCESS!";
            } else {
                $body = NULL;
                $status = FALSE;
                $message = "Error! User couldnt be saved";
            }
            $contents = array(
                'user_id' => $this->User->id,
                'device_id' => $data['device_id']
            );
            $isUserId = $this->User->id;
            $data['access_token'] = md5($data['device_id'] . time());
            $updateData['UserLog']['user_id'] = $isUserId;
            $updateData['UserLog']['access_token'] = $data['access_token'];
            $updateData['UserLog']['device_id'] = trim($data['device_id']);
            if ($this->UserLog->saveall($updateData)) {
                $contents = array(
                    'user_id' => $this->User->id,
                    'device_id' => $data['device_id'],
                    'access_token' => $data['access_token'],
                );
                $body = $contents;
                $status = TRUE;
                $message = "SUCESS!";
            } else {
                $body = NULL;
                $status = TRUE;
                $message = "Error! user log could not be saved";
            }
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to remove a share from watch list
     * web service method
     */
//    function remove_from_watchlist($data) {
//        if ($this->UserLog->checkAccessTokenValid($data)) {
//            $recordId = $data['watchlist_id'];
//            $conditions = array('Watchlist.id' => $recordId);
//            $watchlist_query = $this->Watchlist->find('first', array(
//                'conditions' => $conditions,
//                'fields' => array('Watchlist.share_id','Watchlist.portfolio_id'),
//                'recursive' => -1
//            ));
//            
//            $conditions1 = array('Portfolio.id' => $watchlist_query["Watchlist"]["portfolio_id"]);
//            $DayTradeOrDefault = $this->Portfolio->find('first', array(
//                'conditions' => $conditions1,
//                'fields' => array('Portfolio.id', 'Portfolio.game_id'),
//                'recursive' => -1
//            ));
//            
//            $game_id = $DayTradeOrDefault["Portfolio"]["game_id"];
//            $data["share_id"] = $watchlist_query["Watchlist"]["share_id"];
//            $data["portfolio_id"] = $watchlist_query["Watchlist"]["portfolio_id"];
//            if ($deleteWatchlist = $this->Watchlist->delete($data['watchlist_id'])) {
//                switch ($game_id){
//                    case 1:
//                        $this->Watchlist->deleteDayTradeGame($data);
//                        break;
//                    case 2:
//                        $this->Watchlist->deleteDefaultProfolio($data);
//                        break;
//                }
//                        
//                $body = NULL;
//                $status = TRUE;
//                $message = Configure::read('site.remove_from_watchlist_message1');
//            } else {
//                $body = null;
//                $status = False;
//                $message = Configure::read('site.remove_from_watchlist_message2');
//            }
//        } else {
//            $body = null;
//            $status = False;
//            $message = Configure::read('site.invalid_error_msg');
//        }
//        return $result = array(
//            'body' => $body,
//            'status' => $status,
//            'message' => $message
//        );
//    }
    
    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to remove a share from watch list
     */
    function remove_from_watchlist($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $recordId = $data['watchlist_id'];
            if ($deleteWatchlist = $this->Watchlist->delete($data['watchlist_id'])) {
                $body = NULL;
                $status = TRUE;
                $message = Configure::read('site.remove_from_watchlist_message1');
            } else {
                $body = null;
                $status = False;
                $message = Configure::read('site.remove_from_watchlist_message2');
            }
        } else {
            $body = null;
            $status = False;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for sending friends leader board data
     * web service method
     */
    function friend_leaderboard($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $data['facebook_friends'][] = $data['email'];
            $facebook_friends = $data['facebook_friends'];
            $registered_users = $this->User->listRegisteredUsers();
            $users_friends = array();
            $users_friends = array_intersect($registered_users, $facebook_friends);
            if ($users_friends) {
                $users_friends = array_keys($users_friends);
                $portfolios = $this->User->leaderPortfolios($users_friends, $data['game_id']);
                $portfolios_max_net_amount = array();
                $i = 0;
                $leaderBoard = array();
                $userData = array();
                if ($portfolios) {
                    foreach ($portfolios as $key => $val) {
                        if (isset($val['total_share_amount'])) {
                            $sortedData = $val['total_share_amount'];
                            $key = array_search(max($sortedData), $sortedData);
                            $portfolios_max_net_amount['user_id'] = $val['User']['id'];
                            $portfolios_max_net_amount['email'] = $val['User']['email'];
                            $portfolios_max_net_amount['username'] = $val['User']['username'];
                            if ($val['User']['facebook_id'] == '') {
                                $portfolios_max_net_amount['image'] = ABS_URL . 'files/uploads/' . $val['User']['image'];
                            } else {
                                $portfolios_max_net_amount['image'] = $val['User']['image'];
                            }
                            $portfolios_max_net_amount['portfolio_id'] = $val['Portfolio'][$key]['id'];
                            $portfolios_max_net_amount['portfolio_name'] = $val['Portfolio'][$key]['po
							rtfolio_name'];
                            $portfolios_max_net_amount['total_net_value'] = $sortedData[$key];
                            $leaderBoard[] = array('data' => $portfolios_max_net_amount);
                            $i++;
                            if ($val['User']['email'] == $data['email']) {
                                $userData = array('data' => $portfolios_max_net_amount);
                            }
                        }
                    }
                    if (!empty($leaderBoard)) {

                        //sorting the result as per the total_net_value
                        function totalNetValueDescSort($item1, $item2) {
                            if ($item1['data']['total_net_value'] == $item2['data']['total_net_value'])
                                return 0;
                            return ($item1['data']['total_net_value'] < $item2['data']['total_net_value']) ? 1 : -1;
                        }

                        usort($leaderBoard, 'totalNetValueDescSort');
                        $isPresent = in_array($userData, $leaderBoard);
                        if ($isPresent) {
                            $key = array_search($userData, $leaderBoard);
                            $userData['data']['rank'] = $key + 1;
                        } else {
                            $userData = array();
                            $userData = $this->User->highestNetAmountPortfolio($data['user_id'], $data['game_id']);
                            if ($userData) {
                                $rand = rand(1, 200);
                                $userData['data']['rank'] = 300 + $rand;
                            } else {
                                $userData['data'] = "No data";
                            }
                        }
                        //get record of 15 users
                        $leaderBoard = array_slice($leaderBoard, 0, 15);
                        $body = array(
                            'leaderBoard' => $leaderBoard,
                            'userRank' => $userData
                        );
                        $status = True;
                        $message = "Success";
                    } else {
                        $body = null;
                        $status = False;
                        $message = "No Data";
                    }
                } else {
                    $body = null;
                    $status = False;
                    $message = "No Data";
                }
            } else {
                $body = null;
                $status = False;
                $message = "No Data";
            }
        } else {
            $body = null;
            $status = False;
            $message = "Access token invalid";
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for sending global (all users) leader board data
     * web service method
     */
    function global_leaderboard($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $registered_users = $this->User->listRegisteredUsers();
            if ($registered_users) {
                $registered_users = array_keys($registered_users);
                $portfolios = $this->User->leaderPortfolios($registered_users, $data['game_id']);
                $portfolios_max_net_amount = array();
                $i = 0;
                $leaderBoard = array();
                $userData = array();
                if ($portfolios) {
                    foreach ($portfolios as $key => $val) {
                        if (isset($val['total_share_amount'])) {
                            $sortedData = $val['total_share_amount'];
                            $key = array_search(max($sortedData), $sortedData);
                            $portfolios_max_net_amount['user_id'] = $val['User']['id'];
                            $portfolios_max_net_amount['email'] = $val['User']['email'];
                            $portfolios_max_net_amount['username'] = $val['User']['username'];
                            if ($val['User']['facebook_id'] == '') {
                                $portfolios_max_net_amount['image'] = ABS_URL . 'files/uploads/' . $val['User']['image'];
                            } else {
                                $portfolios_max_net_amount['image'] = $val['User']['image'];
                            }
                            $portfolios_max_net_amount['portfolio_id'] = $val['Portfolio'][$key]['id'];
                            $portfolios_max_net_amount['portfolio_name'] = $val['Portfolio'][$key]['portfolio_name'];
                            $portfolios_max_net_amount['total_net_value'] = $sortedData[$key];
                            $leaderBoard[] = array('data' => $portfolios_max_net_amount);
                            $i++;
                            if ($val['User']['email'] == $data['email']) {
                                $userData = array('data' => $portfolios_max_net_amount);
                            }
                        }
                    }
                    if (!empty($leaderBoard)) {

                        //sorting the result as per the total_net_value
                        function totalNetValueDescSort($item1, $item2) {
                            if ($item1['data']['total_net_value'] == $item2['data']['total_net_value'])
                                return 0;
                            return ($item1['data']['total_net_value'] < $item2['data']['total_net_value']) ? 1 : -1;
                        }

                        usort($leaderBoard, 'totalNetValueDescSort');
                        $isPresent = in_array($userData, $leaderBoard);
                        if ($isPresent) {
                            $key = array_search($userData, $leaderBoard);
                            $userData['data']['rank'] = $key + 1;
                        } else {
                            $userData = array();
                            $userData = $this->User->highestNetAmountPortfolio($data['user_id'], $data['game_id']);
                            //pr($userData); exit;
                            if ($userData) {
                                $rand = rand(1, 200);
                                $userData['data']['rank'] = 300 + $rand;
                            } else {
                                $userData['data'] = "No data";
                            }
                        }
                        //get record of 15 users
                        $leaderBoard = array_slice($leaderBoard, 0, 15);
                        $body = array(
                            'leaderBoard' => $leaderBoard,
                            'userRank' => $userData
                        );
                        $status = True;
                        $message = "Success";
                    } else {
                        $body = null;
                        $status = False;
                        $message = "No Data";
                    }
                } else {
                    $body = null;
                    $status = False;
                    $message = "No Data";
                }
            } else {
                $body = null;
                $status = False;
                $message = "No Data";
            }
        } else {
            $body = null;
            $status = False;
            $message = "Access token invalid";
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to get the details of an individual portfolio
     * web service method
     */
    function portfolio_detail($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $getIndividualPortfolioValue = $this->Portfolio->getIndividualPortfolioValue($data);
            $getIndividualSumPortfolioAmount = $this->UserStock->getIndividualSumPortfolioAmount($data);
            $userTotalAmount = $getIndividualPortfolioValue['Portfolio']['net_value'] + $getIndividualSumPortfolioAmount['UserStock']['total'];
            $getIndividualTrades = $this->Portfolio->getIndividualTrades($data);
            $totalNoOfStocks = $this->UserStock->totalNoOfStocks($data);
            $pendingTransactions = $this->UserStock->getPendingTransactionsCount($data);
            $contents = array(
                'user_id' => $data['user_id'],
                'portfolio_id' => $data['portfolio_id'],
                'access_token' => trim($data['access_token']),
                'Portfolio_net_value' => trim($userTotalAmount),
                'Remaining_trades' => trim($getIndividualTrades['Portfolio']['total_trades']),
                'total_no_stocks' => trim($totalNoOfStocks['UserStock']['count']),
                'pending_transaction' => trim($pendingTransactions['UserStock']['count'])
            );
            $body = $contents;
            $status = True;
            $message = Configure::read('site.portfolio_detail_message1');
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for setting a portfolio as active
     * web service method
     */
    function set_active_portfolio($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $ActivePortfolio = $this->Portfolio->setActivePortfolio($data['portfolio_id']);
            if ($ActivePortfolio) {
                $body['user_id'] = $data['user_id'];
                $body['access_token'] = $data['access_token'];
                $body['ActivePortfolio'] = $ActivePortfolio;
                $status = true;
                $message = Configure::read('site.set_active_portfolio_message1');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.set_active_portfolio_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for sending the detail of a particular share
     * web service method
     */
    function share_detail($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $shareDetail = $this->Share->shareDetail($data);
            if ($shareDetail) {
                $portfolioDetail = $this->Portfolio->totalTradeCashIndividualPortfolio($data);
                $body['Share'] = $shareDetail;
                $body['Portfolio'] = $portfolioDetail;
                $status = FALSE;
                $message = Configure::read('site.share_detail_message1');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.share_detail_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Ganesh
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for sending all the notifications
     * web service method
     */
    function notification_list($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $response = $this->Notification->getAllNotifications($data);
            $this->User->SaveLastAcessTimeDate($data);
            if (!empty($response)) {
                $body = $response;
                $status = TRUE;
                $message = Configure::read('site.notification_list_message1');
            } else {
                $body = null;
                $status = FALSE;
                $message = Configure::read('site.notification_list_message2');
            }
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Ganesh
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for sending piggy bag notifications
     */
    function polling_count($data = array()) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            //get user last_notification_time
            $data["last_notification_time"] = $this->User->getLastNotificationTime($data);
            $body['notification'] = $this->Notification->polling_count($data);
            $status = TRUE;
            $message = Configure::read('site.polling_count_message1');
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * @author Ganesh
     * @copyright Softway solutions
     * @param array $deviceToken and $msg
     * @uses This function is used for sending push notifications to user
     */
    function send_ios_notification($deviceToken, $msg) {
        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        // PEM file location
        $apnsCert = WWW_ROOT . 'files/pemfiles/STOX.pem';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
        if ($apns) {
            $payload = '{"aps" : { "alert" : "' . $msg . '","badge":' . 1 . ', "sound" : "default"}}';
            $messg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
            fwrite($apns, $messg);
            fclose($apns);
        }
    }
    
    /**
     * @author Ganesh
     * @copyright Softway solutions
     * @param array $deviceToken and $msg
     * @uses This function is used for sending push notifications to user for daytrade game
     */
    function send_ios_notification_daytrade($deviceToken, $msg) {
        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        // PEM file location
        $apnsCert = WWW_ROOT . 'files/pemfiles/STOX.pem';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $notification_title = Configure::read('site.daytrade_notification_title');
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
        if ($apns) {
            $payload = '{"aps" : { "alert" : "' . $msg . '","badge":' . 1 . ', "sound" : "default", "title" : "'.$notification_title.'"}}';
            $messg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
            fwrite($apns, $messg);
            fclose($apns);
        }
    }
    
    /**
     * @author Ganesh
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to send a informative splash screen data
     */
    function splash_screen($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $body = array();
            //get actives data
            $body["actives"] = $this->Active->getActivesData();
            //get gainers data
            $body["gainers"] = $this->Gainer->getGainersData();
            //get losers data
            $body["losers"] = $this->Loser->getLosersData();
            $status = TRUE;
            $message = Configure::read('site.splash_screen_message1');
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }
    
    
    /**
     * @author Ganesh
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to sync the wathclist from old version to new version 
     */
    function sync_data($data) {
        if ($this->UserLog->checkAccessTokenValid($data)) {
            $body = null;
            //sync the old datas
            $getDefaultPortfolioId = $this->Portfolio->getDefaultPortfolioByUserId($data["user_id"]);
            $getDayTradeGameId = $this->Portfolio->getDayTradePortfolioByUserId($data["user_id"]);
            
            //inserting values to the mapping table
            $isMappingPresents1 = $this->WatchlistMapping->isDaytradePresent($getDayTradeGameId);
            $isMappingPresents2 = $this->WatchlistMapping->isDefaultPresent($getDefaultPortfolioId);
            if(empty($isMappingPresents1) && empty($isMappingPresents2)){
                if($getDefaultPortfolioId !=0 || $getDayTradeGameId != 0){
                    $data["WatchlistMapping"] = array();
                    $data["WatchlistMapping"]["default_portfolio_id"] = $getDefaultPortfolioId;
                    $data["WatchlistMapping"]["daytrade_portfolio_id"] = $getDayTradeGameId;
                    $this->WatchlistMapping->storeMappings($data);
                }
            }else if(!empty($isMappingPresents1)){
                $data["WatchlistMapping"] = array();
                $data["WatchlistMapping"]["id"] = $isMappingPresents1[0]["WatchlistMapping"]["id"];
                $data["WatchlistMapping"]["default_portfolio_id"] = $getDefaultPortfolioId;
                $data["WatchlistMapping"]["daytrade_portfolio_id"] = $getDayTradeGameId;
                $this->WatchlistMapping->storeMappings($data);
            }else if (!empty($isMappingPresents2)){
                $data["WatchlistMapping"] = array();
                $data["WatchlistMapping"]["id"] = $isMappingPresents2[0]["WatchlistMapping"]["id"];
                $data["WatchlistMapping"]["default_portfolio_id"] = $getDefaultPortfolioId;
                $data["WatchlistMapping"]["daytrade_portfolio_id"] = $getDayTradeGameId;
                $this->WatchlistMapping->storeMappings($data);
            }
            
            //if default portfolio check for the daytrade watchlist and change
            if($getDefaultPortfolioId !=0 && $getDayTradeGameId != 0){
                //get all the wathclist data based on the portfolio id
                $default_portfolio_shares = $this->Watchlist->getShareIdByPfId($getDefaultPortfolioId);
                
                $daytrade_portfolio_shares = $this->Watchlist->getShareIdByPfId($getDayTradeGameId);
                $default_wathclist = array();
                foreach($default_portfolio_shares as $shares){
                    $default_wathclist[] = $shares["Watchlist"]["share_id"];
                } 
                
                foreach($daytrade_portfolio_shares as $shares_check){
                    $share_id = $shares_check["Watchlist"]["share_id"];
                    if(in_array($share_id, $default_wathclist)){
                        //delete the share id
                        $this->Watchlist->deleteByPfIdShareId($share_id, $getDayTradeGameId);
                    }else{
                        //update
                        $this->Watchlist->updatePortfolioId($share_id, $getDayTradeGameId, $getDefaultPortfolioId);
                    }
                }
            }
            
            $status = TRUE;
            $message = Configure::read('site.sync_message1');
        } else {
            $body = null;
            $status = FALSE;
            $message = Configure::read('site.invalid_error_msg');
        }
        return $result = array(
            'body' => $body,
            'status' => $status,
            'message' => $message
        );
    }

}

?>
