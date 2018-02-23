<?php
App::uses('SentMessage', 'Model');

/**
 * SentMessage Test Case
 *
 */
class SentMessageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sent_message',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SentMessage = ClassRegistry::init('SentMessage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SentMessage);

		parent::tearDown();
	}

}
