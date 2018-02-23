<?php
App::uses('Availability', 'Model');

/**
 * Availability Test Case
 *
 */
class AvailabilityTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.availability',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Availability = ClassRegistry::init('Availability');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Availability);

		parent::tearDown();
	}

}
