<?php
App::uses('AppModel', 'Model');
/**
 * WatchlistPreload Model
 *
 * @property Share $Share
 */
class WatchlistPreload extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'share_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
		public function getPreloadWatchlist($data)
	{
		$watchlist_data = $this -> find('all',array('contain' => array('Share' => array(
					'Exchange' => array('fields' => array(
							'Exchange.id',
							'Exchange.name',
							'Exchange.full_name'
						)),
					'fields' => array(
						'Share.id',
						//'Share.full_name',
						'Share.symbol',
						'Share.todays_closing_price',
						'Share.open_price',
						'Share.previous_close_price',
						'Share.days_high_price',
						'Share.days_low_price'
					)
				)),	'recursive' => -1));
				$response_data=array();
				if (!empty($data))
		{
			foreach ($watchlist_data as $data)
			{
				$data['Share']['exchange_id'] = $data['Share']['Exchange']['id'];
				$data['Share']['exchange_name'] = $data['Share']['Exchange']['name'];
				$data['Share']['exchange_full_name'] = $data['Share']['Exchange']['full_name'];
				$data['Share']['share_id'] = $data['Share']['id'];
				unset($data['Share']['Exchange']);
				unset($data['Share']['id']);
				unset($data['Watchlist']);
				$response_data[] = $data['Share'];
			}
		}
		if (!empty($response_data))
		{
			return $response_data;
		}
		else
		{
			return FALSE;
		}

	}
}
