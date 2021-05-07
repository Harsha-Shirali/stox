<?php
App::uses('AppController', 'Controller');
/**
 * UserstockHistories Controller
 *
 * @property UserstockHistory $UserstockHistory
 */
class UserstockHistoriesController extends AppController {

	function test_worth_calculation() {
		date_default_timezone_set("Asia/Kolkata");
		$end_date = date('Y-m-d H:i:s');
		$start_date = date('Y-m-d H:i:s', strtotime( '-60 day' , strtotime($end_date) ));

		$gain_percentage = $this->UserstockHistory->getPortfolioWorth(9);
		pr($gain_percentage);
		$this->autoRender = false;
	}

}
