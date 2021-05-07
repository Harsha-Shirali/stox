<?php
App::uses('AppController', 'Controller');
/**
 * UserstockHistories Controller
 *
 * @property UserstockHistory $UserstockHistory
 */
class UserstockHistoriesController extends AppController {

	function test_worth_calculation() {
		$gain_percentage = $this->UserstockHistory->getShareWorth(9);
		pr($gain_percentage);
		echo '<br />';
		$gain_percentage = $this->UserstockHistory->getPortfolioWorth(9);
		pr($gain_percentage);
		$this->autoRender = false;
	}

}
