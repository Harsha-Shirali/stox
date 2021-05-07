<?php

App::uses('AppModel', 'Model');

/**
 * Game Model
 *
 */
class Game extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => "Name can't be blank, Please enter the valid name",
                'allowEmpty' => false,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'type' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please select type from the list',
                'allowEmpty' => false,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'status' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => "Fields can't be empty, Please select type from the list",
                'allowEmpty' => false,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'default_net_value' => array(
            'decimal' => array(
                'rule' => array('decimal'),
                'message' => 'Please enter default cash and it should be decimal',
                'allowEmpty' => false,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'default_trades' => array(
            'decimal' => array(
                'rule' => array('decimal'),
                'message' => ' Please enter default trades and it should be decimal',
                'allowEmpty' => false,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
    public $hasMany = array(
        'Portfolio' => array(
            'className' => 'Portfolio',
            'foreignKey' => 'game_id',
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
     * @uses This function is used to get the game data as per $requestData
     */
    public function displayGametype($requestData) {
        $this->virtualFields = array(
            'game_id' => 'Game.id',
            'game_name' => 'Game.name',
        );
        $options = $this->find('all', array(
            'conditions' => array('Game.status' => 'active'),
            'fields' => array(
                'game_id',
                'Game.name',
                'Game.type',
                'Game.default_trades',
                'Game.default_net_value'
            ),
            'recursive' => -1
        ));
        $result = Set::classicExtract($options, '{n}.Game');
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * @author Harsha Shirali
     * @copyright Softway solutions
     * @param array $data
     * @uses This function is used to get the net_value and trades of a particular game as per $data
     */
    public function getGameDetails($data) {
        $options = array(
            'fields' => array(
                'Game.default_net_value',
                'Game.default_trades',
            ),
            'conditions' => array('Game.id' => $data['game_id']),
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
     * @uses This function is used to get the net_value and trades of a particular game as per $data
     */
    public function getGameType($data) {
        $options = array(
            'fields' => array('Game.type'),
            'conditions' => array(
                'Game.id' => $data['game_id'],
                'Game.status' => 'active'
            ),
        );
        $data = $this->find('first', $options);
        if ($data) {
            return $data;
        } else {
            return FALSE;
        }
    }

    /*
     * Author: Alin
     * Description: This function is used to retrive all the premium games
     */

    public function listOfPremiumGames($requestData) {
        $this->virtualFields = array('game_id' => 'Game.id');
        $gameData = $this->find('all', array(
            'conditions' => array(
                'Game.status' => 'active',
                'Game.type' => 'paid'
            ),
            'fields' => array(
                'game_id',
                'Game.name',
                'Game.type'
            ),
            'recursive' => -1
        ));
        $result = Set::classicExtract($gameData, '{n}.Game');
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /*
     * Author: Alin
     * Description: This function is used to retrive all the premium games ids along with the default amount
     */

    public function premiumGameData() {
        $game_data = $this->find('list', array('conditions' => array('Game.type' => 'paid', 'Game.status' => 'active'),
            'fields' => array('Game.id', 'Game.default_trades'),
            'recursive' => -1
        ));
        if ($game_data) {
            return $game_data;
        } else {
            return false;
        }
    }

    /*
     * Author: Alin
     * Description: This function is used to retrive all the free games ids along with the default amount
     */

    public function portfolioGameData() {
        $game_data = $this->find('list', array('conditions' => array('Game.type' => 'free', 'Game.status' => 'active'),
            'fields' => array('Game.id', 'Game.default_trades'),
            'recursive' => -1
        ));
        if ($game_data) {
            return $game_data;
        } else {
            return false;
        }
    }

}
