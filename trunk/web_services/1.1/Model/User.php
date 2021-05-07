<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Portfolio $Portfolio
 * @property UserLog $UserLog
 * @property UserStock $UserStock
 */
class User extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array('alphanumeric' => array('rule' => array('alphanumeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),),
        'username' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => "Field can't be empty. Please enter valid user name ",
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This user name already exists in our database.'
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please enter valid Email address',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This email already exists in our database.'
            ),
        ),
        'password' => array('notempty' => array('rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )),
    );
    //The Associations below have been created with all possible keys, those that are
    // not needed can be removed
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Portfolio' => array(
            'className' => 'Portfolio',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'UserLog' => array(
            'className' => 'UserLog',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'UserStock' => array(
            'className' => 'UserStock',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'UserstockHistory' => array(
            'className' => 'UserstockHistory',
            'foreignKey' => 'user_stock_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used to check if emailId exists
     * @return $user with user info
     */
    public function checkEmailExists($email) {
        $user = $this->find('first', array(
            'conditions' => array('email' => $email),
            'recursive' => -1
        ));
        if ($user) {
            return $user;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used to check if username exists
     * @return $user with user info
     */
    public function checkUsernameExists($username) {
        $user = $this->find('first', array(
            'conditions' => array('username' => $username),
            'recursive' => -1
        ));
        if ($user) {
            return $user;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function will be used save change change_pwd_token
     */
    function updateChangePwdToken($data) {
        if ($this->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to update the biodata for an user
     */
    function updateBioToken($data) {
        $updateData = array(
            'id' => $data['user_id'],
            'biodata' => $data['biodata']
        );
        if ($this->save($updateData)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to update the profile for the user
     * updates biodata, image and job-title as per the $data
     */
    function updateProfile($data) {
        $updateData = array(
            'id' => $data['user_id'],
            'biodata' => $data['biodata'],
            'image' => $data['image'],
            'job_title' => $data['job_title']
        );
        if ($this->save($updateData)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for updating the facebook_id
     */
    function updateFacebookData($data) {
        $updateData = array(
            'id' => $data['user_id'],
            'facebook_id' => $data['facebook_id'],
        );
        if ($this->save($updateData)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for updating the user information
     */
    function updateGuest($data) {
        $updateData = array(
            'id' => $data['user_id'],
            'role' => 'User',
            'username' => $data['username'],
            'job_title' => $data['job_title'],
            'email' => $data['email'],
            'password' => $data['password'],
            'device_id' => NULL,
            'image' => $data['image'],
            'is_registered' => 'yes',
            'last_notification_time' => $data['last_notification_time']
        );
        if ($this->save($updateData)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to check if facebook_id exists as per $data
     */
    public function checkFacebookUserExists($facebook_id) {
        $user = $this->find('first', array(
            'conditions' => array('facebook_id' => $facebook_id),
            'recursive' => -1
        ));
        if ($user) {
            return $user;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to check for the user detail as per $data
     */
    function checkDataExists($requestData) {
        $userInfo = $this->find('first', array(
            'conditions' => array('OR' => array(
                    array('User.email' => $requestData),
                    array('User.username' => $requestData)
                )),
            'recursive' => -1
        ));
        if ($userInfo) {
            return $userInfo;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to check for the user login with email/username and password as per $requestData
     */
    function checkAndLogin($requestData = array()) {
        $userInfo = $this->find('first', array(
            'conditions' => array('OR' => array(
                    array(
                        'User.email' => $requestData['email'],
                        'User.password' => AuthComponent::password($requestData['password'])
                    ),
                    array(
                        'User.username' => $requestData['email'],
                        'User.password' => AuthComponent::password($requestData['password'])
                    )
                )),
            'recursive' => -1
        ));
        if ($userInfo) {
            return $userInfo;
        } else {
            return FALSE;
        }
    }

    /**
     * Function to generate authEncryptPassword
     * @author 	Harsha Shirali
     */
    function authPassword($pwd) {
        if (!empty($pwd)) {
            return AuthComponent::password($pwd);
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to check for password matches as per $id $pwd
     */
    function checkPasswordMatch($id, $pwd) {
        $userPwd = $this->find('first', array(
            'conditions' => array(
                'id' => $id,
                'password' => $pwd
            ),
            'recursive' => -1
        ));
        if ($userPwd) {
            return True;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to update the password for user as per $data
     */
    function updateUserPassword($data) {
        $data['id'] = $data['user_id'];
        $data['password'] = $data['password'];
        $save = $this->save($data);
        if ($save) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to update the image for user as per $data
     */
    function updateImage($data) {
        $updateData = array(
            'id' => $data['user_id'],
            'image' => $data['image']
        );
        $save = $this->save($updateData);
        if ($save) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is saves the user logs for user as per $data
     */
    function saveLoginDatas($data) {
        $save = $this->UserLog->save($data);
        if ($save) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function displays the user info for the user as per $data
     */
    function getUserId($data) {
        $options = array(
            'fields' => array('id',),
            'conditions' => array('device_id' => $data['device_id'],),
        );
        $data = $this->find('first', $options);
        if ($data) {
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function checks for facebook_id and displays the user info for the user as per $data
     */
    function getSocialUserId($data) {
        $options = array(
            'fields' => array(
                'id',
                'image'
            ),
            'conditions' => array('facebook_id' => $data['facebook_id'],),
            'recursive' => -1
        );
        $data = $this->find('first', $options);
        if ($data) {
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function checks for device_id exists for the guest user and displays the user info for the user as per $data
     */
    function checkDeviceExists($data) {
        $user = $this->find('first', array(
            'conditions' => array(
                'is_registered' => 'no',
                'device_id' => $data['device_id']
            ),
            'recursive' => -1
        ));
        if ($user) {
            return $user;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function checks if user is registered and displays the user info for the user as per $data
     */
    function isNotRegistered($data) {
        $user = $this->find('first', array(
            'conditions' => array(
                'is_registered' => 'no',
                'device_id' => $data['device_id']
            ),
            'recursive' => -1
        ));
        if ($user) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for listing out the registered users
     */
    function listRegisteredUsers() {
        $list = $this->find('list', array(
            'conditions' => array(
                'User.status' => 'Active',
                'User.role' => 'User',
                'User.is_registered' => 'yes'
            ),
            'fields' => array(
                'User.id',
                'User.email'
            ),
            'recursive' => -1,
            'limit' => 500,
            'order' => 'User.modified DESC'
        ));
        if ($list) {
            return $list;
        } else {
            return $list;
        }
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for listing the portfolios in the leader board
     */
    function leaderPortfolios($users, $game_id) {
        $portfolios = $this->find('all', array(
            'conditions' => array('User.id' => $users),
            'fields' => array(
                'User.id',
                'User.email',
                'User.username',
                'User.facebook_id',
                'User.image'
            ),
            'contain' => array('Portfolio' => array(
                    'conditions' => array('Portfolio.game_id' => $game_id),
                    'UserStock' => array(
                        'conditions' => array(
                            'UserStock.status' => 'buy',
                            'UserStock.is_pending' => 'no'
                        ),
                        'fields' => array(
                            'UserStock.id',
                            'UserStock.user_id',
                            'UserStock.portfolio_id',
                            'UserStock.total_amount'
                        )
                    )
                )),
            'limit' => 300
        ));
        if ($portfolios) {
            $portfoliosTotalAmount = $this->_calculateTotalShareAmount($portfolios);
            return $portfoliosTotalAmount;
        } else {
            return false;
        }
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used for calculating the highest net amount of user
     */
    function highestNetAmountPortfolio($user_id, $game_id) {
        $portfolios = $this->find('all', array(
            'conditions' => array('User.id' => $user_id),
            'fields' => array(
                'User.id',
                'User.email',
                'User.username',
                'User.facebook_id',
                'User.image'
            ),
            'contain' => array('Portfolio' => array(
                    'conditions' => array('Portfolio.game_id' => $game_id),
                    'UserStock' => array(
                        'conditions' => array(
                            'UserStock.status' => 'buy',
                            'UserStock.is_pending' => 'no'
                        ),
                        'fields' => array(
                            'UserStock.id',
                            'UserStock.user_id',
                            'UserStock.portfolio_id',
                            'UserStock.total_amount'
                        )
                    )
                )),
        ));
        if ($portfolios) {
            $totalAmount = $this->_calculateTotalShareAmount($portfolios);
            foreach ($totalAmount as $key => $val) {
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
                    $userData = array('data' => $portfolios_max_net_amount);
                }
            }
            return $userData;
        } else {
            return false;
        }
    }

    /**
     * @author Alin Begum
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used calculating the summation of net value and total
     * share value for each portfolios
     */
    function _calculateTotalShareAmount($portfolios) {
        foreach ($portfolios as $key => $val) {
            if (isset($val['Portfolio'])) {
                $total = 0;
                foreach ($val['Portfolio'] as $portfolioKey => $portfolioVal) {
                    $total = $portfolioVal['net_value'];
                    if (isset($portfolioVal['UserStock'])) {
                        foreach ($portfolioVal['UserStock'] as $UserStock) {
                            $total += $UserStock['total_amount'];
                        }
                    }
                    $portfolios[$key]['total_share_amount'][$portfolioKey] = $total;
                }
            }
        }
        return $portfolios;
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to list all the portfolios of a particular user
     * with portfolio_worth and total count of stocks 
     */
    public function finalPortfolioList($data) {
        $portfoliolistData = $this->query('select  
                p.id as portfolio_id, p.portfolio_name, p.net_value as pnet_value, p.trades as available_trades, p.available_cash, u.portfolio_stock_count,(COALESCE(p.available_cash,0) + COALESCE(u.total,0)) as portfolio_worth, p.start_money, p.created 
                FROM
                (
                    select id, portfolio_name, trades, net_value, COALESCE(sum(net_value),0) as available_cash, start_money, created
                    from portfolios
                    where user_id=' . $data['user_id'] . ' and game_id=' . $data['game_id'] . '
                    group by id
                ) p
                left join
                (
                    select portfolio_id, COALESCE(sum(total_amount),0) as total, COALESCE(sum(quantity),0) as portfolio_stock_count
                    from user_stocks 
                    where user_id=' . $data['user_id'] . ' and status="buy"
                    group by portfolio_id
                ) u
                on p.id=u.portfolio_id ');
        $response = array();
        if (!empty($portfoliolistData)) {
            foreach ($portfoliolistData as $data) {
                $data['p']['portfolio_stock_count'] = strval(intval($data['u']['portfolio_stock_count']));
                $data['p']['portfolio_worth'] = $data['0']['portfolio_worth'];
                $data['p']['net_value_change'] = ($data['p']['portfolio_worth'] - $data['p']['start_money']);
                unset($data['u']);
                unset($data['0']);
                $todays_date = date('Y-m-d h:i:s');
                $data['p']['portfolio_percentage_change'] = $this->UserstockHistory->getPortfolioWorth($data['p']['portfolio_id'], $data['p']['created'], $todays_date);
                $response[] = $data['p'];
            }
        }
        if ($data) {
            return $response;
        } else {
            return FALSE;
        }
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to save the last access time and date of the notification
     */
    function SaveLastAcessTimeDate($data) {
        $data['id'] = $data['user_id'];
        $data['last_notification_time'] = date('Y-m-d H:i:s');
        $save = $this->save($data);
        if ($save) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * @author Ganesh
     * @uses This function is used to find the last access time and date of the notification
     */
    function getLastNotificationTime($data) {
        $value = $this->find('first', array(
            'conditions' => array('User.id' => $data["user_id"]),
            'fields' => array('User.last_notification_time'),
            'recursive' => -1
        ));
        return $value["User"]["last_notification_time"];
    }

    /**
     * @author Ganesh
     * @copyright Softway solutions
     * @param array $user_id
     * @uses This function is used to get the push note tokens based on
     * the user id
     */
    function getPushnoteTokenByUser($user_id) {
        $conditions = array("UserLog.user_id" => $user_id, "UserLog.status" => "LoggedIn");
        $fields = array("UserLog.push_note_token");
        $tokens = $this->UserLog->find("all", array(
            "conditions" => $conditions,
            "fields" => $fields,
            "group" => array("UserLog.push_note_token"),
            "recursive" => -1
        ));
        return $tokens;
    }

}
