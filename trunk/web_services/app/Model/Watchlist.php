<?php
App::uses('AppModel', 'Model');
/**
 * Watchlist Model
 *
 * @property Portfolio $Portfolio
 * @property Share $Share
 */
class Watchlist extends AppModel
{

	//The Associations below have been created with all possible keys, those that are
	// not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Portfolio' => array(
			'className' => 'Portfolio',
			'foreignKey' => 'portfolio_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true,
		),
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'share_id',
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
	 * @uses This function is used to lists all the shares in watchlist of a portfolio as per $data
	 */

	function getWatchListDatas($data)
	{
                $conditions = array('Watchlist.portfolio_id' => $data['portfolio_id']);
                if($data['search'] != '')
                {
                    $conditions['Share.symbol'] = trim($data['search']);
                }
		$Watchlist_data = $this -> find('all', array(
			'fields' => array(
				'share_id',
				'portfolio_id',
				'id'
			),
			'conditions' => $conditions,
			'contain' => array('Share' => array(
					'Exchange' => array('fields' => array(
							'Exchange.id',
							'Exchange.name',
							'Exchange.full_name'
						)),
					'fields' => array(
						'Share.id',
						'Share.last_trade_price',
						'Share.symbol_full_name',
						'Share.symbol',
						'Share.todays_closing_price',
						'Share.open_price',
						'Share.previous_close_price',
						'Share.days_high_price',
						'Share.days_low_price'
					)
				)),
		));
		$response_data = array();
		if (!empty($Watchlist_data))
		{
			foreach ($Watchlist_data as $data)
			{
				$data['Share']['watchlist_id'] = $data['Watchlist']['id'];
				$data['Share']['exchange_id'] = $data['Share']['Exchange']['id'];
				$data['Share']['exchange_name'] = $data['Share']['Exchange']['name'];
				$data['Share']['exchange_full_name'] = $data['Share']['Exchange']['full_name'];
				$data['Share']['share_id'] = $data['Share']['id'];
				$data['Share']['full_name'] = $data['Share']['symbol_full_name'];
				unset($data['Share']['symbol_full_name']);
				unset($data['Share']['Exchange']);
				unset($data['Share']['id']);
				unset($data['Watchlist']);
				$response_data[] = $data['Share'];
			}
		}
		$result = Set::classicExtract($response_data, '{n}');
		if ($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}

	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to save the watch-list data as per $data
	 */

	public function saveWatchlistDatas($data)
	{
		if ($this -> save($data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}
	
	/**
	 * @author Harsha Shirali
	 * @copyright Softway solutions
	 * @param array $data
	 * @uses This function is used to check if a particular share exists in watchlist as per the $data
	 */

	public function checkShareExists($data)
	{
		$options = array(
			'conditions' => array(
				'portfolio_id' => $data['portfolio_id'],
				'share_id' => $data['share_id'],
			),
			'recursive' => -1
		);
		$data = $this -> find('all', $options);
		if ($data)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}

	/* Author: Alin
	 * Description: this function is used for deleting a record from the table
	 */
	function deleteRecord($id)
	{
		if ($this -> delete($id))
			return true;
		else
			return false;
	}

}
