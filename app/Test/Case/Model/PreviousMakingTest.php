<?php
App::uses('PreviousMaking', 'Model');

/**
 * PreviousMaking Test Case
 *
 */
class PreviousMakingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.previous_making',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PreviousMaking = ClassRegistry::init('PreviousMaking');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PreviousMaking);

		parent::tearDown();
	}

}
