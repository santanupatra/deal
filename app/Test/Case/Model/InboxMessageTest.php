<?php
App::uses('InboxMessage', 'Model');

/**
 * InboxMessage Test Case
 *
 */
class InboxMessageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.inbox_message',
		'app.user',
		'app.sender'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InboxMessage = ClassRegistry::init('InboxMessage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InboxMessage);

		parent::tearDown();
	}

}
