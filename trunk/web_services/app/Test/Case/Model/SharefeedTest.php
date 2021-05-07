<?php
App::uses('Sharefeed', 'Model');

/**
 * Sharefeed Test Case
 *
 */
class SharefeedTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sharefeed'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Sharefeed = ClassRegistry::init('Sharefeed');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sharefeed);

		parent::tearDown();
	}

}
