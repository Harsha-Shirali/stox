<?php
App::uses('AppModel', 'Model');
/**
 * Game Model
 *
 */
class Game extends AppModel
{

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
				'message' => 'Please enter default net value and it should be decimal',
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

	public function displayGametype($requestData)
	{

		$this -> virtualFields = array(
			'game_id' => 'Game.id',
			'game_name' => 'Game.name',
			'type' => 'Game.type',
			'default_trades' => 'Game.default_trades',
			'default_net_value' => 'Game.default_net_value'
		);

		$options = $this -> find('all', array(
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
		if ($result)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}
		
		
	}

	public function getGameDetails($data)
	{
		$options = array(
			'fields' => array(
				'Game.default_net_value',
				'Game.default_trades',
			),
			'conditions' => array('Game.id' => $data['game_id']),
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	public function getGameType($data)
	{
		$options = array(
			'fields' => array('Game.type'),
			'conditions' => array(
				'Game.id' => $data['game_id'],
				'Game.status' => 'active'
			),
		);
		$data = $this -> find('first', $options);
		if ($data)
		{
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

	/*
	 * Author: Alin
	 * Description: This function is used to retrive all the premium games
	 */

	public function listOfPremiumGames($requestData)
	{

		$this -> virtualFields = array('game_id' => 'Game.id');

		$gameData = $this -> find('all', array(
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
		if ($result)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}
	}

}
