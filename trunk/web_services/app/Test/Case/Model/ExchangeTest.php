<?php
App::uses('Exchange', 'Model');

/**
 * Exchange Test Case
 *
 */
class ExchangeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.exchange',
		'app.sharefeed'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Exchange = ClassRegistry::init('Exchange');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Exchange);

		parent::tearDown();
	}

}
