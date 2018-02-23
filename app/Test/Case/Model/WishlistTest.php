<?php
App::uses('Wishlist', 'Model');

/**
 * Wishlist Test Case
 *
 */
class WishlistTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.wishlist',
		'app.user',
		'app.availability',
		'app.inbox_message',
		'app.previous_making',
		'app.request',
		'app.review',
		'app.sent_message',
		'app.skill',
		'app.skill_image',
		'app.maker'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Wishlist = ClassRegistry::init('Wishlist');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Wishlist);

		parent::tearDown();
	}

}
